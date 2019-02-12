<?php

namespace App;

use AlexMuller\ImageCache\ImageCache;
use App\Models\Setting;
use App\Models\User\RBAC\Traits\RBAC;
use App\Models\UserPrize;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;


/**
 * Class User
 * @property string|null $name
 * @property string|null $lastname
 * @property string $email
 * @property string $birthday
 * @property integer $money
 * @property integer $bonuses
 * @property string $card
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens, RBAC;

    protected $dates = ['created_at', 'updated_at', 'birthday'];

    protected $fillable = [
        'name',
        'lastname',
        'email',
        'phone',
        'birthday',
        'gender',
        'last_login',
        'money',
        'bonuses',
        'card'
    ];

    protected $visible = [
        'id', 'lastname', 'name', 'smallAvatar', 'pivot', 'fullname', 'money', 'bonuses', 'card'
    ];

    protected $casts = [
        'confirmed' => 'boolean'
    ];

    protected $appends = ['smallAvatar', 'location', 'fullname'];


    /**
     * @param integer $bonus
     */
    public function addBonus($bonus)
    {

        $this->bonuses += $bonus;
        $this->save();
    }


    /**
     * @param integer $money
     */
    public function addMoney($money)
    {
        $this->money += $money;
        $this->save();
    }


    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeConfirmed(Builder $query): Builder
    {
        return $query->where('confirmed', true);
    }


    /**
     * @return mixed|string
     */
    public function getRefToken()
    {
        if (auth()->check() && auth()->user()->id === $this->id) {
            return $this->ref_token;
        }
    }


    /**
     * @return string|null
     */
    public function getFullnameAttribute()
    {
        $fullname = $this->name;
        $fullname .= $this->lastname ? ' ' . $this->lastname : '';
        return $fullname;
    }


    /**
     * @return bool|int
     */
    public function getAgeAttribute()
    {
        if ($this->birthday) {
            return Carbon::now()->diffInYears($this->birthday);
        }

        return false;
    }


    /**
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search = ''): Builder
    {
        if ($search) {
            $words = explode(' ', $search);
            $words = array_filter($words);
            $words = array_slice($words, 0, 2);

            if (count($words) < 2) {
                $query
                    ->where('name', 'like', $words[0] . '%')
                    ->orWhere('lastname', 'like', $words[0] . '%');
            } else {
                $query
                    ->where([
                        ['name', 'like', $words[0] . '%'],
                        ['lastname', 'like', $words[1] . '%']
                    ])
                    ->orWhere([
                        ['name', 'like', $words[1] . '%'],
                        ['lastname', 'like', $words[0] . '%']
                    ]);
            }

        }

        return $query;
    }


    /**
     * @return bool|mixed
     */
    public function getSmallAvatarAttribute()
    {
        $avatar = $this->avatar ?: 'no-avatar.png';

        return ImageCache::imageResize(200, 200, $avatar);
    }

    /**
     * @return Relation
     */
    public function settings(): Relation
    {
        return $this->morphMany(Setting::class, 'settingtable');
    }


    /**
     * @return Relation
     */
    public function prizes(): Relation
    {
        return $this->hasMany(UserPrize::class);
    }


    /**
     * @return string
     */
    public function getNumberCard(): string
    {
        return $this->card;
    }


    /**
     *
     */
    public function emptyYourWallet(): void
    {
        $this->update(['money' => 0]);
    }

}
