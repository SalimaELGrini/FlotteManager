<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Garage</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
</head>
<body style="background-color: #ecf0f1; min-height: 100vh;">

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4 shadow-lg">
                <div class="card-header custom-header text-white">
                    <h6>{{ __('garage.edit_title') }}</h6>
                </div>

                <x-alert-sweet />

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('garages.update', $garage->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="name">{{ __('garage.name') }}</label>
                            <input type="text" class="form-control" name="name"
                                value="{{ old('name', $garage->name) }}" placeholder="{{ __('garage.name_placeholder') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="address">{{ __('garage.address') }}</label>
                            <input type="text" class="form-control" name="address"
                                value="{{ old('address', $garage->address) }}" placeholder="{{ __('garage.address_placeholder') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="phone">{{ __('garage.phone') }}</label>
                            <input type="text" class="form-control" name="phone"
                                value="{{ old('phone', $garage->phone) }}" placeholder="{{ __('garage.phone_placeholder') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">{{ __('garage.email') }}</label>
                            <input type="email" class="form-control" name="email"
                                value="{{ old('email', $garage->email) }}" placeholder="{{ __('garage.email_placeholder') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="specializations">{{ __('garage.specializations') }}</label>
                            <textarea class="form-control" name="specializations" rows="4"
                                placeholder="{{ __('garage.specializations_placeholder') }}">{{ old('specializations', $garage->specializations) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn custom-btn px-4">{{ __('garage.update') }}</button>
                            <a href="{{ route('garages.index') }}" class="btn btn-secondary btn-lg px-4">{{ __('garage.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>


