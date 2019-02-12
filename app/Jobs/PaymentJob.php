<?php

namespace App\Jobs;

use App\Service\BankService;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $users;
    protected $service;

    /**
     * PaymentJob constructor.
     * @param User[] $users
     */
    public function __construct($users)
    {
        $this->users = $users;
        $this->service = new BankService();
    }


    public function handle()
    {
        foreach ($this->users as $user) {
            $this->service->transaction($user->card, $user->money);
            $user->emptyYourWallet();
        }
    }
}
