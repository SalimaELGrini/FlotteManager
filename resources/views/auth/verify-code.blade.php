@extends('layouts.app')

@section('content')
<div class="container">
    <h3>🔐 Vérifiez votre email</h3>
    <form method="POST" action="{{ route('verify.code') }}">
        @csrf
        <input type="hidden" name="email" value="{{ session('email') }}">
        <input type="text" name="code" placeholder="Code reçu par email" class="form-control mb-2" required>
        <button class="btn btn-success">Vérifier le code</button>
    </form>
</div>
@endsection
