<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container-fluid py-4">
    <h3>Détails des Assignments pour le Véhicule</h3>
    <form method="GET" action="{{ route('assignments.details', $vehicule->id) }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="date" name="date_filter" value="{{ request('date_filter') }}" class="form-control" placeholder="Rechercher par Date">
            </div>
            <div class="col-md-4">
                <select name="date_range" class="form-control">
                    <option value="">Filtrer par période</option>
                    <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Aujourd'hui</option>
                    <option value="yesterday" {{ request('date_range') == 'yesterday' ? 'selected' : '' }}>dernier jours</option>
                    <option value="last_2_days" {{ request('date_range') == 'last_2_days' ? 'selected' : '' }}>Les 2 derniers jours</option> <option value="last_3_days" {{ request('date_range') == 'last_3_days' ? 'selected' : '' }}>Les 3 derniers jours</option> <option value="last_7_days" {{ request('date_range') == 'last_7_days' ? 'selected' : '' }}>Les 7 derniers jours</option>
                    <option value="last_month" {{ request('date_range') == 'last_month' ? 'selected' : '' }}>Le mois dernier</option>
                    <option value="last_2month" {{ request('date_range') == 'last_month' ? 'selected' : '' }}>Le mois dernier</option>
                    <option value="last_year" {{ request('date_range') == 'last_year' ? 'selected' : '' }}>L'année dernière</option>
                    <option value="all" {{ request('date_range') == 'all' ? 'selected' : '' }}>Toutes les Dates</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
        </div>
    </form>

    </form>

    <div class="card">
        <div class="card-body">
            <h5>Liste des Assignments</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Chauffeur</th>
                        <th>Date de Début</th>
                        <th>Type d'Affectation</th>
                        <th>Remarques</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assignments as $assignment)
                        <tr>
                            <td>{{ $assignment->id }}</td>
                            <td>{{ $assignment->driver->nom }}</td>
                            <td>{{ $assignment->date_debut }}</td>
                            <td>{{ $assignment->type_affectation }}</td>
                            <td>{{ $assignment->remarques }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $assignments->links() }}
        </div>
    </div>
</div>
<a href="{{ route('vehicules.index') }}" class="btn btn-secondary btn-lg px-4">Retour</a>