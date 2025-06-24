@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100']) 

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">{{ __('type_intervention.list_title') }}</h3>
            @can('createTypeIntervention')
                <a href="{{ route('type_interventions.create') }}" class="btn btn-light text-primary fw-bold">
                    + {{ __('type_intervention.add') }}
                </a>
            @endcan
        </div>

        <div class="card-body">
            <x-alert-sweet />

            <form action="{{ route('type_interventions.index') }}" method="GET" class="d-flex justify-content-center mb-4" style="width: 100%;">
                <div style="position: relative; max-width: 600px; width: 100%;">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control" 
                        placeholder="{{ __('type_intervention.search_placeholder') }}" 
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

            <!-- Tableau des types d'interventions -->
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">{{ __('type_intervention.name') }}</th>
                            <th class="text-center">{{ __('type_intervention.description') }}</th>
                            <th class="text-center">{{ __('type_intervention.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($types as $type)
                            <tr>
                                <td class="text-center">{{ $type->name }}</td>
                                <td class="text-center">{{ $type->description ?? __('type_intervention.not_specified') }}</td>
                                <td class="text-center">
                                    @can('viewTypeIntervention')
                                        <a href="{{ route('type_interventions.show', $type->id) }}" class="btn btn-link p-2 fs-7 primary" title="{{ __('type_intervention.details') }}">
                                            <i data-lucide="list-collapse"></i>
                                        </a>
                                    @endcan

                                    @can('editTypeIntervention')
                                        <a href="{{ route('type_interventions.edit', $type->id) }}" class="btn btn-link p-2 fs-7 primay" title="{{ __('type_intervention.edit') }}">
                                            <i data-lucide="square-pen"></i>
                                        </a>
                                    @endcan

                                    @can('deleteTypeIntervention')
                                        <form action="{{ route('type_interventions.destroy', $type->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('type_intervention.confirm_delete') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link p-2 fs-7 primary" title="{{ __('type_intervention.delete') }}">
                                                <i data-lucide="x"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    {{ __('type_intervention.no_results') }} "<strong>{{ request('search') }}</strong>".
                                    <a href="{{ route('type_interventions.index') }}" class="btn btn-link">{{ __('type_intervention.back') }}</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $types->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
</body>
</html>