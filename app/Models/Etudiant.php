<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;
    protected $fillabel=[
        'id',
        'Nom',
        'Prenom',
        'Naissance',
        'CIN',
        'Email',
        'Adresse',
        'Apogee',
        'F_ID',
        'Niveau',
        'Username',
        'Password'
    ];
    protected $guarded = [];
}
