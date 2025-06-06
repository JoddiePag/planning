@extends('layouts.app')

@section('content')
<link href="{{ asset('css/accueil.css') }}" rel="stylesheet">

<!-- <div class=""> -->
    

    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active position-relative">
                <img src="{{ asset('images/sary.jpg') }}" class="d-block w-100" alt="Dentition humaine">
                <div class="banner-overlay"></div>
                <div class="carousel-caption d-none d-md-block">
                    <h5>Bienvenue au Cabinet Dentaire</h5>
                    <p>Votre santé bucco-dentaire est notre priorité.</p>
                </div>
            </div>
            <div class="carousel-item position-relative">
                <img src="{{ asset('images/images.jpg') }}" class="d-block w-100" alt="Dentition humaine">
                <div class="banner-overlay"></div>
                <div class="carousel-caption d-none d-md-block">
                    <h5 >Technologies Modernes</h5>
                    <p>Équipements de dernière génération pour vos soins.</p>
                </div>
            </div>
            <div class="carousel-item position-relative">
                <img src="{{ asset('images/equipe.jpg') }}" class="d-block w-100" alt="Dentition humaine">
                <div class="banner-overlay"></div>
                <div class="carousel-caption d-none d-md-block">
                    <h5>Équipe Professionnelle</h5>
                    <p>Des dentistes expérimentés à votre service.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="form-containerDashboard">
  <div class="dashboard-container">
    <div class="dashboard-header">
      <h1>Tableau de Bord Dentaire</h1>
    </div>

    <div class="stats-cards">
  <div class="stat-card">
    <i class="fas fa-user-injured iconeDashboard"></i>
    <div class="stat-info">
      <div class="stat-number"> {{ number_format($totalPatients ?? 0) }}</div>

      <p>Patients</p>
    </div>
  </div>

  <div class="stat-card">
    <i class="fas fa-calendar-alt iconeDashboard"></i>
    <div class="stat-info">
      <div class="stat-number">{{ $totalRdvAujourdhui }}</div>
      <p>Rendez-vous</p>
    </div>
  </div>

  <div class="stat-card">
    <i class="fas fa-tooth iconeDashboard"></i>
    <div class="stat-info">
      <div class="stat-number">{{ $totalConsultationsAujourdhui }}</div>
      <p>Consultations</p>
    </div>
  </div>

  <!-- <div class="stat-card">
    <i class="fas fa-file-prescription iconeDashboard"></i>
    <div class="stat-info">
      <div class="stat-number">8</div>
      <p>Ordonnances</p>
    </div>
  </div> -->
</div>


    <div class="dashboard-content">
      <div class="dashboard-column">
        <div class="dashboard-section">
          <h3>Consultations par mois</h3>
          <ul class="month-list">
            @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'] as $month)
              <li>{{ $month }}</li>
            @endforeach
          </ul>
        </div>
      </div>

      <div class="dashboard-column">
        <div class="dashboard-section">
          <h3>Mises à jour récentes</h3>
          <div class="updates-list">
            <div class="update-item">
              <p>Nouveaux patients ajoutés aujourd'hui</p>
              <span class="update-time">Nombres : {{ $nouveauxPatientsAujourdhui }}</span>
            </div>
            <div class="update-item">
              <p>Rendez-vous à tenir demain</p>
              <span class="update-time">Nombres : {{ $totalRdvDemain }}</span>
            </div>
            <!-- <div class="update-item">
              <p>Ordonnance à renouveler</p>
              <span class="update-time">Il y a 1 jour</span>
            </div> -->
          </div>
        </div>
      </div>

      <div class="dashboard-column">
        <div class="dashboard-section">
          <h3>Répartition des soins dentaires</h3>
          <div class="quick-actions">
            <!-- <button class="action-btn"><i class="fas fa-bolt icon-btn"></i> Actions rapides</button> -->
            <button class="action-btn">
            <a href="{{ url('/ajout_patient') }}" >
                <i class="fas fa-user-plus icon-btn"></i> Nouveau patient
            </a>
            </button>
            <button class="action-btn">
            <a href="{{ url('/rendez_vous') }}" >
              <i class="fas fa-calendar-alt icon-btn"></i> Prendre un rendez-vous
            </a>
          </button>
            <button class="action-btn">
            <a href="{{ url('/listes_patients') }}" >

              <i class="fas fa-search icon-btn"></i> Rechercher
            </a>
            </button>
            <!-- <button class="action-btn"><i class="fas fa-file-prescription icon-btn"></i> Voir les ordonnances</button> -->
          </div>
        </div>
      </div>
    </div>
  </div>    
<!-- </div> -->

    
@endsection

@section('scripts')
<script>
    console.log('Page home chargée');
</script>
@endsection
