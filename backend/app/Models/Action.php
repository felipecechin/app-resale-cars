<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Action
 *
 * @property int $id
 * @property int $car_id
 * @property int $user_id
 * @property string $type
 * @property string $occurrence
 * @method static \Illuminate\Database\Eloquent\Builder|Action newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Action newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Action query()
 * @method static \Illuminate\Database\Eloquent\Builder|Action whereCarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Action whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Action whereOccurrence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Action whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Action whereUserId($value)
 * @mixin \Eloquent
 */
class Action extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id', 'car_id', 'type', 'occurrence'
    ];

    public function car() {
        return $this->belongsTo(Car::class)->withTrashed();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }


}
