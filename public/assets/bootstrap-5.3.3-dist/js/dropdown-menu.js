// Gestion du menu déroulant
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