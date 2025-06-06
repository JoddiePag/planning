<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Planinako</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="{{ asset('assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="{{ asset('css/media_query.css') }}" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <link href="{{ asset('css/blink.css') }}" rel="stylesheet"> 



    @stack('styles')
</head>

<body class="antialiased">
    <!-- Inclusion de la topbar -->
    @include('layouts.topbar')
    
    <!-- Inclusion de la sidebar -->
    @include('layouts.sidebar')
    <div class="overlay hidden"></div>

    <!-- Contenu principal -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Avatar dropdown -->
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const avatar   = document.getElementById('profileAvatar');
            const dropdown = document.getElementById('profileDropdown');

            avatar.addEventListener('click', function(e){
                e.stopPropagation();
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            });

            document.addEventListener('click', function(){
                dropdown.style.display = 'none';
            });

            dropdown.addEventListener('click', function(e){
                e.stopPropagation();
            });
        });
    </script>

    <!-- Bouton Menu Grand Écran -->
    <script>
        document.querySelector('.BouttonMenu')?.addEventListener('click', function() {
            const sidebar = document.querySelector('.navbar-vertical');
            const topbar = document.querySelector('.navbartop');
            const content = document.querySelector('.main-content');

            sidebar.classList.toggle('hidden');
            topbar.classList.toggle('full-width');
            content.classList.toggle('full-width');
        });
    </script>

    <!-- Bouton Menu Mobile -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const menuButton = document.querySelector('.BouttonMenu_Mobile');
            const sidebar = document.querySelector('.navbar-vertical');
            const overlay = document.querySelector('.overlay');

            menuButton?.addEventListener('click', function () {
                sidebar.classList.remove('hidden'); // CORRECTION ICI
                sidebar.classList.toggle('active');
                overlay.classList.toggle('visible');
            });

            overlay?.addEventListener('click', function () {
                sidebar.classList.remove('active');
                overlay.classList.remove('visible');
            });
        });
    </script>
    
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/fr.min.js'></script>
    @stack('scripts')
    
</body>
</html>
