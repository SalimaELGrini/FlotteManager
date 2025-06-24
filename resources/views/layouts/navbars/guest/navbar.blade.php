<div class="container position-sticky z-index-sticky top-0">
    <div class="row">
        <div class="col-12">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-absolute mt-3 py-2 start-0 end-0 mx-4" style="background-color: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="container-fluid">
                    <!-- Logo / App Name -->
                    <ul class="navbar-nav d-lg-block d-none">
                       
                            <li class="nav-item">
                                <a class="btn btn-sm mb-0 me-2 text-white" style="background-color:#2F6690;" href="{{ route('home') }}">
                                    {{ $custom_settings['app_name'] }}
                                </a>
                            </li>
                       
                    </ul>

                    <!-- Toggler -->
                    <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon mt-2"></span>
                    </button>

                    <!-- Navigation Links -->
                    <div class="collapse navbar-collapse" id="navigation">
                        <ul class="navbar-nav mx-auto">
                            <li class="nav-item">
                                <a class="nav-link me-3 {{ request()->routeIs('accueil') ? 'active fw-bold text-primary' : 'text-dark' }}" href="{{ route('accueil') }}">
                                    <i class="bi bi-house-door me-1"></i> Accueil
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-3 {{ request()->routeIs('a-propos') ? 'active fw-bold text-primary' : 'text-dark' }}" href="{{ route('a-propos') }}">
                                    <i class=""></i> À propos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-3 {{ request()->routeIs('register') ? 'active fw-bold text-primary' : 'text-dark' }}" href="{{ route('register') }}">
                                    <i class="fas fa-user-circle me-1"></i> S'inscrire
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>
    </div>
</div>
