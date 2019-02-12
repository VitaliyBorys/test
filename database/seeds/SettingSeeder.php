<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends MainSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->prepare();
        $user = \App\User::first();

        \App\Models\Setting::attach($user, [
            [

                'key' => 'limit_money',
                'value' => 20000
            ],
            [
                'key' => 'k_convert',
                'value' => 2
            ]
        ]);
        $this->commit();
    }
}
