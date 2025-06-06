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

          {{-- Illustration --}}
          <div class="col-md-9 col-lg-6 col-xl-5">
            <img
              src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
              class="img-fluid"
              alt="Illustration inscription"
            />
          </div>

          {{-- Formulaire d’inscription --}}
          <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <form method="POST" action="{{url('/savedentiste')}}">
              @csrf

              {{-- Titre --}}
              <div class="d-flex justify-content-center align-items-center mb-2">
                <p class="lead fw-normal mb-0 me-3 planinako-title">Planinako</p>
              </div>

              {{-- Ligne Nom + Prénom --}}
              <div class="row">
                <div class="col-md-6 mb-2">
                  <div class="form-outline">
                    <input
                      type="text"
                      name="nom"
                      id="nom"
                      class="form-control form-control-lg @error('nom') is-invalid @enderror"
                      placeholder="Nom"
                      value="{{ old('nom') }}"
                      required
                    />
                    <label class="form-label" for="nom">Nom</label>
                    @error('nom')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-6 mb-2">
                  <div class="form-outline">
                    <input
                      type="text"
                      name="prenom"
                      id="prenom"
                      class="form-control form-control-lg @error('prenom') is-invalid @enderror"
                      placeholder="Prénom"
                      value="{{ old('prenom') }}"
                      required
                    />
                    <label class="form-label" for="prenom">Prénom</label>
                    @error('prenom')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>

              {{-- Email --}}
              <div class="form-outline mb-2">
                <input
                  type="email"
                  name="email"
                  id="email"
                  class="form-control form-control-lg @error('email') is-invalid @enderror"
                  placeholder="Adresse email"
                  value="{{ old('email') }}"
                  required
                />
                <label class="form-label" for="email">Adresse email</label>
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-outline mb-2">
                <!-- <label for="numero">Numéro de téléphone</label> -->
                <!-- <input type="text" name="numero" id="numero" class="form-control" value="{{ old('numero') }}"> -->
                <input type="hidden" name="numero" value="0000000000">

            </div>
            <div class="form-outline mb-2">
                <!-- <label for="numero">Numéro de téléphone</label> -->
                <!-- <input type="text" name="numero" id="numero" class="form-control" value="{{ old('numero') }}"> -->
                <input type="hidden" name="qualifications" value="Qualifications">

            </div>
            <div class="form-outline mb-2">
                <!-- <label for="numero">Numéro de téléphone</label> -->
                <!-- <input type="text" name="numero" id="numero" class="form-control" value="{{ old('numero') }}"> -->
                <input type="hidden" name="adresse" value="adresse">

            </div>


              {{-- Mot de passe --}}
              <div class="form-outline mb-2">
                <input
                  type="password"
                  name="motdepasse"
                  id="motdepasse"
                  class="form-control form-control-lg @error('motdepasse') is-invalid @enderror"
                  placeholder="Mot de passe"
                  required
                />
                <label class="form-label" for="motdepasse">Mot de passe</label>
                @error('motdepasse')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Confirmation du mot de passe --}}
              <div class="form-outline mb-2">
                <input
                  type="password"
                  name="motdepasse_confirmation"
                  id="motdepasse_confirmation"
                  class="form-control form-control-lg"
                  placeholder="Confirmez mot de passe"
                  required
                />
                <label class="form-label" for="motdepasse_confirmation">Confirmez mot de passe</label>
              </div>
              @error('motdepasse_confirmation')
<div class="invalid-feedback">{{ $message }}</div>
@enderror


              {{-- Sélection du rôle --}}
              <!-- <div class="form-outline mb-2">
                <select
                  name="role"
                  id="role"
                  class="form-select form-select-lg @error('role') is-invalid @enderror"
                  required
                >
                  <option value="" disabled selected>Choisir un rôle</option>
                  <option value="administrateur" {{ old('role')=='administrateur' ? 'selected':'' }}>
                    Administrateur
                  </option>
                  <option value="utilisateur" {{ old('role')=='utilisateur' ? 'selected':'' }}>
                    Utilisateur
                  </option>
                </select>
                <label class="form-label" for="role">Rôle</label>
                @error('role')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div> -->

              {{-- Bouton --}}
              <div class="text-center text-lg-start ">
                <button
                  type="submit"
                  class="btn btn-primary btn-lg form-control form-control-lg"
                  style="padding-left: 2.5rem; padding-right: 2.5rem;"
                >
                  Créer un compte
                </button>
                <p class="small fw-bold mt-2 pt-1 mb-0">
                  Vous avez déjà un compte ?
                  <a href="{{ route('login') }}" class="link-danger">Connectez‑vous</a>
                </p>
              </div>

            </form>
            @if (Session::has('message'))
            <div class="alert alert-success">
              {{Session::get('message')}}
              {{Session::put('message',null)}}

            </div>
            @endif
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
