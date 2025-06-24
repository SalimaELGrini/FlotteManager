<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Intervention</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body style="background-color: #ecf0f1; min-height: 100vh;">

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-4 shadow-lg">
                    <div class="card-header text-white" style="background-color: #0070BB;">
                    <h6>Ajouter une Intervention</h6>
                </div>

                <!-- Notifications -->
                <x-alert-sweet/>

                <!-- Erreurs -->
                @if ($errors->any())
                    <div class="alert alert-danger mt-2">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body">
                    <form action="{{ route('interventions.store') }}" method="POST">
                        @csrf

                      
                        <div class="form-group mb-3">
                            <label for="vehicule_id">{{ __('intervention.vehicle') }}</label>
                            <select class="form-control" id="vehicule_id" name="vehicule_id">
                                <option value="">{{ __('intervention.select_vehicle') }}</option>
                                @foreach($vehicules as $vehicule)
                                    <option value="{{ $vehicule->id }}" {{ old('vehicule_id') == $vehicule->id ? 'selected' : '' }}>
                                        {{ $vehicule->modele }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="type_intervention_id" class="form-label">{{ __('intervention.type') }}</label>
                            <select name="type_intervention_id" id="type_intervention_id" class="form-control">
                                <option value="">{{ __('intervention.select_type') }}</option>
                                @foreach($typesInterventions as $type)
                                    <option value="{{ $type->id }}" {{old('type_intervention_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="date_intervention">{{ __('intervention.date') }}</label>
                            <input type="date" class="form-control" id="date_intervention" name="date_intervention" value="{{ old('date_intervention') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="duration">{{ __('intervention.duration') }}</label>
                            <input type="time" class="form-control" id="duration" name="duration" value="{{ old('duration') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">{{ __('intervention.description') }}</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="parts_used">{{ __('intervention.parts_used') }}</label>
                            <textarea class="form-control" id="parts_used" name="parts_used" rows="3">{{ old('parts_used') }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="total_cost">{{ __('intervention.total_cost') }}</label>
                            <input type="number" step="0.01" class="form-control" id="total_cost" name="total_cost" value="{{ old('total_cost') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="nom_technician">{{ __('intervention.technician_name') }}</label>
                            <input type="text" class="form-control" id="nom_technician" name="nom_technician" value="{{ old('nom_technician') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="garage_id" class="form-label fw-bold">{{ __('intervention.garage') }}</label>
                            <select name="garage_id" class="form-control">
                                <option value="">{{ __('intervention.select_garage') }}</option>
                                @foreach($garages as $garage)
                                    <option value="{{ $garage->id }}" {{ old('garage_id') == $garage->id ? 'selected' : '' }}>
                                        {{ $garage->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="panne_id" class="form-label">{{ __('intervention.breakdown') }}</label>
                            <select name="panne_id" id="panne_id" class="form-control">
                                <option value="">{{ __('intervention.select_breakdown') }}</option>
                                @foreach($pannes as $panne)
                                    <option value="{{ $panne->id }}" {{ old('panne_id', $intervention->panne_id ?? '') == $panne->id ? 'selected' : '' }}>
                                        {{ $panne->resolved == 1 ? __('intervention.yes') : __('intervention.no') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-4">{{ __('intervention.save') }}</button>
                            <a href="{{ route('interventions.index') }}" class="btn btn-secondary btn-lg px-4">{{ __('intervention.cancel') }}</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
