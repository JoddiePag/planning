<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<nav class="navbar-vertical">
    <div class="top">
        <p class="lead fw-normal mb-0 title-top-sidebar">
            <span class="icon-circle">
                <i class="fas fa-tooth"></i>
            </span>
            <span class="title-top">Planinako</span> 
        </p>
    </div>

    <div class="centre">
        <ul class="sidebar-menu">
            <li>
            <a class="sidebar-link {{ request()->is('accueil') ? 'active' : '' }}"
               href="{{ url('/accueil') }}">
                <i class="fas fa-tachometer-alt icone"></i> Tableau de bord
            </a>
            </li>
            <li>
            <a class="sidebar-link {{ request()->is('ajout_patient') ? 'active' : '' }}"
               href="{{ url('/ajout_patient') }}">
                <i class="fas fa-plus-circle icone"></i> Nouveau patient
            </a>
            </li>
            <li>
               
                <a class="sidebar-link {{ request()->is('listes_patients') ? 'active' : '' }}"
               href="{{ url('/listes_patients') }}">
               <i class="fas fa-list icone"></i> Listes des patients
            </a>
            </li>
            <li>
               
                <a class="sidebar-link {{ request()->is('rendez_vous') ? 'active' : '' }}"
               href="{{ url('/rendez_vous') }}">
                <i class="fas fa-calendar-alt icone"></i> Rendez-vous
            </a>
            </li>
            <!-- <li>
                <a class="sidebar-link "
            
                 >
                    <i class="fas fa-history icone"></i> Historique
                </a>
            </li> -->
        </ul>
    </div>
</nav>