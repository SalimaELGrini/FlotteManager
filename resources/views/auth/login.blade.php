@extends('layouts.app')

@section('content')
<main class="main-content mt-0">
    <section class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow-lg border-0 rounded-4 p-4">
                        
                        
                        <div class="text-center mb-4">
                            <img src="{{ asset('img/logosans.png') }}" alt="VéhiTrack Logo" style="width: 80px; display: block; margin: 0 auto; margin-bottom: 0px;">
                            <h6 style="margin-top: -19px; margin-bottom: 0; font-size: 12px; color: #0070BB;">{{ $custom_settings['app_name'] }}</>
                        </div>
                        
                        
                        

                        
                        <div class="card-header bg-white border-0 text-center pb-0">
                            <h4 class="fw-bold modules" >Connexion</h4>
                            <p class="text-muted small">Connectez-vous à votre espace</p>
                        </div>

                        
                        <div class="card-body">
                            <form method="POST" action="{{ route('login.perform') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label" style="color:#0070BB;">Adresse e-mail</label>
                                    <input type="email" name="email" class="form-control" placeholder="exemple@email.com" value="{{ old('email') ?? 'admin@vehitrack.com' }}">
                                    @error('email') <small class="text-danger"> {{ $message }} </small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label" style="color:#0070BB;">Mot de passe</label>
                                    <input type="password" name="password" class="form-control" placeholder="********" value="secret">
                                    @error('password') <small class="text-danger"> {{ $message }} </small> @enderror
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Se souvenir de moi</label>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                            </form>
                        </div>

                        
                        <div class="card-footer text-center bg-white border-0">
                            <p class="small mb-1">
                                <a href="{{ route('password.reset') }}" class="text-decoration-none">Mot de passe oublié ?</a>
                            </p>
                            <p class="small">
                                Pas encore de compte ? 
                                <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color:#0070BB;">Inscrivez-vous</a>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection


