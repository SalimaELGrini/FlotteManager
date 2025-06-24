<!DOCTYPE html>
<html lang="{{ $locale ?? app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <title>{{ __('consommation.Report') }}</title>
</head>
<body>
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header text-white text-center" style="background-color: #0070BB;">
            <h3 class="mb-0">{{ __('consommation.Report') }}</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center">{{ __('consommation.info_title') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>{{ __('consommation.vehicle') }}</strong></td>
                        <td>{{ $fuelConsumption->vehicule->name ?? __('consommation.unknown') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('consommation.fuel_added') }}</strong></td>
                        <td>{{ $fuelConsumption->fuel_added }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('consommation.distance') }}</strong></td>
                        <td>{{ $fuelConsumption->distance_parcourue }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('consommation.efficiency') }}</strong></td>
                        <td>{{ $fuelConsumption->fuel_efficiency ?? __('consommation.not_specified') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('consommation.date_added') }}</strong></td>
                        <td>{{ $fuelConsumption->date_fuel_added }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('consommation.price_per_liter') }}</strong></td>
                        <td>{{ $fuelConsumption->fuel_price_per_liter }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('consommation.total_cost') }}</strong></td>
                        <td>{{ $fuelConsumption->total_cost }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('consommation.station') }}</strong></td>
                        <td>{{ $fuelConsumption->station_service ?? __('consommation.not_specified') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('consommation.comment') }}</strong></td>
                        <td>{{ $fuelConsumption->commentaire ?? __('consommation.no_comment') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>


    </div>
</div>

</body>
</html>