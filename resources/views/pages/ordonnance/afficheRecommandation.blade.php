@extends('layouts.app')

@section('content')
{{-- Load Tailwind CSS from CDN --}}
<script src="https://cdn.tailwindcss.com"></script>
{{-- Configure Tailwind to use 'Inter' font --}}
<link href="{{ asset('css/ordonnance.css') }}" rel="stylesheet">

<div class="homes min-h-screen bg-gray-100 p-4 sm:p-6 lg:p-8 flex justify-center items-start">
     <!-- <div class="homes min-h-screen bg-white p-4 sm:p-6 lg:p-8 flex justify-center items-start"> -->
    <div class="body w-full max-w-4xl bg-white rounded-lg shadow-xl p-6 sm:p-8 lg:p-10">
        <div class="ordonnances">
     
            <div class="mb-8 p-4 bg-blue-50 rounded-lg border border-blue-200 no-print">
                  <label class="block text-lg font-semibold text-blue-700 mb-2" for="ordonnanceSelect">
                        Type d'ordonnance : 
                        <input type="text" id="type_ordonnance" name="type_ordonnance" 
                            class=""
                            placeholder="Saisissez le type d'ordonnance" value="{{ $ordonnance->type_ordonnance }}">
                    </label>
               
            </div>

            {{-- Doctor Information Section --}}
            <center>
                <p class="font-semibold text-gray-800">
                    Conseils post-opératoires après avulsion une ou plusieurs dents
                    Le jour de la chirurgie
                </p>
                </center>
   
            {{-- Patient Information Section --}}
            <div class=""><br>
                <!-- <h3 class="text-xl font-semibold text-gray-700 mb-4">Informations du Patient</h3> -->
                <div class=""> 
                    <div>
                        <p>
                            •	Gardez les compresses en bouche pendant une heure ou deux en maintenant une pression ferme. 
                            Changez-les toutes les demi-heures tant que le saignement persiste.
                        </p>
                        <p>
                            •	Sur conseils de votre praticien vous pouvez appliquer de la glace 
                            sur la joue à intervalles réguliers (20 minutes de glace à toutes les heures).
                        </p>
                        <p>
                            •	Les écoulements sanguins et la coloration de la salive sont des effets postopératoires normaux.
                        </p>
                        <p>
                            •	Limitez vos efforts physiques. Reposez-vous.
                        </p>
                        <p>
                            •	Ne retirer pas le caillot de sang formé, car il aide à la guérison.
                        </p>
                        <p>
                            •	Ne mangez rien avant l’arrêt du saignement.
                        </p>
                        <p>
                            •	Évitez de boire avec une paille.
                        </p>
                        <p>
                            •	Évitez de vous rincer la bouche, ou de cracher.
                        </p>
                        <p>
                            •	Éviter de fumer ou de boire de l’alcool.
                        </p>
                        <p>
                            •	Ne mangez pas d’aliments durs.
                        </p>
                        <p>
                            •	Vous pouvez continuer à vous brosser les dents, évitez simplement le ou les sites d’extraction
                        </p>
                        <p>
                            •	Si vous êtes incommodé par la douleur, prenez les médicaments qui vous ont été prescrits.
                             Ne prenez pas d’aspirine, sauf en cas de traitement au long cours.  
                        </p>
                        <p>
                            •	Si vous avez des antibiotiques prescrits pour ce traitement, continuez de 
                            les prendre pour la période de temps indiqué, même si les symptômes disparaissent.
                        </p>
                        <p>
                            •	Consommez de préférence des aliments mous ou des liquides tièdes le jour de l’extraction.
                             Reprenez votre diète habituelle dès que vous en êtes capable.

                        </p>
                     </div><br>
                     <center>
                <p class="font-semibold text-gray-800">
                    Du lendemain jusqu’à la guérison complète
                </p>
                </center>
                <p>
                    •	Rincez-vous la bouche, 2 fois par jour, avec le bain de bouche prescrit
                </p>
                <p>
                    •	Brossez vos dents et passez les brossettes interdentaires tous les jours pour enlever la plaque et assurer 
                    de meilleurs résultats à long terme. Évitez de brosser la zone d’extraction pour les 72 premières heures.
                </p>
                <p>
                    •	Évitez de manger des aliments durs (noix, bonbons, glace)
                </p>
                <p>
                    •	Il se peut que vous ayez des difficultés
                     de prononciation et une augmentation de la salive. Le tout devrait se replacer en une semaine.
                </p>
                <p>
                    •	Des ecchymoses peuvent apparaître sur la peau. Elles disparaîtront au bout de cinq à sept jours.
                </p>
                <p>
                    •	Il se peut que vous ayez des difficultés à ouvrir la bouche.
                     Le tout devrait s’atténuer au bout de quatre à cinq jours.
                </p>
                <p>
                    •	Si, après trois jours, la douleur augmente au lieu de diminuer, appelez-nous.
                </p>
                <br>
                <p>
                    Après quelques jours, vous vous sentirez mieux et vous pourrez reprendre vos activités habituelles. 
                    Si vous saignez beaucoup, ressentez de la douleur, êtes enflé depuis deux ou trois jours ou 
                    si vous réagissez 
                    au médicament, appelez-nous au {{ $ordonnance->dentiste->numero}} ou consultez un service d’urgence si le cabinet est fermé.
                </p>
                    <div>
                        
                </div>
            </div>


            {{-- Signature Section --}}
            <!-- <div class="mt-8 pt-6 border-t border-gray-200 text-right"> -->
            <div class="mt-8 pt-6 border-gray-200 text-right">
                <p class="text-gray-700 font-semibold mb-4">Signature :</p>
                <!-- <div class="w-48 h-24 border-b-2 border-gray-400 inline-block signature-area">
                 
                </div> -->
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
