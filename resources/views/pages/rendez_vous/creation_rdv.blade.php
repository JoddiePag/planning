{{-- resources/views/pages/creation_rdv.blade.php --}}
<div id="creationRdvModal" class="modal-overlay" style="display: none;">
  <div class="modal-content">
    <span id="closeCreationModal" class="close-btn">&times;</span>
    <h5>Création de rendez‑vous</h5>
   
    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
    <form action="{{ route('creation_rdv') }}" method="POST">
      @csrf
      <div class="mb-3">
  <label for="rdvName" class="form-label">Nom du patient</label>
  <input type="text" name="nom" id="rdvName" class="form-control">
</div>
      <div class="mb-3">
  <label for="rdvPrenom" class="form-label">Prénoms du patient</label>
  <input type="text" name="prenom" id="rdvPrenom" class="form-control">
</div>




      <div class="mb-3">
        <label for="rdvDate" class="form-label">Date et heure</label>
        <input type="datetime-local" name="date" id="rdvDate" class="form-control" required>
      </div>
     <div class="mb-3">
    <label for="heure_fin" class="form-label">Heure fin</label>
    <input type="time" class="form-control" id="heure_fin" name="heure_fin" step="900" required>
</div>

      <div class="mb-3">
        <label for="rdvSoin" class="form-label">Type de soin</label>
        <select name="soin" id="rdvSoin" class="form-select">
          <option value="consultation">Consultation</option>
          <option value="detartrage">Détartrage</option>
          <option value="extraction">Extraction</option>
          <option value="prothese">Prothèse</option>
          <option value="ODF">ODF</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
  </div>
</div>
