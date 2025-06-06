<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Ordonnance extends Model
{
    protected $fillable = [
        'patient_id',
        'dentiste_id',
        'type_ordonnance',
        // 'content',
    ];
    // use HasFactory;
  public function patient(): BelongsTo
    {
        return $this->belongsTo(Patients::class);
    }
     public function dentiste()
    {
        // return $this->belongsTo(Dentiste::class);
         return $this->belongsTo(Dentiste::class, 'dentiste_id');
    }
    
}
