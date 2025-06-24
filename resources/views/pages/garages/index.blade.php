@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">{{ __('garage.list_title') }}</h3>
                    <a href="{{ route('garages.create') }}" class="btn btn-light text-primary fw-bold">
                        + {{ __('garage.add_garage') }}
                    </a>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <x-alert-sweet />

                    <div class="card-body">
                        <form action="{{ route('garages.index') }}" method="GET" class="d-flex justify-content-center mb-4" style="width: 100%;">
                            <div style="position: relative; max-width: 600px; width: 100%;">
                                <input 
                                    type="text" 
                                    name="search" 
                                    class="form-control" 
                                    placeholder="{{ __('garage.search_placeholder') }}" 
                                    value="{{ request('search') }}"
                                    style="height: 50px; border-radius: 12px; padding-right: 50px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);"
                                >
                                <button 
                                    type="submit"
                                    style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); border: none; background: none; padding: 0; margin: 0;"
                                >
                                    <i class="fas fa-search" style="font-size: 20px; color: #0070BB;"></i>
                                </button>
                            </div>
                        </form>

                        <!-- Tableau des garages -->
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        
                                        <th class="text-center">{{ __('garage.name') }}</th>
                                        <th class="text-center">{{ __('garage.address') }}</th>
                                        <th class="text-center">{{ __('garage.phone') }}</th>
                                        <th class="text-center">{{ __('garage.email') }}</th>
                                        <th class="text-center">{{ __('garage.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($garages as $garage)
                                        <tr>
                                           
                                            <td class="text-center">{{ $garage->name }}</td>
                                            <td class="text-center">{{ $garage->address }}</td>
                                            <td class="text-center">{{ $garage->phone }}</td>
                                            <td class="text-center">{{ $garage->email }}</td>
                                            <td class="text-center">
                                                <!-- Bouton Voir -->
                                                <a href="{{ route('garages.show', $garage->id) }}" class="btn btn-link primry p-2 fs-7" title="{{ __('garage.details') }}">
                                                    <i data-lucide="list-collapse"></i>
                                                </a>
                                                <!-- Bouton Modifier -->
                                                <a href="{{ route('garages.edit', $garage->id) }}" class="btn btn-link primry p-2 fs-7" title="{{ __('garage.edit') }}">
                                                    <i data-lucide="square-pen"></i>
                                                </a>
                                                @can('deleteGarage')
                                                    <!-- Supprimer -->
                                                    <form action="{{ route('garages.destroy', $garage->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('garage.confirm_delete') }}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link  p-2 fs-7 primry" title="{{ __('garage.delete') }}">
                                                            <i data-lucide="x"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                {{ __('garage.no_results') }} "<strong>{{ request('search') }}</strong>".
                                                <a href="{{ route('garages.index') }}" class="btn btn-link">{{ __('garage.back') }}</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $garages->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection









