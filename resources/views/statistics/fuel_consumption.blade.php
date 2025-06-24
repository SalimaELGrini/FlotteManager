<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
    <div class="row">
        <!-- Cartes de statistiques -->
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Carburant Total Ajouté</h5>
                    <p class="card-text">{{ $totalFuelAdded }} Litres</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Distance Totale Parcourue</h5>
                    <p class="card-text">{{ $totalDistance }} km</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Coût Total du Carburant</h5>
                    <p class="card-text">{{ $totalCost }} Dirhams</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Rendement Moyen du Carburant</h5>
                    <p class="card-text">{{ $averageFuelEfficiency }} km/L</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Row pour les tableaux -->
    <div class="row mt-4">
        <!-- Table 1 et Table 2 côte à côte -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3>Consommation de carburant par mois</h3>
                    <input type="text" class="form-control mb-2 search-input" placeholder="Rechercher...">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mois</th>
                                <th>Numéro d'immatriculation</th>
                                <th>Total carburant (L)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthlyStats as $monthData)
                                <tr>
                                    <td>{{ \Carbon\Carbon::create()->month($monthData->month)->format('F') }}</td>
                                    <td>{{ $monthData->vehicule_matricule }}</td>
                                    <td>{{ $monthData->total_fuel_added }} L</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3>Distance parcourue par mois</h3>
                    <input type="text" class="form-control mb-2 search-input" placeholder="Rechercher...">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mois</th>
                                <th>Numéro d'immatriculation</th>
                                <th>Distance totale (km)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthlyStats as $monthData)
                            <tr>
                                <td>{{ \Carbon\Carbon::create()->month($monthData->month)->format('F') }}</td>
                                <td>{{ $monthData->vehicule_matricule }}</td>


                                <td>{{ $monthData->total_distance_parcourue }} Km</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Row pour les autres tableaux -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3>Véhicules ayant plus de 5 consommations</h3>
                    <input type="text" class="form-control mb-2 search-input" placeholder="Rechercher...">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Numéro d'immatriculation</th>
                                <th>Nombre de consommations</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vehiclesWithMoreThanFive as $vehicle)
                                <tr>
                                    <td>{{ $vehicle->matricule }}</td>
                                    <td>{{ $vehicle->fuel_consumptions_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3>Véhicules avec consommation non optimale</h3>
                    <input type="text" class="form-control mb-2 search-input" placeholder="Rechercher...">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Numéro d'immatriculation</th>
                                <th>Mois</th>
                                <th>Année</th>
                                <th>Consommation (L)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vehiclesWithPoorMonthlyConsumption as $vehicle)
                                <tr>
                                    <td>{{ $vehicle->matricule }}</td>
                                    <td>{{ \Carbon\Carbon::create()->month($vehicle->month)->format('F') }}</td>
                                    <td>{{ $vehicle->year }}</td>
                                    <td>{{ $vehicle->total_fuel_consumed }} L</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS & jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script pour la recherche dans les tableaux -->
<script>
    $(document).ready(function(){
        $(".search-input").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(this).closest(".card").find("tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
</script>

<style>
    .container {
        max-width: 1200px;
    }
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .table th {
        background-color: #f8f8f8;
    }
    .search-input {
        width: 100%;
        padding: 5px;
        margin-bottom: 10px;
    }
</style>