<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
class Patients extends Model
{
    use HasFactory;
 protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'age',
        'motif',
        'antecedents_medicaux',
        'traitements',
        'ordonnance',
        'dentiste_id',
        'total_soins',
        
    ];
    public function dentiste()
    {
        return $this->belongsTo(Dentiste::class);
    }
    public function soins()
    {
        return $this->hasMany(Soins::class, 'patient_id');
    }
    
    // public function rendezvous()
    // {
    //     return $this->hasMany(Rendez_vous::class, 'patients_id');
    // }
    public function rendezVous() 
    {
        return $this->hasMany(Rendez_vous::class, 'patient_id'); 
    }
    public function prochainRendezVous()
{
    return $this->hasOne(Rendez_vous::class, 'patient_id')->orderBy('date_heure_rdv', 'asc');
}
// Ajoutez cette relation pour récupérer tous les soins groupés par type
// public function soinsParType()
// {
//     return $this->hasMany(Soins::class)->get()->groupBy('type_dent');
// }
}
