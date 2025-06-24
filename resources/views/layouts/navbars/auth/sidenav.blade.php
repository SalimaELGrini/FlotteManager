<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <!-- Lien CDN pour Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
</head>
<body>


    <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
        <div class="sidenav-header d-flex flex-column justify-content-center align-items-center p-3">
            @auth
                <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
                <a class="navbar-brand m-0 text-center" href="@if(Auth::user()->role === 'admin') {{ route('dashboard.admin') }} @elseif(Auth::user()->role === 'user') {{ route('dashboard.user') }} @endif" target="_blank">
                    <span class="ms-1 font-weight-bold" style="font-size: 16px;">
                        {{ $custom_settings['app_name'] }}
                    </span>
                </a>
            @endauth
        </div>


    <hr class="horizontal dark mt-0">
    <div id="sidenav-collapse-main">
        <ul class="navbar-nav">
            @auth
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == (Auth::user()->role === 'admin' ? 'dashboard.admin' : 'dashboard.user') ? 'active' : '' }}" href="@if(Auth::user()->role === 'admin') {{ route('dashboard.admin') }} @elseif(Auth::user()->role === 'user') {{ route('dashboard.user') }} @endif">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-tv text-sm" style="color: #0070BB;"></i>
                        </div>
                        <span class="nav-link-text ms-1">{{ __('sidebar.dashboard') }}</span>
                    </a>
                </li>
            @endauth

            <!-- Profil -->
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}" href="{{ route('profile') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-user-circle text-sm" style="color: #0070BB;"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('sidebar.profile') }}</span>
                </a>
            </li>

            <!-- Gestion des utilisateurs (admin only) -->
            @can('access-admin-area')
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'user-management') ? 'active' : '' }}" href="{{ route('admin.users.pending') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-users-cog text-sm" style="color: #0070BB;"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('sidebar.user_management') }}</span>
                </a>
            </li>
            @endcan

            <li class="nav-item mt-3">
                <h6 class="modules ps-4 ms-2 text-uppercase text-xs font-weight-bolder text-dark">Modules</h6>
            </li>

            <!-- Véhicules -->
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'vehicules') ? 'active' : '' }}" href="{{ route('vehicules.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-car text-sm" style="color: #0070BB;"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('sidebar.vehicles') }}</span>
                </a>
            </li>

            <!-- Consommation de carburant -->
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'fuel-consumption') ? 'active' : '' }}" href="{{ route('fuel-consumption.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-tachometer-alt text-sm" style="color: #0070BB;"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('sidebar.fuel_consumption') }}</span>
                </a>
            </li>

            <!-- Conducteurs -->
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'drivers') ? 'active' : '' }}" href="{{ route('drivers.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-user-tie text-sm" style="color: #0070BB;"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('sidebar.drivers') }}</span>
                </a>
            </li>


                <!-- Types d'intervention -->
                <li class="nav-item">
                    <a class="nav-link {{ str_contains(request()->url(), 'type_interventions') ? 'active' : '' }}" href="{{ route('type_interventions.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-cogs text-sm" style="color: #0070BB;"></i>
                        </div>
                        <span class="nav-link-text ms-1">{{ __('sidebar.intervention_types') }}</span>
                    </a>
                </li>


            <!-- Interventions -->
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'interventions') ? 'active' : '' }}" href="{{ route('interventions.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-hammer text-sm" style="color: #0070BB;"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('sidebar.interventions') }}</span>
                </a>
            </li>

        

            <!-- Pannes -->
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'pannes') ? 'active' : '' }}" href="{{ route('pannes.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-tools text-sm" style="color: #0070BB;"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('sidebar.breakdowns') }}</span>
                </a>
            </li>

            <!-- Pièces -->
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'pieces') ? 'active' : '' }}" href="{{ route('pieces.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-wrench text-sm" style="color: #0070BB;"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('sidebar.parts') }}</span>
                </a>
            </li>

            <!-- Garages -->
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'garages') ? 'active' : '' }}" href="{{ route('garages.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-store text-sm" style="color: #0070BB;"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('sidebar.garages') }}</span>
                </a>
            </li>

            <!-- Paramètres -->
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'settings') ? 'active' : '' }}" href="{{ route('settings.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-sliders-h text-sm" style="color: #0070BB;"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('sidebar.settings') }}</span>
                </a>
            </li>

        </ul>
    </div>
</aside>

</body>
</html>
