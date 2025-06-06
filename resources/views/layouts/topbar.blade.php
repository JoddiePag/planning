<nav class="navbartop">
    <div class="navWrappers">
        <div class="lefts">
            <div class="MenuTopbar">
                <div class="IconeMenu">
                    <button class="BouttonMenu">
                        <i class="fas fa-bars menu-icon"></i>
                    </button>

                    <button class="BouttonMenu_Mobile">
                        <i class="fas fa-bars menu-icon"></i>
                    </button>
                </div>
            </div>
            <div class="NomduService">
                <span>Cabinet Dentaire</span>
            </div>
        </div>

        <div class="right">
            <div class="topbar-icon">
                <span class="notif-icon">
                    <i class="fas fa-bell"></i>
                </span>
            <div class="notification-count" style="display: none;"></div>
        </div>

            <div class="topbar-icon">
                <span class="settings-icon">
                    
                <a href="/parametre" >
                <i class="fas fa-cog" style="color: black;"></i>
                </a>

                </span>
            </div>

            <!-- <div class="profil-photo" style="position: relative;">
                <img src="https://i.pravatar.cc/40?img=3" alt="Profil" class="profil-img">
            </div> -->

            <div class="profil-photo" style="position: relative;">
  <img src="{{ session('dentiste_avatar') ?? asset('images/default-avatar.jpg') }}"
       alt="Profil"
       id="profileAvatar"
       style="cursor: pointer;">

  <!-- Dropdown caché par défaut -->
  <div id="profileDropdown" class="dropDownProfile" style="display: none; position: absolute; right: 0; top: 100%;">
    <ul class="dropdo-menu">
    <li>
        <i class="username-Mobile  dropdown-link">Dr. John</i> 
       
    </li>
      <li>
        <a href="/profil" class="dropdown-link"><i class="fas fa-user icone"></i> Profil</a>
       
    </li>
      <li><a href="{{ route('logout') }}" class="dropdown-link"><i class="fas fa-sign-out-alt icone"></i> Déconnexion</a></li>
    </ul>
  </div>
</div>

<p class="username">Dr. {{ session('dentiste_prenom') }}</p>

        </div>
    </div>
</nav>
<script>
document.addEventListener("DOMContentLoaded", function () {
    fetch('/rdv-restants')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const notifCount = document.querySelector('.notification-count');
            
            // Masquer complètement si 0 notification
            if (data.total_restant > 0) {
                notifCount.textContent = data.total_restant;
                notifCount.style.display = "flex"; // ou "block" selon votre besoin
            } else {
                notifCount.style.display = "none";
                notifCount.textContent = ""; // Vide le contenu au cas où
            }
        })
        .catch(error => {
            console.error("Erreur lors du chargement des RDV restants :", error);
            // Cache le badge en cas d'erreur
            document.querySelector('.notification-count').style.display = "none";
        });
});
</script>
