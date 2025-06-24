@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">{{ __('consommation.title') }}</h3>
                    <div>
                        @can('createFuelConsumption')
                            <a href="{{ route('fuel-consumption.create') }}" class="btn btn-light text-primary fw-bold">
                                {{ __('consommation.add') }}
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <x-alert-sweet />

                    <!-- Search and Filter Section -->
                    <div class="container mt-4">
                        <form method="GET" action="{{ route('fuel-consumption.index') }}">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-4">
                                    <input type="text" name="first_letter" class="form-control" placeholder="{{ __('consommation.search_vehicle') }}" value="{{ request(key: 'search') }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="date_filter" class="form-control" value="{{ request('date') }}">
                                </div>
                                <div class="col-md-3">
                                    <select name="period" class="form-control">
                                        <option value="">{{ __('consommation.period.all') }}</option>
                                        <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>{{ __('consommation.period.today') }}</option>
                                        <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>{{ __('consommation.period.week') }}</option>
                                        <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>{{ __('consommation.period.month') }}</option>
                                    </select>
                                    
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary fs-7 p-2">{{ __('consommation.search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Table of Fuel Consumption -->
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                   
                                    <th class="text-center">{{ __('consommation.vehicle') }}</th>
                                    <th class="text-center">{{ __('consommation.fuel') }}</th>
                                    <th class="text-center">{{ __('consommation.distance') }}</th>
                                    <th class="text-center">{{ __('consommation.date_fuel_added') }}</th>
                                    <th class="text-center">{{ __('consommation.efficiency') }}</th>
                                    <th class="text-center">{{ __('consommation.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($fuelConsumptions as $consumption)
                                    <tr>
                                      
                                        <td class="text-center">{{ $consumption->vehicule->matricule ?? __('consommation.unknown') }}</td>
                                        <td class="text-center">{{ $consumption->fuel_added }} L</td>
                                        <td class="text-center">{{ $consumption->distance_parcourue }} Km</td>
                                        <td class="text-center">{{ $consumption->date_fuel_added }} </td>
                                        <td class="text-center">
                                            @php
                                                $color = $consumption->fuel_efficiency > 10 ? '#DC3545' : '#01796F';
                                            @endphp
                                            <p class="btn btn-sm rounded-circle p-1" style="color: {{ $color }};">
                                                {{ $consumption->fuel_efficiency ?? __('consommation.not_specified') }}
                                            </p>
                                        </td>

                                        <td class="text-center">
                                            <a href="{{ route('fuel-consumption.show', $consumption->id) }}" class="btn btn-link primary p-2 fs-7" title="{{ __('consommation.details') }}">
                                                <i data-lucide="list-collapse"></i>
                                            </a>
                                            @can('editFuelConsumption')
                                                <a href="{{ route('fuel-consumption.edit', $consumption->id) }}" class="btn btn-link primary p-2 fs-7" title="{{ __('consommation.edit') }}">
                                                    <i data-lucide="square-pen"></i>
                                                </a>
                                            @endcan
                                            @can('deleteFuelConsumption')
                                                <form action="{{ route('fuel-consumption.destroy', $consumption->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('fuel.confirm_delete') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link primry p-2 fs-7" title="{{ __('consommation.delete') }}">
                                                        <i data-lucide="x"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            {{ __('consommation.no_result') }} "<strong>{{ request('search') }}</strong>".
                                            <a href="{{ route('fuel-consumption.index') }}" class="btn btn-link">{{ __('consommation.back') }}</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $fuelConsumptions->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


