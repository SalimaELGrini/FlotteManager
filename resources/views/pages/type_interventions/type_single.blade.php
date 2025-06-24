<!DOCTYPE html>
<html lang="{{ $locale ?? app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <title>{{ __('type_intervention.Report') }}</title>
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
        .table, .table td, .table th {
            border: 1px solid #000;
            padding: 8px;
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
                <h3 class="mb-0">{{ __('type_intervention.Report') }}</h3>
            </div>
            <div class="card-body">
               
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
        
    </div>
</div>


</body>
</html>


