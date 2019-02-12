<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends MainSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory('App\User')->create([
            'name' => 'John',
            'lastname' => 'Doe',
            'email' => 'john@doe.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'confirmed' => 1,
            'phone' => '+38 (099) 123 45678',
            'birthday' => '1982-11-07',
            'gender' => 'm',
        ]);

        $user->roles()->sync([1]);

        $this->prepare();
        factory('App\User', 500)->create();
        $this->commit();

    }
}
