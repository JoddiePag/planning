<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'adresse',
        'motif_consultation',
        'antecedents',
        'traitements_en_cours',
        'status',
    ];
}
