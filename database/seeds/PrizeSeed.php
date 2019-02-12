<?php

use Illuminate\Database\Seeder;

class PrizeSeed extends MainSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->prepare();
        factory(\App\Models\Prize::class, 250)->create();
        $this->commit();
    }
}
