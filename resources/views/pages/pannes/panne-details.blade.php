<!DOCTYPE html>
<html lang="{{ $locale ?? app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('panne.Report') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-size: 14px;
        }
        .card-header {
            background-color: #0070BB !important;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header text-white text-center" style="background-color: #0070BB;">
                <h3 class="mb-0">{{ __('panne.Report') }}</h3>
            </div>
    
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-center">{{ __('panne.info_title') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>{{ __('panne.vehicle') }}</strong></td>
                            <td>{{ $panne->vehicule->matricule }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('panne.driver') }}</strong></td>
                            <td>{{ $panne->driver->nom ?? __('panne.not_assigned') }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('panne.date') }}</strong></td>
                            <td>{{ $panne->date_panne }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('panne.description') }}</strong></td>
                            <td>{{ $panne->description }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('panne.resolved') }}</strong></td>
                            <td>
                                @if($panne->resolved)
                                    {{ __('panne.yes') }}
                                @else
                                    {{ __('panne.no') }}
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</body>
</html>
</body>
</html>