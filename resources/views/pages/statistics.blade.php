<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
<div class="row mt-4">
<div class="col-lg-5 mb-3">
    <div class="card shadow-sm p-3">
        <div class="card-header pb-0 pt-3 bg-transparent">
            <h6 class="text-capitalize  modules">Répartition des Interventions par Type</h6>
            <p class="text-sm mb-0">
                <i class="fa fa-pie-chart text-info"></i>
                <span class="font-weight-bold">Types d'interventions</span>
            </p>
        </div>
        <div class="card-body">
            <canvas id="interventionsByType"></canvas>
        </div>
    </div>
</div>


    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm p-3">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize modules ">Répartition des Interventions par Type</h6>
                <p class="text-sm mb-0">
                    <i class="fa fa-pie-chart text-info"></i>
                    <span class="font-weight-bold">Types d'interventions</span>
                </p>
            </div>
            <div class="card-body">
                <canvas id="interventionsByTechnician"></canvas>
            </div>
        </div>
    </div>
    
   
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm p-3">
                <div class="card-header pb-0 pt-3 bg-transparent">

                    <h6 class="text-capitalize modules">Répartition des Interventions par Type</h6>
                    <p class="text-sm mb-0">
                        <i class="fa fa-pie-chart text-info"></i>
                        <span class="font-weight-bold">Types d'interventions</span>
                    </p>
                </div>
                <div class="card-body">
                    <canvas id="averageTimeBetweenRepairs"></canvas>
                </div>
            </div>
        </div>
        </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function createChart(id, type, labels, data, label, bgColors, borderColors, formatTooltip) {
        var ctx = document.getElementById(id).getContext("2d");
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
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    //  Interventions par Type (Doughnut Chart)
    createChart("interventionsByType", "doughnut", 
        @json(array_keys($interventionsByType->toArray())), 
        @json(array_values($interventionsByType->toArray())), 
        "Répartition des Interventions", 
        ["rgba(255, 99, 132, 0.5)", "rgba(54, 162, 235, 0.5)", "rgba(255, 206, 86, 0.5)"], 
        ["rgba(255, 99, 132, 1)", "rgba(54, 162, 235, 1)", "rgba(255, 206, 86, 1)"],
        (tooltipItem) => tooltipItem.raw + "%"
    );

    //  Interventions par Technicien (Bar Chart)
    createChart("interventionsByTechnician", "bar", 
        @json(array_keys($interventionsByTechnician->toArray())), 
        @json(array_values($interventionsByTechnician->toArray())), 
        "Interventions par Technicien", 
        ["rgba(75, 192, 192, 0.5)"], 
        ["rgba(75, 192, 192, 1)"],
        (tooltipItem) => tooltipItem.raw + " interventions"
    );

    //  Gauge Chart pour le temps moyen entre réparations
    function createGaugeChart(id, value, maxValue) {
        var ctx = document.getElementById(id).getContext("2d");
        new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: ["Temps Moyen", "Reste"],
                datasets: [{
                    data: [value, maxValue - value],
                    backgroundColor: ["rgba(54, 162, 235, 0.8)", "rgba(200, 200, 200, 0.3)"],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                circumference: 180,
                rotation: 270,
                cutout: "80%",
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: (tooltipItem) => tooltipItem.raw + " jours"
                        }
                    }
                }
            }
        });
    }

    createChart("averageTimeBetweenRepairs", "bar", 
    @json(array_keys($averageTimeBetweenRepairs->toArray())), 
    @json(array_values($averageTimeBetweenRepairs->toArray())), 
    "Temps Moyen Entre Réparations", 
    "rgba(255, 159, 64, 0.5)", 
    "rgba(255, 159, 64, 1)",
    (tooltipItem) => tooltipItem.raw + " jours"
);
</script>

