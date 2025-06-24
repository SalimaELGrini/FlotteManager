<!DOCTYPE html>
<html lang="{{ $locale ?? app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <title>{{ __('vehicule.Report') }}</title>
</head>
<body>
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header text-white text-center" style="background-color: #0070BB;">
            <h3 class="mb-0">{{ __('vehicule.Report') }}</h3>
        </div>
        <div class="card-body">
            

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center">{{ __('vehicule.infos') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>{{ __('vehicule.numero') }}</strong></td>
                        <td>{{ $vehicule->numero }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('vehicule.modele') }}</strong></td>
                        <td>{{ $vehicule->modele }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('vehicule.matricule') }}</strong></td>
                        <td>{{ $vehicule->matricule }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('vehicule.annee') }}</strong></td>
                        <td>{{ $vehicule->annee_fabrication }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('vehicule.carburant') }}</strong></td>
                        <td>{{ $vehicule->type_carburant }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('vehicule.reservoir') }}</strong></td>
                        <td>{{ $vehicule->capacite_reservoir }} litres</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('vehicule.kilometrage') }}</strong></td>
                        <td>{{ $vehicule->kilometrage }} km</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('vehicule.visite') }}</strong></td>
                        <td>{{ $vehicule->date_visite_technique }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('vehicule.assurance') }}</strong></td>
                        <td>{{ $vehicule->date_expiration_assurance }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('vehicule.statut') }}</strong></td>
                        <td>{{ $vehicule->status }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('vehicule.achat') }}</strong></td>
                        <td>{{ $vehicule->date_achat }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Assignations -->
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th colspan="3" class="text-center">{{ __('vehicule.affectations') }}</th>
                    </tr>
                    <tr>
                        <th>{{ __('vehicule.chauffeur') }}</th>
                        <th>{{ __('vehicule.debut') }}</th>
                        <th>{{ __('vehicule.type_affectation') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vehicule->assignments as $assignment)
                        <tr>
                            <td>{{ $assignment->driver->nom }}</td>
                            <td>{{ $assignment->date_debut }}</td>
                            <td>{{ $assignment->type_affectation }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


</body>
</html>
