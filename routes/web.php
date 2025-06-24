<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\Vehicules\VehiculeController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\FuelConsumptions\FuelConsumptionController;
use App\Http\Controllers\Drivers\ControllerDriver;
use App\Http\Controllers\Garages\GarageController;
use App\Http\Controllers\Interventions\InterventionController;
use App\Http\Controllers\TypeIntervention\TypeInterventionController;
use App\Http\Controllers\NeussiteController;
use App\Http\Controllers\Pieces\PieceController;
use App\Http\Controllers\Pannes\PanneController;
use App\Http\Controllers\VehicleStatisticsController;
use App\Http\Controllers\PanneStatisticsController;
use App\Http\Controllers\FuelConsumptionStatisticsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


use App\Http\Controllers\Auth\PasswordResetController;

Route::get('/dashboard', function () {return redirect('/dashboard');})->middleware('auth');


Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr', 'ar'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');



// Page d'accueil (française)
Route::get('/', function () {
    return view('accueil');
})->name('accueil');


Route::middleware(['auth'])->group(function () {
    Route::resource('pannes', PanneController::class);
    Route::get('/pannes/{id}/pdf', [PanneController::class, 'exportPDF'])->name('pannes.exportPDF');


    Route::get('/pannes/all', [PanneController::class, 'fetchAllPannes']);
    Route::get('/pannes/search', [PanneController::class, 'search'])->name('pannes.search');
    Route::get('/pannes/{panne}', [PanneController::class, 'show'])->name('pannes.show');
    Route::get('pannes/{id}/intervention', [PanneController::class, 'redirectToIntervention'])->name('pannes.intervention');
    Route::post('/notifications/{id}/mark-as-read', [UserProfileController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::get('/pieces/search', [PieceController::class, 'search'])->name('pieces.search');
    Route::resource('pieces', PieceController::class);
    Route::get('/pieces/{piece}/export-pdf', [PieceController::class, 'generateSinglePdf'])->name('pieces.export.single');

    Route::resource('fuel-consumption', FuelConsumptionController::class);
    Route::get('/fuel-consumption/{id}/export-pdf', [FuelConsumptionController::class, 'exportPDF'])->name('fuel.export_pdf');

    Route::get('/fuel-consumption-stats', [FuelConsumptionStatisticsController::class, 'index']);
    Route::get('vehicules/{id}/assignments', [AssignmentController::class, 'details'])->name('assignments.details');
    Route::resource('vehicules', VehiculeController::class);
    Route::get('/vehicules/{vehicule}/pdf', [VehiculeController::class, 'generateSinglePdf'])->name('vehicules.generateSinglePdf');

    Route::resource('drivers', ControllerDriver::class);
    Route::get('/drivers/{id}/pdf', [ControllerDriver::class, 'exportPDF'])->name('drivers.pdf');
    Route::post('/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
    Route::put('/assignments/{assignment}', [AssignmentController::class, 'update'])->name('assignments.update');
    Route::delete('/assignments/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');


    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::get('/test-notifications', [InterventionController::class, 'testNotifications']);



    Route::resource('interventions', InterventionController::class);

    // Route pour générer le PDF d’une intervention
    Route::get('interventions/{intervention}/pdf', [InterventionController::class, 'generateSinglePdf'])
        ->name('interventions.single.pdf');
    
    // ——— Routes imbriquées pour les “neussites” (pièces utilisées) ———
    
    // POST   /interventions/{intervention}/neussites
    Route::post('interventions/{intervention}/neussites', [NeussiteController::class, 'store'])
        ->name('interventions.neussites.store');
    
    // PUT    /interventions/{intervention}/neussites/{neussite}
    Route::put('interventions/{intervention}/neussites/{neussite}', [NeussiteController::class, 'update'])
        ->name('interventions.neussites.update');
    
    // DELETE /interventions/{intervention}/neussites/{neussite}
    Route::delete('interventions/{intervention}/neussites/{neussite}', [NeussiteController::class, 'destroy'])
        ->name('interventions.neussites.destroy');
        

    //Route::resource('interventions', InterventionController::class);
    //Route::post('/interventions/store', [InterventionController::class, 'store'])->name('interventions.store');
    //Route::get('/interventions/{intervention}/pdf', [InterventionController::class, 'generateSinglePdf'])->name('interventions.single.pdf');

    Route::post('/neussite/store', [NeussiteController::class, 'store'])->name('neussite.store');
    
    Route::post('/interventions/{id}/assign-garage', [InterventionController::class, 'assignGarage'])->name('interventions.assignGarage');
    Route::get('/statistics', [VehicleStatisticsController::class, 'index'])->name('statistics.index');
    Route::get('/statistics/pannes', [PanneStatisticsController::class, 'index'])->name('statistics.pannes');
    Route::resource('type_interventions', TypeInterventionController::class);
    Route::get('/statistics', [VehicleStatisticsController::class, 'index'])->name('statistics.index');
    Route::get('/statistics/pannes', [PanneStatisticsController::class, 'index'])->name('statistics.pannes');
    // Garages
    Route::get('/garages', [GarageController::class, 'index'])->name('garages.index');
    Route::get('/garages/create', [GarageController::class, 'create'])->name('garages.create');
    Route::post('/garages', [GarageController::class, 'store'])->name('garages.store');
    Route::get('/garages/{garage}', [GarageController::class, 'show'])->name('garages.show');
    Route::get('/garages/{garage}/edit', [GarageController::class, 'edit'])->name('garages.edit');
    Route::put('/garages/{garage}', [GarageController::class, 'update'])->name('garages.update');
    Route::delete('/garages/{garage}', [GarageController::class, 'destroy'])->name('garages.destroy');
    Route::get('/garages/{garage}/pdf', [GarageController::class, 'generateSinglePdf'])->name('garages.single.pdf');


    Route::resource('type_interventions', TypeInterventionController::class);
    Route::get('/type-interventions/{typeIntervention}/export-pdf', [TypeInterventionController::class, 'generateSinglePdf'])->name('type_interventions.export.single');

    Route::get('/statistics', [HomeController::class, 'statistics']);
});


Route::get('/test-exec', function () {
    sleep(70);
    return 'done';
});




//Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');


// 1. Ajouter la route pour afficher les utilisateurs en attente
Route::middleware(['auth', 'check.approved'])->group(function () {
    Route::middleware('can:access-admin-area')->group(function () {
        Route::get('/admin/users/pending', [App\Http\Controllers\AdminController::class, 'pendingUsers'])->name('admin.users.pending');
        // routes/web.php
        Route::post('/admin/utilisateurs/{user}/refuser', [AdminController::class, 'refuser'])->name('admin.users.refuse');

        Route::post('/admin/utilisateurs/{user}/approuver', [AdminController::class, 'approuver'])->name('admin.users.approve');

       // Route::put('/admin/users/{user}/approve', [App\Http\Controllers\AdminController::class, 'approveUser'])->name('admin.users.approve');
    });
});



Route::middleware(['auth'])->group(function () {
    Route::post('/interventions/add', [NotificationController::class, 'addIntervention'])->name('interventions.add');
    Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications.all');
    Route::post('/notifications/mark-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
   


    Route::get('/notifications/get-all', [NotificationController::class, 'getAll'])->name('notifications.getAll');
    Route::post('/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::get('/notifications/count', [NotificationController::class, 'countNotifications'])->name('notifications.count');

});




// Routes accessibles pour les invités
Route::middleware(['guest'])->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.perform');
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
    //Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    /* Mot de passe reset & changement
    Route::get('/reset-password', [ResetPassword::class, 'show'])->name('reset-password');
    Route::post('/reset-password', [ResetPassword::class, 'send'])->name('reset.perform');
    Route::get('/change-password', [ChangePassword::class, 'show'])->name('change-password');
    Route::post('/change-password', [ChangePassword::class, 'update'])->name('change.perform');*/


Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.forgot');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetCode'])->name('password.send');

Route::get('/verify-code', [PasswordResetController::class, 'showVerifyForm'])->name('verify.code.form');
Route::post('/verify-code', [PasswordResetController::class, 'verifyCode'])->name('verify.code');

Route::get('/reset-password', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.reset');

});


Route::get('/notifications-page', [UserProfileController::class, 'notifications'])->middleware('auth')->name('notifications.page');


// Routes protégées pour les utilisateurs authentifiés
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard user/admin
  //  Route::get('/dashboardAdmin', [PageController::class, 'index'])->name('dashboard');

    //  Ajout du lien HomeController dashboard
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');


    // Profile
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');

    // Pages accessibles pour tous les utilisateurs connectés
    Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
    Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
    Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
    Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
    Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');

    // Route générique pour les pages
    Route::get('/{page}', [PageController::class, 'index'])->name('page');
});


// Routes réservées aux administrateurs
// admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard.admin');
    // routes admin khorine hna
});

// user routes
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user/dashboard', [HomeController::class, 'index'])->name('dashboard.user');

});




