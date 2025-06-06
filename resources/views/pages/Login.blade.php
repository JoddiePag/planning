<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Planinako</title>

  <!-- Bootstrap CSS (CDN ou local) -->
  <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet"
  >

  <!-- Font Awesome -->
  <link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
  >

  <!-- Styles de l’application -->
  <link href="{{ asset('css/login.css') }}" rel="stylesheet">

  <!-- Styles spécifiques à la page (ex: login.css) -->
  @stack('styles')
</head>
<body class="antialiased">

 

  <main class="main-content">
  <section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
          class="img-fluid" alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
      <form method="POST" action="{{ url('/dentiste_connection') }}">
  @csrf

  <div class="d-flex justify-content-center align-items-center full-height">
    <p class="lead fw-normal mb-0 me-3 planinako-title">Planinako</p>
  </div>

  <!-- Email input -->
  <div class="form-outline mb-4">
    <input type="email" name="email" id="form3Example3" class="form-control form-control-lg"
      placeholder="Entrer votre adresse email" value="{{ old('email') }}" required />
    <label class="form-label" for="form3Example3">Adresse email</label>
  </div>

  <!-- Password input -->
  <div class="form-outline mb-3">
    <input type="password" name="motdepasse" id="form3Example4" class="form-control form-control-lg"
      placeholder="Entrer votre mot de passe" required />
    <label class="form-label" for="form3Example4">Mot de passe</label>
  </div>

  @if ($errors->any())
    <div class="alert alert-danger">
      @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
      @endforeach
    </div>
  @endif

  <div class="d-flex justify-content-between align-items-center">
     <!-- Checkbox -->
    
    <a href="#!" class="text-body">Mot de passe oublié?</a>
  </div>

  <div class="text-center text-lg-start mt-4 pt-2">
    <button type="submit" class="btn btn-primary btn-lg form-control form-control-lg btnLogin"
      style="padding-left: 2.5rem; padding-right: 2.5rem;">Se connecter</button>

    <p class="small fw-bold mt-2 pt-1 mb-0">
      Avez-vous un compte ? 
      <a class="link-danger {{ request()->is('creation_compte') ? 'active' : '' }}" href="{{ url('/creation_compte') }}">
        Créer un compte
      </a>
    </p>
  </div>

</form>

      </div>
    </div>
  </div>
 

</section>
  </main>

  <!-- Bootstrap Bundle JS (CDN ou local) -->
  <script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    defer
  ></script>

  <!-- Votre JS global -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Scripts spécifiques à la page -->
  @stack('scripts')
</body>
</html>
