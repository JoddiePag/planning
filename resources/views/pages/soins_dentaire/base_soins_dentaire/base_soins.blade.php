<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Planification Soins Dentaires</title>
  <link href="{{ asset('css/soins_dents.css') }}" rel="stylesheet">
  <style>
    /* .main-container {
      max-width: 800px;
      margin: 0 auto;
      position: relative;
    } */

    /* .image-container {
      position: relative;
      width: 100%;
      height: auto;
      overflow: hidden;
      border: 1px solid #ccc;
      border-radius: 8px;
      margin-bottom: 20px;
    } */

    /* #dentImage {
      width: 100%;
      height: auto;
    }

    .dropdown-menu {
      position: absolute;
      background: white;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
      z-index: 100;
      display: none;
      max-height: 300px;
      overflow-y: auto;
    } */

    /* .recapitulatif {
      margin-top: 20px;
      padding: 15px;
      border: 1px solid #ddd;
      border-radius: 5px;
      background-color: #f9f9f9;
    }

    .treatment-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    } */

    /* .treatment-table th, .treatment-table td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    .treatment-table th {
      background-color: #f2f2f2;
    }

    .total-price {
      margin-top: 10px;
      font-weight: bold;
      text-align: right;
    } */

    /* .highlight {
      position: absolute;
      border: 2px solid rgba(255, 0, 0, 0.7);
      background-color: rgba(13, 110, 253, 0.2);
      pointer-events: none;
      display: none;
      z-index: 5;
      border-radius: 3px;
    } */

    /* .absent-overlay {
      position: absolute;
      background-color: rgba(255, 0, 0, 0.3);
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      font-weight: bold;
      pointer-events: none;
    } */
  </style>
</head>

<body>
<div class="main-container">
  <h2></h2>
  <div class="ajout_soins">
  <div class="image-container">
    <img src="{{ asset($imagePath) }}" usemap="#dentMap" alt="Dentition Humaine" id="dentImage">
    <div class="highlight" id="dentHighlight"></div>
    <map name="dentMap">
      @foreach($mapAreas as $area)
        <area shape="{{ $area['shape'] }}" coords="{{ $area['coords'] }}" alt="{{ $area['alt'] }}" href="#" data-dent="{{ $area['data-dent'] }}">
      @endforeach
    </map>
  </div>
  </div>

  <!-- Menu contextuel -->
  <div class="dropdown-menu" id="dropdownMenu">
    <div class="menu-header" id="menuHeader">Dent sélectionnée : <span id="selectedDentNumber"></span></div>
    <div class="menu-content" id="menuContent"></div>
  </div>

  <!-- Récapitulatif des soins -->
  <div class="recapitulatif" id="recapSection">
    <h3>Soins Dentaires</h3>
    
    <table class="treatment-table">
      <thead>
        <tr>
          <th>Dent</th>
          <th>Traitement</th>
          <th>Prix </th>

          <th>Argent recu </th>
          <th>Reste </th>
          <th>Action</th>

        </tr>
      </thead>
      <tbody id="treatmentsTableBody"></tbody>
    </table>
    <div class="total-price">Total des soins : <span id="totalPrice">0</span> DH</div>
    <button id="clearTreatments" class="btn btn-danger" style="margin-top: 10px;">Effacer tous les soins</button>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/image-map-resizer/1.0.10/js/imageMapResizer.min.js"></script>
</body>
</html>