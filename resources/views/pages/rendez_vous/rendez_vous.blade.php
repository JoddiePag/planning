@extends('layouts.app')

@section('content')
<link href="{{ asset('css/rendez_vous.css') }}" rel="stylesheet">
@push('styles')
<style>
   .fc-timegrid-slot.fc-timegrid-slot-label.fc-scrollgrid-shrink {
        position: relative;
        height: auto !important; /* MODIFICATION */
        min-height: 40px; /* MODIFICATION */
        white-space: normal !important; /* MODIFICATION */
    }
    
    .apres-midi-label {
        display: block; /* MODIFICATION */
        font-weight: bold;
        background: #f0f0f0;
        padding: 2px 5px;
        border-radius: 3px;
        margin-top: 5px; /* MODIFICATION */
    }

    .fc-timegrid-slot-label-frame {
        display: block; /* MODIFICATION */
    }
    /* Styles pour la légende */
    .legende-container {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin: 15px 0;
        /* padding: 5px; */
        /* background: #f8f9fa; */
        /* border-radius: 5px;
        border: 1px solid #eaeaea; */
    }
    
    .legende-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.9rem;
    }
    
    .legende-couleur {
        width: 20px;
        height: 20px;
        border-radius: 3px;
        display: inline-block;
    }
    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border-radius: 8px;
        width: 400px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .close {
        float: right;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
    }
    
    .btn-confirmer {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-right: 10px;
    }
    
    .btn-annuler {
        background-color: #f44336;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
</style>
@endpush

<div class="homes">
    <div class="body">
        @if($nouveauPatientId)
            <div class="alert alert-info">
                <strong>Création de rendez-vous</strong>
                <p>Sélectionnez un créneau horaire pour le patient : {{ $patient->nom }}</p>
            </div>
        @endif
        <div class="form_rdv">
            <h4>
                Planning des rendez‑vous
                @if($filtre === 'semaine')
                    ({{ $semaineDebut->format('d/m') }} → {{ $semaineFin->format('d/m') }})
                @elseif($filtre === 'mois' && $moisFiltre)
                    ({{ \Carbon\Carbon::createFromDate(null, $moisFiltre, 1)->locale('fr')->monthName }} {{ $anneeFiltre ?? now()->year }})
                @elseif($filtre === 'annee' && $anneeFiltre)
                    ({{ $anneeFiltre }})
                @endif
            </h4>

            <button id="openCreationModal" class="btn btn-success">
                Création de rendez‑vous
            </button>
        </div>

        @include('pages.rendez_vous.creation_rdv')

        <div class="rdv-filtres">
            @foreach(['semaine'=>'Cette semaine','passes'=>'Passés','futurs'=>'Futurs'] as $key => $label)
                <a href="{{ route('rendez_vous',['filtre'=>$key]) }}"
                   class="btn {{ $filtre === $key ? 'btn-primary' : 'btn-secondary' }}">
                    {{ $label }}
                </a>
            @endforeach
            <div class="legende-container">
            <div class="legende-item">
                <span class="legende-couleur" style="background-color: #4285f4;"></span>
                <span>Consultation</span>
            </div>
            <div class="legende-item">
                <span class="legende-couleur" style="background-color: #ea4335;"></span>
                <span>Extraction</span>
            </div>
            <div class="legende-item">
                <span class="legende-couleur" style="background-color: #fbbc05;"></span>
                <span>Détartrage</span>
            </div>
            <div class="legende-item">
                <span class="legende-couleur" style="background-color: #34a853;"></span>
                <span>Prothèse</span>
            </div>
             <div class="legende-item">
                <span class="legende-couleur" style="background-color: grey;"></span>
                <span>ODF</span>
            </div>
            <div class="legende-item">
                <span class="legende-couleur" style="background-color: #673ab7;"></span>
                <span>Autres soins</span>
            </div>
        </div>
            
        </div>
        
        <div class="planning-table">
            @if(in_array($filtre, ['passes', 'futurs']))
                <div class="filtre">
                    <form action="{{ route('rendez_vous') }}" method="GET" class="d-inline-block">
                        <select name="mois" class="form-control form-control-sm">
                            <option value="">-- Choisir le mois --</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $moisFiltre == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::createFromDate(null, $i, 1)->locale('fr')->monthName }}
                                </option>
                            @endfor
                        </select>
                        <input type="hidden" name="filtre" value="mois">
                        <button type="submit" class="btn btn-sm btn-outline-secondary">Filtrer par mois</button>
                    </form>

                    <form action="{{ route('rendez_vous') }}" method="GET" class="d-inline-block">
                        <select name="annee" class="form-control form-control-sm">
                            <option value="">-- Choisir l'année --</option>
                            @foreach(range(date('Y') - 5, date('Y') + 5) as $annee)
                                <option value="{{ $annee }}" {{ $anneeFiltre == $annee ? 'selected' : '' }}>
                                    {{ $annee }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="filtre" value="annee">
                        <button type="submit" class="btn btn-sm btn-outline-secondary">Filtrer par année</button>
                    </form>
                </div>
            @endif

            <div id="calendar" class="fc-calendar-container"></div>
        </div>
    </div>
</div>
<!-- Modale de confirmation de RDV -->
<div id="confirmationModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <h3>Confirmer le rendez-vous</h3>
        <div id="modalContent">
            <p><strong>Patient:</strong> <span id="patientNom"></span></p>
            <p><strong>Date:</strong> <span id="rdvDate"></span></p>
            <p><strong>Heure:</strong> <span id="rdvHeure"></span></p>
            <p><strong>Durée:</strong> <span id="rdvDuree"></span></p>
            
            <div class="modal-buttons">
                <button type="button" class="btn-confirmer" id="btnConfirmer">Confirmer</button>
                <button type="button" class="btn-annuler" id="btnAnnuler">Annuler</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        
        let initialView = 'timeGridWeek';
        let initialDate = null;
        const nouveauPatientId = {{ $nouveauPatientId ?? 'null' }};
        // Utilisation de 'prenom' au lieu de 'nom' pour le patient si c'est ce que vous voulez afficher dans la modale
        const patientNom = '{{ $patient->prenom ?? "" }}'; 
        let selectedSlot = null;

        @if($filtre === 'semaine')
            initialDate = '{{ $semaineDebut->format('Y-m-d') }}';
        @elseif($filtre === 'mois' && $moisFiltre)
            initialView = 'dayGridMonth';
            initialDate = '{{ $anneeFiltre }}-{{ $moisFiltre }}-01';
        @elseif($filtre === 'annee' && $anneeFiltre)
            initialView = 'dayGridMonth';
            initialDate = '{{ $anneeFiltre }}-01-01';
        @endif

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: initialView,
            initialDate: initialDate,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            locale: 'fr',
            firstDay: 1,
            allDaySlot: false,
            // C'est ici que nous construisons les événements avec le prénom seul
            events: [
                @foreach($rvFiltres as $rv)
                {
                    // Afficher uniquement le prénom comme titre
                    title: '{{ $rv["prenom"] }} ({{ $rv["soin"] }})', 
                    start: '{{ $rv["start"] }}',
                    end: '{{ $rv["end"] }}',
                    
                    extendedProps: {
                        patient_id: '{{ $rv["patient_id"] }}',
                        statut: '{{ $rv["statut"] }}',
                        soin: '{{ $rv["soin"] }}', // Garder le soin dans extendedProps si besoin pour d'autres usages
                        original_rv_id: '{{ $rv["original_rv_id"] }}'
                    },
                    classNames: [
                        // Supprimez la ligne suivante si vous ne voulez plus de la classe basée sur le soin
                        // '{{ Str::slug($rv["soin"]) }}', 
                         'soin-{{ Str::slug($rv["soin"]) }}',
                        '{{ $rv["statut"] === "Manqué" ? "blink-manque" : "" }}',
                        '{{ $rv["statut"] === "Fini" ? "fini-event" : "" }}'
                    ]
                },
                @endforeach
            ],
            
            // Le eventContent est déjà bon pour afficher le titre (qui est maintenant le prénom)
            eventContent: function(arg) {
                return {
                    html: `<div class="fc-event-content">
                                <div class="nom">${arg.event.title}</div>
                            </div>`
                };
            },
            eventClick: function(info) {
                window.location.href = '/modification_patient/' + info.event.extendedProps.patient_id;
            },
            slotMinTime: "06:00:00",
            slotMaxTime: "21:30:00",
            slotDuration: "00:30:00",
            slotLabelInterval: "00:30:00",
            slotLabelFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false,
                omitZeroMinute: false
            },
            slotLabelDidMount: function(arg) {
                const time = arg.date;
                const hours = time.getHours();
                const minutes = time.getMinutes();
                
                if (hours === 12 && minutes === 30) {
                    const label = document.createElement('div');
                    label.className = 'apres-midi-label';
                    label.textContent = 'Après-midi';
                    arg.el.appendChild(label);
                }
            },
            selectable: true,
            select: function(selectionInfo) {
                if (nouveauPatientId) {
                    selectedSlot = selectionInfo;
                    
                    const dateStr = selectionInfo.start.toLocaleDateString('fr-FR', {
                        weekday: 'long', 
                        day: 'numeric', 
                        month: 'numeric', 
                        year: 'numeric'
                    });
                    
                    const heureDebut = selectionInfo.start.toLocaleTimeString('fr-FR', 
                                        {hour: '2-digit', minute:'2-digit'});
                    const heureFin = selectionInfo.end.toLocaleTimeString('fr-FR', 
                                        {hour: '2-digit', minute:'2-digit'});

                    document.getElementById('patientNom').textContent = patientNom;
                    document.getElementById('rdvDate').textContent = dateStr;
                    document.getElementById('rdvHeure').textContent = heureDebut + ' - ' + heureFin;
                    
                    const durationMs = selectionInfo.end - selectionInfo.start;
                    const durationMinutes = Math.floor(durationMs / (1000 * 60));
                    document.getElementById('rdvDuree').textContent = durationMinutes + ' minutes';
                    
                    document.getElementById('confirmationModal').style.display = 'block';
                }
            },
            dateClick: function(info) {
                if (nouveauPatientId) {
                    const start = info.date;
                    const end = new Date(start);
                    end.setMinutes(end.getMinutes() + 30);

                    selectedSlot = {
                        start: start,
                        end: end
                    };

                    const dateStr = start.toLocaleDateString('fr-FR', {
                        weekday: 'long', 
                        day: 'numeric', 
                        month: 'numeric', 
                        year: 'numeric'
                    });
                    
                    const heureDebut = start.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
                    const heureFin = end.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });

                    document.getElementById('patientNom').textContent = patientNom;
                    document.getElementById('rdvDate').textContent = dateStr;
                    document.getElementById('rdvHeure').textContent = heureDebut + ' - ' + heureFin;
                    document.getElementById('rdvDuree').textContent = '30 minutes';

                    document.getElementById('confirmationModal').style.display = 'block';
                }
            },
            views: {
                timeGridWeek: {
                    slotDuration: '00:30:00',
                    slotLabelInterval: '00:30:00',
                    slotLabelFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    },
                    allDaySlot: false
                },
                timeGridDay: {
                    slotDuration: '00:30:00',
                    slotLabelInterval: '00:30:00',
                    slotLabelFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    },
                    allDaySlot: false
                },
                dayGridMonth: {
                    dayMaxEvents: 3
                }
            }
        });

        // Supprimez cette ligne en double qui réinitialise le calendrier
        // var calendar = new FullCalendar.Calendar(calendarEl, { ... }); 
        calendar.render();

        // Le reste de votre script de gestion des modales est correct

        const openBtn = document.getElementById('openCreationModal');
        const modal = document.getElementById('creationRdvModal');
        const closeBtn = document.getElementById('closeCreationModal');

        if(openBtn && modal && closeBtn) {
            openBtn.addEventListener('click', function(e){
                e.preventDefault();
                modal.style.display = 'flex';
            });
            closeBtn.addEventListener('click', function(){
                modal.style.display = 'none';
            });
            modal.addEventListener('click', function(e){
                if(e.target === modal) modal.style.display = 'none';
            });
        }

        @if (session('success') || session('error'))
            modal.style.display = 'flex';
        @endif

        const confirmationModal = document.getElementById('confirmationModal');
        const closeConfirmationModal = document.getElementById('closeModal');
        const btnAnnuler = document.getElementById('btnAnnuler');
        
        function fermerModal() {
            confirmationModal.style.display = 'none';
        }
        
        closeConfirmationModal.addEventListener('click', fermerModal);
        btnAnnuler.addEventListener('click', fermerModal);
        
        window.addEventListener('click', function(event) {
            if (event.target === confirmationModal) {
                fermerModal();
            }
        });
        
        document.getElementById('btnConfirmer').addEventListener('click', function() {
            if (selectedSlot && nouveauPatientId) {
                const formatDateForServer = (date) => {
                    return date.getFullYear() + '-' +
                        String(date.getMonth() + 1).padStart(2, '0') + '-' +
                        String(date.getDate()).padStart(2, '0') + ' ' +
                        String(date.getHours()).padStart(2, '0') + ':' +
                        String(date.getMinutes()).padStart(2, '0') + ':' +
                        String(date.getSeconds()).padStart(2, '0');
                };

                fetch('{{ route("store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        patient_id: nouveauPatientId,
                        date_heure_rdv: formatDateForServer(selectedSlot.start),
                        heure_fin: formatDateForServer(selectedSlot.end)
                    })
                })
                .then(response => {
                    if (response.ok) {
                        window.location.href = '{{ route("rendez_vous") }}?nouveau_patient=1';
                    } 
                    else if (response.status === 409) {
                        return response.json().then(data => {
                            alert('Erreur: ' + data.message);
                        });
                    }
                    else {
                        throw new Error('Erreur serveur');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue');
                })
                .finally(() => {
                    fermerModal(); 
                });
            }
        });
    });
</script>
@endpush
@endpush