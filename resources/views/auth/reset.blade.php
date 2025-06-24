@extends('layouts.app')

@section('content')
<main class="main-content mt-0">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-4">
                        <h4 class="text-center mb-4 connexion-title" style="color:#0070BB;"> Réinitialiser le mot de passe</h4>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.reset') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" style="color:#0070BB;">Adresse e-mail</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"  value="{{ old('email', session('email')) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color:#0070BB;">Nouveau mot de passe</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color:#0070BB;">Confirmer le mot de passe</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Réinitialiser</button>
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

