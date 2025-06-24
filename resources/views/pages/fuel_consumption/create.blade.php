<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout consommation carburant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4 shadow-lg">
                <div class="card-header text-white" style="background-color: #0070BB;">
                    <h6>{{ __('consommation.add_fuel_consumption') }}</h6>
                </div>
                <x-alert-sweet />

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body">
                    <form action="{{ route('fuel-consumption.store') }}" method="POST">
                        @csrf

                        <!-- Véhicule -->
                        <div class="form-group mb-3">
                            <label for="vehicule_id">{{ __('consommation.vehicle') }}</label>
                            <select name="vehicule_id" id="vehicule_id" class="form-control">
                                <option value="">{{ __('consommation.select_vehicle') }}</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">{{ $vehicle->numero }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Carburant Ajouté -->
                        <div class="form-group mb-3">
                            <label for="fuel_added">{{ __('consommation.fuel_added') }}</label>
                            <input type="number" step="0.01" class="form-control" id="fuel_added" name="fuel_added" placeholder="Ajoute le carburant">
                        </div>

                        <!-- Date -->
                        <div class="form-group mb-3">
                            <label for="date_fuel_added">{{ __('consommation.fuel_added_date') }}</label>
                            <input type="date" class="form-control" id="date_fuel_added" name="date_fuel_added">
                        </div>

                        <!-- Prix -->
                        <div class="form-group mb-3">
                            <label for="fuel_price_per_liter">{{ __('consommation.fuel_price_per_liter') }}</label>
                            <input type="number" step="0.01" class="form-control" id="fuel_price_per_liter" name="fuel_price_per_liter" placeholder="{{ __('consommation.fuel_price_placeholder') }}">
                        </div>

                        <!-- Coût Total -->
                        <div class="form-group mb-3">
                            <label for="total_cost">{{ __('consommation.total_cost') }}</label>
                            <input type="number" step="0.01" class="form-control" id="total_cost" name="total_cost" placeholder="{{ __('consommation.total_cost_placeholder') }}" readonly>
                        </div>

                        <!-- Station -->
                        <div class="form-group mb-3">
                            <label for="station_service">{{ __('consommation.service_station') }}</label>
                            <input type="text" class="form-control" id="station_service" name="station_service" placeholder="{{ __('consommation.service_station_placeholder') }}">
                        </div>

                        <!-- Distance -->
                        <div class="form-group mb-3">
                            <label for="distance_parcourue">{{ __('consommation.distance_travelled') }}</label>
                            <input type="number" step="0.01" class="form-control" id="distance_parcourue" name="distance_parcourue" placeholder="{{ __('consommation.distance_travelled_placeholder') }}">
                        </div>

                        <!-- Efficacité -->
                        <div class="form-group mb-3">
                            <label for="fuel_efficiency">{{ __('consommation.fuel_efficiency') }}</label>
                            <input type="number" step="0.01" class="form-control" id="fuel_efficiency" name="fuel_efficiency" placeholder="{{ __('consommation.fuel_efficiency_placeholder') }}" readonly>
                        </div>

                        <!-- Commentaire -->
                        <div class="form-group mb-3">
                            <label for="commentaire">{{ __('consommation.comment') }}</label>
                            <textarea class="form-control" id="commentaire" name="commentaire" rows="4" placeholder="{{ __('consommation.comment_placeholder') }}"></textarea>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-4">{{ __('consommation.add_button') }}</button>
                            <a href="{{ route('fuel-consumption.index') }}" class="btn btn-secondary btn-lg px-4">{{ __('consommation.back_button') }}</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/fuel-consumption.js') }}"></script>

</body>
</html>

    

