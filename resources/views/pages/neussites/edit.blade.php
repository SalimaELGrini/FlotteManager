<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Modifier une Neussite</h3>
        </div>
        <div class="card-body">
            <x-alert-sweet />

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('neussites.update', $neussite->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="intervention_id" class="form-label fw-bold">Intervention</label>
                    <select class="form-control" id="intervention_id" name="intervention_id" required>
                        <option value="">Sélectionnez une intervention</option>
                        @foreach($interventions as $intervention)
                            <option value="{{ $intervention->id }}" {{ $intervention->id == $neussite->intervention_id ? 'selected' : '' }}>
                                {{ $intervention->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="piece_id" class="form-label fw-bold">Pièce</label>
                    <select class="form-control" id="piece_id" name="piece_id" required>
                        <option value="">Sélectionnez une pièce</option>
                        @foreach($pieces as $piece)
                            <option value="{{ $piece->id }}" {{ $piece->id == $neussite->piece_id ? 'selected' : '' }}>
                                {{ $piece->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="date_change" class="form-label fw-bold">Date de Changement</label>
                    <input type="date" class="form-control" id="date_change" name="date_change" value="{{ old('date_change', $neussite->date_change) }}" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label fw-bold">Statut</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="pending" {{ $neussite->status == 'pending' ? 'selected' : '' }}>En Attente</option>
                        <option value="in_progress" {{ $neussite->status == 'in_progress' ? 'selected' : '' }}>En Cours</option>
                        <option value="completed" {{ $neussite->status == 'completed' ? 'selected' : '' }}>Complété</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="prix_piece" class="form-label fw-bold">Prix de la Pièce</label>
                    <input type="number" step="0.01" class="form-control" id="prix_piece" name="prix_piece" value="{{ old('prix_piece', $neussite->prix_piece) }}" required>
                </div>

                <div class="mb-3">
                    <label for="nom_technicien" class="form-label fw-bold">Nom du Technicien</label>
                    <input type="text" class="form-control" id="nom_technicien" name="nom_technicien" value="{{ old('nom_technicien', $neussite->nom_technicien) }}" required>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success btn-lg px-4">Enregistrer</button>
                    <a href="{{ route('neussites.index') }}" class="btn btn-secondary btn-lg px-4">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #007bff;
        color: white;
        padding: 1rem;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .form-label {
        font-weight: 600;
    }

    .form-control {
        border-radius: 8px;
        padding: 0.75rem;
        font-size: 1rem;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .btn {
        border-radius: 50px;
        font-size: 1rem;
        padding: 0.6rem 2rem;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }
</style>
@endpush

