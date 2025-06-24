<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Conducteur</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body style="background-color: #ecf0f1; min-height: 100vh;">

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4 shadow-lg">
                <div class="card-header custom-header text-white">
                    <h6>{{ __('drivers.edit_driver') }}</h6>
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
                    <form action="{{ route('drivers.update', $driver->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="nom">{{ __('drivers.name') }}</label>
                            <input type="text" id="nom" class="form-control" name="nom" value="{{ $driver->nom }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="telephone">{{ __('drivers.phone') }}</label>
                            <input type="text" id="telephone" class="form-control" name="telephone" value="{{ $driver->telephone }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="numero_permis">{{ __('drivers.license_number') }}</label>
                            <input type="text" id="numero_permis" class="form-control" name="numero_permis" value="{{ $driver->numero_permis }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="type_permis">{{ __('drivers.license_type') }}</label>
                            <input type="text" id="type_permis" class="form-control" name="type_permis" value="{{ $driver->type_permis }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="date_expiration_permis">{{ __('drivers.license_expiration') }}</label>
                            <input type="date" id="date_expiration_permis" class="form-control" name="date_expiration_permis" value="{{ $driver->date_expiration_permis }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="adresse">{{ __('drivers.address') }}</label>
                            <input type="text" id="adresse" class="form-control" name="adresse" value="{{ $driver->adresse }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="date_embauche">{{ __('drivers.hire_date') }}</label>
                            <input type="date" id="date_embauche" class="form-control" name="date_embauche" value="{{ $driver->date_embauche }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="contact_urgence">{{ __('drivers.emergency_contact') }}</label>
                            <input type="text" id="contact_urgence" class="form-control" name="contact_urgence" value="{{ $driver->contact_urgence }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="status">{{ __('drivers.status') }}</label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="disponible" {{ $driver->status == 'disponible' ? 'selected' : '' }}>{{ __('drivers.available') }}</option>
                                <option value="occupe" {{ $driver->status == 'occupe' ? 'selected' : '' }}>{{ __('drivers.busy') }}</option>
                                <option value="en pause" {{ $driver->status == 'en pause' ? 'selected' : '' }}>{{ __('drivers.on_break') }}</option>
                                <option value="non disponible" {{ $driver->status == 'non disponible' ? 'selected' : '' }}>{{ __('drivers.not_available') }}</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn custom-btn px-4">{{ __('drivers.edit') }}</button>
                            <a href="{{ route('drivers.index') }}" class="btn btn-secondary btn-lg px-4">{{ __('drivers.back') }}</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
