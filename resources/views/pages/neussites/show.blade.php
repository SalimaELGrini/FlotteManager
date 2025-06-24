@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-info text-white text-center">
            <h3 class="mb-0">Détails de la Neussite</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Intervention :</strong></p>
                    <h5>{{ $neussite->intervention->nom ?? 'Non spécifié' }}</h5>
                </div>
                <div class="col-md-6">
                    <p><strong>Pièce :</strong></p>
                    <h5>{{ $neussite->piece->nom ?? 'Non spécifiée' }}</h5>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Date de Changement :</strong></p>
                    <h5>{{ $neussite->date_change }}</h5>
                </div>
                <div class="col-md-6">
                    <p><strong>Statut :</strong></p>
                    <h5>{{ ucfirst($neussite->status) }}</h5>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Prix de la Pièce :</strong></p>
                    <h5>{{ $neussite->prix_piece }} MAD</h5>
                </div>
                <div class="col-md-6">
                    <p><strong>Nom du Technicien :</strong></p>
                    <h5>{{ $neussite->nom_technicien }}</h5>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{ route('neussites.index') }}" class="btn btn-secondary btn-lg">Retour à la liste</a>
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
        background-color: #17a2b8;
        color: white;
        padding: 1rem;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .form-label {
        font-weight: 600;
    }

    .form-control {
        border-radius: 8px;
        padding: 0.75rem;
        font-size: 1rem;
    }

    .btn {
        border-radius: 50px;
        font-size: 1rem;
        padding: 0.6rem 2.5rem;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .card-body {
        padding: 1.5rem;
    }
</style>
@endpush
@endsection
