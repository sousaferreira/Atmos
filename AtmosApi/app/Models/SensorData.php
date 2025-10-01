<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    // Força o Laravel a usar a tabela correta
    protected $table = 'sensor_data'; // verifique o nome exato no banco

    // Permite atribuição em massa
    protected $fillable = [
        'luminosity',
        'rain',
        'temperature',
        'humidity'
    ];

    
    public $timestamps = true;
}
