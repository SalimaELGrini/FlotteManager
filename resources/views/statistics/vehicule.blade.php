<div class="container">
    <h2 class="text-center my-4">Vehicle Statistics for {{ $month }} / {{ $year }}</h2>

    <div class="row">
        <!-- Fuel Efficiency Statistics -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Fuel Efficiency</h4>
                </div>
                <div class="card-body">
                    @foreach ($vehiclesFuelEfficiency as $vehicle)
                        <p><strong>{{ $vehicle['vehicle'] }}:</strong> {{ $vehicle['average_fuel_efficiency'] }} km/l</p>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Vehicles with High Costs -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Vehicles with High Costs</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Vehicle</th>
                                <th>Total Cost (USD)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vehiclesWithHighCosts as $vehicle)
                                <tr>
                                    <td>{{ $vehicle['vehicle'] }}</td>
                                    <td>{{ isset($vehicle['total_cost']) ? number_format($vehicle['total_cost'], 2) : 'No cost available' }} USD</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Vehicles Close to Technical Visit -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Vehicles Close to Technical Visit</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Vehicle</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vehiclesCloseToVisit as $vehicle)
                                <tr>
                                    <td>{{ $vehicle->numero }}</td>
                                    <td>{{ $vehicle->getTechnicalVisitStatusAttribute() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Vehicles with More Than 5 Pannes -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white">
                    <h4 class="mb-0">Vehicles with More Than 5 Pannes</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Vehicle</th>
                                <th>Panne Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vehiclesWithMoreThanFivePannes as $vehicle)
                                <tr>
                                    <td>{{ $vehicle->numero }}</td>
                                    <td>More than 5 pannes</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Vehicles with Good Performance -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Vehicles with Good Performance</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Vehicle</th>
                                <th>Performance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vehiclesWithGoodPerformance as $vehicle)
                                <tr>
                                    <td>{{ $vehicle->numero }}</td>
                                    <td>Good Performance</td>
                                </tr>
                            @endforeach
<STYle>.container {
    margin-top: 20px;
}

h2 {
    text-align: center;
    color: #333;
    font-weight: bold;
    margin-bottom: 20px;
}

.card-group {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

.card {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: scale(1.02);
}

.card-header {
    background-color: #007bff;
    color: white;
    text-align: center;
    font-weight: bold;
    padding: 10px;
}

.card-body {
    background: #ffffff;
    padding: 20px;
    border-radius: 0 0 10px 10px;
}

.table {
    width: 100%;
    margin-bottom: 20px;
    border-collapse: separate;
    border-spacing: 0 8px;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f8f9fa;
}

.table th {
    background-color: #007bff;
    color: white;
    text-align: center;
    padding: 10px;
}

.table td {
    text-align: center;
    padding: 10px;
    border-top: 1px solid #ddd;
}
</STYle>