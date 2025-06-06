<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dentiste extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'numero',
        'adresse',
        'motdepasse',
        'avatar',
        'qualifications',
        'remember_token', 
    ];

    public function patients()
    {
        return $this->hasMany(Patients::class);
    }
}
