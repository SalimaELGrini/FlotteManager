@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Liste des Neussites</h3>
            <a href="{{ route('neussites.create') }}" class="btn btn-light text-primary fw-bold">+ Ajouter</a>
        </div>
        <x-alert-sweet />

        <div class="card-body">
            <!-- Barre de recherche -->
            <form action="{{ route('neussites.index') }}" method="GET" class="mb-4">
                <div class="row">
                    <!-- Recherche par nom_technicien -->
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control" placeholder="Rechercher par technicien..." value="{{ request('search') }}">
                    </div>
            
                    <!-- Recherche par date_change -->
                    <div class="col-md-4">
                        <input type="date" name="date_change" class="form-control" value="{{ request('date_change') }}">
                    </div>
            
                    <!-- Bouton de recherche -->
                    <div class="col-md-3">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Rechercher
                        </button>
                    </div>
                </div>
            </form>
            

            <!-- Tableau des Neussites -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Intervention</th>
                            <th>Pièce</th>
                            <th>Date de Changement</th>
                            <th>Status</th>
                            <th>Prix Pièce</th>
                            <th>Technicien</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($neussites as $neussite)
                            <tr>
                                <td>{{ $neussite->id }}</td>
                                <td>{{ $neussite->intervention->id }}</td>
                                <td>{{ $neussite->piece->id }}</td>
                                <td>{{ $neussite->date_change }}</td>
                                <td>
                                    <span class="badge 
                                        @if($neussite->status == 'pending') bg-warning 
                                        @elseif($neussite->status == 'completed') bg-success 
                                        @else bg-info @endif">
                                        {{ ucfirst($neussite->status) }}
                                    </span>
                                </td>
                                <td>{{ number_format($neussite->prix_piece, 2) }} MAD</td>
                                <td>{{ $neussite->nom_technicien }}</td>
                                <td class="text-center">
                                    <a href="{{ route('neussites.show', $neussite->id) }}" class="btn btn-info btn-sm">Voir</a>
                                    <a href="{{ route('neussites.edit', $neussite->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                                    <form action="{{ route('neussites.destroy', $neussite->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    Aucun enregistrement trouvé.
                                    <a href="{{ route('neussites.index') }}" class="btn btn-link">Retour</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $neussites->links() }}
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #007bff;
        color: white;
        padding: 1rem;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .table th {
        font-weight: 600;
        background-color: #f8f9fa;
    }

    .table td {
        vertical-align: middle;
    }

    .btn {
        border-radius: 50px;
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }

    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-light {
        background-color: white;
        border: 1px solid #007bff;
        color: #007bff;
    }

    .btn-light:hover {
        background-color: #007bff;
        color: white;
    }

    .table-responsive {
        overflow-x: auto;
    }
</style>
@endpush
@endsection
