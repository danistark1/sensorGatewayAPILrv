<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sensorData extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
        'location',
        'sensorID'
        ];

    /**
     * One-to-one relationship: Each sensor can have one type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function type() {
        return $this->hasOne('App\Models\sensorType');
    }
}
