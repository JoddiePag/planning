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
    <img src="{{ asset('images/dent_modifier1.png') }}" usemap="#dentMap" alt="Dentition Humaine" id="dentImage">
    <div class="highlight" id="dentHighlight"></div>
    <map name="dentMap">
      <!-- Dents supérieures (18 -> 11) -->
      <area shape="rect" coords="10,80,65,240" alt="Dent 18" href="#" data-dent="18">
      <area shape="rect" coords="65,70,120,240" alt="Dent 17" href="#" data-dent="17">
      <area shape="rect" coords="120,70,175,240" alt="Dent 16" href="#" data-dent="16">
      <area shape="rect" coords="175,70,230,240" alt="Dent 15" href="#" data-dent="15">
      <area shape="rect" coords="230,70,270,240" alt="Dent 14" href="#" data-dent="14">
      <area shape="rect" coords="270,70,310,240" alt="Dent 13" href="#" data-dent="13">
      <area shape="rect" coords="310,70,345,240" alt="Dent 12" href="#" data-dent="12">
      <area shape="rect" coords="345,70,390,240" alt="Dent 11" href="#" data-dent="11">

      <!-- Dents supérieures (21 -> 28) -->
      <area shape="rect" coords="390,70,427,240" alt="Dent 21" href="#" data-dent="21">
      <area shape="rect" coords="427,70,470,240" alt="Dent 22" href="#" data-dent="22">
      <area shape="rect" coords="470,70,510,240" alt="Dent 23" href="#" data-dent="23">
      <area shape="rect" coords="510,70,548,240" alt="Dent 24" href="#" data-dent="24">
      <area shape="rect" coords="548,70,592,240" alt="Dent 25" href="#" data-dent="25">
      <area shape="rect" coords="592,70,650,240" alt="Dent 26" href="#" data-dent="26">
      <area shape="rect" coords="650,70,705,240" alt="Dent 27" href="#" data-dent="27">
      <area shape="rect" coords="705,70,770,240" alt="Dent 28" href="#" data-dent="28">

      <!-- Dents inférieures (48 -> 41) -->
      <area shape="rect" coords="20,240,90,420" alt="Dent 48" href="#" data-dent="48">
      <area shape="rect" coords="90,240,150,420" alt="Dent 47" href="#" data-dent="47">
      <area shape="rect" coords="150,240,205,420" alt="Dent 46" href="#" data-dent="46">
      <area shape="rect" coords="205,240,245,420" alt="Dent 45" href="#" data-dent="45">
      <area shape="rect" coords="245,240,285,420" alt="Dent 44" href="#" data-dent="44">
      <area shape="rect" coords="285,240,315,420" alt="Dent 43" href="#" data-dent="43">
      <area shape="rect" coords="315,240,350,420" alt="Dent 42" href="#" data-dent="42">
      <area shape="rect" coords="350,240,387,420" alt="Dent 41" href="#" data-dent="41">

      <!-- Dents inférieures (31 -> 38) -->
      <area shape="rect" coords="387,240,425,420" alt="Dent 31" href="#" data-dent="31">
      <area shape="rect" coords="425,240,460,420" alt="Dent 32" href="#" data-dent="32">
      <area shape="rect" coords="460,240,492,420" alt="Dent 33" href="#" data-dent="33">
      <area shape="rect" coords="492,240,530,420" alt="Dent 34" href="#" data-dent="34">
      <area shape="rect" coords="530,240,570,420" alt="Dent 35" href="#" data-dent="35">
      <area shape="rect" coords="570,240,625,420" alt="Dent 36" href="#" data-dent="36">
      <area shape="rect" coords="625,240,680,420" alt="Dent 37" href="#" data-dent="37">
      <area shape="rect" coords="680,240,750,420" alt="Dent 38" href="#" data-dent="38">
    </map>
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
          <th>Prix (Ar)</th>
        </tr>
      </thead>
      <tbody id="treatmentsTableBody"></tbody>
    </table>
    <div class="total-price">Total des soins : <span id="totalPrice">0</span> Ar</div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/image-map-resizer/1.0.10/js/imageMapResizer.min.js"></script>

<script>
// Structure des soins (menu hiérarchique)
const soinsStructure = {
  "Absente": [],
  "Extraction": [],
  "Soins dentaires": {
    "Canalaire": [],
    "OC": []
  },
  "ODF": [],
  "Detartrage": [],
  "Prothèse": {
    "PC": ["Zincan", "CCM", "Résine"],
    "Stellite": [],
    "PAP": []
  },
  "Plombage": []
};

let selectedDent = null;
const dropdownMenu = document.getElementById('dropdownMenu');
const menuHeader = document.getElementById('menuHeader');
const selectedDentNumber = document.getElementById('selectedDentNumber');
const menuContent = document.getElementById('menuContent');
const recapSection = document.getElementById('recapSection');
const treatmentsTableBody = document.getElementById('treatmentsTableBody');
const totalPriceElem = document.getElementById('totalPrice');
const dentHighlight = document.getElementById('dentHighlight');
const dentImage = document.getElementById('dentImage');
const imageContainer = document.querySelector('.image-container');

let soinsList = []; // Stocker les soins choisis

// Variables pour le zoom
let isZoomed = false;
let currentZoom = 1;
const ZOOM_LEVEL = 1.5;
let originalImageWidth = 800;
let originalImageHeight = 420;

// Stocker les coordonnées originales des zones
const areaOriginalCoords = {};

// Générer le menu HTML
function generateMenu(data, parentElem, path = []) {
  const ul = document.createElement('ul');

  for (const key in data) {
    const li = document.createElement('li');
    li.textContent = key;

    const fullPath = [...path, key];

    if (Array.isArray(data[key])) {
      // Si c'est un tableau et qu'il contient des options
      if (data[key].length > 0) {
        const submenu = document.createElement('ul');
        submenu.classList.add('submenu');
        
        data[key].forEach(option => {
          const subLi = document.createElement('li');
          subLi.textContent = option;
          subLi.onclick = (e) => {
            e.stopPropagation();
            confirmSoin(fullPath.join(" > "), option);
            dropdownMenu.style.display = 'none';
            resetZoom();
          };
          submenu.appendChild(subLi);
        });
        
        li.appendChild(submenu);
        li.classList.add('has-submenu');
      } else {
        // Si c'est un tableau vide, c'est une option finale
        li.onclick = (e) => {
          e.stopPropagation();
          confirmSoin(fullPath.join(" > "), "");
          dropdownMenu.style.display = 'none';
          resetZoom();
        };
      }
    } else if (typeof data[key] === 'object') {
      // Sous-menu
      const submenu = document.createElement('div');
      submenu.classList.add('submenu');
      generateMenu(data[key], submenu, fullPath);
      li.appendChild(submenu);
      li.classList.add('has-submenu');
    }

    ul.appendChild(li);
  }

  parentElem.appendChild(ul);
}

// Ajouter le soin au tableau + recalcul du total
function confirmSoin(traitement, option) {
  if (!selectedDent) return;

  // Créer une nouvelle ligne dans le tableau
  const row = document.createElement('tr');
  row.dataset.dent = selectedDent;
  row.dataset.traitement = traitement;
  if (option) row.dataset.option = option;
  
  // Afficher le traitement complet
  let traitementComplet = traitement;
  if (option) traitementComplet += " > " + option;
  
  row.innerHTML = `
    <td>${selectedDent}</td>
    <td>${traitementComplet}</td>
    <td><input type="number" class="price-input" placeholder="Entrez le prix" value="0"></td>
  `;
  
  // Appliquer la classe CSS en fonction du type de soin
  if (traitement === "Prothèse") {
    row.classList.add('prothese');
    
    // Optionnel: ajouter une sous-classe pour le type spécifique
    if (option) {
      const sousType = option.split(' > ')[0]; // Prend juste le premier niveau
      row.classList.add(`prothese-${sousType.toLowerCase()}`);
    }
  } else if (traitement === "Detartrage") {
    row.classList.add('detartrage');
  }
  // Ajouter d'autres conditions pour les autres types de soins...
  
  // Ajouter un écouteur d'événement pour mettre à jour le total quand le prix change
  const priceInput = row.querySelector('.price-input');
  priceInput.addEventListener('input', updateTotal);
  
  treatmentsTableBody.appendChild(row);
  
  // Stocker le soin dans la liste
  soinsList.push({
    dent: selectedDent,
    traitement: traitementComplet,
    prix: 0, 
    row: row
  });

  recapSection.style.display = 'block';

  // Si le traitement est "Absente", masquer la dent
  if (traitement === "Absente") {
    markToothAsMissing(selectedDent);
  }
}

// Mettre à jour le total des soins
function updateTotal() {
  let total = 0;
  
  // Parcourir toutes les lignes du tableau
  document.querySelectorAll('#treatmentsTableBody tr').forEach(row => {
    const priceInput = row.querySelector('.price-input');
    if (priceInput && priceInput.value) {
      const price = parseInt(priceInput.value) || 0;
      total += price;
      
      // Mettre à jour le prix dans soinsList
      const dent = row.dataset.dent;
      const traitement = row.dataset.traitement;
      const option = row.dataset.option || "";
      
      const traitementComplet = option ? `${traitement} > ${option}` : traitement;
      
      // Trouver et mettre à jour le soin correspondant
      const soin = soinsList.find(item => 
        item.dent === dent && item.traitement === traitementComplet
      );
      
      if (soin) {
        soin.prix = price;
      }
    }
  });
  
  totalPriceElem.textContent = total;
}
// Marquer une dent comme absente
function markToothAsMissing(toothNumber) {
  const area = document.querySelector(`area[data-dent="${toothNumber}"]`);
  if (!area) return;

  // Vérifier si la dent est déjà marquée comme absente
  if (document.querySelector(`.absent-overlay[data-dent="${toothNumber}"]`)) {
    return;
  }

  // Créer un overlay pour la dent absente
  const overlay = document.createElement('div');
  overlay.className = 'absent-overlay';
  overlay.dataset.dent = toothNumber;
  overlay.textContent = 'Absente';

  // Positionner l'overlay sur la dent
  const coords = area.coords.split(',').map(Number);
  const [x1, y1, x2, y2] = coords;
  
  overlay.style.left = `${x1}px`;
  overlay.style.top = `${y1}px`;
  overlay.style.width = `${x2 - x1}px`;
  overlay.style.height = `${y2 - y1}px`;

  // Ajouter l'overlay au conteneur d'image
  imageContainer.appendChild(overlay);

  // Désactiver la zone cliquable
  area.style.pointerEvents = 'none';
}

// Mettre à jour la position des overlays absents lors du zoom
function updateAbsentOverlays() {
  const zoomFactor = isZoomed ? currentZoom : 1;
  const originX = parseFloat(dentImage.style.transformOrigin.split(' ')[0]);
  const originY = parseFloat(dentImage.style.transformOrigin.split(' ')[1]);

  document.querySelectorAll('.absent-overlay').forEach(overlay => {
    const toothNumber = overlay.dataset.dent;
    const area = document.querySelector(`area[data-dent="${toothNumber}"]`);
    if (area) {
      const coords = areaOriginalCoords[toothNumber].split(',').map(Number);
      const [x1, y1, x2, y2] = coords;
      
      if (isZoomed) {
        // Calculer les nouvelles positions avec le zoom
        const newX1 = originX - (originX - x1) * zoomFactor;
        const newY1 = originY - (originY - y1) * zoomFactor;
        const newX2 = originX + (x2 - originX) * zoomFactor;
        const newY2 = originY + (y2 - originY) * zoomFactor;
        
        overlay.style.left = `${newX1}px`;
        overlay.style.top = `${newY1}px`;
        overlay.style.width = `${newX2 - newX1}px`;
        overlay.style.height = `${newY2 - newY1}px`;
      } else {
        // Position originale sans zoom
        overlay.style.left = `${x1}px`;
        overlay.style.top = `${y1}px`;
        overlay.style.width = `${x2 - x1}px`;
        overlay.style.height = `${y2 - y1}px`;
      }
    }
  });
}

// Zoom sur la dent sélectionnée
function applyZoom(area) {
  if (isZoomed) return;
  
  const coords = area.coords.split(',').map(Number);
  const [x1, y1, x2, y2] = coords;
  
  // Calcul du centre de la zone
  const centerX = (x1 + x2) / 2;
  const centerY = (y1 + y2) / 2;
  
  // Sauvegarder l'état original
  currentZoom = ZOOM_LEVEL;
  isZoomed = true;
  
  // Appliquer le zoom centré sur la dent
  dentImage.style.transformOrigin = `${centerX}px ${centerY}px`;
  dentImage.style.transform = `scale(${ZOOM_LEVEL})`;
  
  // Highlight
  updateHighlightPosition(area);
  dentHighlight.style.display = 'block';
  
  // Mettre à jour les overlays absents
  updateAbsentOverlays();
  
  // Désactiver temporairement la carte image pendant le zoom
  document.querySelector('map[name="dentMap"]').style.pointerEvents = 'none';
}

// Mettre à jour la position du highlight en fonction du zoom
function updateHighlightPosition(area) {
  const coords = area.coords.split(',').map(Number);
  const [x1, y1, x2, y2] = coords;
  
  // Ajuster les coordonnées en fonction du zoom
  const scaleFactor = isZoomed ? currentZoom : 1;
  const originX = parseFloat(dentImage.style.transformOrigin.split(' ')[0]);
  const originY = parseFloat(dentImage.style.transformOrigin.split(' ')[1]);
  
  // Calculer les nouvelles positions avec le zoom
  const newX1 = originX - (originX - x1) * scaleFactor;
  const newY1 = originY - (originY - y1) * scaleFactor;
  const newX2 = originX + (x2 - originX) * scaleFactor;
  const newY2 = originY + (y2 - originY) * scaleFactor;
  
  dentHighlight.style.left = `${newX1}px`;
  dentHighlight.style.top = `${newY1}px`;
  dentHighlight.style.width = `${newX2 - newX1}px`;
  dentHighlight.style.height = `${newY2 - newY1}px`;
}

// Réinitialiser le zoom
function resetZoom() {
  if (!isZoomed) return;
  
  dentImage.style.transform = 'scale(1)';
  dentHighlight.style.display = 'none';
  isZoomed = false;
  currentZoom = 1;
  
  // Mettre à jour les overlays absents
  updateAbsentOverlays();
  
  // Réactiver la carte image
  document.querySelector('map[name="dentMap"]').style.pointerEvents = 'auto';
}

// Afficher le menu sur clic de dent
document.querySelectorAll('area').forEach(area => {
  // Stocker les coordonnées originales
  areaOriginalCoords[area.dataset.dent] = area.coords;
  
  // Effet de zoom au survol
  area.addEventListener('mouseenter', () => {
    applyZoom(area);
  });
  
  area.addEventListener('mouseleave', () => {
    if (!dropdownMenu.style.display || dropdownMenu.style.display === 'none') {
      resetZoom();
    }
  });
  
  area.addEventListener('click', (e) => {
    e.preventDefault();
    selectedDent = area.dataset.dent;
    
    // Mettre à jour l'affichage du numéro de dent
    selectedDentNumber.textContent = selectedDent;
    
    // Régénérer le menu
    menuContent.innerHTML = '';
    generateMenu(soinsStructure, menuContent);
    
    // Obtenir les coordonnées de la zone cliquée
    const coords = area.coords.split(',').map(Number);
    const [x1, y1, x2, y2] = coords;
    
    // Positionner le menu à droite de la dent
    let menuLeft = x2 + 10;
    let menuTop = y1;
    
    // Vérifier si le menu dépasse de l'image
    const imageWidth = document.querySelector('.image-container').offsetWidth;
    
    if (menuLeft + dropdownMenu.offsetWidth > imageWidth) {
      // Si ça dépasse à droite, mettre à gauche
      menuLeft = x1 - dropdownMenu.offsetWidth - 10;
    }
    
    // Vérifier si le menu dépasse en bas
    const imageHeight = document.querySelector('.image-container').offsetHeight;
    
    if (menuTop + dropdownMenu.offsetHeight > imageHeight) {
      // Si ça dépasse en bas, aligner avec le bas de la dent
      menuTop = y2 - dropdownMenu.offsetHeight;
    }
    
    // Positionner le menu
    dropdownMenu.style.left = `${menuLeft}px`;
    dropdownMenu.style.top = `${menuTop}px`;
    dropdownMenu.style.display = 'block';
    
    // Appliquer le zoom
    applyZoom(area);
  });
});

// Cacher le menu si on clique ailleurs
document.addEventListener('click', (e) => {
  if (!dropdownMenu.contains(e.target) && e.target.tagName !== 'AREA') {
    dropdownMenu.style.display = 'none';
    resetZoom();
  }
});

// Fermer le menu avec Escape
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    dropdownMenu.style.display = 'none';
    resetZoom();
  }
});

// Scroll automatique des éléments au survol
document.addEventListener('mouseover', function(e) {
  if (e.target.tagName === 'LI' && e.target.closest('.dropdown-menu')) {
    e.target.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }
});

// Adapter la carte image au redimensionnement
function resizeMap() {
  const image = document.getElementById('dentImage');
  const originalWidth = 800;
  const ratio = image.clientWidth / originalWidth;

  document.querySelectorAll('area').forEach(area => {
    const originalCoords = areaOriginalCoords[area.dataset.dent] || area.coords;
    if (!areaOriginalCoords[area.dataset.dent]) {
      areaOriginalCoords[area.dataset.dent] = originalCoords;
    }
    const scaledCoords = originalCoords.split(',').map(coord => Math.round(coord * ratio));
    area.coords = scaledCoords.join(',');
  });

  // Mettre à jour aussi les overlays des dents absentes
  document.querySelectorAll('.absent-overlay').forEach(overlay => {
    const toothNumber = overlay.dataset.dent;
    const area = document.querySelector(`area[data-dent="${toothNumber}"]`);
    if (area) {
      const coords = areaOriginalCoords[toothNumber].split(',').map(Number);
      const [x1, y1, x2, y2] = coords;
      overlay.style.left = `${x1}px`;
      overlay.style.top = `${y1}px`;
      overlay.style.width = `${x2 - x1}px`;
      overlay.style.height = `${y2 - y1}px`;
    }
  });
}

// Initialisation
window.addEventListener('load', function() {
  // Stocker les coordonnées originales
  document.querySelectorAll('area').forEach(area => {
    areaOriginalCoords[area.dataset.dent] = area.coords;
  });
  
  resizeMap();
  setTimeout(resizeMap, 100); // Double vérification pour certains navigateurs
  
  // Initialiser image-map-resizer
  imageMapResize();
});

window.addEventListener('resize', resizeMap);
</script>

</body>
</html>