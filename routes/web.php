<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SoinsDentaireController;
use App\Http\Controllers\OrdonnanceController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/home1', function () {
    // return "bt";
    return view('welcome');
});
Route::get('/service/{nom}/{id}', function ($nom, $id) {
    return "Mon nom est : {$nom}, id = {$id}.";
});

Route::get('/home', [PagesController::class, 'home'])->name('home');
Route::get('/accueil', [PagesController::class, 'accueil'])->name('accueil');
// Route::get('/nouveau_patient', [PagesController::class, 'nouveau_patient'])->name('nouveau_patient');
// Route::get('/soins', [PagesController::class, 'soins'])->name('soins');
// Route::get('/soins', [PagesController::class, 'soins'])->name('soins');
Route::get('/dents_mixte', [PagesController::class, 'dents_mixte'])->name('dents_mixte');
Route::get('/liste_patients', [PagesController::class, 'liste_patients'])->name('liste_patients');

Route::get('/rendez_vous', [PagesController::class, 'rendez_vous'])->name('rendez_vous');
Route::get('/profil', [PagesController::class, 'profil'])->name('profil');
Route::get('/ajout_patient', [PatientController::class, 'ajout_patient'])->name('ajout_patient');
Route::get('/parametre', [PagesController::class, 'parametre'])->name('parametre');

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::get('/creation_compte', [LoginController::class, 'creation_compte'])->name('creation_compte');
Route::get('/modification_patient/{id}', [PatientController::class, 'modification_patient'])->name('modification_patient');

Route::get('/show/{id}', [PagesController::class, 'show'])->name('show');
Route::get('/patient_modification/{id}', [PagesController::class, 'patient_modification'])->name('patient_modification');
Route::post('/savedentiste', [PagesController::class, 'savedentiste'])->name('savedentiste');
Route::post('/modifier_patient', [PagesController::class, 'modifier_patient'])->name('modifier_patient');
Route::post('/dentiste_connection', [LoginController::class, 'dentiste_connection'])->name('dentiste_connection');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/profil_update', [PagesController::class, 'profil_update'])->name('profil_update');
Route::post('/savePatient', [PatientController::class, 'savePatient'])->name('savePatient');
Route::get('/listes_patients', [PatientController::class, 'listes_patients'])->name('listes_patients');
Route::delete('/patients/supprimer', [PatientController::class, 'supprimerPatients'])->name('patients.supprimer');
Route::put('/patient_update/{id}', [PatientController::class, 'patient_update'])->name('patient_update');
Route::get('/modification_soins_dent/{id}', [PatientController::class, 'modification_soins_dent'])->name('modification_soins_dent');
Route::post('/creation-rdv', [PatientController::class, 'creationRdv'])->name('creation_rdv');
Route::get('/showOrdonnance/{patientId}', [VotreController::class, 'showOrdonnance'])->name('showOrdonnance');
Route::get('/rdv-restants', [PagesController::class, 'getRdvRestantsAujourdhui']);
Route::get('/historique', [PagesController::class, 'historique']);
Route::post('/changePassword', [PagesController::class, 'changePassword'])->name('changePassword');
Route::get('/modification_soins_permanent/{patientId}', [SoinsDentaireController::class, 'modification_soins_permanent'])->name('modification_soins_permanent');
Route::get('/modification_soins_mixte/{patientId}', [SoinsDentaireController::class, 'modification_soins_mixte'])->name('modification_soins_mixte');

Route::get('modification_dents_mixte/{id}', [PatientController::class, 'modification_dents_mixte'])->name('modification_dents_mixte');
Route::get('/soins_permanent', function() {
    return view('pages.soins_dentaire.base_soins_dentaire.soins_permanent');
})->name('soins_permanent');

Route::get('/soins_mixte', function() {
    return view('pages.soins_dentaire.base_soins_dentaire.soins_mixte');
})->name('soins_mixte');
// ordonnance
Route::get('cas_simple/{id}', [OrdonnanceController::class, 'cas_simple'])->name('cas_simple');
Route::get('dent_sagesse/{id}', [OrdonnanceController::class, 'dent_sagesse'])->name('dent_sagesse');
Route::get('extraction_simple/{id}', [OrdonnanceController::class, 'extraction_simple'])->name('extraction_simple');
Route::get('soins_simple/{id}', [OrdonnanceController::class, 'soins_simple'])->name('soins_simple');
Route::get('allergie_amox/{id}', [OrdonnanceController::class, 'allergie_amox'])->name('allergie_amox');
Route::get('recommendation/{id}', [OrdonnanceController::class, 'recommendation'])->name('recommendation');
Route::post('/saveOrdonnance/{id}', [OrdonnanceController::class, 'saveOrdonnance'])->name('saveOrdonnance');
Route::get('/historique_ordonnance/{patient_id}', [OrdonnanceController::class, 'historique_ordonnance'])->name('historique_ordonnance');
Route::get('/ordonnance_detail/{ordonnance_id}', [OrdonnanceController::class, 'ordonnance_detail'])->name('ordonnance_detail');
Route::get('/afficheCasSimple/{ordonnance_id}', [OrdonnanceController::class, 'afficheCasSimple'])->name('afficheCasSimple');
Route::get('/afficheDentSagesse/{ordonnance_id}', [OrdonnanceController::class, 'afficheDentSagesse'])->name('afficheDentSagesse');
Route::get('/afficheExtraction/{ordonnance_id}', [OrdonnanceController::class, 'afficheExtraction'])->name('afficheExtraction');
Route::get('/afficheSoinsSimple/{ordonnance_id}', [OrdonnanceController::class, 'afficheSoinsSimple'])->name('afficheSoinsSimple');
Route::get('/afficheAllergieAmox/{ordonnance_id}', [OrdonnanceController::class, 'afficheAllergieAmox'])->name('afficheAllergieAmox');
Route::get('/afficheRecommandation/{ordonnance_id}', [OrdonnanceController::class, 'afficheRecommandation'])->name('afficheRecommandation');

// Route pour créer un RDV à partir d'une sélection
Route::post('/store', [PagesController::class, 'store'])->name('store');
// Route::get('/patient_modification/{id}')
// Route::get('/accueil', function () {
    
//     return view('pages.accueil');
// });
// Route::get('/nouveau_patient', function () {
    
//     return view('pages.nouveau_patient');
// });
Route::get('/soins', function () {
    return view('pages.soins_dentaire.soins_dents');
})->name('soins');
Route::get('/dents_mixte', function () {
    return view('pages.soins_dentaire.dents_mixte');
})->name('dents_mixte');