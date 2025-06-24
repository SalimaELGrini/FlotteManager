<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ __('panne.create_title') }}</title>
   
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
                <div class="card-header custom-header text-white">
                    <h6>{{ __('panne.create_title') }}</h6>
                </div>

                <x-alert-sweet />
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
                    <form action="{{ route('pannes.store') }}" method="POST">
                        @csrf

                        <!-- Véhicule -->
                        <div class="form-group mb-3">
                            <label for="vehicule_id">{{ __('panne.vehicle') }}</label>
                            <select name="vehicule_id" id="vehicule_id" class="form-control">
                                <option value="" disabled selected>{{ __('panne.select_vehicle') }}</option>
                                @foreach ($vehicules as $vehicule)
                                    <option value="{{ $vehicule->id }}">{{ $vehicule->numero }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Conducteur -->
                        <div class="form-group mb-3">
                            <label for="driver_id">{{ __('panne.driver') }}</label>
                            <select name="driver_id" id="driver_id" class="form-control">
                                <option value="" disabled selected>{{ __('panne.select_driver') }}</option>
                                @foreach ($drivers as $driver)
                                    <option value="{{ $driver->id }}">{{ $driver->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Statut -->
                        <div class="form-group mb-3" id="status_div" style="display: none;">
                            <label for="status">{{ __('panne.status') }}</label>
                            <select name="status" id="status" class="form-control">
                                <option value="" disabled selected>{{ __('panne.select_status') }}</option>
                                <option value="avant">{{ __('panne.status_avant') }}</option>
                                <option value="en_cours">{{ __('panne.status_en_cours') }}</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="form-group mb-3">
                            <label for="description">{{ __('panne.description') }}</label>
                            <textarea name="description" id="description" class="form-control" rows="4" placeholder="{{ __('panne.description_placeholder') }}"></textarea>
                        </div>

                        <!-- Date -->
                        <div class="form-group mb-3">
                            <label for="date_panne">{{ __('panne.date') }}</label>
                            <input type="date" name="date_panne" id="date_panne" class="form-control">
                        </div>

                        <!-- Résolu -->
                        <div class="form-group mb-3">
                            <input class="form-check-input custom-checkbox" type="checkbox" name="resolved" id="resolved" value="1" {{ old('resolved') ? 'checked' : '' }}>
                            <label class="form-check-label" for="resolved">{{ __('panne.resolved') }}</label>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-4">{{ __('panne.submit') }}</button>
                            <a href="{{ route('pannes.index') }}" class="btn btn-secondary btn-lg px-4">{{ __('panne.back') }}</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/panne-form.js') }}"></script>

</body>
</html>

