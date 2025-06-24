<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Vehicules</title>
    <!-- Ajouter le CSS de Bootstrap pour un meilleur style -->
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
                    <h6>{{ __('vehicule.edit_vehicle') }}</h6>
                </div>

                <x-alert-sweet/>

                <div class="card-body">
                    <form action="{{ route('vehicules.update', $vehicule->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="numero">{{ __('vehicule.number') }}</label>
                            <input type="text" name="numero" class="form-control" value="{{ old('numero', $vehicule->numero) }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="modele">{{ __('vehicule.model') }}</label>
                            <input type="text" name="modele" class="form-control" value="{{ old('modele', $vehicule->modele) }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="matricule">{{ __('vehicule.plate') }}</label>
                            <input type="text" name="matricule" class="form-control" value="{{ old('matricule', $vehicule->matricule) }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="annee_fabrication">{{ __('vehicule.annee_fabrication') }}</label>
                            <input type="number" name="annee_fabrication" class="form-control" value="{{ old('annee_fabrication', $vehicule->annee_fabrication) }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="type_carburant">{{ __('vehicule.type_carburant') }}</label>
                            <input type="text" name="type_carburant" class="form-control" value="{{ old('type_carburant', $vehicule->type_carburant) }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="capacite_reservoir">{{ __('vehicule.capacite_reservoir') }}</label>
                            <input type="number" name="capacite_reservoir" class="form-control" value="{{ old('capacite_reservoir', $vehicule->capacite_reservoir) }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="kilometrage">{{ __('vehicule.kilometrage') }}</label>
                            <input type="number" name="kilometrage" class="form-control" value="{{ old('kilometrage', $vehicule->kilometrage) }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="date_visite_technique">{{ __('vehicule.date_visite_technique') }}</label>
                            <input type="date" name="date_visite_technique" class="form-control" value="{{ old('date_visite_technique', $vehicule->date_visite_technique) }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="date_expiration_assurance">{{ __('vehicule.date_expiration_assurance') }}</label>
                            <input type="date" name="date_expiration_assurance" class="form-control" value="{{ old('date_expiration_assurance', $vehicule->date_expiration_assurance) }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="status">{{ __('vehicule.status') }}</label>
                            <select name="status" class="form-control">
                                <option value="Disponible" {{ old('status', $vehicule->status) == 'Disponible' ? 'selected' : '' }}>{{ __('vehicule.disponible') }}</option>
                                <option value="Indisponible" {{ old('status', $vehicule->status) == 'Indisponible' ? 'selected' : '' }}>{{ __('vehicule.indisponible') }}</option>
                                <option value="En Réparation" {{ old('status', $vehicule->status) == 'En Réparation' ? 'selected' : '' }}>{{ __('vehicule.en_reparation') }}</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="date_achat">{{ __('vehicule.date_achat') }}</label>
                            <input type="date" name="date_achat" class="form-control" value="{{ old('date_achat', $vehicule->date_achat) }}">
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn custom-btn px-4">{{ __('vehicule.modifier') }}</button>
                            <a href="{{ route('vehicules.index') }}" class="btn btn-secondary btn-lg px-4">{{ __('vehicule.retour') }}</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
