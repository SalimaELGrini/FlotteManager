<x-lucide />
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('vehicule.details') }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body>

<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header text-white text-center" style="background-color: #0070BB;">
            <h3 class="mb-0">{{ __('vehicule.details') }}</h3>
        </div>
        <div class="card-body">

            <!-- Bouton PDF -->
            <div class="text-end mb-3">
                <a href="{{ route('vehicules.generateSinglePdf', $vehicule->id) }}" class="btn btn-link-primary" style="color: #0070BB;" target="_blank">
                    <i data-lucide="file-down"></i> {{ __('vehicule.download_pdf') }}
                </a>
            </div>

            <!-- Infos véhicule -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center">{{ __('vehicule.infos') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>{{ __('vehicule.numero') }}</strong></td><td>{{ $vehicule->numero }}</td></tr>
                    <tr><td><strong>{{ __('vehicule.modele') }}</strong></td><td>{{ $vehicule->modele }}</td></tr>
                    <tr><td><strong>{{ __('vehicule.matricule') }}</strong></td><td>{{ $vehicule->matricule }}</td></tr>
                    <tr><td><strong>{{ __('vehicule.annee') }}</strong></td><td>{{ $vehicule->annee_fabrication }}</td></tr>
                    <tr><td><strong>{{ __('vehicule.carburant') }}</strong></td><td>{{ $vehicule->type_carburant }}</td></tr>
                    <tr><td><strong>{{ __('vehicule.reservoir') }}</strong></td><td>{{ $vehicule->capacite_reservoir }} litres</td></tr>
                    <tr><td><strong>{{ __('vehicule.kilometrage') }}</strong></td><td>{{ $vehicule->kilometrage }} km</td></tr>
                    <tr><td><strong>{{ __('vehicule.visite') }}</strong></td><td>{{ $vehicule->date_visite_technique }}</td></tr>
                    <tr><td><strong>{{ __('vehicule.assurance') }}</strong></td><td>{{ $vehicule->date_expiration_assurance }}</td></tr>
                    <tr><td><strong>{{ __('vehicule.statut') }}</strong></td><td>{{ $vehicule->status }}</td></tr>
                    <tr><td><strong>{{ __('vehicule.achat') }}</strong></td><td>{{ $vehicule->date_achat }}</td></tr>
                </tbody>
            </table>

            <!-- Assignations -->
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th colspan="5" class="text-center">{{ __('vehicule.affectations') }}</th>
                    </tr>
                    <tr>
                        <th>{{ __('vehicule.chauffeur') }}</th>
                        <th>{{ __('vehicule.debut') }}</th>
                        <th>{{ __('vehicule.type_affectation') }}</th>
                        <th>Remarques</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vehicule->assignments as $assignment)
                        <tr>
                            <td>{{ optional($assignment->driver)->nom ?? '-' }}</td>
                            <td>{{ $assignment->date_debut ?? '-' }}</td>
                            <td>{{ $assignment->type_affectation ?? '-' }}</td>
                            <td>{{ $assignment->remarques ?? '-' }}</td>
                            <td class="d-flex">
                                <!-- Bouton Modifier -->
                                <button  class="primary btn btn-link p-2 fs-7" 
                                        style="color: #0070BB"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editAssignmentModal-{{ $assignment->id }}">
                                        <i data-lucide="square-pen"></i>
                                </button>

                                <!-- Formulaire Supprimer -->
                                <form action="{{ route('assignments.destroy', $assignment->id) }}" method="POST"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette affectation ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link primary p-2 fs-7" style="color: #0070BB">
                                        <i data-lucide="x"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        <!-- Bouton Retour -->
        <div class="card-footer text-center">
            <a href="{{ route('vehicules.index') }}" class="btn btn-secondary btn-lg">
                {{ __('vehicule.retourl') }}
            </a>
        </div>
    </div>
</div>

<!-- Modales modifier assignations -->
@foreach ($vehicule->assignments as $assignment)
    <div class="modal fade" id="editAssignmentModal-{{ $assignment->id }}" tabindex="-1" aria-labelledby="editAssignmentModalLabel-{{ $assignment->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAssignmentModalLabel-{{ $assignment->id }}" style="color: #0070BB">{{ __('vehicule.edit_assignment') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('assignments.update', $assignment->id) }}" method="POST" id="editAssignmentForm-{{ $assignment->id }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="vehicule_id" value="{{ $vehicule->id }}">

                        <div class="mb-3">
                            <label class="form-label">{{ __('vehicule.start_date') }}</label>
                            <input type="date" name="date_debut" class="form-control" value="{{ old('date_debut', $assignment->date_debut) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('vehicule.assignment_type') }}</label>
                            <select name="type_affectation" class="form-select">
                                <option value="">{{ __('vehicule.select_type') }}</option>
                                <option value="permanente" {{ $assignment->type_affectation == 'permanente' ? 'selected' : '' }}>{{ __('vehicule.permanent') }}</option>
                                <option value="temporaire" {{ $assignment->type_affectation == 'temporaire' ? 'selected' : '' }}>{{ __('vehicule.temporary') }}</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('vehicule.remarks') }}</label>
                            <textarea name="remarques" class="form-control">{{ old('remarques', $assignment->remarques) }}</textarea>
                        </div>

                        <div class="modal-footer d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary me-2" style="background-color: #0070BB">{{ __('vehicule.modifier') }}</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('vehicule.cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach


<!-- Scripts Bootstrap et Lucide -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<script>
    lucide.createIcons();
</script>

</body>
</html>

