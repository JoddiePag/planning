<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Planification Soins Dentaires</title>
  <link href="{{ asset('css/soins_dents.css') }}" rel="stylesheet">

</head>

<body>
<div class="main-container">
  <h2></h2>

  <div class="image-container">
    <img src="{{ asset('images/DentMixte.png') }}" usemap="#dentMap" alt="Dentition Humaine" id="dentImage">
    <div class="highlight" id="dentHighlight"></div>
    <map name="dentMap">
      <area shape="rect" coords="345,70,390,240" alt="Dent 51" href="#" data-dent="51">
      <area shape="rect" coords="310,70,345,240" alt="Dent 52" href="#" data-dent="52">
      <area shape="rect" coords="270,70,310,240" alt="Dent 53" href="#" data-dent="53">
      <area shape="rect" coords="230,70,270,240" alt="Dent 54" href="#" data-dent="54">
      <area shape="rect" coords="175,70,230,240" alt="Dent 55" href="#" data-dent="55">

      <area shape="rect" coords="390,70,427,240" alt="Dent 61" href="#" data-dent="61">
      <area shape="rect" coords="427,70,470,240" alt="Dent 62" href="#" data-dent="62">
      <area shape="rect" coords="470,70,510,240" alt="Dent 63" href="#" data-dent="63">
      <area shape="rect" coords="510,70,548,240" alt="Dent 64" href="#" data-dent="64">
      <area shape="rect" coords="548,70,592,240" alt="Dent 65" href="#" data-dent="65">

      <area shape="rect" coords="350,240,387,420" alt="Dent 81" href="#" data-dent="81">
      <area shape="rect" coords="315,240,350,420" alt="Dent 82" href="#" data-dent="82">
      <area shape="rect" coords="285,240,315,420" alt="Dent 83" href="#" data-dent="83">
      <area shape="rect" coords="245,240,285,420" alt="Dent 84" href="#" data-dent="84">
      <area shape="rect" coords="205,240,245,420" alt="Dent 85" href="#" data-dent="85">

      <area shape="rect" coords="387,240,425,420" alt="Dent 71" href="#" data-dent="71">
      <area shape="rect" coords="425,240,460,420" alt="Dent 72" href="#" data-dent="72">
      <area shape="rect" coords="460,240,492,420" alt="Dent 73" href="#" data-dent="73">
      <area shape="rect" coords="492,240,530,420" alt="Dent 74" href="#" data-dent="74">
      <area shape="rect" coords="530,240,570,420" alt="Dent 75" href="#" data-dent="75">
   
      
    </map>
  </div>
  
  <!-- Menu contextuel -->
  <div class="dropdown-menu" id="dropdownMenu">
    <div class="menu-header" id="menuHeader">Dent sélectionnée : <span id="selectedDentNumber"></span></div>
    <div class="menu-content" id="menuContent"></div>
  </div>
  <div class="recapitulatif_soins_modifier" id="recapSection">
    <p>Nouveau soins</p>
        <table class="treatment-table">
            <thead>
            <tr>
                <th>Dent</th>
                <th>Traitement</th>
                <th>Prix (Ar)</th>
                <th>Argent reçu</th>
                <th>Reste</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="treatmentsTableBody">
            </tbody>
        </table>
        <div class="total-price">
            Total des soins permanents : <span id="totalPrice">0</span> Ar
        </div>
        <button id="clearTreatments" class="btn btn-danger">Effacer tous les soins</button>
    </div>
  <!-- Récapitulatif des soins -->
    <div class="recapitulatif_soins_modifier" id="recapSection">
    <!-- Debug des données -->
    <p>Soins récents</p>

    <div style="display:none;">
        <pre>{{ print_r($patient->toArray(), true) }}</pre>
        <pre>{{ print_r($soins->toArray(), true) }}</pre>
    </div>

    @if($soins->isEmpty())
        <p class="alert alert-info">Aucun soin mixte enregistré pour ce patient.</p>
    @else
        <table class="treatment-table">
        <thead>
            <tr>
                <th>Dent</th>
                <th>Traitement</th>
                <th>Prix (Ar)</th>
                <th>Total reçu</th>
                <th>Nouveau paiement</th>

                <th>Reste</th>
                <!-- <th>Actions</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach($soins as $soin)
                <tr data-soin-id="{{ $soin->id }}">
                    <td>{{ $soin->dent }}</td>
                    <td>{{ $soin->traitement }}</td>
                    <td>
                        <input type="number" name="existing_soins[{{ $soin->id }}][prix]" class="editable prix" value="{{ $soin->prix }}" min="0">
                    </td>
                     <td>
                        <input type="number" name="existing_soins[{{ $soin->id }}][recu]" class="editable recu" value="{{ $soin->recu }}" readonly>
                        <input type="hidden" name="existing_soins[{{ $soin->id }}][ancien_recu]" class="ancien-recu" value="{{ $soin->recu }}">
                    </td>
                    <td>
                        <input type="number" name="existing_soins[{{ $soin->id }}][nouveau_paiement]" class="editable nouveau-paiement" value="0" min="0">
                    </td>
                   
                    <td>
                        <input type="number" name="existing_soins[{{ $soin->id }}][reste]" class="editable reste" value="{{ $soin->reste }}" readonly>
                    </td>
                    <!-- <td>
                        <button type="button" class="btn btn-sm btn-primary ajouter-paiement">Ajouter</button>
                    </td> -->
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Gestion de l'ajout des paiements
    document.querySelectorAll('.ajouter-paiement').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const prixInput = row.querySelector('.prix');
            const nouveauPaiementInput = row.querySelector('.nouveau-paiement');
            const recuInput = row.querySelector('.recu');
            const ancienRecuInput = row.querySelector('.ancien-recu');
            const resteInput = row.querySelector('.reste');

            // Récupérer les valeurs
            const prix = parseFloat(prixInput.value) || 0;
            const nouveauPaiement = parseFloat(nouveauPaiementInput.value) || 0;
            const ancienRecu = parseFloat(ancienRecuInput.value) || 0;
            const recuActuel = parseFloat(recuInput.value) || 0;

            // Calculer le nouveau total reçu
            const totalRecu = ancienRecu + nouveauPaiement;
            
            // Mettre à jour les champs
            recuInput.value = totalRecu;
            ancienRecuInput.value = totalRecu; // Mettre à jour pour le prochain paiement
            
            // Calculer le nouveau reste
            const reste = Math.max(0, prix - totalRecu);
            resteInput.value = reste;
            
            // Réinitialiser le champ nouveau paiement
            nouveauPaiementInput.value = 0;
            
            // Afficher un message de confirmation
            alert(`Paiement de ${nouveauPaiement} Ar ajouté avec succès!`);
        });
    });

    // Calcul automatique quand on change le prix
    document.querySelectorAll('.prix').forEach(input => {
        input.addEventListener('input', function() {
            const row = this.closest('tr');
            const prixInput = row.querySelector('.prix');
            const recuInput = row.querySelector('.recu');
            const resteInput = row.querySelector('.reste');

            const prix = parseFloat(prixInput.value) || 0;
            const recu = parseFloat(recuInput.value) || 0;
            const reste = Math.max(0, prix - recu);
            
            resteInput.value = reste;
        });
    });
});
</script>


</body>
</html>