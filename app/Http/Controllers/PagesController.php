<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Dentiste; //models creer Dentiste
use App\Models\Patients; 
use App\Models\Soins; 
use App\Models\Rendez_vous;

use Session;
use Carbon\Carbon;
class PagesController extends Controller
{
    //affiche bd
    public function home()
    {
        $dentiste= DB::table('dentistes')
                    // ->paginate(3);
                    ->get();
        // $dentiste = Dentiste::inRandomOrder()->paginate(4)
        return view('pages.home')->with('dentiste',$dentiste); 
    }
    // affiche detail id 
    public function show($id)
    {
        // print('id '.$id);
        $dentiste= DB::table('dentistes')
        ->where('id',$id)
        ->first();
        return view('pages.patient.show')->with('dentiste',$dentiste); 
        // return view('pages.patient.patient_modification'); 
    }
    // affichage modification dans formulaire
    public function patient_modification($id)
    {
       $dentiste = Dentiste::find($id);
        return view('pages.patient.patient_modification')->with('dentiste',$dentiste); 
       
    }
   
    public function modifier_patient(Request $request)
    {
        $dentiste = Dentiste::find($request->id);
    
        if ($dentiste) {
            $dentiste->nom = $request->nom;
            $dentiste->prenom = $request->prenom;
            $dentiste->email = $request->email;
            $dentiste->save();
    
            return redirect('/patient_modification/' . $dentiste->id)->with('success', 'Patient modifié avec succès.');
        } else {
            return redirect('/')->with('error', 'Patient introuvable.');
        }
    }
    

    // enregistrer compte dentiste dans bd
    public function savedentiste(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            // 'email' => 'required|email|unique:dentistes,email',
            'motdepasse' => [
                'required',
                'string',
                'min:6',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]+$/'

            ],
        ], [
            'motdepasse.required' => 'Le mot de passe est obligatoire.',
            'motdepasse.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
            'motdepasse.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'motdepasse.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial (@$!%*?&).',
            // 'email.unique' => 'Cette adresse email est déjà utilisée.',
        ]);
        $dentiste= New Dentiste();
        $dentiste->nom = $request->nom;
        $dentiste->prenom = $request->prenom;
        $dentiste->email = $request->email;
        $dentiste->numero = $request->numero;
        $dentiste->adresse = $request->adresse;
        $dentiste->qualifications = $request->qualifications;
        $dentiste->motdepasse = Hash::make($request->motdepasse);  
        $dentiste->motdepasse_confirmation = Hash::make($request->motdepasse_confirmation);  
        $dentiste->avatar = 'images/profiles/default-avatar.jpg';

        // $dentiste->motdepasse_confirmation = $request->motdepasse_confirmation;
        $dentiste->save();
        Session::put('message','Votre compte est enregistré');
        return redirect('/creation_compte');
        // print('ok');
    }
   
    // public function accueil()
    // {
        
    //     return view('pages.accueil'); 
    // }
    public function accueil()
    {
        $dentisteId = Session::get('dentiste_id');
        $totalPatients = Patients::where('dentiste_id', $dentisteId)->count();

        // Récupérer le nombre total de rendez-vous pour aujourd'hui pour ce dentiste
        $today = Carbon::today();
        $totalRdvAujourdhui = Rendez_vous::whereHas('patient', function ($query) use ($dentisteId) {
            $query->where('dentiste_id', $dentisteId);
        })
        ->whereDate('date_heure_rdv', $today)
        ->count();

        // Récupérer le nombre total de consultations aujourd'hui (via la table soins)
        $totalConsultationsAujourdhui = Rendez_vous::whereHas('patient', function ($query) use ($dentisteId) {
            $query->where('dentiste_id', $dentisteId);
        })
        ->whereDate('date_heure_rdv', $today)
        ->whereHas('patient.soins', function ($query) {
            $query->where('traitement', 'Consultation');
        })
        ->count();

        // Récupérer le nombre total de nouveaux patients ajoutés aujourd'hui
        $nouveauxPatientsAujourdhui = Patients::where('dentiste_id', $dentisteId)
            ->whereDate('created_at', $today)
            ->count();

        // Récupérer le nombre total de rendez-vous pour demain
        $tomorrow = Carbon::tomorrow();
        $totalRdvDemain = Rendez_vous::whereHas('patient', function ($query) use ($dentisteId) {
            $query->where('dentiste_id', $dentisteId);
        })
        ->whereDate('date_heure_rdv', $tomorrow)
        ->count();

        return view('pages.accueil', compact('totalPatients', 'totalRdvAujourdhui', 'totalConsultationsAujourdhui', 'nouveauxPatientsAujourdhui', 'totalRdvDemain'));
    }

    public function profil_update(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'numero' => 'required|string|max:20',
            'qualifications' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',

            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $dentiste = Dentiste::find(session('dentiste_id'));
    
        if ($dentiste) {
            // Mettre à jour dentiste
            $dentiste->nom = $request->nom;
            $dentiste->prenom = $request->prenom;
            $dentiste->email = $request->email;
            $dentiste->numero = $request->numero;
            $dentiste->adresse = $request->adresse;
            $dentiste->qualifications = $request->qualifications;
            
    
            // Gestion de l'avatar
            if ($request->hasFile('avatar')) {
                $destinationPath = public_path('images/profiles');
                
                // Créer le dossier s'il n'existe pas
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
    
                // Supprimer l'ancienne image si elle existe
                if ($dentiste->avatar) {
                    $oldImagePath = public_path($dentiste->avatar);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
    
                // Générer un nom de fichier unique
                $avatarName = 'profile-'.$dentiste->id.'-'.time().'.'.$request->avatar->extension();
                
                // Déplacer le fichier
                $request->avatar->move($destinationPath, $avatarName);
                
                // Enregistrer le chemin relatif dans la base de données
                $dentiste->avatar = 'images/profiles/'.$avatarName;
            }
    
            $dentiste->save();
    
            // Mettre à jour la session
            session([
                'dentiste_nom' => $dentiste->nom,
                'dentiste_prenom' => $dentiste->prenom,
                'email' => $dentiste->email,
                'dentiste_numero' => $dentiste->numero,
                'dentiste_adresse' => $dentiste->adresse,
                'dentiste_qualifications' => $dentiste->qualifications,
                'dentiste_avatar' => $dentiste->avatar ? asset($dentiste->avatar) : asset('images/profiles/default-avatar.jpg'),
           
            ]);
    
            return back()->with('success', 'Profil mis à jour avec succès.');
        }
    
        return back()->with('error', 'Dentiste non trouvé.');
    }
    
    
    public function changePassword(Request $request)
    {
        $request->validate([
            'motdepasse' => 'required',
            'new_password' => [
                'required',
                'string',
                'min:6',
                'confirmed', 
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]+$/'
            ],
        ], [
            'new_password.required' => 'Le nouveau mot de passe est obligatoire.',
            'new_password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
            'new_password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'new_password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial (@$!%*?&).',
        ]);
    
        $dentiste = Dentiste::find(session('dentiste_id'));
        
        if (!$dentiste) {
            return back()->with('error', 'Dentiste non trouvé.');
        }
    
        
        if (!Hash::check($request->motdepasse, $dentiste->motdepasse)) {
            return back()->withErrors(['motdepasse' => 'L\'ancien mot de passe est incorrect.']);
        }
    
        // mis a jour motdepasse
        $dentiste->motdepasse = Hash::make($request->new_password);
        
        $dentiste->motdepasse_confirmation = Hash::make($request->new_password);
        
        $dentiste->save();
    
        return back()->with('password_success', 'Mot de passe changé avec succès!');
    }
    public function parametre()
    {
        $dentiste = Dentiste::find(session('dentiste_id'));

        return view('pages.parametre.parametre', compact('dentiste'));
    }
    public function historique()
    {
        // $dentiste = Dentiste::find(session('dentiste_id'));

        return view('pages.parametre.historique');
    }
    // public function soins()
    // {
    //     return view('pages.soins_dents'); 
    // }
//     public function soins()
// {
//     return view('pages.soins_dents');
// }

// public function dents_mixte()
// {
//     return view('pages.dents_mixte');
// }
    public function profil()
    {
        return view('pages.profil'); 
    }
    

// public function rendez_vous(Request $request)
//     {
//         $dentisteId = session('dentiste_id');
//         if (!$dentisteId) {
//             return redirect()->route('login')->with('error', 'Vous devez être connecté en tant que dentiste.');
//         }

//         $filtre = $request->query('filtre', 'semaine');
//         $moisFiltre = $request->query('mois');
//         $anneeFiltre = $request->query('annee');

//         $maintenant = now();
//         $semaineDebut = $maintenant->copy()->startOfWeek()->setTime(0, 0, 0);
//         $semaineFin = $maintenant->copy()->endOfWeek()->setTime(23, 59, 59);

//         $rendezVousQuery = Rendez_vous::whereHas('patient', function ($query) use ($dentisteId) {
//             $query->where('dentiste_id', $dentisteId);
//         })->with(['patient.soins' => function($query) {
//             $query->latest();
//         }, 'patient']);

//         if ($moisFiltre && is_numeric($moisFiltre) && $moisFiltre >= 1 && $moisFiltre <= 12) {
//             $rendezVousQuery->whereMonth('date_heure_rdv', $moisFiltre);
//         }
//         if ($anneeFiltre && is_numeric($anneeFiltre)) {
//             $rendezVousQuery->whereYear('date_heure_rdv', $anneeFiltre);
//         }

//         $rendezVous = $rendezVousQuery->get();

//         $rendezVousFiltres = match ($filtre) {
//             'passes' => $rendezVous->filter(fn($rv) => $rv->date_heure_rdv < now()),
//             'futurs' => $rendezVous->filter(fn($rv) => $rv->date_heure_rdv >= now()),
//             'semaine' => $rendezVous->filter(fn($rv) => $rv->date_heure_rdv >= $semaineDebut && $rv->date_heure_rdv <= $semaineFin),
//             'mois', 'annee' => $rendezVous,
//             default => collect(),
//         };

//         // MODIFICATION ICI : Générer un événement pour chaque créneau de 15 minutes
//         $rvFiltres = $rendezVousFiltres->flatMap(function ($rv) { // Utilisation de flatMap pour aplatir les collections
//             $dernierSoin = $rv->patient->soins->first();
//             $soinSimplifie = $dernierSoin ? explode(' > ', $dernierSoin->traitement)[0] : 'Aucun soin';
            
//             // $start = Carbon::parse($rv->date_heure_rdv);
//               $start = Carbon::parse($rv->date_heure_rdv);
//         // $end = $rv->heure_fin ? Carbon::parse($rv->date_heure_rdv)->setTimeFromTimeString($rv->heure_fin) : $start->copy()->addMinutes(30);
//         // $end = $rv->heure_fin ? Carbon::parse($rv->date_heure_rdv)->setTimeFromTimeString($rv->heure_fin) : $start->copy()->addMinutes(30);
//         $end = $rv->heure_fin
//         ? Carbon::parse($rv->date_heure_rdv)->setTimeFromTimeString($rv->heure_fin)
//         : $start->copy()->addMinutes(30);
//             $eventsForRendezVous = [];
//             $current = $start->copy();

//             // Calculez les couleurs une seule fois par RV principal
//             $color = match ($soinSimplifie) {
//                 'detartrage' => '#fbbc05',
//                 'consultation' => '#4285f4',
//                 'extraction' => '#ea4335',
//                 'prothese' => '#34a853',
//                 default => '#673ab7',
//             };
//             $textColor = ($soinSimplifie == 'detartrage') ? '#333' : 'white';

//             while ($current->lessThan($end)) {
//                 $eventsForRendezVous[] = [
//                     'id' => $rv->id, // L'ID du RV principal
//                     'title' => $rv->patient->prenom . ' (' . $soinSimplifie . ')',
//                     'start' => $current->format('Y-m-d H:i:s'),
//                     'end' => $current->copy()->addMinutes(15)->format('Y-m-d H:i:s'), // Chaque tranche dure 15 minutes
//                     'patient_id' => $rv->patient->id,
//                     'nom' => $rv->patient->nom,
//                     'prenom' => $rv->patient->prenom,
                    
//                     'soin' => $soinSimplifie,
//                     'statut' => $rv->statut,
//                     'soin_complet' => $dernierSoin ? $dernierSoin->traitement : null,
//                     'color' => $color,
//                     'textColor' => $textColor,
//                     'full_rv_start' => $start->format('Y-m-d H:i:s'),
//                     'full_rv_end' => $end->format('Y-m-d H:i:s'),     
//                     'original_rv_id' => $rv->id 
//                 ];
//                 $current->addMinutes(30);
//             }

//             return $eventsForRendezVous;
//         })->toArray(); 
//  // Récupérer l'ID du nouveau patient s'il est en session
//     $nouveauPatientId = session()->pull('nouveau_patient_id', null);
//     $patient = null;
    
//     if ($nouveauPatientId) {
//         $patient = Patients::find($nouveauPatientId);
//     }
//         return view('pages.rendez_vous.rendez_vous', compact(
//             'rvFiltres',
//             'filtre',
//             'semaineDebut',
//             'semaineFin',
//             'moisFiltre',
//             'anneeFiltre',
//             'nouveauPatientId',
//             'patient'
//         ));
//     }


//     public function getRdvRestantsAujourdhui()
// {
//     $dentisteId = session('dentiste_id');

//     $maintenant = Carbon::now();
//     $debutJournee = $maintenant->copy()->startOfDay();
//     $finJournee = $maintenant->copy()->endOfDay();

//     $rdvRestants = Rendez_vous::whereHas('patient', function ($query) use ($dentisteId) {
//             $query->where('dentiste_id', $dentisteId);
//         })
//         ->whereBetween('date_heure_rdv', [$maintenant, $finJournee])
//         ->count();

//     return response()->json(['total_restant' => $rdvRestants]);
// }
    public function rendez_vous(Request $request)
{
    $dentisteId = session('dentiste_id');
    if (!$dentisteId) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté en tant que dentiste.');
    }

    $filtre = $request->query('filtre', 'semaine');
    $moisFiltre = $request->query('mois');
    $anneeFiltre = $request->query('annee');

    $maintenant = now();
    $semaineDebut = $maintenant->copy()->startOfWeek()->setTime(0, 0, 0);
    $semaineFin = $maintenant->copy()->endOfWeek()->setTime(23, 59, 59);

    $rendezVousQuery = Rendez_vous::whereHas('patient', function ($query) use ($dentisteId) {
        $query->where('dentiste_id', $dentisteId);
    })->with(['patient.soins' => function($query) {
        $query->latest();
    }, 'patient']);

    if ($moisFiltre && is_numeric($moisFiltre) && $moisFiltre >= 1 && $moisFiltre <= 12) {
        $rendezVousQuery->whereMonth('date_heure_rdv', $moisFiltre);
    }
    if ($anneeFiltre && is_numeric($anneeFiltre)) {
        $rendezVousQuery->whereYear('date_heure_rdv', $anneeFiltre);
    }

    $rendezVous = $rendezVousQuery->get();

    $rendezVousFiltres = match ($filtre) {
        'passes' => $rendezVous->filter(fn($rv) => $rv->date_heure_rdv < now()),
        'futurs' => $rendezVous->filter(fn($rv) => $rv->date_heure_rdv >= now()),
        'semaine' => $rendezVous->filter(fn($rv) => $rv->date_heure_rdv >= $semaineDebut && $rv->date_heure_rdv <= $semaineFin),
        'mois', 'annee' => $rendezVous,
        default => collect(),
    };

    // Générer les événements pour le calendrier
    $rvFiltres = $rendezVousFiltres->flatMap(function ($rv) {
        $dernierSoin = $rv->patient->soins->first();
        $soinSimplifie = $dernierSoin ? explode(' > ', $dernierSoin->traitement)[0] : 'Aucun soin';
        
        $start = Carbon::parse($rv->date_heure_rdv);
        $end = $rv->heure_fin
            ? Carbon::parse($rv->date_heure_rdv)->setTimeFromTimeString($rv->heure_fin)
            : $start->copy()->addMinutes(30);
        
        $eventsForRendezVous = [];
        $current = $start->copy();

        // $color = match ($soinSimplifie) {
        //     'detartrage' => '#fbbc05',
        //     'consultation' => '#4285f4',
        //     'extraction' => '#ea4335',
        //     'prothese' => '#34a853',
        //     default => '#673ab7',
        // };
        // $textColor = ($soinSimplifie == 'detartrage') ? '#333' : 'white';

        while ($current->lessThan($end)) {
            $eventsForRendezVous[] = [
                'id' => $rv->id,
                'title' => $rv->patient->prenom . ' (' . $soinSimplifie . ')',
                'start' => $current->format('Y-m-d H:i:s'),
                'end' => $current->copy()->addMinutes(15)->format('Y-m-d H:i:s'),
                'patient_id' => $rv->patient->id,
                'nom' => $rv->patient->nom,
                'prenom' => $rv->patient->prenom,
                'soin' => $soinSimplifie,
                'statut' => $rv->statut,
                'soin_complet' => $dernierSoin ? $dernierSoin->traitement : null,
                // 'color' => $color,
                // 'textColor' => $textColor,
                // 'soin_class' => $soinClass,
                'full_rv_start' => $start->format('Y-m-d H:i:s'),
                'full_rv_end' => $end->format('Y-m-d H:i:s'),     
                'original_rv_id' => $rv->id 
            ];
            $current->addMinutes(30);
        }

        return $eventsForRendezVous;
    })->toArray(); 

    // Récupérer l'ID du nouveau patient s'il est en session
    $nouveauPatientId = session()->pull('nouveau_patient_id', null);
    $patient = null;
    
    if ($nouveauPatientId) {
        $patient = Patients::find($nouveauPatientId);
    }

    return view('pages.rendez_vous.rendez_vous', compact(
        'rvFiltres',
        'filtre',
        'semaineDebut',
        'semaineFin',
        'moisFiltre',
        'anneeFiltre',
        'nouveauPatientId',
        'patient'
    ));
}
public function store(Request $request)
{
    $validatedData = $request->validate([
        'patient_id' => 'required|exists:patients,id',
        'date_heure_rdv' => 'required|date_format:Y-m-d H:i:s',
        'heure_fin' => 'required|date_format:Y-m-d H:i:s|after:date_heure_rdv',
        'statut' => 'nullable|string|max:50',
    ]);

    try {
        // Convertir en dates avec le bon fuseau horaire
        $dateHeureRdv = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $validatedData['date_heure_rdv'],
            'Indian/Antananarivo'
        );

        $heureFin = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $validatedData['heure_fin'],
            'Indian/Antananarivo'
        );

        $rendezVous = Rendez_vous::create([
            'patient_id' => $validatedData['patient_id'],
            'date_heure_rdv' => $dateHeureRdv,
            'heure_fin' => $heureFin,
            'statut' => $validatedData['statut'] ?? 'planifié',
        ]);

        return response()->json(['message' => 'Rendez-vous enregistré avec succès.'], 200);

    } catch (\Exception $e) {
        \Log::error('Erreur lors de l\'enregistrement: ' . $e->getMessage());
        return response()->json(['message' => 'Erreur lors de l\'enregistrement'], 500);
    }
}


// public function store(Request $request)
// {
//     $request->validate([
//         'patient_id' => 'required|exists:patients,id',
//         'date_heure_rdv' => 'required|date',
//         'heure_fin' => 'required|date|after:date_heure_rdv',
//         'soin' => 'required|string|max:255'
//     ]);
    
//     // Convertir en Carbon pour une comparaison précise
//     $start = Carbon::parse($request->date_heure_rdv);
//     $end = Carbon::parse($request->heure_fin);
    
//     // Vérifier les conflits
//     $existingRdv = Rendez_vous::where(function($query) use ($start, $end) {
//             $query->whereBetween('date_heure_rdv', [$start, $end])
//                   ->orWhereBetween('heure_fin', [$start, $end])
//                   ->orWhere(function($q) use ($start, $end) {
//                       $q->where('date_heure_rdv', '<', $start)
//                         ->where('heure_fin', '>', $end);
//                   });
//         })
//         ->exists();
        
//     if ($existingRdv) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Ce créneau est déjà occupé'
//         ], 409);
//     }
    
//     // Créer le rendez-vous
//     $rendezVous = Rendez_vous::create([
//         'patient_id' => $request->patient_id,
//         'date_heure_rdv' => $start,
//         'heure_fin' => $end,
//         'soin' => $request->soin,
//         'statut' => 'Prévu'
//     ]);
    
//     return response()->json([
//         'success' => true,
//         'message' => 'Rendez-vous créé avec succès'
//     ]);
// }
    public function liste_patients(Request $request)
    {
        // $search = $request->input('search');

        // $patients = Patients::query()
        //     ->when($search, function ($query, $search) {
        //         $query->where('nom', 'like', '%' . $search . '%')
        //               ->orWhere('prenom', 'like', '%' . $search . '%');
        //     })
        //     ->get();
    
        // return view('pages.patient.listes_patients', compact('patients'));
    }
    public function index(Request $request)
{
    // Supprimer la session après création
    if ($request->has('nouveau_patient')) {
        session()->forget('nouveau_patient_id');
    }
    
    // ... reste du code existant ...
}
}
