<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rendez_vous extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'date_heure_rdv',
        'heure_fin',
        'statut',
    ];

    // **C'est ici que vous devez vous assurer que `date_heure_rdv` est inclus :**
    protected $dates = [
        'date_heure_rdv', 
        'created_at',
        'updated_at',
    ];

    /**
     * Get the patient that owns the rendez_vous.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patients::class);
    }
    // soins
   
    // Dans le modèle Rendez_vous
public function soins()
{
    return $this->hasMany(Soins::class);
}


}