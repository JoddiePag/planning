<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patients; //models Patients
use App\Models\Soins;
use App\Models\Rendez_vous;
use App\Models\Dentiste; 
use App\Models\Ordonnance; 
use Illuminate\Support\Facades\DB;

class OrdonnanceController extends Controller
{
//     public function cas_simple()
// {
  

//     return view('pages.ordonnance.cas_simple');
// }
  public function cas_simple($id)
    {
        // Récupérer le dentiste connecté
        $dentiste = Dentiste::find(session('dentiste_id'));
        
        // Récupérer les informations du patient
        $patient = Patients::find($id);
        $ordonnance = Ordonnance::find($id);
    
        return view('pages.ordonnance.cas_simple', compact('dentiste', 'patient','ordonnance'));
    }
    public function dent_sagesse($id)
    {
        // Récupérer le dentiste connecté
        $dentiste = Dentiste::find(session('dentiste_id'));
        
        // Récupérer les informations du patient
        $patient = Patients::find($id);
        $ordonnance = Ordonnance::find($id);
    
        return view('pages.ordonnance.dent_sagesse', compact('dentiste', 'patient','ordonnance'));
    }
     public function extraction_simple($id)
    {
        // Récupérer le dentiste connecté
        $dentiste = Dentiste::find(session('dentiste_id'));
        
        // Récupérer les informations du patient
        $patient = Patients::find($id);
        $ordonnance = Ordonnance::find($id);
    
        return view('pages.ordonnance.extraction_simple', compact('dentiste', 'patient','ordonnance'));
    }
      public function soins_simple($id)
    {
        // Récupérer le dentiste connecté
        $dentiste = Dentiste::find(session('dentiste_id'));
        
        // Récupérer les informations du patient
        $patient = Patients::find($id);
        $ordonnance = Ordonnance::find($id);
    
        return view('pages.ordonnance.soins_simple', compact('dentiste', 'patient','ordonnance'));
    }
      public function allergie_amox($id)
    {
        // Récupérer le dentiste connecté
        $dentiste = Dentiste::find(session('dentiste_id'));
        
        // Récupérer les informations du patient
        $patient = Patients::find($id);
        $ordonnance = Ordonnance::find($id);
    
        return view('pages.ordonnance.allergie_amox', compact('dentiste', 'patient','ordonnance'));
    }
       public function recommendation($id)
    {
        // Récupérer le dentiste connecté
        $dentiste = Dentiste::find(session('dentiste_id'));
        
        // Récupérer les informations du patient
        $patient = Patients::find($id);
        $ordonnance = Ordonnance::find($id);
    
        return view('pages.ordonnance.recommendation', compact('dentiste', 'patient','ordonnance'));
    }
   public function historique_ordonnance($patient_id)
{
    // Récupérer toutes les ordonnances pour le patient_id donné
    $ordonnances = DB::table('ordonnances')
                     ->where('patient_id', $patient_id)
                     ->get();

    return view('pages.ordonnance.historique_ordonnance', compact('ordonnances'));
}
   public function afficheCasSimple($ordonnance_id)
{
     $dentiste = Dentiste::find(session('dentiste_id'));
        
        // Récupérer les informations du patient
        $patient = Patients::find($id);
        $ordonnance = Ordonnance::find($id);


    return view('pages.ordonnance.afficheCasSimple', compact('dentiste', 'patient','ordonnance'));
}
   public function afficheDentSagesse($ordonnance_id)
{
    // Récupérer toutes les ordonnances pour le patient_id donné
    // $ordonnances = DB::table('ordonnances')
    //                  ->where('patient_id', $patient_id)
    //                  ->get();afficheDentSagesse

    return view('pages.ordonnance.afficheDentSagesse');
}
public function ordonnance_detail($ordonnance_id)
{
    $ordonnance = Ordonnance::findOrFail($ordonnance_id);
    
    return view('pages.ordonnance.ordonnance_detail', [
        'ordonnance' => $ordonnance, // Passer l'objet complet
        'type_ordonnance' => $ordonnance->type_ordonnance
    ]);
}
//  public function saveOrdonnance(Request $request, $patientId)
// {
//     // Debug: Vérifier les données entrantes
//     \Log::debug('Données reçues:', $request->all());
    
    

//     try {
//         // 2. Récupération du patient
//         $patient = Patient::findOrFail($patientId);
        
//         // 3. Création de l'ordonnance
//         $ordonnance = Ordonnance::create([
//             'patient_id' => $patient->id,
//             'dentiste_id' => $patient->dentiste_id, // Utilisez directement la relation
//             'type_ordonnance' => $validated['OrdonnanceType']
//         ]);

//         \Log::debug('Ordonnance créée:', $ordonnance->toArray());

//         // 4. Redirection
//         return redirect()->back()
//                          ->with('success', 'Ordonnance enregistrée!');

//     } catch (\Exception $e) {
//         \Log::error('Erreur enregistrement ordonnance:', [
//             'error' => $e->getMessage(),
//             'trace' => $e->getTraceAsString()
//         ]);
        
//         return redirect()->back()
//                          ->with('error', 'Erreur: '.$e->getMessage());
//     }
// }
public function saveOrdonnance(Request $request, $id)
{
    try {
        // Debug: Afficher les données reçues
        \Log::info('Données du formulaire:', $request->all());
        
        // Vérifier que le type d'ordonnance est bien présent
        if (!$request->has('type_ordonnance')) {
            throw new \Exception("Le type d'ordonnance est requis");
        }

        // Création de l'ordonnance
        $ordonnance = Ordonnance::create([
            'patient_id' => $id,
            'dentiste_id' => session('dentiste_id'),
            'type_ordonnance' => $request->input('type_ordonnance')
        ]);

        \Log::info('Ordonnance créée:', $ordonnance->toArray());

        return redirect()->back()
                       ->with('success', 'Ordonnance enregistrée avec succès!');

    } catch (\Exception $e) {
        \Log::error('Erreur enregistrement:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()->back()
                       ->with('error', 'Erreur lors de l\'enregistrement: ' . $e->getMessage())
                       ->withInput(); // Conserve les anciennes valeurs du formulaire
    }
}
}

