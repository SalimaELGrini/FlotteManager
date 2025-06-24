<!DOCTYPE html>
<html lang="{{ $locale ?? app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <title>{{ __('garage.Report') }}</title>
</head>
<body>
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header text-white text-center" style="background-color: #0070BB;">
            <h3 class="mb-0">{{ __('garage.Report') }}</h3>
        </div>
        <div class="card-body">
           

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center">{{ __('garage.info_title') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>{{ __('garage.name') }}</strong></td>
                        <td>{{ $garage->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('garage.address') }}</strong></td>
                        <td>{{ $garage->address }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('garage.phone') }}</strong></td>
                        <td>{{ $garage->phone ?? __('garage.not_specified') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('garage.email') }}</strong></td>
                        <td>{{ $garage->email ?? __('garage.not_specified') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('garage.specializations') }}</strong></td>
                        <td>{{ $garage->specializations ?? __('garage.not_specified_plural') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>