@extends('layouts.app')

@section('content')
{{-- Load Tailwind CSS from CDN --}}
<script src="https://cdn.tailwindcss.com"></script>
{{-- Configure Tailwind to use 'Inter' font --}}
<style>
    body {
        font-family: 'Inter', sans-serif;
    }

    /* Styles spécifiques pour l'impression */
    @media print {
        /* Cacher tous les éléments sauf le contenu de l'ordonnance */
        body * {
            visibility: hidden;
        }

        /* Afficher uniquement le contenu de l'ordonnance */
        .ordonnances, .ordonnances * {
            visibility: visible;
        }

        /* Positionner l'ordonnance en haut à gauche de la page et ajuster les marges */
        .ordonnances {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 20mm; /* Marges pour l'impression, simule une page A4 */
            box-shadow: none !important;
            border-radius: 0 !important;
            background-color: #fff !important; /* Assurer un fond blanc */
        }

        /* Réinitialiser les styles des conteneurs principaux pour l'impression */
        .homes, .body {
            background-color: #fff !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
            min-height: auto !important;
        }

        /* Supprimer les styles des inputs et textarea pour qu'ils apparaissent comme du texte simple */
        input[type="text"], input[type="number"], textarea {
            border: none !important;
            background-color: transparent !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
            width: auto !important; /* Permet aux inputs de prendre juste la largeur de leur contenu */
            display: inline-block; /* Pour que le texte "Nom et Prénoms :" soit sur la même ligne */
            vertical-align: baseline; /* Aligner le texte des inputs avec le texte des labels */
            font-size: 1rem; /* Assurer une taille de police lisible */
            color: #000; /* Forcer le texte en noir */
        }

        /* Style spécifique pour les noms de médicaments */
        input[name="medicationName[]"] {
            font-weight: bold;
            margin-bottom: 8px !important;
            display: block; /* Chaque nom de médicament sur une nouvelle ligne */
            width: 100% !important;
        }

        /* Cacher tous les labels par défaut pour l'impression */
        label {
            display: none !important;
        }

        /* Afficher les textes des labels pour les informations patient et médecin comme du texte direct */
        .patient-info-label, .doctor-info-label {
            display: inline !important; /* Afficher ces labels comme du texte */
            font-weight: bold;
            color: #000;
            margin-right: 5px;
        }


        /* Style pour les informations médecin/date (pour aligner la date à droite) */
        .doctor-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            width: 100%; /* Assurer qu'il prend toute la largeur */
        }

        /* Style pour les informations patient (pour aligner nom et âge) */
        .patient-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            width: 100%;
        }

        /* Style des items de médicament */
        .medication-item {
            page-break-inside: avoid; /* Empêche la coupure d'un élément de médicament */
            margin-bottom: 15px; /* Réduire l'espace entre les médicaments */
            border: none !important;
            background: white !important;
            padding: 0 !important;
            box-shadow: none !important;
        }

        /* Ajuster le grid des dosages pour qu'ils soient compacts */
        .medication-item .grid {
            display: flex; /* Utiliser flexbox pour les dosages */
            gap: 10px; /* Réduire l'espace entre Matin, Midi, Soir */
            margin-left: 20px; /* Indenter les dosages */
        }
        .medication-item .grid > div {
            flex: 1; /* Distribuer l'espace équitablement */
        }

        /* Optimiser l'espace pour les qualifications du médecin */
        pre {
            white-space: pre-wrap; /* Conserver les retours à la ligne */
            font-size: 0.9rem; /* Taille de police légèrement plus petite */
            color: #000;
        }

        /* Ligne de signature plus nette */
        .signature-area {
            border-bottom: 1px solid #000 !important;
        }

        /* Cacher spécifiquement les éléments d'interface */
        .no-print, #ordonnanceSelect, .print-btn, #addMedicationBtn {
            display: none !important;
        }

        /* Forcer la couleur du texte en noir pour tous les éléments imprimés */
        * {
            color: #000 !important;
        }
    }
</style>
<a href="/modification_patient/{{$patient->id}}" class="edit-link">
                    <i class="fas fa-angle-double-left"></i>

                </a>
<div class="homes min-h-screen bg-gray-100 p-4 sm:p-6 lg:p-8 flex justify-center items-start">
     
    <div class="body w-full max-w-4xl bg-white rounded-lg shadow-xl p-6 sm:p-8 lg:p-10">
        <div class="ordonnances">
            <!-- <form action=""> -->
            <!-- <form method="POST" action="{{ url('/saveOrdonnance', $patient->id) }}"> -->
    
                <form method="POST" action="{{ route('saveOrdonnance', $patient->id) }}">
                    @csrf

            {{-- Type d'Ordonnance Selection - Masqué à l'impression --}}
            <div class="mb-8 p-4 bg-blue-50 rounded-lg border border-blue-200 no-print">
                  <label class="block text-lg font-semibold text-blue-700 mb-2" for="ordonnanceSelect">
                        Type d'ordonnance : 
                        <input type="text" id="type_ordonnance" name="type_ordonnance" 
                            class=""
                            placeholder="Saisissez le type d'ordonnance" value="{{ old('type_ordonnance', 'Extraction simple') }}">
                    </label>
                <label class="block text-lg font-semibold text-blue-700 mb-2" for="ordonnanceSelect">
                    Sélectionnez le type d'ordonnance :
                </label>
                <select
                    name="OrdonnanceType"
                    id="ordonnanceSelect"
                    class="block w-full p-3 border border-blue-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-base text-gray-800 transition duration-150 ease-in-out"
                >
                     <option value="" disabled selected class="text-gray-500">-- Sélectionnez une option --</option>
                    <option value="cas_simple" class="text-gray-900">Cas simple</option>
                    <option value="dent_sagesse" class="text-gray-900">Dent de sagesse</option>
                    <option value="extraction_simple" class="text-gray-900">Extraction simple</option>
                    <option value="allergie_amox" class="text-gray-900">Allergie Amoxicilline</option>
                    <option value="recommendation" class="text-gray-900">Recommandations Postuvulsionnelles</option>
                    <option value="soins_simple" class="text-gray-900">Soins simple</option>
                </select>
            </div>

            {{-- Doctor Information Section --}}
            <!-- <div class="mb-8 border-b pb-6 border-gray-200"> -->
            <div class="">
                <div class="doctor-header"> {{-- Added doctor-header class --}}
                    <div>
                <p class="font-semibold text-gray-800">Cabinet de Dr {{ $patient->dentiste->nom}}</p>
                        <p class="font-semibold text-gray-800">{{ $patient->dentiste->prenom}}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-700">Fait le {{ date('d/m/Y') }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <!-- <p class="block text-sm font-medium text-gray-700 mb-1 doctor-info-label">Qualifications :</p> -->
                    <pre class="whitespace-pre-wrap text-gray-800">
{{ $patient->dentiste->qualifications}}</pre>
                </div>
            </div>

            {{-- Patient Information Section --}}
            <div class=""><br>
                <!-- <h3 class="text-xl font-semibold text-gray-700 mb-4">Informations du Patient</h3> -->
                <div class="patient-details grid grid-cols-1 md:grid-cols-2 gap-4"> 
                    <div>
                        <span class="patient-info-label">Nom et Prénoms : {{ $patient->prenom }} {{ $patient->nom }}</span>
                        <!-- <input type="text" id="patientName" name="patientName"
                               class="mt-1 block w-full p-2 border border-gray-300 
                               rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                               placeholder="Entrez le nom complet du patient" value="{{ $patient->prenom }} {{ $patient->nom }}"> -->
                    </div>
                    <div>
                        <span class="patient-info-label">Âge : {{ $patient->age }}</span>
                        <!-- <input type="number" id="patientAge" name="patientAge" min="0"
                               class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Entrez l'âge du patient" value="{{ $patient->age }}"> -->
                    </div>
                </div>
            </div>

            {{-- Medication List Section --}}
            <div class="">
                <h5 class="">Extraction d’une dent de sagesse</h5>
                <div id="medication-list" class="space-y-6">
                    {{-- Medication Item 1 --}}
                    <div class="medication-item p-4 border border-gray-200 rounded-md bg-gray-50 shadow-sm">
                        <div class="flex justify-between items-center mb-3">
                            <label for="medicationName1" class="block text-base font-medium text-gray-800">1. Médicament</label>
                        </div>
                        <input type="text" id="medicationName1" name="medicationName[]" value="1-AMOXICILLINE 500 MG  "
                               class="mb-3 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-semibold" placeholder="Nom du médicament">
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label for="dosageMatin1" class="block text-xs font-medium text-gray-600 mb-1">Matin</label>
                                <input type="text" id="dosageMatin1" name="dosageMatin[]" value="2 MATIN"
                                       class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Ex: 1 cp">
                            </div>
                            <div>
                                <label for="dosageMidi1" class="block text-xs font-medium text-gray-600 mb-1">Midi</label>
                                <input type="text" id="dosageMidi1" name="dosageMidi[]" value="2 MIDI"
                                       class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Ex: 1 cp">
                            </div>
                            <div>
                                <label for="dosageSoir1" class="block text-xs font-medium text-gray-600 mb-1">Soir</label>
                                <input type="text" id="dosageSoir1" name="dosageSoir[]" value="2 SOIR"
                                       class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Ex: 1 cp">
                            </div>
                        </div>
                    </div>

                    {{-- Medication Item 2 --}}
                    <div class="medication-item p-4 border border-gray-200 rounded-md bg-gray-50 shadow-sm">
                        <div class="flex justify-between items-center mb-3">
                            <label for="medicationName2" class="block text-base font-medium text-gray-800">2. Médicament</label>
                        </div>
                        <input type="text" id="medicationName2" name="medicationName[]" value="2-METRONIDAZOLE 500 MG"
                               class="mb-3 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-semibold" placeholder="Nom du médicament">
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label for="dosageMatin2" class="block text-xs font-medium text-gray-600 mb-1">Matin</label>
                                <input type="text" id="dosageMatin2" name="dosageMatin[]" value="1 MATIN"
                                       class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Ex: 1 cp">
                            </div>
                            <div>
                                <label for="dosageMidi2" class="block text-xs font-medium text-gray-600 mb-1">Midi</label>
                                <input type="text" id="dosageMidi2" name="dosageMidi[]" value="1 MIDI"
                                       class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Ex: 1 cp">
                            </div>
                            <div>
                                <label for="dosageSoir2" class="block text-xs font-medium text-gray-600 mb-1">Soir</label>
                                <input type="text" id="dosageSoir2" name="dosageSoir[]" value="1 SOIR"
                                       class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Ex: 1 cp">
                            </div>
                        </div>
                    </div>

                    {{-- Medication Item 3 (Specific Instructions) --}}
                    <div class="medication-item p-4 border border-gray-200 rounded-md bg-gray-50 shadow-sm">
                        <div class="flex justify-between items-center mb-3">
                            <label for="medicationName3" class="block text-base font-medium text-gray-800">3. Médicament</label>
                        </div>
                        <input type="text" id="medicationName3" name="medicationName[]" value="3 - DOLIPRANE 1000 MG"
                               class="mb-3 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-semibold" placeholder="Nom du médicament">
                            <p>1 cps toutes les 6 heures en cas de douleur sans dépasser 3 cps par jours </p>
                           <div><br>
                            <p>Instructions spécifiques :</p>
                            <p>Repos aujourd’hui et demain . </p>
                            <!-- <label for="specificInstructions3" class="block text-xs font-medium text-gray-600 mb-1">Instructions spécifiques</label> -->
                            <!-- <textarea id="specificInstructions3" name="specificInstructions[]" 
                                      class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm textareaInstructions"
                                      placeholder="Ex: 1 cp toutes les 6 heures en cas de douleur sans dépasser 3 cps par jours">1 cps toutes les 6 heures en cas de douleur sans dépasser 3 cps par jours</textarea> -->
                        <!-- <input type="text" id="specificInstructions3" name="medicationName[]" value="3 - DOLIPRANE 1000 MG"
                               class="mb-3 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-semibold" placeholder="Nom du médicament">
                    -->
                                    </div>
                    </div>
                </div>
            </div>

            {{-- Signature Section --}}
            <!-- <div class="mt-8 pt-6 border-t border-gray-200 text-right"> -->
            <div class="mt-8 pt-6 border-gray-200 text-right">
                <p class="text-gray-700 font-semibold mb-4">Signature :</p>
                <!-- <div class="w-48 h-24 border-b-2 border-gray-400 inline-block signature-area">
                 
                </div> -->
            </div>
            <div class="mt-8 text-center no-print">
                <button type="submit" id=""
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold
                        py-3 px-8 rounded-full shadow-lg transition duration-300
                        ease-in-out transform hover:scale-105 focus:outline-none
                        focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 print-btn">
                    Enregistrer
                </button>
            </div>
            </form>

            {{-- Print Button - Masqué à l'impression --}}
            <div class="mt-8 text-center no-print">
                <button type="button" id="printOrdonnanceBtn"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold
                        py-3 px-8 rounded-full shadow-lg transition duration-300
                        ease-in-out transform hover:scale-105 focus:outline-none
                        focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 print-btn">
                    Imprimer l'Ordonnance
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    // JavaScript pour l'impression
    document.getElementById('printOrdonnanceBtn').addEventListener('click', function() {
        window.print();
    });

    // JavaScript pour la redirection du type d'ordonnance
    const ordonnanceSelect = document.getElementById('ordonnanceSelect');
    ordonnanceSelect.addEventListener('change', function() {
        const selectedValue = this.value;
        let redirectUrl = '';

        if (selectedValue) {
             switch (selectedValue) {
                case 'cas_simple':
                     redirectUrl = "{{ url('/cas_simple/' . $patient->id) }}"; 
                    break;
                case 'dent_sagesse':
                     redirectUrl = "{{ url('/dent_sagesse/' . $patient->id) }}"; 
                    break;
                case 'extraction_simple':
                     redirectUrl = "{{ url('/extraction_simple/' . $patient->id) }}"; 
                    break;
                case 'allergie_amox':
                     redirectUrl = "{{ url('/allergie_amox/' . $patient->id) }}"; 
                    break;
                case 'recommendation':
                     redirectUrl = "{{ url('/recommendation/' . $patient->id) }}"; 
                    break;
                case 'soins_simple':
                     redirectUrl = "{{ url('/soins_simple/' . $patient->id) }}"; 
                    break;
                default:
                    console.error("Type d'ordonnance non reconnu : " + selectedValue);
                    return;
            }
            window.location.href = redirectUrl;
        }
    });

   
</script>

@endsection
