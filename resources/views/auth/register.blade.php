@extends('layouts.app')

@section('content')
<main class="main-content mt-0">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-4">
                        <h4 class="connexion-title text-center mb-4" style="color:#0070BB;" >Créer un compte</h4>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" style="color:#0070BB;">Nom d'utilisateur</label>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}">
                                @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color:#0070BB;">Adresse e-mail</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color:#0070BB;">Mot de passe</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color:#0070BB;">Rôle</label>
                                <select name="role" class="form-select @error('role') is-invalid @enderror">
                                    <option value="">Sélectionner un rôle </option>
                                    <option value="user">Utilisateur</option>
                                    <option value="admin">Admin</option>
                                </select>
                                @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="terms" id="terms">
                                <label class="form-check-label" for="terms">
                                    J'accepte les <a href="#" class="text-decoration-none">conditions générales</a>
                                </label>
                                @error('terms') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">S'inscrire</button>

                            <div class="text-center mt-3">
                                <small>Déjà un compte ? <a href="{{ route('login') }}" class="text-decoration-none">Se connecter</a></small>
                            </div>
                        </form>

                        <div id="alert" class="mt-3">
                            @include('components.alert')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

