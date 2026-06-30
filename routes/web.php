<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Teams\TeamInvitationController;
use App\Http\Middleware\EnsureTeamMembership;
use App\Http\Controllers\AdminAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.login');
})->name('home');

// Admin Login Routes
Route::middleware('guest:admin')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login']);
    
    Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('/admin/register', [AdminAuthController::class, 'register']);
});

// Admin Protected Routes
Route::middleware('auth:admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        $today = now()->startOfDay();
        
        $stats = [
            'visitorsToday' => \App\Models\Visitor::where('created_at', '>=', $today)->count(),
            'onPremises' => \App\Models\Visitor::where('status', 'checked_in')->count(),
            'preRegistered' => \App\Models\Visitor::where('status', 'pending')->count(),
            'pendingApprovals' => \App\Models\Visitor::where('status', 'pending')->count(),
            'passesIssued' => \App\Models\Visitor::whereMonth('created_at', now()->month)->count(),
            'totalEmployees' => \App\Models\User::count(),
            'deliveriesToday' => 0,
            'contractorsOnSite' => \App\Models\Visitor::where('category', 'contractor')->where('status', 'checked_in')->count(),
        ];
        
        return \Inertia\Inertia::render('admin/dashboard', [
            'stats' => $stats
        ]);
    })->name('admin.dashboard');
    
    Route::get('/search', [\App\Http\Controllers\SearchController::class, 'index'])->name('admin.search');
    
    Route::get('/visitors', [\App\Http\Controllers\VisitorController::class, 'index'])->name('admin.visitors');
    Route::get('/visitors/registration', [\App\Http\Controllers\VisitorController::class, 'create'])->name('admin.visitors.registration');
    Route::post('/visitors/registration', [\App\Http\Controllers\VisitorController::class, 'store'])->name('admin.visitors.store');
    Route::get('/visitors/{visitor}', [\App\Http\Controllers\VisitorController::class, 'show'])->name('admin.visitors.show');
    Route::get('/visitors/{visitor}/edit', [\App\Http\Controllers\VisitorController::class, 'edit'])->name('admin.visitors.edit');
    Route::put('/visitors/{visitor}', [\App\Http\Controllers\VisitorController::class, 'update'])->name('admin.visitors.update');
    Route::delete('/visitors/{visitor}', [\App\Http\Controllers\VisitorController::class, 'destroy'])->name('admin.visitors.destroy');
    Route::get('/employees', [\App\Http\Controllers\EmployeeController::class, 'index'])->name('admin.employees');
    Route::get('/employees/create', [\App\Http\Controllers\EmployeeController::class, 'create'])->name('admin.employees.create');
    Route::post('/employees', [\App\Http\Controllers\EmployeeController::class, 'store'])->name('admin.employees.store');
    Route::get('/employees/{employee}/edit', [\App\Http\Controllers\EmployeeController::class, 'edit'])->name('admin.employees.edit');
    Route::put('/employees/{employee}', [\App\Http\Controllers\EmployeeController::class, 'update'])->name('admin.employees.update');
    Route::delete('/employees/{employee}', [\App\Http\Controllers\EmployeeController::class, 'destroy'])->name('admin.employees.destroy');

    Route::get('/appointments', [\App\Http\Controllers\AppointmentController::class, 'index'])->name('admin.appointments');
    Route::get('/appointments/create', [\App\Http\Controllers\AppointmentController::class, 'create'])->name('admin.appointments.create');
    Route::post('/appointments', [\App\Http\Controllers\AppointmentController::class, 'store'])->name('admin.appointments.store');
    Route::get('/appointments/{appointment}/edit', [\App\Http\Controllers\AppointmentController::class, 'edit'])->name('admin.appointments.edit');
    Route::put('/appointments/{appointment}', [\App\Http\Controllers\AppointmentController::class, 'update'])->name('admin.appointments.update');
    Route::delete('/appointments/{appointment}', [\App\Http\Controllers\AppointmentController::class, 'destroy'])->name('admin.appointments.destroy');

    Route::get('/security', [\App\Http\Controllers\WatchlistController::class, 'index'])->name('admin.security');
    Route::get('/security/create', [\App\Http\Controllers\WatchlistController::class, 'create'])->name('admin.security.create');
    Route::post('/security', [\App\Http\Controllers\WatchlistController::class, 'store'])->name('admin.security.store');
    Route::get('/security/{watchlist}/edit', [\App\Http\Controllers\WatchlistController::class, 'edit'])->name('admin.security.edit');
    Route::put('/security/{watchlist}', [\App\Http\Controllers\WatchlistController::class, 'update'])->name('admin.security.update');
    Route::delete('/security/{watchlist}', [\App\Http\Controllers\WatchlistController::class, 'destroy'])->name('admin.security.destroy');

    Route::get('/vehicles', [\App\Http\Controllers\VehicleController::class, 'index'])->name('admin.vehicles');
    Route::get('/vehicles/registration', [\App\Http\Controllers\VehicleController::class, 'create'])->name('admin.vehicles.registration');
    Route::post('/vehicles/registration', [\App\Http\Controllers\VehicleController::class, 'store'])->name('admin.vehicles.store');
    Route::get('/vehicles/{vehicle}', [\App\Http\Controllers\VehicleController::class, 'show'])->name('admin.vehicles.show');
    Route::get('/vehicles/{vehicle}/edit', [\App\Http\Controllers\VehicleController::class, 'edit'])->name('admin.vehicles.edit');
    Route::put('/vehicles/{vehicle}', [\App\Http\Controllers\VehicleController::class, 'update'])->name('admin.vehicles.update');
    Route::delete('/vehicles/{vehicle}', [\App\Http\Controllers\VehicleController::class, 'destroy'])->name('admin.vehicles.destroy');
    
    Route::get('/deliveries', [\App\Http\Controllers\DeliveryController::class, 'index'])->name('admin.deliveries');
    Route::get('/deliveries/create', [\App\Http\Controllers\DeliveryController::class, 'create'])->name('admin.deliveries.create');
    Route::get('/deliveries/history', [\App\Http\Controllers\DeliveryController::class, 'history'])->name('admin.deliveries.history');
    Route::post('/deliveries', [\App\Http\Controllers\DeliveryController::class, 'store'])->name('admin.deliveries.store');
    Route::get('/deliveries/{delivery}', [\App\Http\Controllers\DeliveryController::class, 'show'])->name('admin.deliveries.show');
    Route::get('/deliveries/{delivery}/edit', [\App\Http\Controllers\DeliveryController::class, 'edit'])->name('admin.deliveries.edit');
    Route::put('/deliveries/{delivery}', [\App\Http\Controllers\DeliveryController::class, 'update'])->name('admin.deliveries.update');
    Route::delete('/deliveries/{delivery}', [\App\Http\Controllers\DeliveryController::class, 'destroy'])->name('admin.deliveries.destroy');
    
    Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('admin.reports');
    Route::get('/settings', function () { return \Inertia\Inertia::render('admin/settings/index'); })->name('admin.settings');
    
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

Route::prefix('{current_team}')
    ->middleware(['auth', 'verified', EnsureTeamMembership::class])
    ->group(function () {
        Route::get('dashboard', DashboardController::class)->name('dashboard');
    });

Route::middleware(['auth'])->group(function () {
    Route::get('invitations/{invitation}/accept', [TeamInvitationController::class, 'accept'])->name('invitations.accept');
    Route::delete('invitations/{invitation}', [TeamInvitationController::class, 'decline'])->name('invitations.decline');
});

require __DIR__.'/settings.php';
