<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Intervention</title>
    <!-- Bootstrap CSS -->
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
                    <h6>Modifier Intervention</h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('interventions.update', $intervention->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Véhicule -->
                        <div class="form-group mb-3">
                            <label for="vehicule_id">{{ __('intervention.vehicle') }}</label>
                            <select name="vehicule_id" id="vehicule_id" class="form-control">
                                @foreach($vehicules as $vehicule)
                                    <option value="{{ $vehicule->id }}" {{ $vehicule->id == $intervention->vehicule_id ? 'selected' : '' }}>
                                        {{ $vehicule->modele }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Type d'Intervention -->
                        <div class="form-group mb-3">
                            <label for="type_intervention_id">{{ __('intervention.type') }}</label>
                            <select name="type_intervention_id" id="type_intervention_id" class="form-control">
                                @foreach($typesInterventions as $type)
                                    <option value="{{ $type->id }}" {{ $type->id == $intervention->type_intervention_id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date d'Intervention -->
                        <div class="form-group mb-3">
                            <label for="date_intervention">{{ __('intervention.date') }}</label>
                            <input type="date" class="form-control" name="date_intervention" value="{{ $intervention->date_intervention }}">
                        </div>

                        <!-- Durée -->
                        <div class="form-group mb-3">
                            <label for="duration">{{ __('intervention.duration') }}</label>
                            <input type="time" class="form-control" name="duration" value="{{ $intervention->duration }}">
                        </div>

                        <!-- Description -->
                        <div class="form-group mb-3">
                            <label for="description">{{ __('intervention.description') }}</label>
                            <textarea class="form-control" name="description" rows="3">{{ $intervention->description }}</textarea>
                        </div>

                        <!-- Pièces Utilisées -->
                        <div class="form-group mb-3">
                            <label for="parts_used">{{ __('intervention.parts_used') }}</label>
                            <textarea class="form-control" name="parts_used" rows="3">{{ $intervention->parts_used }}</textarea>
                        </div>

                        <!-- Coût Total -->
                        <div class="form-group mb-3">
                            <label for="total_cost">{{ __('intervention.total_cost') }} (MAD)</label>
                            <input type="number" step="0.01" class="form-control" name="total_cost" value="{{ $intervention->total_cost }}">
                        </div>

                        <!-- Nom du Technicien -->
                        <div class="form-group mb-3">
                            <label for="nom_technician">{{ __('intervention.technician_name') }}</label>
                            <input type="text" class="form-control" name="nom_technician" value="{{ $intervention->nom_technician }}">
                        </div>

                        <!-- Garage -->
                        <div class="form-group mb-3">
                            <label for="garage_id">{{ __('intervention.garage') }}</label>
                            <select name="garage_id" class="form-control">
                                <option value="" disabled>{{ __('intervention.select_garage') }}</option>
                                @foreach($garages as $garage)
                                    <option value="{{ $garage->id }}" {{ $intervention->garage_id == $garage->id ? 'selected' : '' }}>
                                        {{ $garage->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Panne -->
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
                            <button type="submit" class="btn custom-btn px-4">{{ __('intervention.update') }}</button>
                            <a href="{{ route('interventions.index') }}" class="btn btn-secondary btn-lg px-4">{{ __('intervention.cancel') }}</a>
                        </div>

                    </form>
                </div>
                

            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

