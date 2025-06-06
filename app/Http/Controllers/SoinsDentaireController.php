<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SoinsDentaireController extends Controller
{
    // public function modification_soins_mixte()
    // {
    //     return view('pages.soins_dentaire.base_soins_dentaire.modification_soins_mixte'); 
    // }
    public function modification_soins_permanent($patientId)
{
    $patient = Patients::findOrFail($patientId);
    $soins = Soins::where('patient_id', $patientId)
                ->where('type_dent', 'permanent')
                ->get();

    return view('pages.soins_dentaire.base_soins_dentaire.modification_soins_permanent', [
        'patient' => $patient,
        'soins' => $soins,
        'imagePath' => 'images/dent_modifier1.png',
        'mapAreas' => config('soins.coords_permanent')
    ]);
}
    // public function modification_soins_permanent()
    // {
    //     return view('pages.soins_dentaire.base_soins_dentaire.modification_soins_permanent'); 
    // }
    public function modification_soins_mixte($patientId)
{
    $patient = Patient::findOrFail($patientId);
    $soins = Soin::where('patient_id', $patientId)
                ->where('type_dent', 'mixte')
                ->get();

    return view('pages.soins_dentaire.base_soins_dentaire.modification_soins_mixte', [
        'patient' => $patient,
        'soins' => $soins,
        'imagePath' => 'images/DentMixte.png',
        'mapAreas' => config('soins.coords_mixte')
    ]);
}
}
