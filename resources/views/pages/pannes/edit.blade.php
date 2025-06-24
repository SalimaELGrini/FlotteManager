<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Panne</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body style="background-color: #ecf0f1;">

<div class="container-fluid py-4" style="min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4 shadow-lg">
                <div class="card-header custom-header text-white">
                    <h6>{{ __('panne.edit_title') }}</h6>
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
                    <form action="{{ route('pannes.update', $panne->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        
                        <div class="form-group mb-3">
                            <label for="vehicule_id">{{ __('panne.vehicle') }}</label>
                            <select name="vehicule_id" id="vehicule_id" class="form-control" required>
                                <option value="" disabled {{ old('vehicule_id', $panne->vehicule_id) ? '' : 'selected' }}>{{ __('panne.select_vehicle') }}</option>
                                @foreach ($vehicules as $vehicule)
                                    <option value="{{ $vehicule->id }}" {{ old('vehicule_id', $panne->vehicule_id) == $vehicule->id ? 'selected' : '' }}>{{ $vehicule->numero }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="driver_id">{{ __('panne.driver') }}</label>
                            <select name="driver_id" id="driver_id" class="form-control" required>
                                <option value="" disabled {{ old('driver_id', $panne->driver_id) ? '' : 'selected' }}>{{ __('panne.select_driver') }}</option>
                                @foreach ($drivers as $driver)
                                    <option value="{{ $driver->id }}" {{ old('driver_id', $panne->driver_id) == $driver->id ? 'selected' : '' }}>{{ $driver->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                       
                        <div class="form-group mb-3">
                            <label for="status">{{ __('panne.status') }}</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="avant" {{ old('status', $panne->status) == 'avant' ? 'selected' : '' }}>{{ __('panne.status_avant') }}</option>
                                <option value="en_cours" {{ old('status', $panne->status) == 'en_cours' ? 'selected' : '' }}>{{ __('panne.status_en_cours') }}</option>
                            </select>
                        </div>

                        
                        <div class="form-group mb-3">
                            <label for="description">{{ __('panne.description') }}</label>
                            <textarea name="description" id="description" class="form-control" rows="4" placeholder="{{ __('panne.description_placeholder') }}" required>{{ old('description', $panne->description) }}</textarea>
                        </div>

                        
                        <div class="form-group mb-3">
                            <label for="date_panne">{{ __('panne.date') }}</label>
                            <input type="date" name="date_panne" id="date_panne" class="form-control" required value="{{ old('date_panne', \Carbon\Carbon::parse($panne->date_panne)->format('Y-m-d')) }}">
                        </div>

                       
                        <div class="form-group mb-3">
                            <input class="form-check-input custom-checkbox" type="checkbox" name="resolved" id="resolved" value="1" {{ old('resolved') ? 'checked' : '' }}>
                            <label class="form-check-label" for="resolved">{{ __('panne.resolved') }}</label>
                        </div>

                      
                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn custom-btn px-4">{{ __('panne.submitm') }}</button>
                            <a href="{{ route('pannes.index') }}" class="btn btn-secondary btn-lg px-4">{{ __('panne.back') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
