<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Car
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Car newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Car newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Car query()
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $brand
 * @property string $model
 * @property string $km
 * @property string $color
 * @property string $transmission
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|Car onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereKm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereTransmission($value)
 * @method static \Illuminate\Database\Query\Builder|Car withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Car withoutTrashed()
 */
class Car extends Model {
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'brand', 'model', 'km', 'color', 'transmission'
    ];

    public function rules() {
        return [
            'brand' => 'required',
            'model' => 'required',
            'km' => 'required|integer',
            'color' => 'required',
            'transmission' => 'required'
        ];
    }

    public function messages() {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'km.integer' => 'O campo quilometragem deve ser um inteiro',
        ];
    }

    public function attributes() {
        return ['brand' => 'marca', 'model' => 'modelo', 'km' => 'quilometragem', 'color' => 'cor', 'transmission' => 'câmbio'];
    }
}
