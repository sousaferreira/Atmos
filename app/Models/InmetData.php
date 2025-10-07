<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InmetData extends Model
{
    protected $table = 'weather_data';

    protected $fillable = [
        'observed_at',
        'temperature',
        'humidity',
        'pressure',
        'wind_speed',
        'rainfall'
    ];

    protected $casts = [
        'observed_at' => 'datetime',
        'temperature' => 'float',
        'humidity' => 'float',
        'pressure' => 'float',
        'wind_speed' => 'float',
        'rainfall' => 'float',
    ];

    public $timestamps = true; // sua tabela tem created_at/updated_at
}
