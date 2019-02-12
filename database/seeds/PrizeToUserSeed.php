<?php

use Illuminate\Database\Seeder;

class PrizeToUserSeed extends MainSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prizeType = ['physical', 'bonus', 'money'];

        $this->prepare();
        \App\User::chunk(100, function ($users) use ($prizeType) {
            foreach ($users as $user) {
                for ($i = 0; $i < 20; $i++) {
                    $method = 'attach' . ucfirst(strtolower($prizeType[array_rand($prizeType)]));
                    $this->$method($user);
                }
            }

        });
        $this->commit();
    }

    private function attachBonus(\App\User $user)
    {
        \App\Models\UserPrize::add($user, ['type' => 'bonus', 'prize' => rand(1, 50)]);
    }

    private function attachMoney(\App\User $user)
    {
        \App\Models\UserPrize::add($user, ['type' => 'money', 'prize' => rand(1, 100)]);
    }

    private function attachPhysical(\App\User $user)
    {
        \App\Models\UserPrize::add($user, ['type' => 'physical', 'prize' => factory(\App\Models\Prize::class)->create()]);
    }
}
