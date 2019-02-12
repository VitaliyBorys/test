<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

abstract class MainSeeder extends Seeder
{
    protected function prepare()
    {
        if(config('database.default') == 'mysql'){
            DB::statement('SET autocommit=0');
            DB::statement('SET unique_checks=0;');
            DB::statement('SET foreign_key_checks=0;');
        }

    }

    protected function commit()
    {
        if(config('database.default') == 'mysql') {
            DB::statement('COMMIT;');
            DB::statement('SET unique_checks=1;');
            DB::statement('SET autocommit=1');
            DB::statement('SET foreign_key_checks=1;');
        }
    }
}
