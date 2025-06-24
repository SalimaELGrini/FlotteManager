<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Type Intervention</title>
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
                    <h6>{{ __('type_intervention.edit_title') }}</h6>
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
                    <form action="{{ route('type_interventions.update', $typeIntervention->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        
                        <div class="form-group mb-3">
                            <label for="name">{{ __('type_intervention.name') }}</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $typeIntervention->name) }}" required>
                        </div>

                       
                        <div class="form-group mb-3">
                            <label for="description">{{ __('type_intervention.description') }}</label>
                            <textarea name="description" id="description" class="form-control" rows="4">{{ $typeIntervention->description }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn custom-btn px-4">{{ __('type_intervention.update') }}</button>
                            <a href="{{ route('type_interventions.index') }}" class="btn btn-secondary btn-lg px-4">{{ __('type_intervention.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>