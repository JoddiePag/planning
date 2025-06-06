<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soins extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'traitement',
        'type_dent',
        'prix',
        'dent', 
        'recu',
        'reste',
        // 'overlay_type',
        'overlay_position',
        // 'type_dent',
    ];
    public function patient()
{
    return $this->belongsTo(Patient::class, 'patient_id');
}
// rdv

public function rendezVous()
{
    return $this->belongsTo(Rendez_vous::class);
}

}
