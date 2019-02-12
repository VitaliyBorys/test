@component('mail::message')
<b>Welcome!</b>

You recently registered for Ensemblers.

To complete your registration, please confirm your account by clicking a button below

The Ensemblers project is a social network for the people related to musical industry all over the world.
Once you join Ensemblers, you'll be able to join Ensembles, plan events, chat and more.

@component('mail::button', ['url' => url('/confirm/' . $user->confirm_token), 'color' => 'gradient'])
Confirm registration
@endcomponent
Link: <br>
{{ url('/confirm/' . $user->confirm_token) }}
@endcomponent
