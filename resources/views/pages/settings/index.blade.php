
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
 <!-- SweetAlert2 -->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/lucide@latest"></script>
{{-- Lang actuelle : {{ app()->getLocale() }}--}}

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-white border-bottom">
                    <h4 class="mb-0 d-flex align-items-center">
                        <i data-lucide="settings" class="me-2" style="color: #0070BB;"></i>
                        {{ __('settings.title') }}
                    </h4>
                    <x-alert-sweet />
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        @method('POST')

                        <div class="mb-3">
                            <label class="form-label d-flex align-items-center">
                                {{ __('settings.app_name') }}
                            </label>
                            <input type="text" name="app_name" class="form-control" value="{{ \App\Models\Setting::get('app_name') }}">
                        </div>
                        <div class="mb-3">
                            <label for="languageSwitcher" class="form-label">
                                {{ __('settings.choose_language') }}
                            </label>
                                <select id="languageSwitcher" class="form-select">
                                    <option value="{{ route('lang.switch', 'fr') }}" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}> Français</option>
                                    <option value="{{ route('lang.switch', 'en') }}" {{ app()->getLocale() == 'en' ? 'selected' : '' }}> English</option>
                                    <option value="{{ route('lang.switch', 'ar') }}" {{ app()->getLocale() == 'ar' ? 'selected' : '' }}> العربية</option>
                                </select>
                                
                                <script>
                                    document.getElementById('languageSwitcher').addEventListener('change', function() {
                                        window.location.href = this.value;
                                    });
                                </script>
                                
                        
                            </div>
                        <div class="mb-3">
                            <label class="form-label d-flex align-items-center">
                                {{ __('settings.notifications') }}
                            </label>
                            <select name="notifications_enabled" class="form-select">
                                <option value="true" {{ \App\Models\Setting::get('notifications_enabled') == 'true' ? 'selected' : '' }}>
                                    {{ __('settings.enabled') }}
                                </option>
                                <option value="false" {{ \App\Models\Setting::get('notifications_enabled') == 'false' ? 'selected' : '' }}>
                                    {{ __('settings.disabled') }}
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-flex align-items-center">
                                {{ __('settings.cleaning') }}
                            </label>
                            <input type="number" name="report_cleaning" class="form-control" value="{{ \App\Models\Setting::get('report_cleaning') }}">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard.admin') }}" class="btn btn-outline-secondary d-flex align-items-center">
                                <i data-lucide="arrow-left" class="me-1"></i>
                                {{ __('settings.back') }}
                            </a>
                            @if(in_array(auth()->user()->role, ['admin', 'user']))
                                <button type="submit" class="btn d-flex align-items-center text-white " style="background-color:#0070BB;">
                                    {{ __('settings.save') }}
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    lucide.createIcons();
</script>

