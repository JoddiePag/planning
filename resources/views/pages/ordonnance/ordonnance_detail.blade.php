
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    @if($type_ordonnance === 'Cas simple')
        @include('pages.ordonnance.afficheCasSimple', ['ordonnance' => $ordonnance])
    @elseif($type_ordonnance === 'Dent de sagesse')
        @include('pages.ordonnance.afficheDentSagesse', ['ordonnance' => $ordonnance])
    @elseif($type_ordonnance === 'Extraction simple')
        @include('pages.ordonnance.afficheExtraction', ['ordonnance' => $ordonnance])
    @elseif($type_ordonnance === 'Allergie Amoxicilline')
        @include('pages.ordonnance.afficheAllergieAmox', ['ordonnance' => $ordonnance])
    @elseif($type_ordonnance === 'Recommandations Postuvulsionnelles')
        @include('pages.ordonnance.afficheRecommandation', ['ordonnance' => $ordonnance])
    @elseif($type_ordonnance === 'Soins simple')
        @include('pages.ordonnance.afficheSoinsSimple', ['ordonnance' => $ordonnance])
    @endif
</div>
@endsection