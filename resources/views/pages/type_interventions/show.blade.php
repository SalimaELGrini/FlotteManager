<!DOCTYPE html>
<html lang="{{ $locale ?? app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <title>{{ __('type_intervention.details_title') }}</title>
</head>
<body>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            direction: {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }};
        }
        .container {
            margin: 30px auto;
            width: 90%;
        }
        .card-header {
            background-color: #0070BB;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header text-white text-center" style="background-color: #0070BB;">
                <h3 class="mb-0">{{ __('type_intervention.details_title') }}</h3>
            </div>
            <div class="card-body">
                <!-- Bouton PDF -->
                <div class="text-end mb-3">
                    <a href="{{ route('type_interventions.export.single', $typeIntervention->id) }}" class="btn btn-link-primary" style="color: #0070BB;" target="_blank">
                        <i data-lucide="file-down"></i> {{ __('type_intervention.download_pdf') }}
                    </a>
                </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="2" class="text-center">{{ __('type_intervention.infos') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>{{ __('type_intervention.name') }}</strong></td>
                    <td>{{ $typeIntervention->name }}</td>
                </tr>
                <tr>
                    <td><strong>{{ __('type_intervention.description') }}</strong></td>
                    <td>{{ $typeIntervention->description ?? __('type_intervention.not_specified') }}</td>
                </tr>
            </tbody>
        </table>
        <div class="card-footer text-center">
            <a href="{{ route('type_interventions.index') }}" class="btn btn-secondary btn-lg">
                {{ __('type_intervention.back_to_list') }}
            </a>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
</body>
</html>
