<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/logosans.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('img/logosans.png') }}">
  <title>{{ $custom_settings['app_name'] }} - Accueil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f9f9f9;
    }

    .navbar {
      background-color: #ffffff;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .navbar-brand {
      color: #0070BB;
      font-weight: bold;
    }

    .nav-link {
      color: #0070BB;
      font-weight: 500;
    }

    .hero {
      background: linear-gradient(135deg, #0070BB, #008DD5);
      color: white;
      padding: 100px 0;
      text-align: center;
    }

    .hero h1 {
      font-weight: bold;
    }

    .btn-main {
      background-color: #ffffff;
      color: #0070BB;
      font-weight: bold;
      border-radius: 50px;
      padding: 10px 25px;
      transition: 0.3s;
    }

    .btn-main:hover {
      background-color: #def2f1;
      color: #0070BB;
    }

    .feature-card {
      background-color: white;
      border-radius: 20px;
      padding: 30px 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
      transition: transform 0.3s ease-in-out;
    }

    .feature-card:hover {
      transform: translateY(-10px);
    }

    .icon-style {
      font-size: 40px;
      color: #0070BB;
      margin-bottom: 15px;
    }

    .contact-section {
      background-color: #def2f1;
      padding: 60px 0;
    }

    .footer {
      background-color: #0070BB;
      color: white;
      padding: 30px 0;
    }

    .footer a {
      color: #ffffff;
      margin: 0 10px;
      text-decoration: none;
    }

    .footer a:hover {
      text-decoration: underline;
    }

  </style>
</head>
<body>

<!--  Navbar -->
<nav class="navbar navbar-expand-lg px-5">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="{{ asset('img/logosans.png') }}" alt="Logo" width="45" height="45" class="d-inline-block align-text-top me-2 rounded-circle">
      {{ $custom_settings['app_name'] }}
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Inscription</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Connexion</a></li>
      </ul>
    </div>
  </nav>
  


<section class="hero">
  <div class="container">
    <h1 class="display-4" data-aos="fade-down">Optimisez votre gestion de flotte avec {{ $custom_settings['app_name'] }}</h1>
    <p class="lead mt-3 mb-4" data-aos="fade-up" data-aos-delay="200">
        Check-list quotidienne, maintenance, consommation, tout est centralisé et facile à gérer.
    </p>
    <a href="{{ route('register') }}" class="btn btn-main btn-lg" data-aos="zoom-in" data-aos-delay="400">Commencer</a>
  </div>
</section>


<section class="py-5" id="features">
  <div class="container text-center">
    <h2 class="mb-5" data-aos="fade-up">Fonctionnalités principales</h2>
    <div class="row g-4">
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
        <div class="feature-card">
          <div class="icon-style"><i class="bi bi-clipboard-check-fill"></i></div>
          <h5>Check-list quotidienne</h5>
          <p> Vérifiez les points essentiels avant chaque utilisation du véhicule</p>
        </div>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
        <div class="feature-card">
          <div class="icon-style"><i class="bi bi-tools"></i></div>
          <h5>Maintenance</h5>
          <p>Planifiez et gérez facilement l’entretien de votre flotte.</p>
        </div>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
        <div class="feature-card">
          <div class="icon-style"><i class="bi bi-fuel-pump-fill"></i></div>
          <h5>Carburant</h5>
          <p>Analysez les consommations pour mieux contrôler vos coûts.</p>
        </div>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
        <div class="feature-card">
          <div class="icon-style"><i class="bi bi-bar-chart-fill"></i></div>
          <h5>Rapports</h5>
          <p>Obtenez des statistiques précises sur l’utilisation de votre flotte.</p>
        </div>
      </div>
    </div>
  </div>
</section>




<footer class="footer text-center">
  <div class="container">
    <p class="mb-2"><i class="fas fa-envelope" style="font-size: 1rem;"></i>  support @ {{ $custom_settings['app_name'] }}.com | <i class="fas fa-phone-alt" style="font-size: 1rem;"></i>  +212 600-000000</p>
    <div>
      <a href="#">Politique de confidentialité</a> |
      <a href="#">Conditions d'utilisation</a> |
      <a href="#">Support</a>
    </div>
  </div>
</footer>

<!--  Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init();
</script>

</body>
</html>




