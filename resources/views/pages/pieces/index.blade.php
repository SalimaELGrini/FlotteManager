@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">{{ __('piece.list_title') }}</h3>
                    @can('createPiece')
                        <a href="{{ route('pieces.create') }}" class="btn btn-light text-primary fw-bold">
                            + {{ __('piece.add') }}
                        </a>
                    @endcan
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="card-body">
                        <form id="search-form" class="d-flex justify-content-center mb-4" style="width: 100%;">
                            <div style="position: relative; max-width: 600px; width: 100%;">
                                <input 
                                    type="text" 
                                    id="search" 
                                    class="form-control" 
                                    placeholder="{{ __('piece.search_placeholder') }}" 
                                    autocomplete="off"
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
                            <table class="table align-items-center mb-0" id="pieces-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ __('piece.name') }}</th>
                                        <th class="text-center">{{ __('piece.reference') }}</th>
                                        <th class="text-center">{{ __('piece.type') }}</th>
                                        <th class="text-center">{{ __('piece.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pieces as $piece)
                                        <tr class="text-center piece-item">
                                            <td>{{ $piece->nom }}</td>
                                            <td>{{ $piece->reference }}</td>
                                            <td>{{ $piece->type }}</td>
                                            <td>
                                                @can('viewPiece')
                                                    <a href="{{ route('pieces.show', $piece->id) }}" class="btn btn-link p-2 fs-7" title="{{ __('piece.details') }}">
                                                        <i data-lucide="list-collapse"></i>
                                                    </a>
                                                @endcan
                                                @can('editPiece')
                                                    <a href="{{ route('pieces.edit', $piece->id) }}" class="btn btn-link p-2 fs-7 primary" title="{{ __('piece.edit') }}">
                                                        <i data-lucide="square-pen"></i>
                                                    </a>
                                                @endcan
                                                @can('deletePiece')
                                                    <form action="{{ route('pieces.destroy', $piece->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('piece.confirm_delete') }}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link p-2 fs-7 primary" title="{{ __('piece.delete') }}">
                                                            <i data-lucide="x"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                {{ __('piece.not_found') }} "<strong>{{ request('search') }}</strong>".
                                                <a href="{{ route('pieces.index') }}" class="btn btn-link">{{ __('piece.back') }}</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $pieces->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- JS pour la recherche -->
<script>
    $(document).ready(function() {
        $('#search-form').on('submit', function(e) {
            e.preventDefault(); // empêche le rechargement de la page

            let query = $('#search').val().toLowerCase();

            $('#pieces-table tbody tr').each(function() {
                let rowText = $(this).text().toLowerCase();
                $(this).toggle(rowText.includes(query));
            });
        });
    });
</script>

@endsection
