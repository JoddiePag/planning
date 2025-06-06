<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Examination')</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="{{ asset('css/soins_dents.css') }}" rel="stylesheet">

    <style>
        /* Styles communs */
        .boutton-menu-Examination { margin-bottom: 20px; }
        .btn {
            padding: 8px 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-primary { background-color: #0d6efd; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
        #dentHighlight {
            position: absolute;
            border: 2px solid rgba(255, 0, 0, 0.7);
            background-color: rgba(13, 110, 253, 0.2);
            pointer-events: none;
            display: none;
            z-index: 10;
            border-radius: 3px;
        }
        #recapSection { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .prothese { background-color: #ffe6e6; }
        .detartrage { background-color: #e6f3ff; }
        .absent-overlay {
            position: absolute;
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            color: red;
            font-weight: bold;
            pointer-events: none;
        }
        .soins-table-container { margin-bottom: 30px; }
        .table-title { font-weight: bold; margin-bottom: 10px; }

        /* Styles pour les overlays de prothèse */
        /* .prothese-overlay {
            position: absolute;
            background-color: rgba(255, 0, 0, 0.3);
            pointer-events: none;
            z-index: 5;
        }

        .prothese-root-overlay {
            position: absolute;
            background-color: rgba(255, 0, 0, 0.3);
            pointer-events: none;
            z-index: 5;
            border-radius: 0 0 5px 5px;
        } */

        /* Styles spécifiques qui peuvent être surchargés */
        @yield('additional-styles')
    </style>
</head>
<body>

<div class="boutton-menu-Examination">
    @yield('buttons')
</div>

<div id="contenu-examination"></div>
<div id="dentHighlight"></div>

<script>
window.soinsList = @json($soinsList ?? []);
let selectedDent = null;
let activeDentType = null;
const ZOOM_LEVEL = 1.5;
let isZoomed = false;
let currentZoom = 1;
const areaOriginalCoords = {};

/* Structure des soins */
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

/* Fonctions pour gérer le localStorage */
function saveTreatmentsToLocalStorage() {
    localStorage.setItem('soinsList', JSON.stringify(soinsList));
}

function loadTreatmentsFromLocalStorage() {
    const savedTreatments = localStorage.getItem('soinsList2');
    if (savedTreatments) {
        soinsList = JSON.parse(savedTreatments);
    }
}

function clearLocalStorage() {
    localStorage.removeItem('soinsList');
    soinsList = [];
}

/* Mettre à jour le tableau des traitements */
function updateTreatmentsTable() {
    const treatmentsTableBody = document.getElementById('treatmentsTableBody');
    if (!treatmentsTableBody) return;
    treatmentsTableBody.innerHTML = '';

    const filteredSoins = soinsList.filter(soin => {
        @yield('filter-logic')
    });

    filteredSoins.forEach((soin, index) => {
        const row = document.createElement('tr');
        row.dataset.dent = soin.dent;
        row.dataset.traitement = soin.traitement;
        row.dataset.originalIndex = soinsList.indexOf(soin);

        row.innerHTML = `
            <td>${soin.dent}</td>
            <td>${soin.traitement}</td>
            <td><input type="number" class="price-input" placeholder="Entrez le prix" value="${soin.prix || 0}"></td>
            <td><input type="number" class="received-input" placeholder="Entrez argent reçu" value="${soin.recu || 0}"></td>
            <td><input type="number" class="remaining-input" placeholder="Reste" value="${soin.reste || 0}" readonly></td>
            <td><button class="btn btn-sm btn-danger remove-treatment">Supprimer</button></td>
        `;

        if (soin.traitement.includes("Prothèse")) {
            row.classList.add('prothese');
        } else if (soin.traitement.includes("Detartrage")) {
            row.classList.add('detartrage');
        } else if (soin.traitement.includes("Absente")) {
            row.classList.add('absent');
        }

        const priceInput = row.querySelector('.price-input');
        priceInput.addEventListener('input', function() {
            soin.prix = parseInt(this.value) || 0;
            calculateRemaining(soin, row);
            updateTotal();
            saveTreatmentsToLocalStorage();
        });

        const receivedInput = row.querySelector('.received-input');
        receivedInput.addEventListener('input', function() {
            soin.recu = parseInt(this.value) || 0;
            calculateRemaining(soin, row);
            saveTreatmentsToLocalStorage();
        });

        treatmentsTableBody.appendChild(row);
        calculateRemaining(soin, row);

    });

    updateTotal();
    checkProtheseOnMissingTeeth();
    updateAllAbsentOverlays();
}

/* Calculer le reste */
function calculateRemaining(soin, row) {
    const remainingInput = row.querySelector('.remaining-input');
    soin.reste = Math.max(0, (soin.prix || 0) - (soin.recu || 0));
    remainingInput.value = soin.reste;
}

/* Ajouter un soin */
/* function confirmSoin(traitement, option) {
    if (!selectedDent || !activeDentType) return;

    let traitementComplet = traitement;
    if (option && traitement !== "Absente") traitementComplet += " > " + option;

    const existingIndex = soinsList.findIndex(item =>
        item.dent === selectedDent &&
        item.traitement === traitementComplet &&
        item.type_dent === activeDentType
    );

    if (existingIndex === -1) {
        soinsList.push({
            dent: selectedDent,
            traitement: traitementComplet,
            type_dent: activeDentType,
            prix: 0,
            recu: 0,
            reste: 0
        });
        saveTreatmentsToLocalStorage();
        updateTreatmentsTable();

        if (traitement === "Absente" && option === "") {
            markToothAsMissing(selectedDent);
        }
    } else {
        console.log("Ce soin est déjà enregistré pour cette dent et ce type de dent.");
    }
} */
function confirmSoin(traitement, option) {
    if (!selectedDent || !activeDentType) return;

    let traitementComplet = traitement;
    if (option && traitement !== "Absente") traitementComplet += " > " + option;

    const area = document.querySelector(`#contenu-examination area[data-dent="${selectedDent}"]`);
    if (!area) return;

    // Récupérer les coordonnées originales de la zone
    const coords = areaOriginalCoords[selectedDent] ?
                  areaOriginalCoords[selectedDent].split(',') :
                  area.coords.split(',');
    const [x1, y1, x2, y2] = coords;

    const existingIndex = soinsList.findIndex(item =>
        item.dent === selectedDent &&
        item.traitement === traitementComplet &&
        item.type_dent === activeDentType
    );

    if (existingIndex === -1) {
        // Créer l'objet soin avec les coordonnées
        const nouveauSoin = {
            dent: selectedDent,
            traitement: traitementComplet,
            type_dent: activeDentType,
            prix: 0,
            recu: 0,
            reste: 0,
            x1: parseInt(x1),
            y1: parseInt(y1),
            x2: parseInt(x2),
            y2: parseInt(y2)
        };

        soinsList.push(nouveauSoin);
        saveTreatmentsToLocalStorage();
        updateTreatmentsTable();

        if (traitement === "Absente" && option === "") {
            markToothAsMissing(selectedDent);
        }
    } else {
        console.log("Ce soin est déjà enregistré pour cette dent et ce type de dent.");
    }
}
// Dans la fonction qui prépare les données avant envoi au serveur
function prepareDataForSave() {
    return {
        // ... autres données du formulaire
        soins: JSON.stringify(soinsList.map(soin => ({
            dent: soin.dent,
            traitement: soin.traitement,
            type_dent: soin.type_dent,
            prix: soin.prix,
            recu: soin.recu,
            reste: soin.reste,
            x1: soin.x1,
            y1: soin.y1,
            x2: soin.x2,
            y2: soin.y2
        })))
    };
}
/* Marquer une dent comme absente */
function markToothAsMissing(toothNumber) {
    const area = document.querySelector(`#contenu-examination area[data-dent="${toothNumber}"]`);
    if (!area) return;

    if (document.querySelector(`.absent-overlay[data-dent="${toothNumber}"][data-type-dent="${activeDentType}"]`)) {
        return;
    }

    const overlay = document.createElement('div');
    overlay.className = 'absent-overlay';
    overlay.dataset.dent = toothNumber;
    overlay.dataset.typeDent = activeDentType;
    overlay.textContent = 'Absente';

    const coords = areaOriginalCoords[toothNumber] ? areaOriginalCoords[toothNumber].split(',').map(Number) : area.coords.split(',').map(Number);
    const [x1, y1, x2, y2] = coords;

    overlay.style.left = `${x1}px`;
    overlay.style.top = `${y1}px`;
    overlay.style.width = `${x2 - x1}px`;
    overlay.style.height = `${y2 - y1}px`;

    const imageContainer = document.querySelector('#contenu-examination .image-container');
    if (imageContainer) {
        imageContainer.appendChild(overlay);
    }

    area.style.pointerEvents = 'none';

    overlay.addEventListener('click', function(e) {
        e.stopPropagation();
        const indexToRemove = soinsList.findIndex(item =>
            item.dent === toothNumber &&
            item.traitement === "Absente" &&
            item.type_dent === activeDentType
        );

        if (indexToRemove !== -1) {
            soinsList.splice(indexToRemove, 1);
            saveTreatmentsToLocalStorage();
            updateTreatmentsTable();

            document.querySelectorAll(`[data-dent="${toothNumber}"][data-type-dent="${activeDentType}"]`).forEach(el => el.remove());

            const areaToReactivate = document.querySelector(`#contenu-examination area[data-dent="${toothNumber}"]`);
            if (areaToReactivate) areaToReactivate.style.pointerEvents = 'auto';
        }
        document.getElementById('dropdownMenu').style.display = 'none';
        resetZoom();
    });

    updateAbsentOverlayPosition(toothNumber);
}

 function checkProtheseOnMissingTeeth() {
    document.querySelectorAll('.prothese-overlay, .prothese-root-overlay').forEach(el => el.remove());

    soinsList.forEach(soin => {
        if (soin.traitement.includes("Prothèse") && soin.type_dent === activeDentType) {
            const isAbsent = soinsList.some(item =>
                item.dent === soin.dent &&
                item.traitement === "Absente" &&
                item.type_dent === activeDentType
            );

            if (isAbsent) {
                const toothNumber = soin.dent;
                const area = document.querySelector(`#contenu-examination area[data-dent="${toothNumber}"]`);
                if (!area) return;

                document.querySelectorAll(`.absent-overlay[data-dent="${toothNumber}"][data-type-dent="${activeDentType}"]`).forEach(el => el.remove());

                if (soin.traitement.includes("PC")) {
                    const rootOverlay = document.createElement('div');
                    rootOverlay.className = 'prothese-root-overlay';
                    rootOverlay.dataset.dent = toothNumber;
                    rootOverlay.dataset.typeDent = activeDentType;

                    const coords = areaOriginalCoords[toothNumber] ? areaOriginalCoords[toothNumber].split(',').map(Number) : area.coords.split(',').map(Number);
                    const [x1, y1, x2, y2] = coords;

                    // Ajustez ces valeurs pour contrôler la taille de l'overlay de racine
                    const rootWidth = x2 - x1;
                    const rootHeight = (y2 - y1) * 0.3; // 40% de la hauteur pour la racine
                    const rootX = x1;

                    // Positionnement différent pour les dents du haut et du bas
                    const toothNum = parseInt(toothNumber);
                    let rootY;
                    if (toothNum >= 11 && toothNum <= 28) {
                        // Dent du haut - positionner en bas
                        rootY = y1 + (y2 - y1) * 0.7; // Commence à 60% du haut
                    } else {
                        // Dent du bas - positionner en haut
                        rootY = y1;
                    }

                    rootOverlay.style.left = `${rootX}px`;
                    rootOverlay.style.top = `${rootY}px`;
                    rootOverlay.style.width = `${rootWidth}px`;
                    rootOverlay.style.height = `${rootHeight}px`;

                    const imageContainer = document.querySelector('#contenu-examination .image-container');
                    if (imageContainer) {
                        imageContainer.appendChild(rootOverlay);
                    }
                } else {
                    // Pour les autres types de prothèses (Stellite/PAP), gardez l'overlay complet
                    const dentOverlay = document.createElement('div');
                    dentOverlay.className = 'prothese-overlay';
                    dentOverlay.dataset.dent = toothNumber;
                    dentOverlay.dataset.typeDent = activeDentType;

                    const coords = areaOriginalCoords[toothNumber] ? areaOriginalCoords[toothNumber].split(',').map(Number) : area.coords.split(',').map(Number);
                    const [x1, y1, x2, y2] = coords;

                    dentOverlay.style.left = `${x1}px`;
                    dentOverlay.style.top = `${y1}px`;
                    dentOverlay.style.width = `${x2 - x1}px`;
                    dentOverlay.style.height = `${y2 - y1}px`;

                    const imageContainer = document.querySelector('#contenu-examination .image-container');
                    if (imageContainer) {
                        imageContainer.appendChild(dentOverlay);
                    }
                }

                updateProtheseOverlayPosition(toothNumber);
            }
        }
    });
}
function updateAbsentOverlayPosition(toothNumber) {
    const overlay = document.querySelector(`.absent-overlay[data-dent="${toothNumber}"][data-type-dent="${activeDentType}"]`);
    const area = document.querySelector(`#contenu-examination area[data-dent="${toothNumber}"]`);

    if (!overlay || !area || !areaOriginalCoords[toothNumber]) return;

    const coords = areaOriginalCoords[toothNumber].split(',').map(Number);
    const [x1, y1, x2, y2] = coords;

    if (isZoomed) {
        const dentImage = document.getElementById('dentImage');
        if (!dentImage) return;
        const [originX, originY] = dentImage.style.transformOrigin.split(' ').map(parseFloat);

        const newX1 = originX - (originX - x1) * currentZoom;
        const newY1 = originY - (originY - y1) * currentZoom;
        const newX2 = originX + (x2 - originX) * currentZoom;
        const newY2 = originY + (y2 - originY) * currentZoom;

        overlay.style.left = `${newX1}px`;
        overlay.style.top = `${newY1}px`;
        overlay.style.width = `${newX2 - newX1}px`;
        overlay.style.height = `${newY2 - newY1}px`;
        overlay.style.transform = `scale(1)`;
    } else {
        overlay.style.left = `${x1}px`;
        overlay.style.top = `${y1}px`;
        overlay.style.width = `${x2 - x1}px`;
        overlay.style.height = `${y2 - y1}px`;
        overlay.style.transform = 'none';
    }
}
 function updateProtheseOverlayPosition(toothNumber) {
    const overlays = document.querySelectorAll(`.prothese-overlay[data-dent="${toothNumber}"], .prothese-root-overlay[data-dent="${toothNumber}"]`);
    const area = document.querySelector(`#contenu-examination area[data-dent="${toothNumber}"]`);

    if (!overlays.length || !area || !areaOriginalCoords[toothNumber]) return;

    const coords = areaOriginalCoords[toothNumber].split(',').map(Number);
    const [x1, y1, x2, y2] = coords;

    if (isZoomed) {
        const dentImage = document.getElementById('dentImage');
        if (!dentImage) return;
        const [originX, originY] = dentImage.style.transformOrigin.split(' ').map(parseFloat);

        const newX1 = originX - (originX - x1) * currentZoom;
        const newY1 = originY - (originY - y1) * currentZoom;
        const newX2 = originX + (x2 - originX) * currentZoom;
        const newY2 = originY + (y2 - originY) * currentZoom;

        overlays.forEach(overlay => {
            if (overlay.classList.contains('prothese-overlay')) {
                overlay.style.left = `${newX1}px`;
                overlay.style.top = `${newY1}px`;
                overlay.style.width = `${newX2 - newX1}px`;
                overlay.style.height = `${newY2 - newY1}px`;
            } else {
                const rootWidth = newX2 - newX1;
                const rootHeight = (newY2 - newY1) * 0.3;
                const rootX = newX1;

                const toothNum = parseInt(toothNumber);
                let rootY;
                if (toothNum >= 11 && toothNum <= 28) {
                    // Dent du haut - positionner en bas
                    rootY = newY1 + (newY2 - newY1) * 0.7;
                } else {
                    // Dent du bas - positionner en haut
                    rootY = newY1;
                }

                overlay.style.left = `${rootX}px`;
                overlay.style.top = `${rootY}px`;
                overlay.style.width = `${rootWidth}px`;
                overlay.style.height = `${rootHeight}px`;
            }
            overlay.style.transform = 'none';
        });
    } else {
        overlays.forEach(overlay => {
            if (overlay.classList.contains('prothese-overlay')) {
                overlay.style.left = `${x1}px`;
                overlay.style.top = `${y1}px`;
                overlay.style.width = `${x2 - x1}px`;
                overlay.style.height = `${y2 - y1}px`;
            } else {
                const rootWidth = x2 - x1;
                const rootHeight = (y2 - y1) * 0.3;
                const rootX = x1;

                const toothNum = parseInt(toothNumber);
                let rootY;
                if (toothNum >= 11 && toothNum <= 28) {
                    // Dent du haut - positionner en bas
                    rootY = y1 + (y2 - y1) * 0.7;
                } else {
                    // Dent du bas - positionner en haut
                    rootY = y1;
                }

                overlay.style.left = `${rootX}px`;
                overlay.style.top = `${rootY}px`;
                overlay.style.width = `${rootWidth}px`;
                overlay.style.height = `${rootHeight}px`;
            }
            overlay.style.transform = 'none';
        });
    }
}
function updateAllAbsentOverlays() {
    document.querySelectorAll(`.absent-overlay[data-type-dent="${activeDentType}"]`).forEach(overlay => {
        updateAbsentOverlayPosition(overlay.dataset.dent);
    });
}

function updateAllProtheseOverlays() {
    soinsList.forEach(soin => {
        if (soin.traitement.includes("Prothèse") && soin.type_dent === activeDentType) {
            updateProtheseOverlayPosition(soin.dent);
        }
    });
}

function updateTotal() {
    let total = 0;
    document.querySelectorAll('#treatmentsTableBody tr').forEach(row => {
        const priceInput = row.querySelector('.price-input');
        if (priceInput) {
            total += parseInt(priceInput.value) || 0;
        }
    });
    const totalPriceElement = document.getElementById('totalPrice');
    if (totalPriceElement) {
        totalPriceElement.textContent = total;
    }
}

/* Gestion du zoom */
function applyZoom(area) {
    if (isZoomed) return;

    const coords = area.coords.split(',').map(Number);
    const [x1, y1, x2, y2] = coords;
    const centerX = (x1 + x2) / 2;
    const centerY = (y1 + y2) / 2;

    currentZoom = ZOOM_LEVEL;
    isZoomed = true;

    const dentImage = document.getElementById('dentImage');
    if (dentImage) {
        dentImage.style.transformOrigin = `${centerX}px ${centerY}px`;
        dentImage.style.transform = `scale(${ZOOM_LEVEL})`;
    }

    updateHighlightPosition(area);
    document.getElementById('dentHighlight').style.display = 'block';
    updateAllAbsentOverlays();
    updateAllProtheseOverlays();

    const dentMap = document.querySelector('map[name="dentMap"]');
    if (dentMap) dentMap.style.pointerEvents = 'none';
}

function updateHighlightPosition(area) {
    const coords = area.coords.split(',').map(Number);
    const [x1, y1, x2, y2] = coords;
    const scaleFactor = isZoomed ? currentZoom : 1;
    const dentImage = document.getElementById('dentImage');
    let originX = 0, originY = 0;
    if (dentImage && dentImage.style.transformOrigin) {
        [originX, originY] = dentImage.style.transformOrigin.split(' ').map(parseFloat);
    }

    const newX1 = originX - (originX - x1) * scaleFactor;
    const newY1 = originY - (originY - y1) * scaleFactor;
    const newX2 = originX + (x2 - originX) * scaleFactor;
    const newY2 = originY + (y2 - originY) * scaleFactor;

    const dentHighlight = document.getElementById('dentHighlight');
    if (dentHighlight) {
        dentHighlight.style.left = `${newX1}px`;
        dentHighlight.style.top = `${newY1}px`;
        dentHighlight.style.width = `${newX2 - newX1}px`;
        dentHighlight.style.height = `${newY2 - newY1}px`;
    }
}

function resetZoom() {
    if (!isZoomed) return;

    const dentImage = document.getElementById('dentImage');
    if (dentImage) {
        dentImage.style.transform = 'scale(1)';
    }
    const dentHighlight = document.getElementById('dentHighlight');
    if (dentHighlight) {
        dentHighlight.style.display = 'none';
    }
    isZoomed = false;
    currentZoom = 1;
    updateAllAbsentOverlays();
    updateAllProtheseOverlays();
    const dentMap = document.querySelector('map[name="dentMap"]');
    if (dentMap) dentMap.style.pointerEvents = 'auto';
}

function resizeMap() {
    const image = document.getElementById('dentImage');
    if (!image) return;
    const originalWidth = 800;
    const ratio = image.clientWidth / originalWidth;

    document.querySelectorAll('#contenu-examination area').forEach(area => {
        const dentNumber = area.dataset.dent;
        const originalCoords = areaOriginalCoords[dentNumber];

        if (originalCoords) {
            const scaledCoords = originalCoords.split(',').map(coord => Math.round(parseFloat(coord) * ratio));
            area.coords = scaledCoords.join(',');
        }
    });

    updateAllAbsentOverlays();
    updateAllProtheseOverlays();
}

/* Générer le menu des soins */
function generateMenu(data, parentElem, path = []) {
    const ul = document.createElement('ul');

    for (const key in data) {
        const li = document.createElement('li');
        li.textContent = key;
        const fullPath = [...path, key];

        if (key === "Absente") {
            const isAbsent = soinsList.some(item =>
                item.dent === selectedDent && item.traitement === "Absente" && item.type_dent === activeDentType
            );
            const submenu = document.createElement('ul');
            submenu.classList.add('submenu');

            if (isAbsent) {
                const subLi = document.createElement('li');
                subLi.textContent = "Annuler l'absence";
                subLi.onclick = (e) => {
                    e.stopPropagation();
                    const indexToRemove = soinsList.findIndex(item =>
                        item.dent === selectedDent && item.traitement === "Absente" && item.type_dent === activeDentType
                    );

                    if (indexToRemove !== -1) {
                        soinsList.splice(indexToRemove, 1);
                        saveTreatmentsToLocalStorage();
                        updateTreatmentsTable();

                        const overlay = document.querySelector(`.absent-overlay[data-dent="${selectedDent}"][data-type-dent="${activeDentType}"]`);
                        const area = document.querySelector(`#contenu-examination area[data-dent="${selectedDent}"]`);
                        if (overlay) overlay.remove();
                        if (area) area.style.pointerEvents = 'auto';
                    }
                    document.getElementById('dropdownMenu').style.display = 'none';
                    resetZoom();
                };
                submenu.appendChild(subLi);
                li.appendChild(submenu);
                li.classList.add('has-submenu');
            } else {
                li.onclick = (e) => {
                    e.stopPropagation();
                    confirmSoin(fullPath.join(" > "), "");
                    document.getElementById('dropdownMenu').style.display = 'none';
                    resetZoom();
                };
            }
        } else if (Array.isArray(data[key])) {
            if (data[key].length > 0) {
                const submenu = document.createElement('ul');
                submenu.classList.add('submenu');

                data[key].forEach(option => {
                    const subLi = document.createElement('li');
                    subLi.textContent = option;
                    subLi.onclick = (e) => {
                        e.stopPropagation();
                        confirmSoin(fullPath.join(" > "), option);
                        document.getElementById('dropdownMenu').style.display = 'none';
                        resetZoom();
                    };
                    submenu.appendChild(subLi);
                });

                li.appendChild(submenu);
                li.classList.add('has-submenu');
            } else {
                li.onclick = (e) => {
                    e.stopPropagation();
                    confirmSoin(fullPath.join(" > "), "");
                    document.getElementById('dropdownMenu').style.display = 'none';
                    resetZoom();
                };
            }
        } else if (typeof data[key] === 'object') {
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

function handleRemoveTreatment(e) {
    if (e.target.classList.contains('remove-treatment')) {
        const row = e.target.closest('tr');
        const originalIndex = parseInt(row.dataset.originalIndex);
        const soinToRemove = soinsList[originalIndex];
        const toothNumber = soinToRemove.dent;
        const typeDent = soinToRemove.type_dent;

        soinsList.splice(originalIndex, 1);

        if (soinToRemove.traitement === "Absente") {
            soinsList = soinsList.filter(item =>
                !(item.dent === toothNumber &&
                  item.type_dent === typeDent &&
                  item.traitement.includes("Prothèse"))
            );
        }

        document.querySelectorAll(`[data-dent="${toothNumber}"][data-type-dent="${typeDent}"]`).forEach(el => el.remove());

        const area = document.querySelector(`#contenu-examination area[data-dent="${toothNumber}"]`);
        if (area) area.style.pointerEvents = 'auto';

        saveTreatmentsToLocalStorage();
        updateTreatmentsTable();
    }
    if (e.target.id === 'clearTreatments') {
        if (confirm('Voulez-vous vraiment effacer tous les soins (pour le type de dent actuel) ?')) {
            soinsList = soinsList.filter(soin => soin.type_dent !== activeDentType);
            saveTreatmentsToLocalStorage();
            document.querySelectorAll(`.absent-overlay[data-type-dent="${activeDentType}"]`).forEach(el => el.remove());
            const areas = document.querySelectorAll(`#contenu-examination area[data-dent]`);
            areas.forEach(area => {
                area.style.pointerEvents = 'auto';
            });
            updateTreatmentsTable();
        }
    }
}

function handleGlobalClick(e) {
    const dropdownMenu = document.getElementById('dropdownMenu');
    if (dropdownMenu && !dropdownMenu.contains(e.target) && e.target.tagName !== 'AREA') {
        dropdownMenu.style.display = 'none';
        resetZoom();
    }
}

function handleGlobalKeydown(e) {
    if (e.key === 'Escape') {
        const dropdownMenu = document.getElementById('dropdownMenu');
        if (dropdownMenu) {
            dropdownMenu.style.display = 'none';
        }
        resetZoom();
    }
}

/* function restoreMissingTeeth() {
    document.querySelectorAll('.absent-overlay, .prothese-overlay, .prothese-root-overlay').forEach(el => el.remove());

    soinsList.forEach(soin => {
        if (soin.traitement === "Absente" && soin.type_dent === activeDentType) {
            markToothAsMissing(soin.dent);
        }
    });

    checkProtheseOnMissingTeeth();
} */
function restoreMissingTeeth() {
    document.querySelectorAll('.absent-overlay, .prothese-overlay, .prothese-root-overlay').forEach(el => el.remove());

    soinsList.forEach(soin => {
        if (soin.traitement === "Absente" && soin.type_dent === activeDentType) {
            markToothAsMissing(soin.dent);
        } else if (soin.traitement.includes("Prothèse") && soin.type_dent === activeDentType) {
            const area = document.querySelector(`#contenu-examination area[data-dent="${soin.dent}"]`);
            if (!area) return;

            if (soin.traitement.includes("PC")) {
                createProtheseRootOverlay(soin.dent, {
                    x1: soin.x1,
                    y1: soin.y1,
                    x2: soin.x2,
                    y2: soin.y2
                });
            } else {
                createProtheseOverlay(soin.dent, {
                    x1: soin.x1,
                    y1: soin.y1,
                    x2: soin.x2,
                    y2: soin.y2
                });
            }
        }
    });
}
function initializeScripts() {
    document.querySelectorAll('#contenu-examination area').forEach(area => {
        if (!areaOriginalCoords[area.dataset.dent]) {
            areaOriginalCoords[area.dataset.dent] = area.coords;
        }
    });

    document.querySelectorAll('#contenu-examination area').forEach(area => {
        const newArea = area.cloneNode(true);
        area.parentNode.replaceChild(newArea, area);
        area = newArea;

        area.addEventListener('mouseenter', () => {
            applyZoom(area);
        });

        area.addEventListener('mouseleave', () => {
            if (!document.getElementById('dropdownMenu').style.display ||
                document.getElementById('dropdownMenu').style.display === 'none') {
                resetZoom();
            }
        });

        area.addEventListener('click', (e) => {
            e.preventDefault();
            selectedDent = area.dataset.dent;

            const selectedDentNumberElement = document.getElementById('selectedDentNumber');
            if (selectedDentNumberElement) {
                selectedDentNumberElement.textContent = selectedDent;
            }

            const menuContentElement = document.getElementById('menuContent');
            if (menuContentElement) {
                menuContentElement.innerHTML = '';
                generateMenu(soinsStructure, menuContentElement);
            }

            const dropdownMenu = document.getElementById('dropdownMenu');
            if (!dropdownMenu) return;

            const coords = area.coords.split(',').map(Number);
            const [x1, y1, x2, y2] = coords;

            let menuLeft = x2 + 10;
            let menuTop = y1;

            const imageContainer = document.querySelector('#contenu-examination .image-container');
            const imageContainerWidth = imageContainer ? imageContainer.offsetWidth : window.innerWidth;

            if (menuLeft + dropdownMenu.offsetWidth > imageContainerWidth) {
                menuLeft = x1 - dropdownMenu.offsetWidth - 10;
            }

            dropdownMenu.style.left = `${menuLeft}px`;
            dropdownMenu.style.top = `${menuTop}px`;
            dropdownMenu.style.display = 'block';

            applyZoom(area);
        });
    });

    document.removeEventListener('click', handleGlobalClick);
    document.addEventListener('click', handleGlobalClick);

    document.removeEventListener('keydown', handleGlobalKeydown);
    document.addEventListener('keydown', handleGlobalKeydown);

    document.removeEventListener('click', handleRemoveTreatment);
    document.addEventListener('click', handleRemoveTreatment);

    restoreMissingTeeth();
    resizeMap();
}

/* Gestion du redimensionnement de la fenêtre */
window.addEventListener('resize', resizeMap);
window.addEventListener('load', function() {
    resizeMap();
    setTimeout(resizeMap, 100);
});

@yield('javascript')
</script>
</body>
</html>
