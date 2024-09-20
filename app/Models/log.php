<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class log extends Model
{
    use HasFactory;
    protected $table='log';

    protected $fillable = [
        'ip',
        'route',
        'route_url',
        'route_path',
        'prev_url'
    ];
}
