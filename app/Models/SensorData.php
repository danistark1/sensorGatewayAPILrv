<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static findOrFail(int $id)
 * @method static create(array $all)
 * @method static saveOrFail(array $all)
 * @property array xAttributes
 * @property array value
 */
class SensorData extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
        'location',
        'sensor_id',
        'xAttributes',
        'created_at',
        'updated_at'
        ];
//    const LIVING_ROOM = 'living-room';
//    const BEDROOM = 'bedroom';
//    const BASEMENT = 'basement';

    protected $casts = [
        "value" => "array",
        "xAttributes" => "array"
    ];

//    const Sensor_NAMES = [
//
//
//    ];

    /**
     * @param string $xattributeField
     * @return mixed
     */
    public function getJsonxAttribute(string $xattributeField) {
        return $this->xAttributes[$xattributeField];
    }

    public function setJsonxAttributes($field, $value) {
        $this->xAttributes[$field] = $value;
    }

    /**
     * @param string $field
     * @return mixed
     */
    public function getJsonValue(string $field) {
        return $this->value[$field];
    }

    /**
     * @param string $field
     * @return mixed
     */
    public function setJsonValue(string $field, $value) {
        return $this->value[$field] = $value;
    }

    /**
     * One-to-one relationship: Each sensor can have one type.
     *
     * @return HasOne
     */
    public function sensorType(): HasOne
    {
        return $this->hasOne(SensorType::class, 'sensor_data_id');
    }
}
