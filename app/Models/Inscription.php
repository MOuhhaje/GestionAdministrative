<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;
    protected $fillabel=[
        'id',
        'Nom',
        'Prenom',
        'CIN',
        'Email',
        'Adresse',
        'Naissance',
        'Genre',
        'F_ID'
    ];
    protected $guarded = [];
}
