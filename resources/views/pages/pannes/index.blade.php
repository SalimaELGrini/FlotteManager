@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">{{ __('panne.list_title') }}</h3>
                    @can('managePanne')
                        <a href="{{ route('pannes.create') }}" class="btn btn-light text-primary fw-bold">
                            + {{ __('panne.add') }}
                        </a>
                    @endcan
                </div>

                <x-alert-sweet />

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="card-body">
                        <form action="{{ route('pannes.index') }}" method="GET" class="d-flex justify-content-center mb-4" style="width: 100%;">
                            <div style="position: relative; max-width: 600px; width: 100%;">
                                <input
                                    type="text"
                                    name="search"
                                    class="form-control"
                                    placeholder="{{ __('panne.search_placeholder') }}"
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

                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ __('panne.vehicle') }}</th>
                                        <th class="text-center">{{ __('panne.resolved') }}</th>
                                        <th class="text-center">{{ __('panne.date') }}</th>
                                        <th class="text-center">{{ __('panne.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pannes as $panne)
                                        <tr>
                                            <td class="text-center">{{ $panne->vehicule->numero ?? 'N/A' }}</td>
                                            <td class="text-center">
                                                @if($panne->resolved)
                                                    <span class="badge" style="color:#0093AF;">{{ __('panne.yes') }}</span>
                                                @else
                                                    <span class="badge" style="color:#DC3545;">{{ __('panne.no') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $panne->date_panne->format('Y-m-d') }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('pannes.show', $panne->id) }}" class="btn btn-link primary p-2 fs-7" title="{{ __('panne.details') }}">
                                                    <i data-lucide="list-collapse"></i>
                                                </a>
                                                @can('managePanne')
                                                    <a href="{{ route('pannes.edit', $panne->id) }}" class="btn btn-link p-2 fs-7 primary" title="{{ __('panne.edit') }}">
                                                        <i data-lucide="square-pen"></i>
                                                    </a>
                                                @endcan
                                                @can('delete-pannes')
                                                    <form action="{{ route('pannes.destroy', $panne->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('panne.confirm_delete') }}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link primary p-2 fs-7" title="{{ __('panne.delete') }}">
                                                            <i data-lucide="x"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                {{ __('panne.no_results') }} "<strong>{{ request('search') }}</strong>".
                                                <a href="{{ route('pannes.index') }}" class="btn btn-link">{{ __('panne.back') }}</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $pannes->appends(request()->query())->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

