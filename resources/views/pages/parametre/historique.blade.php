@extends('layouts.app')

@section('content')

<div class="homes">
  <div class="body">
  <div class="container-fluid">
  <div class="">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-history me-2"></i> Historique</h2>
            <div class="d-flex">
                <div class="search-box me-3">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control search-input" placeholder="Rechercher...">
                </div>
                <button class="btn btn-primary">
                    <i class="fas fa-filter me-1"></i> Filtres
                </button>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">142</div>
                    <div class="stat-label">RDV ce mois</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">8</div>
                    <div class="stat-label">Annulations</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">92%</div>
                    <div class="stat-label">Taux de présence</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">5.6k €</div>
                    <div class="stat-label">Chiffre d'affaires</div>
                </div>
            </div>
        </div>
        
        <!-- Main Tabs -->
        <ul class="nav nav-tabs" id="historyTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="rdv-tab" data-bs-toggle="tab" data-bs-target="#rdv" type="button" role="tab">
                    Rendez-vous
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled" type="button" role="tab">
                    Annulations
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="financial-tab" data-bs-toggle="tab" data-bs-target="#financial" type="button" role="tab">
                    Financier
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="medical-tab" data-bs-toggle="tab" data-bs-target="#medical" type="button" role="tab">
                    Dossiers Médicaux
                </button>
            </li>
        </ul>
        
        <div class="tab-content p-3 border border-top-0 rounded-bottom bg-white" id="historyTabsContent">
            <!-- RDV Tab -->
            <div class="tab-pane fade show active" id="rdv" role="tabpanel">
                <div class="d-flex justify-content-between mb-3">
                    <h5>Historique des rendez-vous</h5>
                    <button class="export-btn">
                        <i class="fas fa-file-export me-1"></i> Exporter
                    </button>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date/Heure</th>
                                <th>Patient</th>
                                <th>Soin</th>
                                <th>Durée</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>15/06/2023 09:30</td>
                                <td>
                                    <img src="https://randomuser.me/api/portraits/women/44.jpg" class="patient-img me-2">
                                    Sophie Martin
                                </td>
                                <td>Détartrage</td>
                                <td>30 min</td>
                                <td><span class="badge badge-success">Honoré</span></td>
                                <td>
                                    <button class="action-btn" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>14/06/2023 14:00</td>
                                <td>
                                    <img src="https://randomuser.me/api/portraits/men/32.jpg" class="patient-img me-2">
                                    Jean Dupont
                                </td>
                                <td>Consultation</td>
                                <td>15 min</td>
                                <td><span class="badge badge-success">Honoré</span></td>
                                <td>
                                    <button class="action-btn" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>14/06/2023 10:30</td>
                                <td>
                                    <img src="https://randomuser.me/api/portraits/women/68.jpg" class="patient-img me-2">
                                    Marie Leroy
                                </td>
                                <td>Blanchiment</td>
                                <td>1h</td>
                                <td><span class="badge badge-danger">Annulé</span></td>
                                <td>
                                    <button class="action-btn" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>13/06/2023 16:15</td>
                                <td>
                                    <img src="https://randomuser.me/api/portraits/men/75.jpg" class="patient-img me-2">
                                    Thomas Bernard
                                </td>
                                <td>Couronne</td>
                                <td>45 min</td>
                                <td><span class="badge badge-success">Honoré</span></td>
                                <td>
                                    <button class="action-btn" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>12/06/2023 11:00</td>
                                <td>
                                    <img src="https://randomuser.me/api/portraits/women/63.jpg" class="patient-img me-2">
                                    Laura Petit
                                </td>
                                <td>Extraction</td>
                                <td>30 min</td>
                                <td><span class="badge badge-warning">Reporté</span></td>
                                <td>
                                    <button class="action-btn" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Précédent</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Suivant</a>
                        </li>
                    </ul>
                </nav>
            </div>
            
            <!-- Annulations Tab -->
            <div class="tab-pane fade" id="cancelled" role="tabpanel">
                <h5 class="mb-3">Historique des annulations</h5>
                
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>Marie Leroy</strong> - Blanchiment
                                <p class="text-muted mb-0">14/06/2023 10:30</p>
                            </div>
                            <span class="badge bg-danger">Annulé</span>
                        </div>
                        <p class="mt-2 mb-0"><small>Motif : Empechement personnel</small></p>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>Paul Durand</strong> - Détartrage
                                <p class="text-muted mb-0">10/06/2023 15:45</p>
                            </div>
                            <span class="badge bg-danger">Annulé</span>
                        </div>
                        <p class="mt-2 mb-0"><small>Motif : Non spécifié</small></p>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>Sophie Martin</strong> - Consultation
                                <p class="text-muted mb-0">05/06/2023 09:00</p>
                            </div>
                            <span class="badge bg-danger">Annulé</span>
                        </div>
                        <p class="mt-2 mb-0"><small>Motif : Maladie</small></p>
                    </div>
                </div>
            </div>
            
            <!-- Financier Tab -->
            <div class="tab-pane fade" id="financial" role="tabpanel">
                <h5 class="mb-3">Historique financier</h5>
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Patient</th>
                                        <th>Montant</th>
                                        <th>Méthode</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>15/06/2023</td>
                                        <td>Sophie Martin</td>
                                        <td>85,00 €</td>
                                        <td>Carte</td>
                                        <td><span class="badge bg-success">Payé</span></td>
                                    </tr>
                                    <tr>
                                        <td>14/06/2023</td>
                                        <td>Jean Dupont</td>
                                        <td>45,00 €</td>
                                        <td>Espèces</td>
                                        <td><span class="badge bg-success">Payé</span></td>
                                    </tr>
                                    <tr>
                                        <td>13/06/2023</td>
                                        <td>Thomas Bernard</td>
                                        <td>250,00 €</td>
                                        <td>Chèque</td>
                                        <td><span class="badge bg-warning">En attente</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                Statistiques financières
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6>CA ce mois</h6>
                                    <h4>5 642,50 €</h4>
                                </div>
                                <div class="mb-3">
                                    <h6>Moyenne par RDV</h6>
                                    <h4>78,80 €</h4>
                                </div>
                                <div>
                                    <h6>Impayés</h6>
                                    <h4>1 250,00 €</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Dossiers Médicaux Tab -->
            <div class="tab-pane fade" id="medical" role="tabpanel">
                <h5 class="mb-3">Dossiers médicaux</h5>
                
                <div class="accordion" id="medicalAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                Sophie Martin
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                            <div class="accordion-body">
                                <div class="mb-3">
                                    <h6>Dernière visite : 15/06/2023</h6>
                                    <p>Détartrage complet - Aucune carie détectée</p>
                                </div>
                                <div class="mb-3">
                                    <h6>Allergies :</h6>
                                    <p>Pas d'allergie connue</p>
                                </div>
                                <div>
                                    <h6>Traitements en cours :</h6>
                                    <p>Aucun</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                Jean Dupont
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo">
                            <div class="accordion-body">
                                <!-- Contenu du dossier -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
  </div>
  </div>
@endsection
