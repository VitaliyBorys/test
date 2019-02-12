<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Mail;
class AuthTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function a_user_can_register_himself()
    {
        $this->withExceptionHandling();
        Mail::fake();
        $response = $this->json('POST', '/api/register',
            [
                'email' => 'john@doe.com',
                'password' => 'secret',
                'password_confirmation' => 'secret',
                'card' => '3242rwer3r456'
            ]
        );

        $response->assertStatus(201)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('users', ['email' => 'john@doe.com']);

    }

    /** @test */
    public function a_user_can_not_register_if_email_is_taken()
    {
        $this->withExceptionHandling();
        factory('App\User')->create(['email' => 'john@doe.com']);
        $response = $this->json('POST', '/api/register',
            [
                'email' => 'john@doe.com',
                'password' => 'secret',
                'password_confirmation' => 'secret',
                'agree' => 'on',
                'card' => '32423r45632'
            ]
        );

        $response->assertStatus(422);
    }

    /** @test */
    public function a_user_can_login_and_logout()
    {
        $this->passport();

        Mail::fake();
        $response = $this->json('POST', '/api/register',
            [
                'email' => 'john@doe.com',
                'password' => 'secret',
                'password_confirmation' => 'secret',
                'card' => '3242rwer3r456'
            ]
        );

        $response->assertStatus(201)
            ->assertJson(['success' => true]);

        $user = User::first();
        $user->confirmed = 1;
        $user->save();

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'john@doe.com',
            'password' => 'secret'
        ]);

        $response->assertJson(['token_type' => 'Bearer']);

        $access_token = $response->json()['access_token'];

        $this->json('GET', '/api/get-user', [], ['Authorization' => 'Bearer ' . $access_token])
            ->assertJsonFragment(['id' => $user->id]);

        $response = $this->json('POST', route('auth.logout'), [], ['Authorization' => 'Bearer ' . $access_token]);

        $response->assertStatus(200);

    }

    /** @test */
    public function guests_cannot_reach_logout_endpoint()
    {
        $this->withExceptionHandling();

        $response = $this->json('POST', route('auth.logout'));

        $response->assertStatus(401);
    }


}
