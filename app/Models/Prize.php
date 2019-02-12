<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Prize
 * @property string $title
 * @property string|null $poster
 * @property string $status
 * @property Carbon $created_at
 * @package App\Models
 */
class Prize extends Model
{
    public const AVAILABLE = 'available';

    public const NO_AVAILABLE = 'no_available';

    protected $fillable = ['title', 'poster', 'status', 'created_at'];

    protected $casts = [
        'created_at' => 'date'
    ];

    public function noAvailable()
    {
        $this->update(['status' => self::NO_AVAILABLE]);
    }

    public function issetAvailablePrize()
    {
        return self::where('status', self::AVAILABLE)->count();
    }
}
