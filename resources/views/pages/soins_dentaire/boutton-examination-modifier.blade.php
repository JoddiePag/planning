@extends('pages.soins_dentaire.examination-base')

@section('title', 'Modification Examination')

@section('additional-styles')
    /* Styles spécifiques à examination.modifier.blade.php */
    .absent-overlay {
        background-color: white;
        color: red;
    }
@endsection

@section('buttons')
    <button type="button" class="btn btn-secondary examination-btn" data-url="{{ route('modification_soins_dent', $patients->id) }}" data-type="Dent Permanente">
        Dent Permanente
    </button>
    <button type="button" class="btn btn-primary examination-btn" data-url="{{ route('modification_dents_mixte', $patients->id) }}" data-type="Dent Mixte">
        Dent Mixte
    </button>
@endsection

@section('filter-logic')
    const dentNumber = parseInt(soin.dent);
    if (activeDentType === "Dent Permanente") {
        return (dentNumber >= 11 && dentNumber <= 18) ||
               (dentNumber >= 21 && dentNumber <= 28) ||
               (dentNumber >= 31 && dentNumber <= 38) ||
               (dentNumber >= 41 && dentNumber <= 48);
    } else if (activeDentType === "Dent Mixte") {
        return (dentNumber >= 51 && dentNumber <= 55) ||
               (dentNumber >= 61 && dentNumber <= 65) ||
               (dentNumber >= 71 && dentNumber <= 75) ||
               (dentNumber >= 81 && dentNumber <= 85);
    }
    return false;
@endsection

@section('javascript')
$(document).ready(function() {
    const defaultTab = $('.examination-btn').first().data('url');
    const defaultType = $('.examination-btn').first().data('type');

    loadTreatmentsFromLocalStorage();

    loadContent(defaultTab, defaultType);

    $(document).on('click', '.examination-btn', function(e) {
        e.preventDefault();
        const url = $(this).data('url');
        const typeDent = $(this).data('type');
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
            soinsList.forEach(soin => {
                if (!soin.type_dent) {
                    soin.type_dent = activeDentType;
                }
            });

            saveTreatmentsToLocalStorage();
            initializeScripts();
            updateTreatmentsTable();

        }, 100);
    }).fail(function() {
        console.error('Erreur lors du chargement du contenu');
    });
    $('#type_dent').val(typeDent);
    localStorage.setItem('currentDentType', typeDent);
}
@endsection
