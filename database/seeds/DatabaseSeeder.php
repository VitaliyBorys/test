<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\Artisan::call('passport:install');
        $this->call(RoleSeed::class);
        $this->call(UserSeeder::class);
        $this->call(PrizeSeed::class);
        $this->call(PrizeToUserSeed::class);
        $this->call(SettingSeeder::class);
    }
}
