@extends('layouts.app')

@section('content')
    <link href="{{ asset('css/liste_patients.css') }}" rel="stylesheet">
    <div class="form-containerDashboard">
        <div class="banner-container">
            <div class="banner-background" style="background-image: url('{{ asset('images/sary.jpg') }}')">
                <div class="banner-overlay">
                    <h2 class="banner-title">Liste des Patients</h2>
                    <p class="banner-subtitle">Patients enregistrés dans le cabinet dentaire</p>
                </div>
            </div>
        </div>

        <div class="liste-container">
            <div class="top-table">
                <form method="GET" action="/listes_patients" class="search-form">
                    <input type="text" name="search" class="search-bar" placeholder="Rechercher..." value="{{ request('search') }}">
                </form>
                <form method="POST" action="{{ route('patients.supprimer') }}" id="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger top-table-Supprimer">Supprimer</button>
                </form>
            </div>

            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="check-all"></th>
                            <th>Id</th>
                            <th>Date</th>
                            <th>Nom</th>
                            <th>Prénoms</th>
                            <th>Motif de consultation</th>
                            <th>Prochain rendez-vous</th>
                            <th>Heure</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
    @forelse($patients as $patient)
        <tr>
            <td><input type="checkbox" class="check-item" name="patient_ids[]" value="{{ $patient->id }}" form="delete-form"></td>
            <td>{{ $patient->id }}</td>
            
            <td>{{ $patient->created_at->format('Y-m-d') }}</td>
            <td>{{ $patient->nom }}</td>
            <td>{{ $patient->prenom }}</td>
            <td>{{ $patient->motif }}</td>
            <td>
                @if ($patient->rendezVous->isNotEmpty())
                    {{ \Carbon\Carbon::parse($patient->rendezVous->first()->date_heure_rdv)->format('Y-m-d') }}
                @else
                    N/A
                @endif
            </td>
            <td>
                @if ($patient->rendezVous->isNotEmpty())
                    {{ \Carbon\Carbon::parse($patient->rendezVous->first()->date_heure_rdv)->format('H:i') }}
                @else
                    N/A
                @endif
            </td>
            <td>
                <a href="/modification_patient/{{$patient->id}}" class="edit-link">
                    <i class="fas fa-edit"></i>
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" style="text-align:center;">Aucun patient trouvé.</td>
        </tr>
    @endforelse
</tbody>
                </table>
               <div class="pagination-links">
    {{ $patients->links() }}
</div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('check-all').addEventListener('change', e => {
        document.querySelectorAll('.check-item')
            .forEach(cb => cb.checked = e.target.checked);
    });
</script>
@endpush