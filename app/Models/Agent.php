<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model 
{
    use HasFactory;
    protected $fillabel=[
        'id',
        'Nom',
        'Prenom',
        'CIN',
        'Email',
        'Adresse',
        'Matricule',
        'img',
        'Password'
    ];
    protected $guarded = [];
}
