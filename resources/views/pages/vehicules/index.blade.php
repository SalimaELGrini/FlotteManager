@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">{{ __('vehicule.list_title') }}</h3>
                    @can('createVehicule')
                        <a href="{{ route('vehicules.create') }}" class="btn btn-light text-primary fw-bold">
                            {{ __('vehicule.add_vehicle') }}
                        </a>
                    @endcan
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <x-alert-sweet />

                    <div class="card-body">
                        <form action="{{ route('vehicules.index') }}" method="GET" class="d-flex justify-content-center mb-4" style="width: 100%;">
                            <div style="position: relative; max-width: 600px; width: 100%;">
                                <input
                                    type="text"
                                    name="search"
                                    class="form-control"
                                    placeholder="{{ __('vehicule.search_placeholder') }}"
                                    value="{{ request('search') }}"
                                    style="height: 50px; border-radius: 12px; padding-right: 50px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);"
                                >
                                <button
                                    type="submit"
                                    style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); border: none; background: none; padding: 0; margin: 0;"
                                >
                                    <i class="fa fa-search" style="font-size: 20px; color: #0070BB;"></i>
                                </button>
                            </div>
                        </form>

                        <!-- Table of Vehicles -->
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ __('vehicule.number') }}</th>
                                        <th class="text-center">{{ __('vehicule.model') }}</th>
                                        <th class="text-center">{{ __('vehicule.plate') }}</th>
                                        <th class="text-center">{{ __('vehicule.status') }}</th>
                                        <th class="text-center">{{ __('vehicule.fuel') }}</th>
                                        <th class="text-center">{{ __('vehicule.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($vehicules as $vehicule)
                                        <tr>
                                            <td class="text-center">{{ $vehicule->numero }}</td>
                                            <td class="text-center">{{ $vehicule->modele }}</td>
                                            <td class="text-center">{{ $vehicule->matricule }}</td>
                                            <td class="text-center">
                                                <span class="badge  fs-7 p-2
                                                    @if($vehicule->status == 'Disponible')" style="color: #00A8E8;"
                                                    @elseif($vehicule->status == 'En Réparation')" style="color: #DC3545;"
                                                    @elseif($vehicule->status == 'Indisponible')" style="color: #6C757D;"
                                                    @endif
                                                ">
                                                    {{ $vehicule->status }}
                                                </span>
                                            </td>
                                            <td class="text-center">{{ $vehicule->type_carburant}}</td>
                                            <td class="text-center">
                                                <button class="btn btn-link p-2 fs-7 open-modal"
                                                            data-bs-toggle="modal"
                                                            style="color:#0070BB;"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="{{ __('vehicule.assign_vehicle') }}"
                                                            data-bs-target="#assignmentModal"
                                                            data-vehicule-id="{{ $vehicule->id }}"
                                                >
                                                            <i data-lucide="plus"></i>
                                                 </button>
                                                <a href="{{ route('vehicules.show', $vehicule->id) }}"class="btn btn-link p-2 fs-7 primary" title="{{ __('vehicule.details') }}">
                                                    <i data-lucide="list-collapse"></i>
                                                     </a>
                                                @can('editVehicule')
                                                    <a href="{{ route('vehicules.edit', $vehicule->id) }}" class="btn btn-link p-2 fs-7 primary" title="{{ __('vehicule.edit') }}">
                                                        <i data-lucide="square-pen"></i>
                                                    </a>
                                                @endcan

                                                @can('deleteVehicule')
                                                    <form action="{{ route('vehicules.destroy', $vehicule->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('vehicule.confirm_delete') }}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"  class="btn btn-link p-2 fs-7 primary"  title="{{ __('vehicule.delete') }}">
                                                            <i data-lucide="x"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                {{ __('vehicule.no_vehicles_found') }} "<strong>{{ request('search') }}</strong>".
                                                <a href="{{ route('vehicules.index') }}" class="btn btn-link">{{ __('vehicule.cancel') }}</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $vehicules->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('pages.vehicules.modals')

<script>
    const assignmentStoreRoute = "{{ route('assignments.store') }}";
</script>

<script src="{{ asset('assets/js/vehicules.js') }}"></script>


@endsection
