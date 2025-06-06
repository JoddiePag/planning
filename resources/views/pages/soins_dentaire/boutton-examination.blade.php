
@extends('pages.soins_dentaire.examination-base')

@section('title', 'Examination')

@section('additional-styles')
    /* Styles spécifiques à examination.blade.php */
    .absent-overlay {
        background-color: rgba(255, 0, 0, 0.3);
        color: white;
    }
@endsection

@section('buttons')
    <button type="button" class="btn btn-secondary examination-btn" data-url="{{ route('soins_permanent') }}" data-type="Dent Permanente">
        Dent Permanente
    </button>
    <button type="button" class="btn btn-primary examination-btn" data-url="{{ route('soins_mixte') }}" data-type="Dent Mixte">
        Dent Mixte
    </button>
@endsection

@section('filter-logic')
    return soin.type_dent === activeDentType;
@endsection

@section('javascript')
$(document).ready(function() {
    const defaultTabUrl = $('.examination-btn').first().data('url');
    const defaultType = $('.examination-btn').first().data('type');
    const lastActiveDentType = localStorage.getItem('currentDentType');
    let initialUrl = defaultTabUrl;
    let initialType = defaultType;

    if (lastActiveDentType) {
        const lastActiveBtn = $(`.examination-btn[data-type="${lastActiveDentType}"]`);
        if (lastActiveBtn.length > 0) {
            initialUrl = lastActiveBtn.data('url');
            initialType = lastActiveBtn.data('type');
        }
    }

    loadContent(initialUrl, initialType);

    $(document).on('click', '.examination-btn', function(e) {
        e.preventDefault();
        const url = $(this).data('url');
        const typeDent = $(this).attr('data-type');
        loadContent(url, typeDent);
    });
});

function loadContent(url, typeDent) {
    $.get(url, function(data) {
        $('#contenu-examination').html(data);
        $('.examination-btn').removeClass('btn-secondary').addClass('btn-primary');
        $(`.examination-btn[data-url="${url}"]`).removeClass('btn-primary').addClass('btn-secondary');
        activeDentType = typeDent;
        
        setTimeout(function() {
            initializeScripts();
            updateTreatmentsTable();
            restoreMissingTeeth();
            
        }, 100);
    }).fail(function() {
        console.error('Erreur lors du chargement du contenu');
    });
    $('#type_dent').val(typeDent);
    localStorage.setItem('currentDentType', typeDent);
}
@endsection