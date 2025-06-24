<!DOCTYPE html>
<html lang="{{ $locale ?? app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('piece.Report') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header text-white text-center" style="background-color: #0070BB;">
                <h3 class="mb-0">{{ __('piece.Report') }}</h3>
            </div>
            <div class="card-body">
           
    
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-center">{{ __('piece.info_title') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>{{ __('piece.name') }}</strong></td>
                            <td>{{ $piece->nom }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('piece.reference') }}</strong></td>
                            <td>{{ $piece->reference }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('piece.type') }}</strong></td>
                            <td>{{ $piece->type }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('piece.description') }}</strong></td>
                            <td>{{ $piece->description }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    



</body>
</html>
