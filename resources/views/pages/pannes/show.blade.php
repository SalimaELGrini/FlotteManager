<!DOCTYPE html>
<html lang="{{ $locale ?? app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <title>{{ __('vehicule.details') }}</title>
</head>
<body>
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header text-white text-center" style="background-color: #0070BB;">
            <h3 class="mb-0">{{ __('panne.details_title') }}</h3>
        </div>

        <div class="card-body">

            <!-- Bouton PDF -->
            <div class="text-end mb-3">
                <a href="{{ route('pannes.exportPDF', $panne->id) }}" class="btn btn-link-primary" style="color: #0070BB;" target="_blank">
                    <i data-lucide="file-down"></i> {{ __('panne.download_pdf') }}
                </a>
            </div>

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

        <div class="card-footer text-center">
            <a href="{{ route('pannes.index') }}" class="btn btn-secondary btn-lg">
                <i data-lucide="arrow-left"></i> {{ __('panne.back_to_list') }}
            </a>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
</body>
</html>