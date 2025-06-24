<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une Pièce</title>

    <!-- Bootstrap -->
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
                        <h6>{{ __('piece.add_title') }}</h6>
                    </div>
    
                    <x-alert-sweet/>
    
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
                        <form action="{{ route('pieces.store') }}" method="POST">
                            @csrf
    
                            <!-- Nom -->
                            <div class="form-group mb-3">
                                <label for="nom">{{ __('piece.name') }}</label>
                                <input type="text" name="nom" id="nom" value="{{ old('nom') }}" class="form-control">
                            </div>
    
                            <!-- Référence -->
                            <div class="form-group mb-3">
                                <label for="reference">{{ __('piece.reference') }}</label>
                                <input type="text" name="reference" id="reference" value="{{ old('reference') }}" class="form-control">
                            </div>
    
                            <!-- Type -->
                            <div class="form-group mb-3">
                                <label for="type">{{ __('piece.type') }}</label>
                                <input type="text" name="type" id="type" value="{{ old('type') }}" class="form-control">
                            </div>
    
                            <!-- Description -->
                            <div class="form-group mb-3">
                                <label for="description">{{ __('piece.description') }}</label>
                                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                            </div>
    
                            <!-- Boutons -->
                            <div class="d-flex justify-content-between mt-4">
                                <button type="submit" class="btn btn-primary">{{ __('piece.save') }}</button>
                                <a href="{{ route('pieces.index') }}" class="btn btn-secondary">{{ __('piece.back') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

</body>
</html>
