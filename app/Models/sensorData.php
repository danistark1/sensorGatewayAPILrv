<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static findOrFail(int $id)
 * @method static create(array $all)
 */
class sensorData extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
        'location',
        'sensorID',
        'sensor_type_id'
        ];

    protected $casts = ["value" => "array"];
//
//    /**
//     * One-to-one relationship: Each sensor can have one type.
//     *
//     * @return BelongsTo
//     */
//    public function sensorType(): BelongsTo
//    {
//        return $this->hasOne('App\Models\sensorType', 'sensor_type_id');
//    }
}
