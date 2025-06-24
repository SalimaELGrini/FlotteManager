<x-lucide />

<!DOCTYPE html>
<html lang="{{ $locale ?? app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <title>{{ __('intervention.details_intervention') }}</title>
</head>
<body>
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header text-white text-center" style="background-color: #0070BB;">
            <h3 class="mb-0">{{ __('intervention.details_intervention') }}</h3>
        </div>
        <div class="card-body">

            <!-- Bouton PDF -->
            <div class="text-end mb-3">
                <a href="{{ route('interventions.single.pdf', $intervention->id) }}" class="btn btn-link-primary" style="color: #0070BB;" target="_blank">
                    <i data-lucide="file-down"></i> {{ __('intervention.download_pdf') }}
                </a>
            </div>

            <!-- Table Intervention -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center">{{ __('intervention.details_intervention') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>{{ __('intervention.vehicle') }}</strong></td>
                        <td>{{ $intervention->vehicule->modele ?? __('Non spécifié') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('intervention.date') }}</strong></td>
                        <td>{{ $intervention->date_intervention }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('intervention.technician') }}</strong></td>
                        <td>{{ $intervention->nom_technician }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('intervention.duration') }}</strong></td>
                        <td>{{ $intervention->duration }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('intervention.parts_used') }}</strong></td>
                        <td>{{ $intervention->parts_used }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('intervention.total_cost') }}</strong></td>
                        <td>{{ $intervention->total_cost }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('intervention.description') }}</strong></td>
                        <td>{{ $intervention->description }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Détails de la Panne -->
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center">{{ __('intervention.breakdown_details') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>{{ __('intervention.description') }}</strong></td>
                        <td>{{ $intervention->panne->description ?? __('Non spécifiée') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('intervention.breakdown_date') }}</strong></td>
                        <td>{{ $intervention->panne->date_panne ?? __('Non spécifiée') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('intervention.resolved') }}</strong></td>
                        <td>
                            @if(isset($intervention->panne->resolved))
                                {{ $intervention->panne->resolved ? __('Oui') : __('Non') }}
                            @else
                                {{ __('Non spécifiée') }}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Détails du Type d'Intervention -->
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center">{{ __('intervention.intervention_type_details') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>{{ __('intervention.name') }}</strong></td>
                        <td>{{ $intervention->typeIntervention->name ?? __('Non spécifié') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('intervention.description') }}</strong></td>
                        <td>{{ $intervention->typeIntervention->description ?? __('Non spécifiée') }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Détails du Garage -->
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center">{{ __('intervention.garage_details') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>{{ __('intervention.name') }}</strong></td>
                        <td>{{ $intervention->garage->name ?? __('Non spécifié') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('intervention.address') }}</strong></td>
                        <td>{{ $intervention->garage->address ?? __('Non spécifiée') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('intervention.phone') }}</strong></td>
                        <td>{{ $intervention->garage->phone ?? __('Non spécifié') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('intervention.email') }}</strong></td>
                        <td>{{ $intervention->garage->email ?? __('Non spécifié') }}</td>
                    </tr>
                </tbody>
            </table>



            <!-- Pièces utilisées -->
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th colspan="6" class="text-center">{{ __('intervention.parts_used') }}</th>
                    </tr>
                    <tr>
                        <th>{{ __('intervention.piece_label') }}</th>
                        <th>{{ __('intervention.replacement_date') }}</th>
                        <th>{{ __('intervention.status') }}</th>
                        <th>{{ __('intervention.price') }}</th>
                        <th>{{ __('intervention.technician_name') }}</th>
                        <th class="text-center">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($intervention->neussites as $neussite)
                        <tr>
                            <td>{{ $neussite->piece->nom ?? 'Non disponible' }}</td>
                            <td>{{ $neussite->date_change ?? __('Non disponible') }}</td>
                            <td>{{ ucfirst($neussite->status) }}</td>
                            <td>{{ number_format($neussite->prix_piece ?? 0, 2, '.', ' ') }} DH</td>
                            <td>{{ $neussite->nom_technicien ?? __('Inconnu') }}</td>
                            <td class="text-center">
                                {{-- Bouton Modifier (ouvre le modal) --}}
                                <button
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editNeussiteModal-{{ $neussite->id }}"
                                    class="primary btn btn-link p-2 fs-7" title="{{ __('intervention.edit') }}" style="color: #0070BB">
                                                <i data-lucide="square-pen"></i>


                                </button>

                                {{-- Bouton Supprimer --}}
                                <form
                                    action="{{ route('interventions.neussites.destroy', [$intervention->id, $neussite->id]) }}"
                                    method="POST"
                                    style="display: inline-block;"
                                    onsubmit="return confirm('{{ __('Êtes-vous sûr(e) de vouloir supprimer cette ligne ?') }}');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link primary p-2 fs-7" title="{{ __('intervention.delete') }}"  style="color: #0070BB">
                                        <i data-lucide="x"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                {{ __('Aucune pièce utilisée enregistrée pour cette intervention.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Bouton Retour -->
            <div class="mt-4 text-center">
                <a href="{{ route('interventions.index') }}" class="btn btn-secondary btn-lg">
                    {{ __('intervention.back_to_list') }}
                </a>
            </div>

        </div>
    </div>
</div>

{{-- Modals d’édition inline pour chaque neussite --}}
@foreach ($intervention->neussites as $neussite)
    <div
        class="modal fade"
        id="editNeussiteModal-{{ $neussite->id }}"
        tabindex="-1"
        aria-labelledby="editNeussiteModalLabel-{{ $neussite->id }}"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                {{-- En-tête du modal --}}
                <div class="modal-header">
                    <h5 class="modal-title" id="editNeussiteModalLabel-{{ $neussite->id }}" style="color: #0070BB">
                        {{ __('Modifier la pièce utilisée') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Fermer') }}"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('interventions.neussites.update', [$intervention->id, $neussite->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="intervention_id" value="{{ $intervention->id }}">

                        <div class="mb-3">
                            <label for="piece_id-{{ $neussite->id }}" class="form-label">{{ __('intervention.piece_label') }}</label>
                            <select class="form-control @error('piece_id') is-invalid @enderror" name="piece_id" required>
                                <option value="">{{ __('intervention.select_piece') }}</option>
                                @foreach(\App\Models\Piece::all() as $piece)
                                    <option value="{{ $piece->id }}" {{ old('piece_id', $neussite->piece_id) == $piece->id ? 'selected' : '' }}>
                                        {{ $piece->id }} – {{ $piece->nom ?? $piece->reference ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('piece_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date_change-{{ $neussite->id }}" class="form-label">{{ __('intervention.date_change_label') }}</label>
                            <input type="date" class="form-control @error('date_change') is-invalid @enderror" name="date_change" value="{{ old('date_change', $neussite->date_change) }}" required>
                            @error('date_change')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="prix_piece-{{ $neussite->id }}" class="form-label">{{ __('intervention.price_label') }}</label>
                            <input type="number" step="0.01" class="form-control @error('prix_piece') is-invalid @enderror" name="prix_piece" value="{{ old('prix_piece', $neussite->prix_piece) }}" required>
                            @error('prix_piece')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nom_technicien-{{ $neussite->id }}" class="form-label">{{ __('intervention.technician_label') }}</label>
                            <input type="text" class="form-control @error('nom_technicien') is-invalid @enderror" name="nom_technicien" value="{{ old('nom_technicien', $neussite->nom_technicien) }}" required>
                            @error('nom_technicien')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status-{{ $neussite->id }}" class="form-label">{{ __('intervention.status_label') }}</label>
                            <select id="status-{{ $neussite->id }}" class="form-control @error('status') is-invalid @enderror" name="status" required>
                                <option value="">{{ __('intervention.select_status') }}</option>
                                <option value="en_attente" {{ (old('status') ?? $neussite->status) == 'en_attente' ? 'selected' : '' }}>
                                    {{ __('intervention.status_in_progress') }}
                                </option>
                                <option value="terminée" {{ (old('status') ?? $neussite->status) == 'terminée' ? 'selected' : '' }}>
                                    {{ __('intervention.status_completed') }}
                                </option>
                                <option value="en_cours" {{ (old('status') ?? $neussite->status) == 'en_cours' ? 'selected' : '' }}>
                                    {{ __('intervention.status_pending') }}
                                </option>
                            </select>

                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="modal-footer d-flex justify-content-between">
                            <button type="submit"  class="btn btn text-white  me-2" style="background-color: #0070BB">{{ __('intervention.update') }}</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('intervention.btn_cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach


@push('styles')
<style>
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background-color: #0070BB;
        color: white;
        padding: 1rem;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    .table th {
        font-weight: 600;
        background-color: #f7f7f7;
    }
    .table td {
        font-size: 1.1rem;
    }
    .btn {
        border-radius: 50px;
        font-size: 1rem;
        padding: 0.6rem 2.5rem;
    }
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }
    .card-body {
        padding: 1.5rem;
    }
    .card-footer {
        padding: 1rem;
    }
</style>
@endpush

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    lucide.createIcons();
</script>

</body>
</html>
