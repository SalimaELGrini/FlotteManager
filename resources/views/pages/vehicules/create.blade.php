<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une Vehicules</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- SweetAlert2 -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
     <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-4 shadow-lg">
                    <div class="card-header custom-header text-white">
                    <h6>{{ __('vehicule.add_title') }}</h6>
                </div>

                <x-alert-sweet/>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body">
                    <form action="{{ route('vehicules.store') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="numero">{{ __('vehicule.numero') }}</label>
                            <input type="text" name="numero" class="form-control" id="numero"
                                value="{{ old('numero') }}" placeholder="{{ __('vehicule.numero_placeholder') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="modele">{{ __('vehicule.modele') }}</label>
                            <input type="text" name="modele" class="form-control" id="modele"
                                value="{{ old('modele') }}" placeholder="{{ __('vehicule.modele_placeholder') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="matricule">{{ __('vehicule.matricule') }}</label>
                            <input type="text" name="matricule" class="form-control" id="matricule"
                                value="{{ old('matricule') }}" placeholder="{{ __('vehicule.matricule_placeholder') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="annee_fabrication">{{ __('vehicule.annee_fabrication') }}</label>
                            <input type="number" name="annee_fabrication" class="form-control" id="annee_fabrication"
                                value="{{ old('annee_fabrication') }}" placeholder="{{ __('vehicule.annee_fabrication_placeholder') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="type_carburant">{{ __('vehicule.type_carburant') }}</label>
                            <input type="text" name="type_carburant" class="form-control" id="type_carburant"
                                value="{{ old('type_carburant') }}" placeholder="{{ __('vehicule.type_carburant_placeholder') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="capacite_reservoir">{{ __('vehicule.capacite_reservoir') }}</label>
                            <input type="number" name="capacite_reservoir" class="form-control" id="capacite_reservoir"
                                value="{{ old('capacite_reservoir') }}" placeholder="{{ __('vehicule.capacite_reservoir_placeholder') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="kilometrage">{{ __('vehicule.kilometrage') }}</label>
                            <input type="number" name="kilometrage" class="form-control" id="kilometrage"
                                value="{{ old('kilometrage') }}" placeholder="{{ __('vehicule.kilometrage_placeholder') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="date_visite_technique">{{ __('vehicule.date_visite_technique') }}</label>
                            <input type="date" name="date_visite_technique" class="form-control" id="date_visite_technique"
                                value="{{ old('date_visite_technique') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="date_expiration_assurance">{{ __('vehicule.date_expiration_assurance') }}</label>
                            <input type="date" name="date_expiration_assurance" class="form-control" id="date_expiration_assurance"
                                value="{{ old('date_expiration_assurance') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="status">{{ __('vehicule.status') }}</label>
                            <select name="status" class="form-control" id="status">
                                <option value="">{{ __('vehicule.status_select') }}</option>
                                <option value="Disponible" {{ old('status') == 'Disponible' ? 'selected' : '' }}>{{ __('vehicule.disponible') }}</option>
                                <option value="Indisponible" {{ old('status') == 'Indisponible' ? 'selected' : '' }}>{{ __('vehicule.indisponible') }}</option>
                                <option value="En Réparation" {{ old('status') == 'En Réparation' ? 'selected' : '' }}>{{ __('vehicule.en_reparation') }}</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="date_achat">{{ __('vehicule.date_achat') }}</label>
                            <input type="date" name="date_achat" class="form-control" id="date_achat"
                                value="{{ old('date_achat') }}">
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-4">{{ __('vehicule.add') }}</button>
                            <a href="{{ route('vehicules.index') }}" class="btn btn-secondary btn-lg px-4">{{ __('vehicule.retour') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
   <!-- SweetAlert2 JS -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
