<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Pièce</title>
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
                        <h6>{{ __('piece.edit_title') }}</h6>
                    </div>
                    <x-alert-sweet/>
                    <div class="card-body">
                        <form action="{{ route('pieces.update', $piece->id) }}" method="POST">
                            @csrf
                            @method('PUT')


                            <div class="form-group mb-3">
                                <label for="nom">{{ __('piece.name') }}</label>
                                <input type="text" name="nom" id="nom" value="{{ old('nom', $piece->nom) }}" class="form-control">
                            </div>

                            
                            <div class="form-group mb-3">
                                <label for="reference">{{ __('piece.reference') }}</label>
                                <input type="text" name="reference" id="reference" value="{{ old('reference', $piece->reference) }}" class="form-control">
                            </div>

                            
                            <div class="form-group mb-3">
                                <label for="type">{{ __('piece.type') }}</label>
                                <input type="text" name="type" id="type" value="{{ old('type', $piece->type) }}" class="form-control">
                            </div>

                            
                            <div class="form-group mb-3">
                                <label for="description">{{ __('piece.description') }}</label>
                                <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $piece->description) }}</textarea>
                            </div>


                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn custom-btn px-4">{{ __('piece.update') }}</button>
                                <a href="{{ route('pieces.index') }}" class="btn btn-secondary btn-lg px-4">{{ __('piece.back') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
</html>
