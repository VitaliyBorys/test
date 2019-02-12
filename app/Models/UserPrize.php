<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class UserPrize extends Model
{
    protected $table = 'prize_to_user';

    protected $fillable = ['user_id', 'prize_id', 'prize_type', 'value', 'status'];

    public const STATUS_NEW = 'new';

    public const STATUS_SEND = 'sent';

    public const STATUS_CONVERT = 'convert_to_money';

    public const STATUS_REFUSED = 'refused';


    /**
     * @param User $user
     * @param array $data
     * @return UserPrize
     */
    public static function add(User $user, array $data): self
    {
        $methodAdd = 'add' . ucfirst(strtolower($data['type']));
        $self = new self;
        $self = $self->$methodAdd($user, $data['prize']);
        return $self;
    }


    /**
     * @param User $user
     * @param $prize
     * @return mixed
     */
    private function addBonus(User $user, $prize): self
    {
        $self = self::create([
            'user_id' => $user->id,
            'prize_type' => 'bonus',
            'value' => $prize,
            'status' => self::STATUS_NEW
        ]);

        $user->addBonus($prize);

        return $self;
    }

    /**
     * @param User $user
     * @param $prize
     * @return UserPrize
     */
    private function addMoney(User $user, $prize): self
    {
        $self = self::create([
            'user_id' => $user->id,
            'prize_type' => 'money',
            'value' => $prize,
            'status' => self::STATUS_NEW
        ]);

        $user->addMoney($prize);

        return $self;
    }

    /**
     * @param User $user
     * @param Prize $prize
     * @return UserPrize
     */
    private function addPhysical(User $user, Prize $prize): self
    {
        $self = self::create([
            'user_id' => $user->id,
            'prize_id' => $prize->id,
            'prize_type' => 'physical',
            'value' => null,
            'status' => self::STATUS_NEW
        ]);
        $prize->noAvailable();

        return $self;
    }


    /**
     * @return Relation
     */
    public function physicalPrize() : Relation
    {
        return $this->belongsTo(Prize::class, 'prize_id');
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        $html = '';
        if ($prize = $this->physicalPrize()->first()) {
            $html .= $prize->title . "<br /> <img style='max-width: 100px' src='{$prize->poster}'>";
        } else {
            $html .= $this->value . " " . $this->prize_type;
        }

        return $html;
    }


    /**
     * @return string
     */
    public function getStatus(): string
    {
        $html = '<span class="badge ';
        switch ($this->status) {
            case 'new' :
                $html .= 'badge-primary">';
                break;
            case 'sent' :
                $html .= 'badge-success">';
                break;
            case 'convert_to_money' :
                $html .= 'badge-warning">';
                break;
            case 'refused' :
                $html .= 'badge-danger">';
                break;
        }

        $html .= $this->status;
        $html .= "</span>";

        return $html;

    }


    /**
     * @return array
     */
    public function getActions(): array
    {
        $actions = [];

        if ($this->status == self::STATUS_NEW) {
            $actions[] = [
                'url' => 'prize/refuse',
                'text' => 'Отказаться',
                'label' => 'danger'
            ];
        }


        switch ($this->prize_type) {
            case 'physical' :
                $actions = array_merge($this->getActionForPhysical(), $actions);
                break;
            case 'bonus' :
                $actions = array_merge($this->getActionForBonus(), $actions);
                break;
        }

        return $actions;
    }


    /**
     * @return array
     */
    private function getActionForPhysical(): array
    {
        $actions = [];
        if ($this->status == self::STATUS_NEW) {
            $actions[] = [
                'url' => 'prize/sent',
                'text' => 'Отправить',
                'label' => 'success'
            ];
        }
        return $actions;
    }


    /**
     * @return array
     */
    private function getActionForBonus(): array
    {
        $actions = [];
        if ($this->status == self::STATUS_NEW) {
            $actions[] = [
                'url' => 'prize/transform',
                'text' => 'Перевести в деньги',
                'label' => 'warning'
            ];
        }
        return $actions;
    }


    /**
     *
     */
    public function sent()
    {
        $this->update(['status' => self::STATUS_SEND]);
    }


    /**
     * @param User $user
     */
    public function convert(User $user): void
    {
        $user->addMoney($this->value * Setting::getKoefTransform());
        $user->addBonus($this->value * (-1));
        $this->update(['status' => self::STATUS_CONVERT]);
    }


    /**
     * @param User $user
     */
    public function refuse(User $user)
    {
        $this->update(['status' => self::STATUS_REFUSED]);
        if ($this->type == 'physical') {
            $this->physicalPrize()->first()->update(['status' => Prize::AVAILABLE]);
        }
    }
}
