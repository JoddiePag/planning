@extends('layouts.app')

@section('content')
{{-- Load Tailwind CSS from CDN --}}
<script src="https://cdn.tailwindcss.com"></script>
{{-- Configure Tailwind to use 'Inter' font --}}
<link href="{{ asset('css/ordonnance.css') }}" rel="stylesheet">

<!-- <a href="/modification_patient/{{$ordonnance->ordonnance_id}}" class="edit-link">
                    <i class="fas fa-angle-double-left"></i>

                </a> -->
<div class="homes min-h-screen bg-gray-100 p-4 sm:p-6 lg:p-8 flex justify-center items-start">
     
    <div class="body w-full max-w-4xl bg-white rounded-lg shadow-xl p-6 sm:p-8 lg:p-10">
        <div class="ordonnances">
          
    

            {{-- Type d'Ordonnance Selection - Masqué à l'impression --}}
            <div class="mb-8 p-4 bg-blue-50 rounded-lg border border-blue-200 no-print">
                  <label class="block text-lg font-semibold text-blue-700 mb-2" for="ordonnanceSelect">
                        Type d'ordonnance : 
                        <input type="text" id="type_ordonnance" name="type_ordonnance" 
                            class=""
                            placeholder="Saisissez le type d'ordonnance" value="{{ old('type_ordonnance', 'Dent de sagesse') }}">
                    </label>
               
            </div>

            {{-- Doctor Information Section --}}
            <!-- <div class="mb-8 border-b pb-6 border-gray-200"> -->
            <div class="">
                <div class="doctor-header"> 
                    <div>
                <p class="font-semibold text-gray-800">Cabinet de Dr {{ $ordonnance->dentiste->nom}}</p>
                        <p class="font-semibold text-gray-800">{{ $ordonnance->dentiste->prenom}}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-700">Fait le {{ $ordonnance->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <!-- <p class="block text-sm font-medium text-gray-700 mb-1 doctor-info-label">Qualifications :</p> -->
                    <pre class="whitespace-pre-wrap text-gray-800">
{{ $ordonnance->dentiste->qualifications}}
</pre>
                </div>
            </div>

            {{-- Patient Information Section --}}
            <div class=""><br>
                <!-- <h3 class="text-xl font-semibold text-gray-700 mb-4">Informations du Patient</h3> -->
                <div class="patient-details grid grid-cols-1 md:grid-cols-2 gap-4"> 
                    <div>
                        <span class="patient-info-label">Nom et Prénoms : {{ $ordonnance->patient->nom }} {{ $ordonnance->patient->prenom }}</span>
                    </div>
                    <div>
                        <span class="patient-info-label">Âge : {{ $ordonnance->patient->age }}</span>
                   </div>
                </div>
            </div>

            {{-- Medication List Section --}}
             <div class=""><br>
                <h5 class="">Extraction d’une dent de sagesse</h5>
                <div id="medication-list" class="space-y-6">
                    {{-- Medication Item 1 --}}
                    <div class="medication-item p-4 border border-gray-200 rounded-md bg-gray-50 shadow-sm">
                        <div class="flex justify-between items-center mb-3">
                            <label for="medicationName1" class="block text-base font-medium text-gray-800">1. Médicament</label>
                        </div>
                        <input type="text" id="medicationName1" name="medicationName[]" value="1-FLEMING 500 MG "
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
                        <input type="text" id="medicationName2" name="medicationName[]" value="2-FLAGYL 500 MG"
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
                            <p>Repos durant 3 jours  à renouveler en fonction de l’amélioration du (de la) patient(e) . </p>
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
</script>

@endsection
