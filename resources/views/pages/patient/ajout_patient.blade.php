@extends('layouts.app') <!--Utilise le template de base-->

@section('content')<!-- Début de la section qui remplacera @yield('content') -->
<link href="{{ asset('css/nouveau_patient.css') }}" rel="stylesheet">

<!-- <div class="container-fluid"> -->
<div class="">
    <div class="row">
        <div class="col-md-12">
            <!-- <div class="card"> -->
                <div class="card-body">
                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <form method="POST" action="{{url('/savePatient')}}">
                        @csrf
                        <div class="page-ajout-patient">
                        <div class="form-containerNouveau-Patient">
                            <div class="three-column-layout">
                                <!-- Colonne 1: Infos patient -->
                                <div class="patient-info-column">
                                    <span class="titleNouveau">Informations Patient</span>
                                    <div class="form-group mb-4">
                                        <label for="nom">Nom </label>
                                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom " required>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="prenom">Prénoms </label>
                                        <input type="text" class="form-control" id="prenom" name="prenom" placeholder=" Prénom" required>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="date_naissance">Date de naissance</label>
                                        <input type="date" class="form-control" id="date_naissance" name="date_naissance" required>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="age">Âge</label>
                                        <input type="number" class="form-control" id="age" name="age" placeholder="Âge" readonly>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="motif">Motif de consultation</label>
                                        <textarea class="form-control" id="motif" name="motif" placeholder="Motif de consultation" rows="3" style="height: 150px; resize: none;"></textarea>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="form-label" for="antecedents_medicaux">Antécédents médicaux</label>
                                        <select
                                            name="antecedents_medicaux"
                                            id="antecedents_medicaux"
                                            class="form-control"
                                            required
                                        >
                                            <option value="" disabled selected>-- Sélectionnez une option --</option>
                                            <option value="RAS">RAS</option>
                                            <option value="Maladie cardiovasculaire">Maladie cardiovasculaire</option>
                                            <option value="Hemophile">Hémophile</option>
                                            <option value="Trouble de la coagulation">Trouble de la coagulation</option>
                                            <option value="Diabète">Diabète</option>
                                            <option value="Ostéoporose">Ostéoporose</option>
                                            <option value="Hospitalisation">Hospitalisation</option>
                                            <option value="Autres">Autres</option>
                                        </select>
                                    </div>


                                    <div class="form-group mb-4">
                                        <label for="traitements">Traitements en cours</label>
                                        <textarea class="form-control" id="traitements" name="traitements" placeholder="Traitements en cours" rows="3" style="height: 150px; resize: none;"></textarea>
                                    </div>

                                    <!-- <div class="form-group mb-4">
                                        <label for="prochain_rdv">Prochain rendez-vous</label>
                                        <input type="date" class="form-control" id="prochain_rdv" name="prochain_rdv" >
                                    </div> -->

                                    <!-- <div class="form-group mb-4">
                                        <label for="heure_rdv">Heure de début</label>
                                        <input type="time" class="form-control" id="heure_rdv" name="heure_rdv" step="900" >
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="heure_fin">Heure de fin</label>
                                        <input type="time" class="form-control" id="heure_fin" name="heure_fin" step="900" >
                                    </div> -->

                                </div>
                                <!-- Colonne 2: Examinations -->

                                <div class="patient-info-column">
    
                                <div class="column-examination">
                                <span class="titleNouveau">Examinations</span>

                                    <div class="boutton-Menu-Examination">
                                    <input type="hidden" name="type_dent" id="mainTypeDentInput" value="{{ $patients->type_dent ?? 'Dent Permanent' }}">
                                    <!-- <input type="hidden" id="type_dent" name="type_dent" value=""> -->
                                    <!-- <input type="hidden" id="type_dent" name="type_dent" value="Dent Permanent"> -->
                                   @include('pages.soins_dentaire.boutton-examination')

                                    </div>
                            
                            
                                </div>
   

                                </div>

                                <!-- Colonne 3: Ordonnance -->
                                <div class="patient-info-column">
                                    <span class="titleNouveau">Ordonnance</span>
                                    <div class="ordonnance-header">
                                        

                                    <div class="header-info">
                                        
                                        <!-- <p>N° RPPS: {{ $dentiste->rpps ?? '123456789' }}</p> -->
                                        @if(isset($patient))
                                            <p>Nom du patient: {{ $patient->nom }} </p>
                                            <p>Nom du patient:  {{ $patient->prenom }}</p>

                                        @else
                                            <p id="patientNamePlaceholder">Nom du patient: </p>
                                        @endif
                                            

                                    </div>
                                    <label class="form-label" for="ordonnanceSelect">Sélectionnez le type d'ordonnance :</label>
                                         
                                    </div>

                                </div>
                            </div>
                          
                            <div class="form-footer mt-4">
                            <input type="hidden" name="soins" id="soinsInput">
                            <input type="hidden" id="total_soins" name="total_soins" value="0">
                               

                                <button type="submit" class="btn btn-primary center-btn">
                                    <span>Enregistrer</span>
                                </button>
                

                            </div>
                        </div>
                        </div>
                    </form>
    
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>
@endsection  <!-- Fin de la section -->

@push('scripts')

<script>
    // Déclarer ces variables au niveau global
    let birthDateInput, ageInput;
    let formSubmitted = false;
    // let soinsList = [];
    window.soinsList = @json($soinsList ?? []);

    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser les variables
        birthDateInput = document.getElementById('date_naissance');
        ageInput = document.getElementById('age');
        
        // Calcul automatique de l'âge
        if (birthDateInput && ageInput) {
            birthDateInput.addEventListener('change', function() {
                if (this.value) {
                    const birthDate = new Date(this.value);
                    const today = new Date();
                    
                    let age = today.getFullYear() - birthDate.getFullYear();
                    const monthDiff = today.getMonth() - birthDate.getMonth();
                    
                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }
                    
                    ageInput.value = age;
                } else {
                    ageInput.value = '';
                }
            });

            if (birthDateInput.value) {
                birthDateInput.dispatchEvent(new Event('change'));
            }

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

        // Gestion de l'impression
        const printBtn = document.querySelector('.print-btn');
        if (printBtn) {
            printBtn.addEventListener('click', function() {
                window.print();
            });
        }

        // Restaurer les données sauf si soumission récente
        if (!formSubmitted) {
            restoreFormData();
        }
        
        updatePatientName();
    });

    // Gestion des soins et soumission du formulaire
    document.querySelector('form').addEventListener('submit', function(e) {
        const soinsInput = document.getElementById('soinsInput');
        const totalSoinsElement = document.getElementById('totalPrice');
        const totalSoinsInput = document.getElementById('total_soins');
        // const totalargentRecu = document.getElementById('recu');
        // const totalreste = document.getElementById('reste');
        // const typedent = document.getElementById('type_dent');

        // soinsInput.value = JSON.stringify(soinsList);
        // totalSoinsInput.value = parseInt(totalSoinsElement.textContent) || 0;
          if (soinsInput) {
            soinsInput.value = JSON.stringify(soinsList);
        }
        //   if (typedent) {
        //     typedent.value = JSON.stringify(soinsList);
        // }
        if (totalSoinsElement && totalSoinsInput) {
            totalSoinsInput.value = parseInt(totalSoinsElement.textContent) || 0;
        }
        //  if (totalargentRecu && totalreste) {
        //     totalreste.value = parseInt(totalargentRecu.textContent) || 0;
        // }
        
        // Marquer que le formulaire a été soumis
        formSubmitted = true;
        
        // Nettoyer le localStorage
        localStorage.removeItem('patientFormData');
        localStorage.removeItem('soinsList');
        
        // Réinitialiser le formulaire après un court délai
        setTimeout(() => {
            document.getElementById('patientForm').reset();
            updatePatientName();
            if (birthDateInput && ageInput) {
                birthDateInput.dispatchEvent(new Event('change'));
            }
        }, 100);
    });

    // Mise à jour du nom du patient
    document.getElementById('nom').addEventListener('input', updatePatientName);
    document.getElementById('prenom').addEventListener('input', updatePatientName);

    function updatePatientName() {
        const nom = document.getElementById('nom').value;
        const prenom = document.getElementById('prenom').value;
        const placeholder = document.getElementById('patientNamePlaceholder');
        
        if (placeholder) {
            placeholder.textContent = `Nom du patient: ${nom} ${prenom}`;
        }
    }

    // Sauvegarde des données
    function saveFormData() {
        if (formSubmitted) return; // Ne pas sauvegarder si soumission en cours
        
        const formData = {
            nom: document.getElementById('nom').value,
            prenom: document.getElementById('prenom').value,
            date_naissance: document.getElementById('date_naissance').value,
            age: document.getElementById('age').value,
            motif: document.getElementById('motif').value,
            antecedents_medicaux: document.getElementById('antecedents_medicaux').value,
            traitements: document.getElementById('traitements').value,
            ordonnance: document.getElementById('ordonnance').value,
        };
        localStorage.setItem('patientFormData', JSON.stringify(formData));
    }

    // Restauration des données
    function restoreFormData() {
        const savedData = localStorage.getItem('patientFormData');
        if (savedData) {
            const formData = JSON.parse(savedData);
            document.getElementById('nom').value = formData.nom || '';
            document.getElementById('prenom').value = formData.prenom || '';
            document.getElementById('date_naissance').value = formData.date_naissance || '';
            document.getElementById('age').value = formData.age || '';
            document.getElementById('motif').value = formData.motif || '';
            document.getElementById('antecedents_medicaux').value = formData.antecedents_medicaux || '';
            document.getElementById('traitements').value = formData.traitements || '';
            document.getElementById('ordonnance').value = formData.ordonnance || '';
        }
    }

    // Écouteurs pour sauvegarder les modifications
    document.getElementById('nom').addEventListener('input', saveFormData);
    document.getElementById('prenom').addEventListener('input', saveFormData);
    document.getElementById('date_naissance').addEventListener('input', saveFormData);
    document.getElementById('age').addEventListener('input', saveFormData);
    document.getElementById('motif').addEventListener('input', saveFormData);
    document.getElementById('antecedents_medicaux').addEventListener('input', saveFormData);
    document.getElementById('traitements').addEventListener('input', saveFormData);
    document.getElementById('ordonnance').addEventListener('input', saveFormData);

    // Code existant pour les boutons d'examen
    $(document).ready(function() {
        // ... (les boutons d'examen)
    });

    

</script>

@endpush