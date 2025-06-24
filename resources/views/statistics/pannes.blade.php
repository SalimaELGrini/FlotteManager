<div class="container">
    <h1>Statistiques des Pannes</h1>
    <form method="GET" action="{{ route('statistics.pannes') }}">

        <div class="row">
            <div class="col-md-3">
                <label for="year">Année:</label>
                <input type="number" name="year" id="year" value="{{ request('year', Carbon\Carbon::now()->year) }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="start_date">De (Date de début):</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="end_date">À (Date de fin):</label>
                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="form-control">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </div>
        </div>
    </form>



    <div class="row mt-5">
        <!-- Tables in the same row -->
        <table class="table">
            <tr>
                <td class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">Total des Pannes</div>
                        <div class="card-body">
                            <p>{{ $totalPannes }} pannes</p>
                        </div>
                    </div>
                </td>
                <td class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-white">Total des Interventions</div>
                        <div class="card-body">
                            <p>{{ $totalInterventions }} interventions</p>
                        </div>
                    </div>
                </td>
                <td class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-danger text-white">Total des Coûts</div>
                        <div class="card-body">
                            <p>{{ number_format($totalCosts, 2) }} DH</p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="row mt-5">
        <!-- 3 More Tables in the same row -->
        <table class="table">
            <tr>
                <td class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">Pannes par mois</div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Mois</th>
                                        <th>Total des pannes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pannesByMonth as $panne)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::create()->month($panne->month)->format('F') }}</td>
                                        <td>{{ $panne->total_pannes }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </td>
                <td class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-white">Interventions par mois</div>
                        <div class="card-body">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Mois</th>
                                        <th>Nombre d'interventions liées aux pannes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($interventionsByMonth as $item)
                                    <tr>
                                        <td>{{ $item->month_name }}</td>
                                        <td>{{ $item->total_interventions ?? 0 }}</td>

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>
                </td>
                <td class="col-md-4">
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header bg-danger text-white">Coûts des interventions par mois</div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Mois</th>
                                            <th>Total des coûts</th>
                                        </tr>
                                    </thead>

                                        <tbody>
                                            @foreach($totalCostsByMonth as $cost)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::create()->month($cost->month)->format('F') }}</td>
                                                    <td>{{ number_format($cost->total_cost, 2) }} DH</td>
                                                </tr>
                                            @endforeach
                                        </tbody>


                                </table>
                            </div>
                        </div>
                    </div>

                </td>
            </tr>
        </table>
    </div>

    <div class="row mt-5">
        <!-- 3 More Tables in Another Row -->
        <table class="table">
            <tr>
                <td class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-dark text-white">Véhicules avec plus de 5 pannes</div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Numéro de véhicule</th>
                                        <th>Nombre de pannes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($frequentPannesVehicles as $vehicle)
                                    <tr>
                                        <td>{{ $vehicle->numero }}</td>
                                        <td>{{ $vehicle->pannes_count }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </td>
                <td class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">Pannes les plus fréquentes</div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Nombre de fois</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($commonPanneDescriptions as $description)
                                    <tr>
                                        <td>{{ $description->description }}</td>
                                        <td>{{ $description->count }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </td>
                <td class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">Conducteurs avec des pannes actives</div>
                        <div class="card-body">
                            <table border="1">
                                <thead>
                                    <tr>
                                        <th>Nom du conducteur</th>
                                        <th>Nombre de pannes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pannesByDriver as $panne)
                                        <tr>
                                            <td>{{ $panne->driver_name }}</td>
                                            <td>{{ $panne->total_pannes }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

<style>
    .container {
        margin-top: 20px;
    }
    .card {
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        font-weight: bold;
        text-align: center;
        font-size: 1.2rem;
        padding: 10px;
    }
    .card-body {
        padding: 15px;
        font-size: 1rem;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    .table th, .table td {
        padding: 8px;
        text-align: left;
        border: 1px solid #ddd;
    }
    .table th {
        background-color: #f1f1f1;
        font-weight: bold;
    }
</style>