@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">{{ __('drivers.drivers_list') }}</h3>
                    @can('createDriver')
                        <a href="{{ route('drivers.create') }}" class="btn btn-light text-primary fw-bold" >
                            {{ __('drivers.addl_driver') }}
                        </a>
                    @endcan
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <x-alert-sweet />

                    <div class="card-body">
                        <!-- Barre de recherche -->
                        <form action="{{ route('drivers.index') }}" method="GET" class="d-flex justify-content-center mb-4" style="width: 100%;">
                            <div style="position: relative; max-width: 600px; width: 100%;">
                                <input 
                                    type="text" 
                                    name="search" 
                                    class="form-control" 
                                    placeholder="{{ __('drivers.search_placeholder') }}" 
                                    value="{{ request('search') }}"
                                    style="height: 50px; border-radius: 12px; padding-right: 50px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);"
                                >
                                <button 
                                    type="submit"
                                    style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); border: none; background: none;"
                                >
                                    <i class="fas fa-search" style="font-size: 20px; color: #0070BB;"></i>
                                </button>
                            </div>
                        </form>
                        
                        <!-- Tableau des conducteurs -->
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ __('drivers.name') }}</th>
                                        <th class="text-center">{{ __('drivers.phone') }}</th>
                                        <th class="text-center">{{ __('drivers.status') }}</th>
                                        <th class="text-center">{{ __('drivers.license_type') }}</th>
                                        <th class="text-center">{{ __('drivers.license_number') }}</th>
                                        <th class="text-center">{{ __('drivers.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($drivers as $driver)
                                        <tr>
                                            <td class="text-center">{{ $driver->nom }}</td>
                                            <td class="text-center">{{ $driver->telephone }}</td>
                                            <td class="text-center">
                                                <span class="badge fs-7 p-2
                                                    @if($driver->status == 'disponible')" style="color: #01796F;" 
                                                    @elseif($driver->status == 'occupe')" style="color: #DC3545;" 
                                                    @elseif($driver->status == 'en pause')" style="color: #00A8E8;" 
                                                    @elseif($driver->status == 'non disponible')" style="color: #6C757D;" 
                                                    @endif
                                                ">
                                                    {{ $driver->status }}
                                                </span>
                                            </td>
                                            <td class="text-center">{{ $driver->type_permis }}</td>
                                            <td class="text-center">{{ $driver->numero_permis }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('drivers.show', $driver->id) }}" class="btn btn-link primary p-2 fs-7"  title="{{ __('drivers.details') }}"><i data-lucide="list-collapse"></i></a>
                                                <a href="{{ route('drivers.edit', $driver->id) }}" class="btn btn-link p-2 fs-7 primary" title="{{ __('drivers.edit') }}"><i data-lucide="square-pen"></i></a>
                                                @can('deleteDriver')
                                                    <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('drivers.delete_confirm') }}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link primry p-2 fs-7" title="{{ __('drivers.delete') }}"> <i data-lucide="x"></i></button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                {{ __('drivers.no_drivers_found') }} "<strong>{{ request('search') }}</strong>".
                                                <a href="{{ route('drivers.index') }}" class="btn btn-link">{{ __('drivers.back') }}</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $drivers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

