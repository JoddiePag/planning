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
  <img src="{{ asset($imagePath) }}" usemap="#dentMap" alt="Dentition Humaine" id="dentImage">
  <div class="highlight" id="dentHighlight"></div>
    <map name="dentMap">
      @foreach($mapAreas as $area)
        <area shape="{{ $area['shape'] }}" coords="{{ $area['coords'] }}" alt="{{ $area['alt'] }}" href="#" data-dent="{{ $area['data-dent'] }}">
      @endforeach
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