<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Intervention;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        $totalInterventions = Intervention::count();

        $stats = [
            
            'interventionsByType' => Intervention::join('type_interventions', 'interventions.type_intervention_id', '=', 'type_interventions.id')
                ->select('type_interventions.name as type', DB::raw('COUNT(interventions.id) as total'))
                ->groupBy('type_interventions.name')
                ->pluck('total', 'type')
                ->mapWithKeys(function ($value, $key) use ($totalInterventions) {
                    $percentage = ($totalInterventions > 0) ? round(($value / $totalInterventions) * 100, 2) : 0;
                    return [$key => $percentage];
                }),

            
            'interventionsByMonth' => Intervention::select(DB::raw("DATE_FORMAT(date_intervention, '%Y-%m') as month"), DB::raw('COUNT(id) as total'))
                ->groupBy('month')
                ->pluck('total', 'month'),

            
            'costsByMonth' => Intervention::select(DB::raw("DATE_FORMAT(date_intervention, '%Y-%m') as month"), DB::raw('SUM(total_cost) as total'))
                ->groupBy('month')
                ->pluck('total', 'month'),

            
            'interventionsByVehicule' => Intervention::join('vehicules', 'interventions.vehicule_id', '=', 'vehicules.id')
                ->select('vehicules.matricule as vehicule', DB::raw('COUNT(interventions.id) as total'))
                ->groupBy('vehicules.matricule')
                ->pluck('total', 'vehicule'),

            
            'interventionsByTechnician' => Intervention::select('nom_technician', DB::raw('COUNT(id) as total'))
            ->whereNotNull('nom_technician')
            ->groupBy('nom_technician')
            ->pluck('total', 'nom_technician'),

            'averageTimeBetweenRepairs' => DB::table('interventions as i1')
            ->select(DB::raw('AVG(diff_days) as avg_days'))
            ->fromSub(function ($query) {
                $query->select('i1.id', DB::raw('DATEDIFF(i1.date_intervention, i2.date_intervention) as diff_days'))
                    ->from('interventions as i1')
                    ->leftJoin('interventions as i2', function ($join) {
                        $join->on('i1.vehicule_id', '=', 'i2.vehicule_id')
                            ->on('i1.date_intervention', '>', 'i2.date_intervention');
                    })
                    ->whereNotNull('i2.date_intervention');
            }, 'subquery')
            ->value('avg_days') ?? 0,


            
            'reliabilityScore' => Intervention::select(DB::raw('COUNT(id) / (SELECT COUNT(DISTINCT vehicule_id) FROM interventions) as score'))
                ->value('score') ?? 0,
        ];

        return view('pages.statistics.index', compact('stats'));
    }
}
