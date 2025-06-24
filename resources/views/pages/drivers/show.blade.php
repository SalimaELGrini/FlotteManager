<!DOCTYPE html>
<html lang="{{ $locale ?? app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <title>{{ __('drivers.driver_details') }}</title>
</head>
<body>
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header text-white text-center" style="background-color: #0070BB;" >
            <h3 class="mb-0">{{ __('drivers.driver_details') }}</h3>
        </div>
        <div class="card-body">
            <!-- Bouton PDF -->
            <div class="text-end mb-3">
                <a href="{{ route('drivers.pdf', $driver->id) }}" class="btn btn-link-primary" style="color: #0070BB;" target="_blank">
                    <i data-lucide="file-down"></i>  {{ __('drivers.download_pdf') }}
                </a>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center">{{ __('drivers.driver_info') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>{{ __('drivers.name') }}</strong></td>
                        <td>{{ $driver->nom }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('drivers.phone') }}</strong></td>
                        <td>{{ $driver->telephone ?? __('drivers.not_specified') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('drivers.license_number') }}</strong></td>
                        <td>{{ $driver->numero_permis ?? __('drivers.not_specified') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('drivers.license_type') }}</strong></td>
                        <td>{{ $driver->type_permis ?? __('drivers.not_specified') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('drivers.status') }}</strong></td>
                        <td>{{ $driver->status ?? __('drivers.not_specified') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-footer text-center">
            <a href="{{ route('drivers.index') }}" class="btn btn-secondary btn-lg">{{ __('drivers.back_to_list') }}</a>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>