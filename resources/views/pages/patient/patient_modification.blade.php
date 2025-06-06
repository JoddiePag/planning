<h1>Modification</h1>
<form method="POST" action="{{ url('/modifier_patient') }}">
    @csrf

    <input type="hidden" name="id" value="{{ $dentiste->id }}"> {{-- ← AJOUTE CECI --}}

    <div class="form-group mb-4">
        <label for="nom">Nom</label>
        <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom " value="{{ $dentiste->nom }}">
    </div>

    <div class="form-group mb-4">
        <label for="prenom">Prénom</label>
        <input type="text" class="form-control" id="prenom" name="prenom" value="{{ $dentiste->prenom }}">
    </div>

    <div class="form-group mb-4">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ $dentiste->email }}">
    </div>

    <button type="submit" class="btn btn-primary btn-lg form-control form-control-lg">
        Modifier
    </button>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

</form>
