@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

    <div class="card shadow-lg mx-4 card-profile-bottom mt-4">
        <div class="card-body p-3">
            <div class="row gx-4 align-items-center">
                <div class="col-auto">
                    
                </div>
                <div class="col">
                    <div class="d-flex flex-column justify-content-center">
                        <h5 class="mb-0 text-capitalize" style="color:#0070BB;">
                            {{ auth()->user()->firstname ?? 'Prénom' }} {{ auth()->user()->lastname ?? 'Nom' }}
                        </h5>
                        <p class="text-sm text-secondary mb-0">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="alert">
        @include('components.alert')
    </div>

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 text-uppercase text-dark">{{ __('profile.edit_profile') }}</h6>
                            <button type="submit" class="text-white btn btn-sm " style="background-color: #0070BB;">
                                {{ __('profile.save') }}
                            </button>
                            <x-alert-sweet/>
                        </div>
                        <div class="card-body">
                            <p class="text-sm text-uppercase text-secondary fw-bold mb-3">
                                {{ __('profile.personal_info') }}
                            </p>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" style="color:#0070BB;">{{ __('profile.username') }}</label>
                                    <input class="form-control" type="text" name="username"
                                           value="{{ old('username', auth()->user()->username) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" style="color:#0070BB;">{{ __('profile.email') }}</label>
                                    <input class="form-control" type="email" name="email"
                                           value="{{ old('email', auth()->user()->email) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" style="color:#0070BB;">{{ __('profile.firstname') }}</label>
                                    <input class="form-control" type="text" name="firstname"
                                           value="{{ old('firstname', auth()->user()->firstname) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" style="color:#0070BB;">{{ __('profile.lastname') }}</label>
                                    <input class="form-control" type="text" name="lastname"
                                           value="{{ old('lastname', auth()->user()->lastname) }}">
                                </div>
                            </div>

                            <hr class="my-4">

                            <p class="text-sm text-uppercase text-secondary fw-bold mb-3">
                                {{ __('profile.contact_info') }}
                            </p>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" style="color:#0070BB;">{{ __('profile.address') }}</label>
                                    <input class="form-control" type="text" name="address"
                                           value="{{ old('address', auth()->user()->address) }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" style="color:#0070BB;">{{ __('profile.city') }}</label>
                                    <input class="form-control" type="text" name="city"
                                           value="{{ old('city', auth()->user()->city) }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" style="color:#0070BB;">{{ __('profile.country') }}</label>
                                    <input class="form-control" type="text" name="country"
                                           value="{{ old('country', auth()->user()->country) }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" style="color:#0070BB;">{{ __('profile.postal') }}</label>
                                    <input class="form-control" type="text" name="postal"
                                           value="{{ old('postal', auth()->user()->postal) }}">
                                </div>
                            </div>

                            <hr class="my-4">

                            <p class="text-sm text-uppercase text-secondary fw-bold mb-3">
                                {{ __('profile.about') }}
                            </p>
                            <div class="mb-3">
                                <label class="form-label" style="color:#0070BB;">{{ __('profile.presentation') }}</label>
                                <textarea class="form-control" name="about" rows="3">{{ old('about', auth()->user()->about) }}</textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
