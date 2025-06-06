@extends('layouts.app')

@section('content')
   
    <link href="{{ asset('css/liste_patients.css') }}" rel="stylesheet">
    <div class="form-containerDashboard">

    <div className="banner-container">
    <div
            class="banner-background"
            style="background-image: url('{{ asset('images/sary.jpg') }}')"
        >
            <div class="banner-overlay">
                <h2 class="banner-title">Liste des Patients</h2>
                <p class="banner-subtitle">Patients enregistrés dans le cabinet dentaire</p>
            </div>
        </div>

    <div class="liste-container">
    <div class="top-table">
    <form method="" action="" class="search-form">
        <input
            type="text"
            name="search"
            class="search-bar"
            placeholder="Rechercher..."
           
        >
    </form>
    
    <button class="btn btn-danger top-table-Supprimer">Supprimer</button>
</div>


        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="check-all"></th>
                        <!-- <th>#</th> -->
                        <th>Date</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Motif de consultation</th>
                        <th>Prochain rendez-vous</th>
                        <th>Heure</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    
           
                <tr>
                    <td><input type="checkbox" class="check-item"></td>
                   
                   
                    <td>
                        <a href="#" class="edit-link">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
            
        </tbody>
                
            </table>

            {{-- Pagination --}}
            <!-- <div class="pagination">
                @if($page > 1)
                    <a href="{{ route('liste_patients', ['page'=>$page-1,'search'=>$search]) }}" class="btn btn-secondary">Précédent</a>
                @endif
                <span>Page {{ $page }} sur {{ $pages }}</span>
                @if($page < $pages)
                    <a href="{{ route('liste_patients', ['page'=>$page+1,'search'=>$search]) }}" class="btn btn-info">Suivant</a>
                @endif
            </div> -->
        </div>
    </div>
    </div>
@endsection

@push('scripts')
<script>
    // Cocher/décocher tous
    document.getElementById('check-all').addEventListener('change', e => {
        document.querySelectorAll('.check-item')
                .forEach(cb => cb.checked = e.target.checked);
    });
</script>
@endpush
