// Gestion des fonctionnalités de zoom
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
    const dentMap = document.querySelector('map[name="dentMap"]');
    if (dentMap) dentMap.style.pointerEvents = 'auto';
}