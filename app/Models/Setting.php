<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;


/**
 * Class Setting
 * @property string $key
 * @property string $value
 * @property boolean $is_serialize
 * @package App\Models
 */
class Setting extends Model
{
    protected $fillable = ['settingtable_id', 'settingtable_type', 'key', 'value', 'is_serialize'];

    protected $casts = [
        'is_serialize' => 'bool'
    ];

    /**
     * @param Model $model
     * @param array $settings
     * @return Model
     */
    public static function attach(Model $model, array $settings): Model
    {
        foreach ($settings as $key => $setting) {
            $self = self::firstOrNew([
                'settingtable_id' => $model->id,
                'settingtable_type' => get_class($model),
                'key' => $setting['key']
            ]);
            $self->key = $setting['key'];
            $self->value = $setting['value'];
            $self->is_serialize = (int)is_array($setting);
            $self->save();
        }
        return $model;
    }


    /**
     * @return Relation
     */
    public function settingtable(): Relation
    {
        return $this->morphTo();
    }


    /**
     * @return string
     */
    public static function getLimitMoneyValue(): string
    {
        $limitMoney = Setting::where('key', 'limit_money')->first();
        return $limitMoney->value ?? '';
    }


    /**
     * @return string
     */
    public static function getKoefTransform() : string
    {
        $koef = Setting::where('key', 'k_convert')->first();
        return $koef->value ?? '';
    }
}
