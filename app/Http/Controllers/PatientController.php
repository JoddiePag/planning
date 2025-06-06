<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Patients; //models Patients
use App\Models\Soins;
use App\Models\Rendez_vous;
use App\Models\Ordonnance;
use App\Models\Dentiste;
use Carbon\Carbon;

class PatientController extends Controller
{
    public function ajout_patient()
    {
        return view('pages.patient.ajout_patient'); 
    }
    public function savePatient(Request $request)
    {
        // Vérifier si le patient existe déjà (même nom, prénom, date de naissance et dentiste)
        $existingPatient = Patients::where('nom', $request->nom)
            ->where('prenom', $request->prenom)
            ->where('date_naissance', $request->date_naissance)
            ->where('dentiste_id', session('dentiste_id'))
            ->first();
    
        if ($existingPatient) {
            return redirect()->back()->with('error', 'Ce patient existe déjà dans votre base de données.');
        }
    
        //  le patient
        $patient = new Patients();
        $patient->nom = $request->nom;
        $patient->prenom = $request->prenom;
        $patient->date_naissance = $request->date_naissance;
        $patient->age = $request->age;
        $patient->motif = $request->motif;
        $patient->antecedents_medicaux = $request->antecedents_medicaux;
        $patient->traitements = $request->traitements;
        $patient->ordonnance = $request->ordonnance;
        $patient->dentiste_id = session('dentiste_id');
        $patient->total_soins = $request->total_soins;
       
        $patient->save();
    
        // le rendez-vous 
        if ($request->prochain_rdv && $request->heure_rdv) {
            $rendezVous = new Rendez_vous();
            $rendezVous->patient_id = $patient->id;
            $rendezVous->date_heure_rdv = $request->prochain_rdv . ' ' . $request->heure_rdv;
            $rendezVous->heure_fin = $request->heure_fin;
            $rendezVous->save();
        }
    
        // soins
        $soins = json_decode($request->soins, true);
    if (is_array($soins)) {
        foreach ($soins as $soinData) {
            $nouveauSoin = new Soins();
            $nouveauSoin->patient_id = $patient->id;
            $nouveauSoin->dent = $soinData['dent'];
            $nouveauSoin->traitement = $soinData['traitement'];
            $nouveauSoin->type_dent = $soinData['type_dent'];
            $nouveauSoin->prix = $soinData['prix'];
            $nouveauSoin->recu = $soinData['recu'] ?? 0;
            $nouveauSoin->reste = $soinData['reste'] ?? $soinData['prix'];

            $nouveauSoin->overlay_position = json_encode([
                'x1' => $soinData['x1'] ?? 0,
                'y1' => $soinData['y1'] ?? 0,
                'x2' => $soinData['x2'] ?? 0,
                'y2' => $soinData['y2'] ?? 0
            ]);

            $nouveauSoin->save();
        }
        }

          return redirect()->route('modification_patient', ['id' => $patient->id])
            ->with('success', 'Patient et rendez-vous enregistrés avec succès.');
        
    }
    // public function savePatient(Request $request)
    // {
    //     // Vérifier si le patient existe déjà (même nom, prénom, date de naissance et dentiste)
    //     $existingPatient = Patients::where('nom', $request->nom)
    //         ->where('prenom', $request->prenom)
    //         ->where('date_naissance', $request->date_naissance)
    //         ->where('dentiste_id', session('dentiste_id'))
    //         ->first();

    //     if ($existingPatient) {
    //         return redirect()->back()->with('error', 'Ce patient existe déjà dans votre base de données.');
    //     }

    //     // Créer le patient
    //     $patient = new Patients();
    //     $patient->nom = $request->nom;
    //     $patient->prenom = $request->prenom;
    //     $patient->date_naissance = $request->date_naissance;
    //     $patient->age = $request->age;
    //     $patient->motif = $request->motif;
    //     $patient->antecedents_medicaux = $request->antecedents_medicaux;
    //     $patient->traitements = $request->traitements;
    //     $patient->ordonnance = $request->ordonnance;
    //     $patient->dentiste_id = session('dentiste_id');
    //     $patient->total_soins = $request->total_soins;

    //     $patient->save();

    //     // Enregistrer le rendez-vous
    //      if ($request->prochain_rdv && $request->heure_rdv) {
    //         $rendezVous = new Rendez_vous();
    //         $rendezVous->patient_id = $patient->id;
    //         $rendezVous->date_heure_rdv = $request->prochain_rdv . ' ' . $request->heure_rdv;
    //         $rendezVous->heure_fin = $request->heure_fin;
    //         $rendezVous->save();
    //      }
    //     // Enregistrer les soins
    //     $soins = json_decode($request->soins, true);

    //     if (is_array($soins)) {
    //         foreach ($soins as $soin) {
    //             $nouveauSoin = new Soins();
    //             $nouveauSoin->patient_id = $patient->id;
    //             $nouveauSoin->dent = $soin['dent'];
    //             $nouveauSoin->traitement = $soin['traitement'];
    //             $nouveauSoin->type_dent = $soin['type_dent'];
    //             $nouveauSoin->prix = $soin['prix'];
    //             $nouveauSoin->recu = $soin['recu'] ?? 0;
    //             $nouveauSoin->reste = $soin['reste'] ?? $soin['prix'];

    //             $nouveauSoin->save();
    //         }
    //     }

    //     // --- Préparer les données pour la redirection vers la vue d'ordonnance ---

    //     // 1. Récupérer l'objet Dentiste connecté
    //     // Assurez-vous d'avoir un modèle Dentiste et qu'il est accessible via session('dentiste_id')
    //     $dentiste = Dentiste::find(session('dentiste_id'));

    //     // 2. Récupérer le contenu de l'ordonnance
    //     // Si 'ordonnance' est un champ dans votre modèle Patient, vous pouvez l'accéder directement
    //     $ordonnance = $patient->ordonnance;

    //     // Rediriger vers la vue 'pages.ordonnance.extraction_simple' en passant les données nécessaires
    //     // return view('pages.ordonnance.extraction_simple', compact('dentiste', 'patient', 'ordonnance'))
    //     //        ->with('success', 'Patient et rendez-vous enregistrés avec succès.');
       
    // }

public function listes_patients(Request $request)
{
    $search = $request->input('search');

    $patients = Patients::with('rendezVous')
        ->where('dentiste_id', session('dentiste_id'))
        ->orderBy('id', 'desc')
        ->when($search, function ($query, $search) {
            // Séparer les termes de recherche
            $terms = explode(' ', $search);

            $query->where(function($q) use ($terms, $search) {
                // Recherche dans chaque champ séparément
                $q->where('nom', 'like', '%' . $search . '%')
                  ->orWhere('prenom', 'like', '%' . $search . '%');

                // Si plusieurs termes, chercher les combinaisons
                if (count($terms) > 1) {
                    $q->orWhere(function($q2) use ($terms) {
                        // Combinaison "nom + prénom"
                        $q2->where('nom', 'like', '%' . $terms[0] . '%')
                           ->where('prenom', 'like', '%' . $terms[1] . '%');
                    })
                    ->orWhere(function($q2) use ($terms) {
                        // Combinaison "prénom + nom"
                        $q2->where('prenom', 'like', '%' . $terms[0] . '%')
                           ->where('nom', 'like', '%' . $terms[1] . '%');
                    });
                }
            });
        })
        ->paginate(10);

    return view('pages.patient.listes_patients', compact('patients', 'search'));
}

    public function supprimerPatients(Request $request)
    {
        if ($request->has('patient_ids')) {
            Patients::whereIn('id', $request->input('patient_ids'))->delete();
            return redirect()->route('listes_patients')->with('success', 'Les patients sélectionnés ont été supprimés.');
        } else {
            return redirect()->route('listes_patients')->with('error', 'Veuillez sélectionner des patients à supprimer.');
        }
    }

    // affichage modification 
public function modification_patient($id)
{
    $patients = Patients::with([
        'rendezVous' => function($query) {
            // Pour le plus récent rendez-vous en général (par date_heure_rdv)
            $query->orderBy('date_heure_rdv', 'desc');
        },
        'dentiste'
    ])->find($id);
   $ordonnances = Ordonnance::where('patient_id', $id)->get();
    // return view('pages.patient.modification_patient')->with('patients', $patients);
     return view('pages.patient.modification_patient')->with('patients', $patients)->with('ordonnances', $ordonnances);
   
}

// public function modification_soins_dent($id)
// {
//     try {
//         $patient = Patients::with(['soins' => function($query) {
//             $query->where('type_dent', 'Dent Permanente');
//         }])->findOrFail($id);

//         // Debug: Vérifiez les données avant envoi à la vue
//         \Log::info('Patient data:', $patient->toArray());
//         \Log::info('Soins data:', $patient->soins->toArray());

//         return view('pages.soins_dentaire.modification_soins_dent', [
//             'patient' => $patient,
//             'soins' => $patient->soins ,
//             //  'soinsList' => $soinsList,
            
//         ]);

//     } catch (\Exception $e) {
//         \Log::error('Error: '.$e->getMessage());
//         return redirect()->back()->with('error', 'Erreur technique');
//     }
// }
// public function modification_soins_dent($id)
// {
//     try {
//         $patient = Patients::with(['soins' => function($query) {
//             $query->where('type_dent', 'Dent Permanente');
//         }])->findOrFail($id);

//         // Convertir les soins en format compatible avec le JavaScript
//         $soinsList = $patient->soins->map(function($soin) {
//             return [
//                 'dent' => $soin->dent,
//                 'traitement' => $soin->traitement,
//                 'type_dent' => $soin->type_dent,
//                 'prix' => $soin->prix,
//                 'recu' => $soin->recu,
//                 'reste' => $soin->reste,
                
//             ];
//         })->toArray();

//         return view('pages.soins_dentaire.modification_soins_dent', [
//             'patient' => $patient,
//             'soins' => $patient->soins,
//             'soinsList' => $soinsList
//         ]);

//     } catch (\Exception $e) {
//         \Log::error('Error: '.$e->getMessage());
//         return redirect()->back()->with('error', 'Erreur technique');
//     }
// }
public function modification_soins_dent($id)
{
    try {
        $patient = Patients::with('soins')->findOrFail($id);
        
        $soinsList = $patient->soins->map(function($soin) {
            $position = json_decode($soin->overlay_position, true);
            return [
                'dent' => $soin->dent,
                'traitement' => $soin->traitement,
                'type_dent' => $soin->type_dent,
                'prix' => $soin->prix,
                'recu' => $soin->recu,
                'reste' => $soin->reste,
                'x1' => $position['x1'] ?? 0,
                'y1' => $position['y1'] ?? 0,
                'x2' => $position['x2'] ?? 0,
                'y2' => $position['y2'] ?? 0
            ];
        })->toArray();

        return view('pages.soins_dentaire.modification_soins_dent', [
            'patient' => $patient,
            'soins' => $patient->soins,
            'soinsList' => $soinsList
        ]);

    } catch (\Exception $e) {
        \Log::error('Error in modification_soins_dent: '.$e->getMessage());
        return redirect()->back()->with('error', 'Erreur technique lors du chargement des soins.');
    }
}

// dent mixte
// public function modification_dents_mixte($id)
// {
//     $patient = Patients::with('soins')->find($id);

//     if (!$patient) {
//         return redirect()->back()->with('error', 'Patient introuvable');
//     }

//     return view('pages.soins_dentaire.modification_dent_mixte', compact('patient'));
// }
// public function modification_dents_mixte($id)
// {
//     $patient = Patients::with(['soins' => function($query) {
//         $query->where('type_dent', 'Dent Mixte');
//     }])->find($id);

//     if (!$patient) {
//         return redirect()->back()->with('error', 'Patient introuvable');
//     }

//     $totalMixte = $patient->soins->sum('prix');
//     $patient->total_soins = $totalMixte;

//     return view('pages.soins_dentaire.modification_dent_mixte', compact('patient'));
// }
// public function modification_dents_mixte($id)
// {
//     $patient = Patients::with(['soins' => function($query) {
//         $query->where('type_dent', 'Dent Mixte');
//     }])->find($id);

//     if (!$patient) {
//         return redirect()->back()->with('error', 'Patient introuvable');
//     }

//     $totalMixte = $patient->soins->sum('prix');
//     $patient->total_soins = $totalMixte;

//     return view('pages.soins_dentaire.modification_dent_mixte', compact('patient'));
// }
public function modification_dents_mixte($id)
{
    try {
        $patient = Patients::with(['soins' => function($query) {
            $query->where('type_dent', 'Dent Mixte');
        }])->findOrFail($id);

        // Debug: Vérifiez les données avant envoi à la vue
        \Log::info('Patient data:', $patient->toArray());
        \Log::info('Soins data:', $patient->soins->toArray());

        return view('pages.soins_dentaire.modification_dent_mixte', [
            'patient' => $patient,
            'soins' => $patient->soins 
        ]);

    } catch (\Exception $e) {
        \Log::error('Error: '.$e->getMessage());
        return redirect()->back()->with('error', 'Erreur technique');
    }
}

 public function patient_update(Request $request, $id)
    {
        $patient = Patients::findOrFail($id);

        // --- Mise à jour des informations générales du patient ---
        $patient->nom = $request->nom;
        $patient->prenom = $request->prenom;
        $patient->date_naissance = $request->date_naissance;
        $patient->age = $request->age;
        $patient->motif = $request->motif;
        $patient->antecedents_medicaux = $request->antecedents;
        $patient->traitements = $request->traitements;
        $patient->ordonnance = $request->ordonnance;
        $patient->total_soins = $request->total_soins ?? 0;
        $patient->save();

        // --- GESTION DES RENDEZ-VOUS ---
        // (Votre code de gestion des rendez-vous existant, inchangé)
        $rendezVousId = $request->input('rendez_vous_id');
        $prochainRdvInput = $request->input('prochain_rdv');
        $heureRdvInput = $request->input('heure_rdv');
        $heureFinInput = $request->input('heure_fin');
        $statutRdvInput = $request->input('statut');

        if ($request->filled('prochain_rdv') && $request->filled('heure_rdv')) {
            $dateHeureRdv = Carbon::parse($prochainRdvInput . ' ' . $heureRdvInput);
            $rendezVous = null;

            if ($rendezVousId) {
                $rendezVous = Rendez_vous::find($rendezVousId);
            }

            if ($rendezVous) {
                $existingRdvDate = Carbon::parse($rendezVous->date_heure_rdv);

                if ($existingRdvDate->equalTo($dateHeureRdv)) {
                    $rendezVous->update([
                        'heure_fin' => $heureFinInput,
                        'statut' => $statutRdvInput,
                    ]);
                } else {
                    $patient->rendezVous()->create([
                        'date_heure_rdv' => $dateHeureRdv,
                        'heure_fin' => $heureFinInput,
                        'statut' => $statutRdvInput,
                    ]);
                }
            } else {
                $patient->rendezVous()->create([
                    'date_heure_rdv' => $dateHeureRdv,
                    'heure_fin' => $heureFinInput,
                    'statut' => $statutRdvInput,
                ]);
            }
        } else {
            $latestRdv = $patient->rendezVous()->latest('date_heure_rdv')->first();
            if ($latestRdv) {
                $latestRdv->update([
                    'statut' => $statutRdvInput,
                ]);
            }
        }
// 
if ($request->has('planifier_rdv')) {
        // Stocker l'ID du patient dans la session pour la redirection
        session(['nouveau_patient_id' => $patient->id]);
        
        // Rediriger vers la page des rendez-vous
        return redirect()->route('rendez_vous');
    }
// 
        if ($request->has('soins')) {
            $newSoinsData = json_decode($request->soins, true);

            if (is_array($newSoinsData)) {
                foreach ($newSoinsData as $soin) {
                    $newSoin = new Soins();
                    $newSoin->patient_id = $patient->id;
                    $newSoin->dent = $soin['dent'];
                    $newSoin->traitement = $soin['traitement'];
                    $newSoin->type_dent = $soin['type_dent'] ?? null;
                    $newSoin->prix = $soin['prix'] ?? 0;
                    $newSoin->recu = $soin['recu'] ?? 0;
                    $newSoin->reste = $newSoin->prix - $newSoin->recu; 
    //                  $soin->overlay_type = 'consultation'; 
    // $soin->overlay_position = 0; 
     $newSoin->overlay_position = json_encode([
                'x1' => $soinData['x1'] ?? 0,
                'y1' => $soinData['y1'] ?? 0,
                'x2' => $soinData['x2'] ?? 0,
                'y2' => $soinData['y2'] ?? 0
            ]);

                    $newSoin->save();
                }
            }
        }

        // --- NOUVEAU BLOC : MISE À JOUR DES SOINS EXISTANTS ---
        if ($request->has('existing_soins') && is_array($request->input('existing_soins'))) {
        foreach ($request->input('existing_soins') as $soinId => $soinData) {
            $soin = Soins::where('patient_id', $patient->id)->findOrFail($soinId);

            // Récupérer les valeurs
            $ancienRecu = $soin->recu;
            $nouveauPaiement = (float) ($soinData['nouveau_paiement'] ?? 0);
            $totalRecu = $ancienRecu + $nouveauPaiement;
            $prix = (float) ($soinData['prix'] ?? $soin->prix);
            $reste = $prix - $totalRecu;

            $soin->update([
                'prix' => $prix,
                'recu' => $totalRecu,
                'reste' => $reste,
            ]);
            }
        }

        return redirect()->route('modification_patient', ['id' => $patient->id])
            ->with('success', 'Patient, rendez-vous et soins mis à jour avec succès.');
    }
// public function patient_update(Request $request, $id)
// {
//     $patient = Patients::findOrFail($id);

//     // --- Mise à jour des informations générales du patient ---
//     $patient->nom = $request->nom;
//     $patient->prenom = $request->prenom;
//     $patient->date_naissance = $request->date_naissance;
//     $patient->age = $request->age;
//     $patient->motif = $request->motif;
//     $patient->antecedents_medicaux = $request->antecedents;
//     $patient->traitements = $request->traitements;
//     $patient->ordonnance = $request->ordonnance;
//     $patient->total_soins = $request->total_soins ?? 0;
//     $patient->save();

//     // --- GESTION DES RENDEZ-VOUS ---
//     $rendezVousId = $request->input('rendez_vous_id');
//     $prochainRdvInput = $request->input('prochain_rdv');
//     $heureRdvInput = $request->input('heure_rdv');
//     $heureFinInput = $request->input('heure_fin');
//     $statutRdvInput = $request->input('statut');

//     if ($request->filled('prochain_rdv') && $request->filled('heure_rdv')) {
//         $dateHeureRdv = Carbon::parse($prochainRdvInput . ' ' . $heureRdvInput);
//         $rendezVous = null;

//         if ($rendezVousId) {
//             $rendezVous = Rendez_vous::find($rendezVousId);
//         }

//         if ($rendezVous) {
//             $existingRdvDate = Carbon::parse($rendezVous->date_heure_rdv);

//             if ($existingRdvDate->equalTo($dateHeureRdv)) {
//                 $rendezVous->update([
//                     'heure_fin' => $heureFinInput,
//                     'statut' => $statutRdvInput,
//                 ]);
//             } else {
//                 $patient->rendezVous()->create([
//                     'date_heure_rdv' => $dateHeureRdv,
//                     'heure_fin' => $heureFinInput,
//                     'statut' => $statutRdvInput,
//                 ]);
//             }
//         } else {
//             $patient->rendezVous()->create([
//                 'date_heure_rdv' => $dateHeureRdv,
//                 'heure_fin' => $heureFinInput,
//                 'statut' => $statutRdvInput,
//             ]);
//         }
//     } else {
//         $latestRdv = $patient->rendezVous()->latest('date_heure_rdv')->first();
//         if ($latestRdv) {
//             $latestRdv->update([
//                 'statut' => $statutRdvInput,
//             ]);
//         }
//     }

  
    
//     return redirect()->route('modification_patient', ['id' => $patient->id])
//         ->with('success', 'Patient, rendez-vous et soins mis à jour avec succès.');
// }
// creation rdv 
public function creationRdv(Request $request)
{
    // Vérifie si le patient existe déjà (même nom, prénom et dentiste)
    $existingPatient = Patients::where('nom', $request->nom)
        ->where('prenom', $request->prenom)
        ->where('dentiste_id', session('dentiste_id'))
        ->first();

    if ($existingPatient) {
        return redirect()->back()->with('error', 'Ce patient existe déjà dans votre base de données.');
    }

    // 1. Créer le patient (nouveau)
    $patient = new Patients();
    $patient->nom = $request->nom;
    $patient->prenom = $request->prenom;
    $patient->date_naissance = '2000-01-01'; 
    $patient->age = 0; 
    $patient->dentiste_id = session('dentiste_id'); 
    $patient->save();

    // 2. Créer le rendez-vous
    $rendezVous = new Rendez_vous();
    $rendezVous->patient_id = $patient->id;
    $rendezVous->date_heure_rdv = $request->date; 
     $rendezVous->heure_fin = $request->heure_fin;
    $rendezVous->save();

    // 3. Créer le soin
    $soin = new Soins();
    $soin->patient_id = $patient->id;
    $soin->dent = 'Général';
    $soin->type_dent = 'Dent Permanente';
    $soin->traitement = $request->soin;
    $soin->prix = 0; 
    $soin->recu = 0; 
    $soin->reste = 0; 
    // $soin->overlay_type = 'consultation'; 
    // $soin->overlay_position = 0; 
    $soin->save();

    return redirect()->back()->with('success', 'Patient, rendez-vous et soin enregistrés avec succès.');
}


    // ordonnance
    public function showOrdonnance($patientId)
    {
        // Récupérer le dentiste connecté
        $dentiste = Dentiste::find(session('dentiste_id'));
        
        // Récupérer les informations du patient
        $patient = Patient::find($patientId);
    
        return view('pages.patient.ajout_patient', compact('dentiste', 'patient'));
    }

public function index(Request $request)
{
    
}

    
}
