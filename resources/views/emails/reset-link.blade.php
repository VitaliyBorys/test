@component('mail::message')
<h1>Reset Password?</h1>
<b>Hi {{ $user->name }}</b>,

We received a request to reset your password on Ensemblers social network.

Click the button (follow the link) below to change your password

If you didn't request a new password please contact the Ensemblers support team

@component('mail::button', ['url' => url('/reset-password/' . $user->confirm_token), 'color' => 'gradient'])
Change password
@endcomponent
Link: <br>
{{ url('/reset-password/' . $user->confirm_token) }}
@endcomponent
