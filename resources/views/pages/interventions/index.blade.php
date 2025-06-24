@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">{{ __('intervention.list_title') }}</h3>
                    <a href="{{ route('interventions.create') }}" class="btn btn-light text-primary fw-bold">
                        + {{ __('intervention.add_intervention') }}
                    </a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <x-alert-sweet />
                    <div class="container mt-4">
                        <form method="GET" action="{{ route('interventions.index') }}">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-4">
                                    <select name="modele" class="form-control me-2">
                                        <option value="all">{{ __('intervention.all_models') }}</option>
                                        @foreach($vehicules as $vehicule)
                                            <option value="{{ $vehicule->modele }}" {{ request('modele') == $vehicule->modele ? 'selected' : '' }}>
                                                {{ $vehicule->modele }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="type_name" class="form-control me-2">
                                        <option value="all">{{ __('intervention.all_types') }}</option>
                                        @foreach($typesInterventions as $type)
                                            <option value="{{ $type->name }}" {{ request('type_name') == $type->name ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="date_range" class="form-control me-2">
                                        <option value="all">{{ __('intervention.all_periods') }}</option>
                                        <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>{{ __('intervention.today') }}</option>
                                        <option value="yesterday" {{ request('date_range') == 'yesterday' ? 'selected' : '' }}>{{ __('intervention.yesterday') }}</option>
                                        <option value="last_2_days" {{ request('date_range') == 'last_2_days' ? 'selected' : '' }}>{{ __('intervention.last_2_days') }}</option>
                                        <option value="last_3_days" {{ request('date_range') == 'last_3_days' ? 'selected' : '' }}>{{ __('intervention.last_3_days') }}</option>
                                        <option value="last_7_days" {{ request('date_range') == 'last_7_days' ? 'selected' : '' }}>{{ __('intervention.last_7_days') }}</option>
                                        <option value="last_month" {{ request('date_range') == 'last_month' ? 'selected' : '' }}>{{ __('intervention.last_month') }}</option>
                                        <option value="last_2months" {{ request('date_range') == 'last_2months' ? 'selected' : '' }}>{{ __('intervention.last_2_months') }}</option>
                                        <option value="last_year" {{ request('date_range') == 'last_year' ? 'selected' : '' }}>{{ __('intervention.last_year') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-1 d-grid">
                                    <button type="submit" class="btn btn-primary fs-7 p-1">{{ __('intervention.search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ __('intervention.vehicle') }}</th>
                                    <th class="text-center">{{ __('intervention.intervention_type') }}</th>
                                    <th class="text-center">{{ __('intervention.duration') }}</th>
                                    <th class="text-center">{{ __('intervention.total_cost') }}</th>
                                    <th class="text-center">{{ __('intervention.technician') }}</th>
                                    <th class="text-center">{{ __('intervention.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($interventions as $intervention)
                                    <tr>
                                        <td class="text-center">{{ $intervention->vehicule->modele }}</td>
                                        <td class="text-center">
                                            <span class="badge fs-7 p-2" style="color: {{ strtolower($intervention->typeIntervention->name ?? '') == 'vidonge' ? '#00A8E8' : (strtolower($intervention->typeIntervention->name ?? '') == 'reparation' ? '#DC3545' : (strtolower($intervention->typeIntervention->name ?? '') == 'visite technique' ? '#6C757D' : '#00A8E8')) }};">
                                                {{ $intervention->typeIntervention->name ?? __('intervention.unknown_type') }}
                                            </span>
                                        </td>
                                        <td class="text-center">{{ $intervention->duration }}</td>
                                        <td class="text-center">{{ $intervention->total_cost }} DH</td>
                                        <td class="text-center">{{ $intervention->nom_technician }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-link primary p-2 fs-7 open-modal" data-bs-toggle="modal" data-bs-target="#neussiteModal" title="{{ __('intervention.add_piece') }}" data-intervention-id="{{ $intervention->id }}">
                                                <i data-lucide="plus"></i>
                                            </button>
                                            <a href="{{ route('interventions.show', $intervention->id) }}" class="btn btn-link primary p-2 fs-7" title="{{ __('intervention.details') }}">
                                                <i data-lucide="list-collapse"></i>
                                            </a>
                                            <a href="{{ route('interventions.edit', $intervention->id) }}" class="primary btn btn-link p-2 fs-7" title="{{ __('intervention.edit') }}">
                                                <i data-lucide="square-pen"></i>
                                            </a>
                                            @can('deleteIntervention')
                                                <form action="{{ route('interventions.destroy', $intervention->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('intervention.confirm_delete') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link primary p-2 fs-7" title="{{ __('intervention.delete') }}">
                                                        <i data-lucide="x"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            {{ __('intervention.no_results', ['search' => request('search')]) }}
                                            <a href="{{ route('interventions.index') }}" class="btn btn-link">{{ __('intervention.cancel') }}</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">{{ $interventions->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>


    {{-- inclusion modal --}}
@include('pages.interventions.partials.neussite_modal')
    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('assets/js/intervention.js') }}"></script>





@endsection