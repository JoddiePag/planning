@extends('layouts.app')

@section('content')
<link href="{{ asset('css/profil.css') }}" rel="stylesheet">

<div class="form-containerDashboard">
  <div class="">
    <section class="profil-header">
      <div class="avatar-upload">
        <label for="avatar">
        <!-- <img src="{{ session('dentiste_avatar') ?? asset('images/default-avatar.jpg') }}?t={{ time() }}" 
     alt="Avatar" 
     class="profil-avatar" 
     id="avatar-preview"/> -->
     <img src="{{ session('dentiste_avatar') }}?t={{ time() }}" 
     alt="Avatar" 
     class="profil-avatar" 
     id="avatar-preview"/>


          <span class="avatar-edit-icon"><i class="fas fa-camera"></i></span>
        </label>
      </div>
      <div>
        <h1 class="profil-name">{{ session('dentiste_nom') }} {{ session('dentiste_prenom') }}</h1>
        <p class="profil-role">{{ old('adresse', session('dentiste_adresse')) }}</p>
      </div>
    </section>

    <form method="POST" action="{{ route('profil_update') }}" enctype="multipart/form-data">
      @csrf
      <div class="profil-grid">
        <!-- Champ avatar unique dans le formulaire -->
        <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;"/>
        
        <!-- Informations de contact -->
        <section class="profil-section">
          <h2>Informations de contact</h2>
          <div class="profil-card">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="{{ session('email') }}" />
            </div>

            <div class="form-group">
              <label for="numero">Téléphone</label>
              <input type="text" class="form-control" id="numero" name="numero" value="{{ session('dentiste_numero') }}" />
            </div>
            <div class="form-group">
              <label for="adresse">Adresse</label>
              <input type="text" class="form-control" id="adresse" name="adresse"  value="{{ session('dentiste_adresse') }}"/>
            </div>
          </div>
        </section>

        <!-- Informations personnelles -->
        <section class="profil-section">
          <h2>Informations personnelles</h2>
          <div class="profil-card">
            <div class="form-group">
              <label for="nom">Nom</label>
              <input type="text" class="form-control" id="nom" name="nom" value="{{ session('dentiste_nom') }}" />
            </div>
            <div class="form-group">
              <label for="prenom">Prénoms</label>
              <input type="text" class="form-control" id="prenom" name="prenom" value="{{ session('dentiste_prenom') }}" />
            </div>
          </div>
        </section>
         <!-- qualification -->
              <section class="profil-section">
                    <h2>Qualifications</h2>
                    <div class="profil-card">
                               <div class="form-group">
            <label for="qualifications">Qualifications</label>
            {{-- La correction est ici : place le contenu entre les balises textarea --}}
            <textarea class="form-control" id="qualifications" name="qualifications" rows="6">{{ old('qualifications', session('dentiste_qualifications')) }}</textarea>
        </div>

                        <!-- <div class="form-group">
                            <label for="motdepasse">Nouveau mot de passe</label>
                            <input type="password" class="form-control" id="motdepasse" name="motdepasse" />
                        </div>
                        <div class="form-group">
                            <label for="motdepasse_confirmation">Confirmer le nouveau mot de passe</label>
                            <input type="password" class="form-control" id="motdepasse_confirmation" name="motdepasse_confirmation" />
                        </div> -->
                    </div>
                </section>
     
      
              </div>
      

      <div class="profil-actions">
        <button type="submit" class="profil-edit-btn">Modifier le profil</button>
      </div>
    </form>
  </div>
</div>

<script>
document.getElementById('avatar').addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('avatar-preview').src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
});
</script>
@endsection