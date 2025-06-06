@extends('layouts.app')

@section('content')
<link href="{{ asset('css/rendez_vous.css') }}" rel="stylesheet">
<style>
  .parametre-container {
    /* background-color: #f9f9f9; */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    /* max-width: 600px; */
    margin: 20px auto;
  }

  .parametre-title {
    color: #2E86AB;
    /* text-align: center; */
    margin-bottom: 20px;
    font-size: 1.2rem;
  }

  .info-section {
    margin-bottom: 20px;
    padding: 15px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    border: 1px solid #eee;
  }

  .info-section h3 {
    color: #2c3e50;
    margin-bottom: 10px;
    font-size: 1.2em;
  }

  .info-section ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .info-section li {
    margin-bottom: 5px;
    color: #555;
  }

  .change-password-button {
    background-color: #3498db;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    display: block;
    /* margin: 20px auto 0 auto; */
    width: 200px;
    /* text-align: center; */
  }

  .change-password-button:hover {
    background-color: #217dbb;
  }

  /* Modal Styles */
  .modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
  }

  .modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 90%;
    max-width: 500px;
    position: relative;
  }

  .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
  }

  .modal-header h2 {
    margin: 0;
    color: #2E86AB;
    font-size: 1.2em;

  }

  .close-button {
    position: absolute;
    top: 10px;
    right: 10px;
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
  }

  .close-button:hover,
  .close-button:focus {
    color: #000;
    text-decoration: none;
  }

  .modal-body {
    margin-bottom: 20px;
  }

  .modal-body form input {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box;
  }

  .modal-body form button {
    background-color: #3498db;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
  }

  .modal-body form button:hover {
    background-color: #217dbb;
  }
  /* @media (max-width: 640px) {
    .parametre-container {
        padding: 15px;
    }
    .info-section {
        padding: 10px;
    }
    .modal-content{
       margin-top: 20%;
    }
} */
</style>

<div class="homes">
  <div class="body">
    
  <div class="parametre-container">
  <h2 class="parametre-title">Paramètres du compte</h2>

  <div class="info-section">
    <h3>Informations personnelles</h3>
    <ul>
      <li>Nom : Dr. {{ $dentiste->nom }} {{ $dentiste->prenom }}</li>
      <li>Email : {{ $dentiste->email }}</li>
    </ul>
  </div>

  <div class="info-section">
    <h3>Préférences de rendez-vous</h3>
    <ul>
      <li>Durée RDV : 15 minutes</li>
      <li>Horaires : 08h-15 à 20h</li>
      <li> Jours de consultation : Lundi à Dimanche</li>
     
    </ul>
  </div>
  <div class="info-section">
    <h3>À propos de l'application</h3>
    <p>
  <strong>Planinako</strong> est une application de gestion de cabinet dentaire.
  Elle permet aux dentistes de :
</p>
    <ul>
    <li>Gérer les rendez-vous des patients</li>
  <li>Suivre les traitements dentaires</li>
  <li>Créer des ordonnances</li>
  <!-- <li>Consulter l’historique des soins</li> -->
  <li>Afficher des statistiques de consultation</li>
     
    </ul>
  </div>
  <button id="changePasswordButton" class="change-password-button">Changer le mot de passe</button>
  

  <div id="changePasswordModal" class="modal" style="@if($errors->has('motdepasse') || $errors->has('new_password') || session('password_success')) display: block; @else display: none; @endif">
    <div class="modal-content">
      <span class="close-button">&times;</span>
      <div class="modal-header">
        <h2>Changer mot de passe</h2>
      </div>
      <div class="modal-body">
        @if(session('password_success'))
        <div class="alert alert-success">
          {{ session('password_success') }}
        </div>
        @endif
        
        <form method="POST" action="{{ route('changePassword') }}">
          @csrf
          <div class="form-group">
            <input type="password" name="motdepasse" placeholder="Ancien mot de passe" required>
            @error('motdepasse')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          
          <div class="form-group">
            <input type="password" name="new_password" placeholder="Nouveau mot de passe" required>
            @error('new_password')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          
          <div class="form-group">
            <input type="password" name="new_password_confirmation" placeholder="Confirmer mot de passe" required>
          </div>
          
          <button type="submit" class="btn-submit">Changer</button>
        </form>
      </div>
    </div>
</div>

</div>
  </div>
</div>
<script>
  const modal = document.getElementById("changePasswordModal");
  const btn = document.getElementById("changePasswordButton");
  const closeBtn = document.querySelector(".close-button");

  // Ouvrir la modal
  if(btn) {
    btn.onclick = function() {
      modal.style.display = "block";
    }
  }

  // Fermer la modal et recharger pour effacer les messages
  if(closeBtn) {
    closeBtn.onclick = function() {
      modal.style.display = "none";
      // Rechargement seulement si succès ou erreurs
      @if($errors->has('motdepasse') || $errors->has('new_password') || session('password_success'))
        window.location.reload();
      @endif
    }
  }

  // Fermer en cliquant à l'extérieur
  window.onclick = function(event) {
    if (event.target === modal) {
      modal.style.display = "none";
      // Rechargement seulement si succès ou erreurs
      @if($errors->has('motdepasse') || $errors->has('new_password') || session('password_success'))
        window.location.reload();
      @endif
    }
  }

  // Afficher automatiquement la modal s'il y a des erreurs ou un succès
  document.addEventListener('DOMContentLoaded', function() {
    @if($errors->has('motdepasse') || $errors->has('new_password') || session('password_success'))
      if(modal) modal.style.display = "block";
    @endif
  });
</script>



@endsection