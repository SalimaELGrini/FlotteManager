@extends('layouts.admin', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Admin Dashboard'])

<div class="container-fluid py-4 d-flex flex-column" style="min-height: 100vh;">

<style>
    .stat-card {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border-radius: 12px;
        transition: all 0.3s ease-in-out;
        padding: 16px;
        height: 100%;
        min-height: 120px;
    }

    .stat-card:hover {
        transform: translateY(-4px);
    }

    .icon-container {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 18px;
        color: white;
    }

    .card-header h6 {
        font-size: 16px;
        font-weight: 600;
        color: #0070BB;
    }

    .card-header p {
        font-size: 12px;
        color: #6c757d;
    }

    .breadcrumb-container {
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .breadcrumb-container h6 {
        font-weight: 700;
        font-size: 20px;
        margin-bottom: 5px;
    }

    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 0;
    }

    .breadcrumb a {
        color: #0070BB;
        text-decoration: none;
    }

    .breadcrumb a:hover {
        text-decoration: underline;
    }
</style>

@php
    $reliabilityScore = round($stats['reliabilityScore'], 2);

    if ($reliabilityScore < 1.5) {
        $reliabilityColor = '#28a745'; 
        $reliabilityLabel =  __('dashboard.reliability_high');
    } elseif ($reliabilityScore < 3) {
        $reliabilityColor = '#ffc107'; 
        $reliabilityLabel = __('dashboard.reliability_medium');
    } else {
        $reliabilityColor = '#dc3545'; 
        $reliabilityLabel = __('dashboard.reliability_low');
    }

    $statsData = [
        [
            'title' => __('dashboard.reliability_index'),
            'value' => $reliabilityScore,
            'label' => $reliabilityLabel,
            'icon' => 'fas fa-shield-alt',
            'bgColor' => '#0070BB',
            'color' => $reliabilityColor
        ],
        [
            'title' => __('dashboard.total_breakdowns'),
            'value' => $pannesCount,
            'label' => '',
            'icon' => 'fas fa-tools',
            'bgColor' => '#00A9E0',
            'color' => '#000000'
        ],
        [
            'title' => __('dashboard.fuel_consumed'),
            'value' => $totalFuel . ' L',
            'label' => '',
            'icon' => 'fas fa-gas-pump',
            'bgColor' => '#008DD5',
            'color' => '#000000'
        ],
    ];
@endphp

<div class="row g-4 mb-4 flex-grow-1">
    @foreach ($statsData as $stat)
    <div class="col-md-4 d-flex">
        <div class="card stat-card border-0 w-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted text-uppercase fw-semibold mb-1">{{ $stat['title'] }}</p>
                    <h4 class="fw-bold mb-0" style="color: {{ $stat['color'] }}">
                        {{ $stat['value'] }}
                        @if($stat['label'])
                            <small class="ms-2 fw-semibold" style="font-size: 0.75rem;">({{ $stat['label'] }})</small>
                        @endif
                    </h4>
                </div>
                <div class="icon-container shadow-sm" style="background-color: {{ $stat['bgColor'] }};">
                    <i class="{{ $stat['icon'] }}"></i>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@php 
    $charts = [
    ['id' => 'fuelCostsByMonthChart', 'title' => 'Dépenses de Carburant', 'desc' => 'Coût mensuel du carburant', 'icon' => 'fa fa-gas-pump', 'iconColor' => 'text-primary'],
    ['id' => 'costByMonthChart', 'title' => 'Coût des Interventions', 'desc' => 'Dépenses mensuelles', 'icon' => 'fa fa-dollar-sign', 'iconColor' => 'text-primary'],
    ['id' => 'interventionsByMonthChart', 'title' => 'Interventions par Mois', 'desc' => 'Évolution des interventions', 'icon' => 'fa fa-chart-line', 'iconColor' => 'text-primary'],
    ['id' => 'interventionsByVehicleChart', 'title' => 'Interventions par Véhicule', 'desc' => 'Nombre d\'interventions', 'icon' => 'fa fa-car', 'iconColor' => 'text-primary'],
    ['id' => 'interventionsByTypeChart', 'title' => 'Interventions par Type', 'desc' => 'Répartition des interventions', 'icon' => 'fa fa-cogs', 'iconColor' => 'text-primary'],
];


@endphp

<div class="container py-4">
    <div class="row g-4 flex-grow-1">
        @foreach ($charts as $chart)
            <div class="@if($chart['id'] == 'interventionsByTypeChart') col-md-12 @else col-md-6 @endif mb-4">
                <div class="card shadow-sm border-0 p-3 h-100 @if($chart['id'] == 'interventionsByTypeChart') large-chart-card @endif">
                    <div class="card-header bg-transparent pb-0">
                        <h6 class="">{{ $chart['title'] }}</h6>
                        <p class="mb-0 small">
                            <i class="{{ $chart['icon'] }} {{ $chart['iconColor'] }}"></i>
                            <span class="font-weight-bold">{{ $chart['desc'] }}</span>
                        </p>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <canvas id="{{ $chart['id'] }}"></canvas>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
   const dualColors = [
  '#0070BB', 
  '#008DD5',
  '#00A9E0',
  '#00C2F0',
  '#00D9FF',
  '#33E3FF',
  '#66EDFF',
  '#99F5FF',
  '#CCFBFF',
  '#E5FDFF',
  '#F2FEFF',
  '#FFFFFF'
];


    function createChart(id, type, labels, data, label, bgColors, borderColors, formatTooltip, indexAxis = 'x') {
        const ctx = document.getElementById(id).getContext("2d");
        new Chart(ctx, {
            type: type,
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    backgroundColor: bgColors,
                    borderColor: borderColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                indexAxis: indexAxis,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: formatTooltip
                        }
                    },
                    legend: {
                        position: type === 'doughnut' ? 'right' : 'top'
                    }
                },
                scales: type === 'doughnut' ? {} : {
                    y: { beginAtZero: true }
                }
            }
        });
    }

   

    // Interventions By Month Chart
    createChart("interventionsByMonthChart", "bar", 
        @json(array_keys($interventionsByMonth->toArray())), 
        @json(array_values($interventionsByMonth->toArray())), 
        "Interventions", dualColors,
        dualColors,
        (tooltipItem) => tooltipItem.raw + " interventions"
    );

    // Interventions By Type Chart (Doughnut Chart)
    createChart("interventionsByTypeChart", "doughnut", 
    @json(array_keys($interventionsByType->toArray())), 
    @json(array_values($interventionsByType->toArray())), 
    "Interventions par Type", 
    ['#0070BB', '#00A9E0', '#33E3FF'], 
    ['#0070BB', '#00A9E0', '#33E3FF'],
    (tooltipItem) => tooltipItem.raw + " %"
);

    // Fuel Costs By Month Chart
    createChart("fuelCostsByMonthChart", "bar", 
        @json(array_keys($fuelCostsByMonth->toArray())), 
        @json(array_values($fuelCostsByMonth->toArray())), 
        "Carburant (DH)", dualColors,
        dualColors,
        (tooltipItem) => tooltipItem.raw + " DH"
    );
// Interventions By Vehicle Chart
    createChart(
    "costByMonthChart", 
    "bar", 
    @json(array_keys($costsByMonth->toArray())), 
    @json(array_values($costsByMonth->toArray())), 
    "Coût", 
    dualColors,
    dualColors,
    (tooltipItem) => tooltipItem.raw + " DH"
);

    createChart(
    "interventionsByVehicleChart", 
    "bar", 
    @json(array_keys($interventionsByVehicule->toArray())), 
    @json(array_values($interventionsByVehicule->toArray())), 
    "Interventions", 
    dualColors,
    dualColors,
    (tooltipItem) => tooltipItem.raw + " interventions"
);

    
</script>

<!-- Style -->
<style>
    .small-chart-card {
        padding: 10px;
    }
    #interventionsByTypeChart {
        max-width: 350px;
        max-height: 350px;
    }
    .card-body {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>



</div>
@endsection

