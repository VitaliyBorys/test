<?php

namespace App\Http\Controllers\Api;

use App\Mail\ConfirmRegistration;
use App\Mail\ResetLinkMail;
use Auth;
use DB;
use Mail;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Passport\Client;
use App\Http\Resources\User as UserResource;

class AuthController extends Controller
{
    public function register()
    {
        request()->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:255|confirmed',
            'card' => 'required|min:12'
        ]);

        $user = new User();
        $user->fill(\request()->all());
        $user->email = request()->email;
        $user->password = bcrypt(request()->password);
        $user->confirm_token = $this->getConfirmToken();
        $user->save();

        $this->sendConfirmationEmail($user);

        return response()->json([
            'success' => true,
            'message' => 'created'
        ], 201);
    }

    public function resend()
    {
        request()->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', request()->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 406);
        }

        $this->sendConfirmationEmail($user);

        return response()->json([
            'success' => true,
            'message' => 'Check your email inbox'
        ]);

    }

    protected function sendConfirmationEmail($user)
    {
        //Mail::to($user->email)->queue(new ConfirmRegistration($user));
        // Mail::to($user->email)->send(new ConfirmRegistration($user));
    }

    public function confirm()
    {

        $user = User::where('confirm_token', request('confirm_token'))->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid confirm token'
            ], 406);
        }

        $user->confirmed = true;
        $user->confirm_token = null;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Your account has been confirmed. Now you can login with your email and password'
        ]);

    }

    protected function getConfirmToken()
    {
        do {
            $token = str_random(25);
        } while (
            User::where('confirm_token', $token)->exists()
        );
        return $token;
    }

    public function login()
    {
        request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //Check if confirmed
     //   if(Auth::attempt(request()->only('email', 'password')) && !Auth::user()->confirmed){
        if (!Auth::attempt(request()->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'The user\'s account is not confirmed'

            ], 401);
        }

        $oauth = Client::where('password_client', 1)->first();

        $data = [
            'grant_type' => 'password',
            'client_id' => $oauth->id,
            'client_secret' => $oauth->secret,
            'username' => request('email'),
            'password' => request('password')
        ];

        $request = Request::create('/oauth/token', 'POST', $data);

        return app()->handle($request);
    }

    public function refresh()
    {
        $oauth = Client::where('password_client', 1)->first();

        $data = [
            'grant_type' => 'refresh_token',
            'refresh_token' => request('refresh_token'),
            'client_id' => $oauth->id,
            'client_secret' => $oauth->secret,
        ];

        $request = Request::create('/oauth/token', 'POST', $data);

        return app()->handle($request);
    }

    public function logout()
    {

        $accessToken = auth()->user()->token();


        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();

        return response()->json(['status' => 200]);
    }

    public function getUser()
    {
        return auth()->user()->confirmed ?
            new UserResource(auth()->user()) :
            response()->json(['message' => 'User account does not activated'], 403);
    }

    public function sendResetLink()
    {
        request()->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', request()->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 401);
        }

        $user->confirm_token = $this->getConfirmToken();
        $user->save();

        Mail::to($user->email)->queue(new ResetLinkMail($user));

        return response()->json([
            'success' => true,
            'message' => 'Reset link has been sent. Check your inbox'
        ]);

    }

    public function resetPassword()
    {
        $data = request()->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6'
        ]);


        $user = User::where([
            ['confirm_token', $data['token']],
            ['email', $data['email']]
        ])->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 401);
        }

        $user->password = bcrypt($data['password']);
        $user->confirmed = true;
        $user->confirm_token = null;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Your password has been changed. Please login now'
        ]);
    }

}
