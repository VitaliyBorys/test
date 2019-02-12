<?php

namespace App\Observers;

use App\Models\Connection;
use App\Models\Country;
use App\Models\Ensemble;
use App\User;
use Log;
class UserObserver
{
    public function creating($user)
    {
       $this->generateRefToken($user);
    }



    private function generateRefToken($user)
    {
        // create unique ref token
        $token = str_random(20);

        if (User::where('ref_token', $token)->exists()){
            return $this->generateRefToken($user);
        }

        $user->ref_token = $token;
    }
}
