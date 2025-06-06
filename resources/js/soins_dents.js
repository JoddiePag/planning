document.addEventListener('DOMContentLoaded', function() {
    // Structure des traitements disponibles
    const treatmentsData = {
        "Extraction": ["Simple: 10000 Ar", "Chirurgicale: 20000 Ar"],
        "Soins dentaires": ["Canalaire: 20000 Ar", "OC: 40000 Ar", "Pulpotomie: 15000 Ar"],
        "ODF": ["Contention: 20000 Ar", "Appareil: 50000 Ar"],
        "Detartrage": ["Supragingival: 20000 Ar", "Sous-gingival: 30000 Ar"],
        "Prothèse": ["Couronne: 80000 Ar", "Bridge: 120000 Ar", "Prothèse amovible: 60000 Ar"],
        "Plombage": ["Composite: 25000 Ar", "Amalgame: 20000 Ar"]
    };

    // Éléments du DOM
    const modal = document.getElementById('dentModal');
    const selectedDentSpan = document.getElementById('dentNumber');
    const subOptionsDiv = document.getElementById('subOptions');
    const subOptionsList = document.getElementById('subOptionsList');
    const treatmentNameSpan = document.getElementById('treatmentName');
    const priceSection = document.querySelector('.price-section');
    const confirmBtn = document.getElementById('confirmTreatment');
    const treatmentsSummary = document.getElementById('treatmentsSummary');
    const totalAmountSpan = document.getElementById('totalAmount');
    const closeButtons = document.querySelectorAll('.close');

    // Variables d'état
    let currentDent = null;
    let selectedTreatment = null;
    let selectedSubOption = null;
    let confirmedTreatments = [];
    let totalAmount = 0;

    // Gestion des clics sur les dents
    document.querySelectorAll('area').forEach(area => {
        area.addEventListener('click', function(e) {
            e.preventDefault();
            currentDent = this.getAttribute('data-dent');
            selectedDentSpan.textContent = currentDent;
            modal.style.display = 'block';
            
            // Réinitialiser les sélections
            selectedTreatment = null;
            selectedSubOption = null;
            subOptionsDiv.style.display = 'none';
            priceSection.style.display = 'none';
            document.getElementById('price').value = '';
        });
    });

    // Gestion des boutons de traitement principal
    document.querySelectorAll('.treatment-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            selectedTreatment = this.getAttribute('data-treatment');
            treatmentNameSpan.textContent = selectedTreatment;
            
            // Afficher les sous-options si disponibles
            if (treatmentsData[selectedTreatment] && treatmentsData[selectedTreatment].length > 0) {
                subOptionsList.innerHTML = '';
                treatmentsData[selectedTreatment].forEach(option => {
                    const btn = document.createElement('button');
                    btn.className = 'btn btn-outline-primary sub-option-btn m-1';
                    btn.textContent = option;
                    btn.addEventListener('click', function() {
                        // Désélectionner les autres options
                        document.querySelectorAll('.sub-option-btn').forEach(b => {
                            b.classList.remove('active');
                        });
                        this.classList.add('active');
                        selectedSubOption = option;
                        priceSection.style.display = 'block';
                    });
                    subOptionsList.appendChild(btn);
                });
                subOptionsDiv.style.display = 'block';
            } else {
                subOptionsDiv.style.display = 'none';
                priceSection.style.display = 'block';
            }
        });
    });

    // Confirmation du traitement
    confirmBtn.addEventListener('click', function() {
        if (!currentDent || !selectedTreatment) return;
        
        const priceInput = document.getElementById('price');
        const price = priceInput.value || (selectedSubOption ? 
            selectedSubOption.match(/\d+/)[0] : 
            '0');
        
        const treatmentName = selectedSubOption ? 
            `${selectedTreatment} - ${selectedSubOption.split(':')[0]}` : 
            selectedTreatment;
        
        // Vérifier si la dent a déjà un traitement
        const existingIndex = confirmedTreatments.findIndex(t => t.dent === currentDent);
        
        if (existingIndex >= 0) {
            // Mettre à jour le traitement existant
            confirmedTreatments[existingIndex] = {
                dent: currentDent,
                treatment: treatmentName,
                price: parseInt(price)
            };
        } else {
            // Ajouter un nouveau traitement
            confirmedTreatments.push({
                dent: currentDent,
                treatment: treatmentName,
                price: parseInt(price)
            });
        }
        
        updateSummary();
        modal.style.display = 'none';
    });

    // Fermeture du modal
    closeButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    });

    // Mise à jour du récapitulatif
    function updateSummary() {
        treatmentsSummary.innerHTML = '';
        totalAmount = 0;
        
        if (confirmedTreatments.length === 0) {
            treatmentsSummary.innerHTML = '<p class="text-muted">Aucun soin sélectionné</p>';
        } else {
            confirmedTreatments.forEach(treatment => {
                const div = document.createElement('div');
                div.className = 'treatment-item';
                div.innerHTML = `
                    <div>
                        <strong>Dent ${treatment.dent}:</strong> ${treatment.treatment}
                    </div>
                    <div>
                        <span class="price">${treatment.price} Ar</span>
                        <button class="remove-btn" data-dent="${treatment.dent}" title="Supprimer">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                treatmentsSummary.appendChild(div);
                totalAmount += treatment.price;
            });
        }
        
        totalAmountSpan.textContent = totalAmount;
        
        // Ajout des écouteurs pour les boutons de suppression
        document.querySelectorAll('.remove-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const dent = this.getAttribute('data-dent');
                confirmedTreatments = confirmedTreatments.filter(t => t.dent !== dent);
                updateSummary();
            });
        });
    }

    // Fermer le modal si on clique en dehors
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Initialisation
    updateSummary();
});