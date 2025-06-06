@extends('layouts.app')

@section('content')
<link href="{{ asset('css/nouveau_patient.css') }}" rel="stylesheet">

<div class="">
    <div class="row">
        <div class="col-md-12">
            <div class="card-body">
                <form method="POST" action="{{ url('/patient_update', $patients->id) }}" id="patientForm">
                    @csrf
                    @method('PUT')
                    <!-- soins  -->
                    <input type="hidden" id="soinsInput" name="soins" value="">
                    <input type="hidden" id="total_soins" name="total_soins" value="0">
                    <input type="hidden" id="type_dent" name="type_dent" value="{{ $patients->type_dent ?? 'Dent Permanent' }}">

                    <div class="form-containerNouveau-Patient">
                        <div class="three-column-layout">
                            <!-- Colonne 1: Infos patient -->
                            <div class="patient-info-column">
                                <span class="titleNouveau">Informations Patient n° : {{ $patients->id }}</span>
                                <div class="form-group mb-4">
                                    <label for="nom">Nom </label>
                                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom " value="{{ $patients->nom }}" required>
                                </div>


                                <div class="form-group mb-4">
                                        <label for="prenom">Prénoms</label>
                                        <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" value="{{ $patients->prenom }}" required>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="date_naissance">Date de naissance</label>
                                        <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="{{ $patients->date_naissance }}" required>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="age">Âge</label>
                                        <input type="number" class="form-control" id="age" name="age" placeholder="Âge" value="{{ $patients->age }}" >
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="motif">Motif de consultation</label>
                                        <textarea class="form-control" id="motif" name="motif" placeholder="Motif de consultation"  rows="3" style="height: 150px; resize: none;">{{ $patients->motif }}</textarea>
                                    </div>

                                    <div class="form-group mb-4">
                                    <label for="antecedents">Antécédents médicaux</label>
                                    <select name="antecedents" id="antecedents" class="form-control" required>
                                        <option value="RAS" {{ $patients->antecedents_medicaux == 'RAS' ? 'selected' : '' }}>RAS</option>
                                        <option value="Maladie cardiovasculaire" {{ $patients->antecedents_medicaux == 'Maladie cardiovasculaire' ? 'selected' : '' }}>Maladie cardiovasculaire</option>
                                        <option value="Hemophile" {{ $patients->antecedents_medicaux == 'Hemophile' ? 'selected' : '' }}>Hemophile</option>
                                        <option value="Trouble de la coagulation" {{ $patients->antecedents_medicaux == 'Trouble de la coagulation' ? 'selected' : '' }}>Trouble de la coagulation</option>
                                        <option value="Diabète" {{ $patients->antecedents_medicaux == 'Diabète' ? 'selected' : '' }}>Diabète</option>
                                        <option value="Ostéoporose" {{ $patients->antecedents_medicaux == 'Ostéoporose' ? 'selected' : '' }}>Ostéoporose</option>
                                        <option value="Hospitalisation" {{ $patients->antecedents_medicaux == 'Hospitalisation' ? 'selected' : '' }}>Hospitalisation</option>
                                        <option value="Autres" {{ $patients->antecedents_medicaux == 'Autres' ? 'selected' : '' }}>Autres</option>
                                    </select>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="traitements">Traitements en cours</label>
                                        <textarea class="form-control" id="traitements" name="traitements" placeholder="Traitements en cours" rows="3" style="height: 150px; resize: none;">{{ $patients->traitements }}</textarea>
                                    </div>

                                                                            @php
                                            $rdv = $patients->rendezVous->first();
                                        @endphp
                                    <input type="hidden" name="rendez_vous_id" value="{{ $rdv ? $rdv->id : '' }}">
                                        <div class="form-group mb-4">
                                            <label for="prochain_rdv">Prochain rendez-vous</label>
                                            <input type="date" class="form-control" id="prochain_rdv" name="prochain_rdv"
                                                value="{{ $rdv ? \Carbon\Carbon::parse($rdv->date_heure_rdv)->format('Y-m-d') : '' }}">
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="heure_rdv">Heure</label>
                                            <input type="time" class="form-control" id="heure_rdv" name="heure_rdv"
                                                value="{{ $rdv ? \Carbon\Carbon::parse($rdv->date_heure_rdv)->format('H:i') : '' }}">
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="heure_fin">Heure fin</label>
                                            <input type="time" class="form-control" id="heure_fin" name="heure_fin"
                                                value="{{ $rdv ? \Carbon\Carbon::parse($rdv->heure_fin)->format('H:i') : '' }}">
                                        </div>
                                                                                <div class="form-group mb-4">
                                            <label for="statut">Statut du rendez-vous</label>
                                            <select class="form-control" id="statut" name="statut">
                                                <option value="">-- Sélectionnez --</option>
                                                <option value="Fini" {{ $rdv && $rdv->statut === 'Fini' ? 'selected' : '' }}>Fini</option>
                                                <option value="Manqué" {{ $rdv && $rdv->statut === 'Manqué' ? 'selected' : '' }}>Manqué</option>
                                                <!-- <option value="Prévu" {{ $rdv && $rdv->statut === 'Prévu' ? 'selected' : '' }}>Prévu</option> -->
                                            </select>
                                        </div>

                     </div>

                            <!-- Colonne 2: Examinations -->
                            <div class="patient-info-column">
                                <div class="column-examination">
                                    <span class="titleNouveau">Examinations</span>
                                    <div class="boutton-Menu-Examination">
                                        @include('pages.soins_dentaire.boutton-examination-modifier')
                                    </div>
                                </div>
                            </div>

                            <!-- Colonne 3: Ordonnance -->
                            <div class="patient-info-column" id="ordonnance-section">
                                <span class="titleNouveau">Ordonnance</span>
                                <div class="ordonnance-header">
                                    <div class="">
                                        <label class="form-label" for="ordonnanceSelect">Sélectionnez le type d'ordonnance :</label>
                                        <select name="Ordonnance" id="ordonnanceSelect" class="">
                                            <option value="" disabled selected>-- Sélectionnez une option --</option>
                                            <option value="cas_simple">Cas simple</option>
                                            <option value="dent_sagesse">Dent de sagesse</option>
                                            <option value="extraction_simple">Extraction simple</option>
                                            <option value="soins_simple">Soins simple</option>
                                            <option value="allergie_amox">Allergie Amoxicilline</option>
                                            <option value="recommendation">Recommandations Postuvulsionnelles</option>
                                        </select>
                                    </div>
                                </div>
                                @include('pages.ordonnance.historique_ordonnance')
                            </div>
                        </div>

                        <div class="form-footer mt-4">
                            <button type="button" id="enregistrerEtPlanifier" class="btn btn-primary">
                                <span>Enregistrer et planifier RDV</span>
                            </button>
                            <button type="submit" class="btn btn-primary center-btn">
                                <span>Enregistrer</span>
                            </button>
                        </div>
                </form>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Calcul de l'âge
     const birthDateInput = document.getElementById('date_naissance');
        const ageInput = document.getElementById('age');

        if (birthDateInput && ageInput) {
            birthDateInput.addEventListener('change', function() {
                if (this.value) {
                    const birthDate = new Date(this.value);
                    const today = new Date();

                    let age = today.getFullYear() - birthDate.getFullYear();
                    const monthDiff = today.getMonth() - birthDate.getMonth();

                    if (monthDiff < 0 ||
                        (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }

                    ageInput.value = age;
                } else {
                    ageInput.value = '';
                }
            });

            // Déclencher le calcul si une date est déjà présente
            if (birthDateInput.value) {
                birthDateInput.dispatchEvent(new Event('change'));
            }

            // Recalcul automatique de l'âge tous les jours à minuit
            function recalculerAge() {
                if (birthDateInput && birthDateInput.value) {
                    birthDateInput.dispatchEvent(new Event('change'));
                }
            }

            const maintenant = new Date();
            const demain = new Date(maintenant.getFullYear(), maintenant.getMonth(), maintenant.getDate() + 1, 0, 0, 0);
            const msJusquaMinuit = demain - maintenant;

            setTimeout(function() {
                recalculerAge();
                setInterval(recalculerAge, 24 * 60 * 60 * 1000);
            }, msJusquaMinuit);
        }

    // 2. Impression d'ordonnance
    const printBtn = document.querySelector('.print-btn');
    if (printBtn) {
        printBtn.addEventListener('click', function() {
            const textarea = document.getElementById('ordonnance');
            const ordonnanceText = document.getElementById('ordonnanceText');

            if (textarea && ordonnanceText) {
                ordonnanceText.textContent = textarea.value;
                window.print();
            }
        });
    }

    // 3. Soumission du formulaire
    const patientForm = document.querySelector('form');
    if (patientForm) {
        patientForm.addEventListener('submit', function(e) {
            const soinsInput = document.getElementById('soinsInput');
            const totalSoinsElement = document.getElementById('totalPrice');
            const totalSoinsInput = document.getElementById('total_soins');

            if (soinsInput && totalSoinsElement && totalSoinsInput) {
                // Sauvegarde des données
                soinsInput.value = JSON.stringify(window.soinsList || []);
                totalSoinsInput.value = parseInt(totalSoinsElement.textContent) || 0;

                // Nettoyage UI
                clearLocalStorage();
                resetUI();
            }
        });
    }

    // 4. Gestion des ordonnances
    const ordonnanceSelect = document.getElementById('ordonnanceSelect');
    if (ordonnanceSelect) {
        ordonnanceSelect.addEventListener('change', function() {
            const selectedValue = this.value;
            if (!selectedValue) return;

            const routes = {
                'cas_simple': '/cas_simple/',
                'dent_sagesse': '/dent_sagesse/',
                'extraction_simple': '/extraction_simple/',
                'soins_simple': '/soins_simple/',
                'allergie_amox': '/allergie_amox/',
                'recommendation': '/recommendation/'
            };

            if (routes[selectedValue]) {
                window.location.href = routes[selectedValue] + '{{$patients->id}}';
            }
        });
    }

    // 5. Bouton "Enregistrer et planifier RDV"
    const planifierBtn = document.getElementById('enregistrerEtPlanifier');
    if (planifierBtn) {
        planifierBtn.addEventListener('click', function(e) {
            e.preventDefault();

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'planifier_rdv';
            input.value = '1';

            if (patientForm) {
                patientForm.appendChild(input);
                patientForm.submit();
            }
        });
    }

    // Fonctions utilitaires
    function clearLocalStorage() {
        localStorage.removeItem('soinsList');
        window.soinsList = [];
    }

    function resetUI() {
        const treatmentsTableBody = document.getElementById('treatmentsTableBody');
        if (treatmentsTableBody) treatmentsTableBody.innerHTML = '';

        const totalPriceElement = document.getElementById('totalPrice');
        if (totalPriceElement) totalPriceElement.textContent = '0';

        document.querySelectorAll('.absent-overlay').forEach(el => el.remove());
        document.querySelectorAll('area').forEach(area => {
            area.style.pointerEvents = 'auto';
        });
    }
});
</script>
@endpush
