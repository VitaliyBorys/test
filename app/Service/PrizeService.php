<?php

namespace App\Service;


use App\Models\UserPrize;
use App\User;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Integer;

class PrizeService
{
    /**
     * @var Model
     */
    private $physicalModel;

    private $limitMoney = 1;

    private $type;

    public function __construct(Model $physicalModel, $limitMoney)
    {

        $this->physicalModel = $physicalModel;

        $this->limitMoney = $limitMoney;
    }

    public function getPrize($type)
    {
        $this->type = $type;

        $method = 'get' . ucfirst(strtolower($type));

        if (method_exists(self::class, $method)) {
            $prize = $this->$method();
        } else {
            throw new \DomainException('Error');
        }

        $prize =  ['type' => $this->type, 'prize' => $prize];

        return $prize;


    }

    public function getBonus()
    {
        $this->type = 'bonus';
        return rand(1, 800);
    }

    public function getMoney()
    {
        $this->type = 'money';

        if ($this->limitMoney) {
            return rand(1, $this->limitMoney);
        }
        return $this->getBonus();
    }

    public function getPhysical()
    {
        $this->type = 'physical';
        if ($this->physicalModel->issetAvailablePrize()) {
            $prize = $this->physicalModel->inRandomOrder()->first();
            $prize->noAvailable();
            return $prize;
        }
        return $this->getBonus();
    }


    /**
     * @param User $user
     * @param $koef
     */
    public function convertBonusToMoney(User $user,$koef)
    {
        if ($user->bonuses <= 0) {
            throw new \DomainException('На вашем счету нету бонусов');
        }
        $user->addMoney($user->bonuses * $koef);
        $user->addBonus($user->bonuses * (-1));

        $user->prizes()->bonus()->update(['status' => UserPrize::STATUS_CONVERT]);
    }
}