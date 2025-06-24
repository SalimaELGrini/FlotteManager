<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header text-white text-center" style="background-color: #0070BB;">
            <h3 class="mb-0">{{ __('intervention.Report') }}</h3>
        </div>
        <div class="card-body">

            <!-- Table Intervention -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center">{{ __('intervention.Report') }}</th>
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
                        <td>{{ $intervention->panne->date_panne }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('intervention.resolved') }}</strong></td>
                        <td>{{ $intervention->panne->resolved }}</td>
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
                        <th colspan="5" class="text-center">{{ __('intervention.parts_used') }}</th>
                    </tr>
                    <tr>
                        <th>{{ __('intervention.part_number') }}</th>
                        <th>{{ __('intervention.replacement_date') }}</th>
                        <th>{{ __('intervention.status') }}</th>
                        <th>{{ __('intervention.price') }}</th>
                        <th>{{ __('intervention.technician_name') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($intervention->neussites as $neussite)
                        <tr>
                            <td>{{ $neussite->piece->id ?? 'N/A' }}</td>
                            <td>{{ $neussite->date_change ?? __('Non disponible') }}</td>
                            <td>{{ $neussite->status ?? __('Non spécifié') }}</td>
                            <td>{{ $neussite->prix_piece ?? '0 DH' }}</td>
                            <td>{{ $neussite->nom_technicien ?? __('Inconnu') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



</body>
</html>