<div class="main-container">
    <h2></h2>
<style>
        /* Overlays styles */
 <style>
    /* Overlays styles */
    .absent-overlay {
        position: absolute;
        background-color: rgba(255, 255, 255, 0.7); /* Semi-transparent */
        border: none;
        display: flex;
        justify-content: center;
        align-items: center;
        color: red;
        font-weight: bold;
        pointer-events: none;
        transform-origin: 0 0;
        z-index: 15;
    }
     .image-container {
        position: relative;
    }
    
    .prothese-root-overlay {
        z-index: 9;
    }
     .prothese-overlay {
        position: absolute;
        background-color: rgba(255, 0, 0, 0.3);
        border: 2px solid rgba(255, 0, 0, 0.7);
        pointer-events: none;
        display: block;
        z-index: 9;
        border-radius: 3px;
        box-sizing: border-box;
    }

    .prothese-root-overlay {
        position: absolute;
        background-color: rgba(40, 167, 69, 0.4); /* Vert semi-transparent */
        border: 2px solid rgba(40, 167, 69, 0.7);
        pointer-events: none;
        z-index: 9;
        border-radius: 3px;
        box-sizing: border-box;
    } 
</style>

    </style>
    <div class="image-container">
        <img src="{{ asset('images/dent_modifier1.png') }}" usemap="#dentMap" alt="Dentition Humaine" id="dentImage">
        <div class="highlight" id="dentHighlight"></div>
        <map name="dentMap">
            <area shape="rect" coords="10,80,65,240" alt="Dent 18" href="#" data-dent="18">
            <area shape="rect" coords="65,70,120,240" alt="Dent 17" href="#" data-dent="17">
            <area shape="rect" coords="120,70,175,240" alt="Dent 16" href="#" data-dent="16">
            <area shape="rect" coords="175,70,230,240" alt="Dent 15" href="#" data-dent="15">
            <area shape="rect" coords="230,70,270,240" alt="Dent 14" href="#" data-dent="14">
            <area shape="rect" coords="270,70,310,240" alt="Dent 13" href="#" data-dent="13">
            <area shape="rect" coords="310,70,345,240" alt="Dent 12" href="#" data-dent="12">
            <area shape="rect" coords="345,70,390,240" alt="Dent 11" href="#" data-dent="11">

            <area shape="rect" coords="390,70,427,240" alt="Dent 21" href="#" data-dent="21">
            <area shape="rect" coords="427,70,470,240" alt="Dent 22" href="#" data-dent="22">
            <area shape="rect" coords="470,70,510,240" alt="Dent 23" href="#" data-dent="23">
            <area shape="rect" coords="510,70,548,240" alt="Dent 24" href="#" data-dent="24">
            <area shape="rect" coords="548,70,592,240" alt="Dent 25" href="#" data-dent="25">
            <area shape="rect" coords="592,70,650,240" alt="Dent 26" href="#" data-dent="26">
            <area shape="rect" coords="650,70,705,240" alt="Dent 27" href="#" data-dent="27">
            <area shape="rect" coords="705,70,770,240" alt="Dent 28" href="#" data-dent="28">

            <area shape="rect" coords="20,240,90,420" alt="Dent 48" href="#" data-dent="48">
            <area shape="rect" coords="90,240,150,420" alt="Dent 47" href="#" data-dent="47">
            <area shape="rect" coords="150,240,205,420" alt="Dent 46" href="#" data-dent="46">
            <area shape="rect" coords="205,240,245,420" alt="Dent 45" href="#" data-dent="45">
            <area shape="rect" coords="245,240,285,420" alt="Dent 44" href="#" data-dent="44">
            <area shape="rect" coords="285,240,315,420" alt="Dent 43" href="#" data-dent="43">
            <area shape="rect" coords="315,240,350,420" alt="Dent 42" href="#" data-dent="42">
            <area shape="rect" coords="350,240,387,420" alt="Dent 41" href="#" data-dent="41">

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

    <div class="recapitulatif_soins_modifier" id="recapSection">
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/image-map-resizer/1.0.10/js/imageMapResizer.min.js"></script>

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

    // 
    // Styles pour les overlays
    window.soinsList = @json($soinsList ?? []);
    const areaOriginalCoords = {};
    let selectedDent = null;
    let activeDentType = 'Dent Permanente';
    const ZOOM_LEVEL = 1.5;
    let isZoomed = false;
    let currentZoom = 1;

    // Initialisation
    function initializeScripts() {
        // Sauvegarde des coordonnées originales
        document.querySelectorAll('#contenu-examination area').forEach(area => {
            areaOriginalCoords[area.dataset.dent] = area.coords;
        });

        // Restauration des overlays
        restoreMissingTeeth();
        
        // Gestion des événements
        document.addEventListener('click', handleGlobalClick);
        document.addEventListener('keydown', handleGlobalKeydown);
        document.addEventListener('click', handleRemoveTreatment);
        
        // Redimensionnement
        resizeMap();
    }

    // Restaurer les overlays à partir des données
    function restoreMissingTeeth() {
        document.querySelectorAll('.absent-overlay, .prothese-overlay, .prothese-root-overlay').forEach(el => el.remove());

        soinsList.forEach(soin => {
            if (soin.traitement === "Absente" && soin.type_dent === activeDentType) {
                createAbsentOverlay(soin);
            } else if (soin.traitement.includes("Prothèse") && soin.type_dent === activeDentType) {
                createProtheseOverlay(soin);
            }
        });
    }

    // Créer un overlay pour dent absente
    function createAbsentOverlay(soin) {
        const overlay = document.createElement('div');
        overlay.className = 'absent-overlay';
        overlay.dataset.dent = soin.dent;
        overlay.dataset.typeDent = soin.type_dent;
        overlay.textContent = 'Absente';

        overlay.style.left = `${soin.x1}px`;
        overlay.style.top = `${soin.y1}px`;
        overlay.style.width = `${soin.x2 - soin.x1}px`;
        overlay.style.height = `${soin.y2 - soin.y1}px`;

        document.querySelector('.image-container').appendChild(overlay);
    }

    // Créer un overlay pour prothèse
    function createProtheseOverlay(soin) {
        if (soin.traitement.includes("PC")) {
            const rootOverlay = document.createElement('div');
            rootOverlay.className = 'prothese-root-overlay';
            rootOverlay.dataset.dent = soin.dent;
            rootOverlay.dataset.typeDent = soin.type_dent;

            // Calcul de la position de la racine
            const rootHeight = (soin.y2 - soin.y1) * 0.3;
            let rootY;
            const toothNum = parseInt(soin.dent);
            if (toothNum >= 11 && toothNum <= 28) {
                rootY = soin.y1 + (soin.y2 - soin.y1) * 0.7;
            } else {
                rootY = soin.y1;
            }

            rootOverlay.style.left = `${soin.x1}px`;
            rootOverlay.style.top = `${rootY}px`;
            rootOverlay.style.width = `${soin.x2 - soin.x1}px`;
            rootOverlay.style.height = `${rootHeight}px`;

            document.querySelector('.image-container').appendChild(rootOverlay);
        } else {
            const dentOverlay = document.createElement('div');
            dentOverlay.className = 'prothese-overlay';
            dentOverlay.dataset.dent = soin.dent;
            dentOverlay.dataset.typeDent = soin.type_dent;

            dentOverlay.style.left = `${soin.x1}px`;
            dentOverlay.style.top = `${soin.y1}px`;
            dentOverlay.style.width = `${soin.x2 - soin.x1}px`;
            dentOverlay.style.height = `${soin.y2 - soin.y1}px`;

            document.querySelector('.image-container').appendChild(dentOverlay);
        }
    }

    // Gestion du zoom
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
        updateAllOverlays();
    }

    // Mettre à jour tous les overlays
    function updateAllOverlays() {
        soinsList.forEach(soin => {
            if (soin.traitement === "Absente" && soin.type_dent === activeDentType) {
                updateOverlayPosition(soin, '.absent-overlay');
            } else if (soin.traitement.includes("Prothèse") && soin.type_dent === activeDentType) {
                if (soin.traitement.includes("PC")) {
                    updateOverlayPosition(soin, '.prothese-root-overlay');
                } else {
                    updateOverlayPosition(soin, '.prothese-overlay');
                }
            }
        });
    }

    // Mettre à jour la position d'un overlay
    function updateOverlayPosition(soin, selector) {
        const overlay = document.querySelector(`${selector}[data-dent="${soin.dent}"][data-type-dent="${soin.type_dent}"]`);
        if (!overlay) return;

        if (isZoomed) {
            const dentImage = document.getElementById('dentImage');
            const [originX, originY] = dentImage.style.transformOrigin.split(' ').map(parseFloat);
            
            const newX1 = originX - (originX - soin.x1) * currentZoom;
            const newY1 = originY - (originY - soin.y1) * currentZoom;
            const newX2 = originX + (soin.x2 - originX) * currentZoom;
            const newY2 = originY + (soin.y2 - originY) * currentZoom;

            if (selector === '.prothese-root-overlay') {
                const rootHeight = (newY2 - newY1) * 0.3;
                let rootY;
                const toothNum = parseInt(soin.dent);
                if (toothNum >= 11 && toothNum <= 28) {
                    rootY = newY1 + (newY2 - newY1) * 0.7;
                } else {
                    rootY = newY1;
                }
                
                overlay.style.left = `${newX1}px`;
                overlay.style.top = `${rootY}px`;
                overlay.style.width = `${newX2 - newX1}px`;
                overlay.style.height = `${rootHeight}px`;
            } else {
                overlay.style.left = `${newX1}px`;
                overlay.style.top = `${newY1}px`;
                overlay.style.width = `${newX2 - newX1}px`;
                overlay.style.height = `${newY2 - newY1}px`;
            }
        } else {
            if (selector === '.prothese-root-overlay') {
                const rootHeight = (soin.y2 - soin.y1) * 0.3;
                let rootY;
                const toothNum = parseInt(soin.dent);
                if (toothNum >= 11 && toothNum <= 28) {
                    rootY = soin.y1 + (soin.y2 - soin.y1) * 0.7;
                } else {
                    rootY = soin.y1;
                }
                
                overlay.style.left = `${soin.x1}px`;
                overlay.style.top = `${rootY}px`;
                overlay.style.width = `${soin.x2 - soin.x1}px`;
                overlay.style.height = `${rootHeight}px`;
            } else {
                overlay.style.left = `${soin.x1}px`;
                overlay.style.top = `${soin.y1}px`;
                overlay.style.width = `${soin.x2 - soin.x1}px`;
                overlay.style.height = `${soin.y2 - soin.y1}px`;
            }
        }
    }

    // Initialiser au chargement
    document.addEventListener('DOMContentLoaded', function() {
        initializeScripts();
        imageMapResize();
    });

    // Gestion du redimensionnement
    window.addEventListener('resize', function() {
        updateAllOverlays();
   
    
});
</script>
