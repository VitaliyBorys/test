<?php

use App\Models\User\RBAC\Role;
use Illuminate\Database\Seeder;

class RoleSeed extends MainSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->prepare();
        Role::insert([
            [
                'name' => 'Admin',
                'description' => 'Admin'
            ],[
                'name' => 'user',
                'description' => 'User'
            ]
        ]);
        $this->commit();
    }
}
