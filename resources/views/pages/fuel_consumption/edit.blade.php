<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Consommation Carburant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="container-fluid py-4" style="background-color: #ecf0f1; min-height: 100vh;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-4 shadow-lg">
                    <div class="card-header custom-header text-white">
                        <h6>{{ __('consommation.edit_title') }}</h6>
                    </div>

                    <x-alert-sweet />

                    <div class="card-body">
                        <form action="{{ route('fuel-consumption.update', $fuelConsumption->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Véhicule -->
                            <div class="form-group mb-3">
                                <label for="vehicule_id">{{ __('consommation.vehicle') }}</label>
                                <select name="vehicule_id" id="vehicule_id" class="form-control">
                                    <option value="" disabled selected>{{ __('consommation.choose_vehicle') }}</option>
                                    @foreach($vehicules as $vehicule)
                                        <option value="{{ $vehicule->id }}"
                                            {{ $fuelConsumption->vehicule_id == $vehicule->id ? 'selected' : '' }}>
                                            {{ $vehicule->numero }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Carburant Ajouté -->
                            <div class="form-group mb-3">
                                <label for="fuel_added">{{ __('consommation.fuel_added') }}</label>
                                <input type="number" step="0.01" class="form-control" name="fuel_added" id="fuel_added"
                                    value="{{ $fuelConsumption->fuel_added }}">
                            </div>

                            <!-- Date d'Ajout de Carburant -->
                            <div class="form-group mb-3">
                                <label for="date_fuel_added">{{ __('consommation.fuel_date') }}</label>
                                <input type="date" class="form-control" name="date_fuel_added" id="date_fuel_added"
                                    value="{{ $fuelConsumption->date_fuel_added }}">
                            </div>

                            <!-- Prix du Carburant par Litre -->
                            <div class="form-group mb-3">
                                <label for="fuel_price_per_liter">{{ __('consommation.fuel_price') }}</label>
                                <input type="number" step="0.01" class="form-control" name="fuel_price_per_liter"
                                    id="fuel_price_per_liter" value="{{ $fuelConsumption->fuel_price_per_liter }}">
                            </div>

                            <!-- Coût Total -->
                            <div class="form-group mb-3">
                                <label for="total_cost">{{ __('consommation.total_cost') }}</label>
                                <input type="number" step="0.01" class="form-control" name="total_cost" id="total_cost"
                                    readonly value="{{ $fuelConsumption->total_cost }}">
                            </div>

                            <!-- Station de Service -->
                            <div class="form-group mb-3">
                                <label for="station_service">{{ __('consommation.station') }}</label>
                                <input type="text" class="form-control" name="station_service" id="station_service"
                                    value="{{ $fuelConsumption->station_service }}">
                            </div>

                            <!-- Distance Parcourue -->
                            <div class="form-group mb-3">
                                <label for="distance_parcourue">{{ __('consommation.distance') }}</label>
                                <input type="number" step="0.01" class="form-control" name="distance_parcourue"
                                    id="distance_parcourue" value="{{ $fuelConsumption->distance_parcourue }}">
                            </div>

                            <!-- Efficacité du Carburant -->
                            <div class="form-group mb-3">
                                <label for="fuel_efficiency">{{ __('consommation.efficiency') }}</label>
                                <input type="number" step="0.01" class="form-control" name="fuel_efficiency"
                                    id="fuel_efficiency" readonly value="{{ $fuelConsumption->fuel_efficiency }}">
                            </div>

                            <!-- Commentaire -->
                            <div class="form-group mb-3">
                                <label for="commentaire">{{ __('consommation.comment') }}</label>
                                <textarea class="form-control" name="commentaire" id="commentaire"
                                    rows="4">{{ $fuelConsumption->commentaire }}</textarea>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="submit" class="btn custom-btn px-4">{{ __('consommation.submit') }}</button>
                                <a href="{{ route('fuel-consumption.index') }}" class="btn btn-secondary btn-lg px-4">{{ __('consommation.back') }}</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/fuel-consumption.js') }}"></script>
</body>

</html>


