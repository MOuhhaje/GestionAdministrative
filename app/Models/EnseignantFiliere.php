<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnseignantFiliere extends Model 
{
    use HasFactory;
    protected $fillabel=[
        'id',
        'id_P',
        'id_F',
        'Module',
        'Heures'
    ];
    protected $guarded = [];
}
