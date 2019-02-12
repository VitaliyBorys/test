<?php

namespace App\Console\Commands;

use App\Jobs\PaymentJob;
use App\User;
use Illuminate\Console\Command;

class WithDrawCommand extends Command
{
    protected $signature = 'payment:user {count_user}';
    protected $description = 'Payment';

    public function handle(): bool
    {
        /** @var integer $count */
        $count = $this->argument('count_user');

        $this->info('Очередь выплат стартовала');

        if ($count < 1) {
            $this->error('Введите кол-во в пользователей в одной пачке');
        } else {
            User::where('money', '>', 0)->chunk($count, function ($users) {
                PaymentJob::dispatch($users)->delay(5);
            });
        }
        return true;
    }
}
