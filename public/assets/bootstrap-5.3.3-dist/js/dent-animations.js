// Gestion des animations et marquages des dents
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
    overlay.style.transformOrigin = '0 0';

    const imageContainer = document.querySelector('#contenu-examination .image-container');
    if (imageContainer) {
        imageContainer.appendChild(overlay);
    }
    
    area.style.pointerEvents = 'none';

    overlay.addEventListener('click', function(e) {
        e.stopPropagation();
        const indexToRemove = soinsList.findIndex(item =>
            item.dent === toothNumber && item.traitement === "Absente" && item.type_dent === activeDentType
        );

        if (indexToRemove !== -1) {
            soinsList.splice(indexToRemove, 1);
            saveTreatmentsToLocalStorage();
            updateTreatmentsTable();

            const areaToReactivate = document.querySelector(`#contenu-examination area[data-dent="${toothNumber}"]`);
            if (areaToReactivate) areaToReactivate.style.pointerEvents = 'auto';
            overlay.remove();
        }
        document.getElementById('dropdownMenu').style.display = 'none';
        resetZoom();
    });

    updateAbsentOverlayPosition(toothNumber);
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

function updateAllAbsentOverlays() {
    document.querySelectorAll(`.absent-overlay[data-type-dent="${activeDentType}"]`).forEach(overlay => {
        updateAbsentOverlayPosition(overlay.dataset.dent);
    });
}

function restoreMissingTeeth() {
    document.querySelectorAll('.absent-overlay').forEach(el => el.remove());

    soinsList.forEach(soin => {
        if (soin.traitement === "Absente" && soin.type_dent === activeDentType) {
            markToothAsMissing(soin.dent);
        }
    });
}