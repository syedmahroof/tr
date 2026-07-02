<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Teams\TeamInvitationController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\WatchlistController;
use App\Http\Middleware\EnsureTeamMembership;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function (Request $request) {
    if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

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
            'visitorsToday' => Visitor::where('created_at', '>=', $today)->count(),
            'onPremises' => Visitor::where('status', 'checked_in')->count(),
            'preRegistered' => Visitor::where('status', 'pending')->count(),
            'pendingApprovals' => Visitor::where('status', 'pending')->count(),
            'passesIssued' => Visitor::whereMonth('created_at', now()->month)->count(),
            'totalEmployees' => User::count(),
            'deliveriesToday' => 0,
            'contractorsOnSite' => Visitor::where('category', 'contractor')->where('status', 'checked_in')->count(),
        ];

        return Inertia::render('admin/dashboard', [
            'stats' => $stats,
        ]);
    })->name('admin.dashboard');

    Route::get('/search', [SearchController::class, 'index'])->name('admin.search');

    Route::get('/visitors', [VisitorController::class, 'index'])->name('admin.visitors');
    Route::get('/visitors/registration', [VisitorController::class, 'create'])->name('admin.visitors.registration');
    Route::post('/visitors/registration', [VisitorController::class, 'store'])->name('admin.visitors.store');
    Route::get('/visitors/{visitor}', [VisitorController::class, 'show'])->name('admin.visitors.show');
    Route::get('/visitors/{visitor}/edit', [VisitorController::class, 'edit'])->name('admin.visitors.edit');
    Route::put('/visitors/{visitor}', [VisitorController::class, 'update'])->name('admin.visitors.update');
    Route::patch('/visitors/{visitor}/status', [VisitorController::class, 'updateStatus'])->name('admin.visitors.update-status');
    Route::delete('/visitors/{visitor}', [VisitorController::class, 'destroy'])->name('admin.visitors.destroy');
    Route::get('/employees', [EmployeeController::class, 'index'])->name('admin.employees');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('admin.employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('admin.employees.store');
    Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('admin.employees.edit');
    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('admin.employees.update');
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('admin.employees.destroy');

    Route::get('/appointments', [AppointmentController::class, 'index'])->name('admin.appointments');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('admin.appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('admin.appointments.store');
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('admin.appointments.edit');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('admin.appointments.update');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('admin.appointments.destroy');

    Route::get('/security', [WatchlistController::class, 'index'])->name('admin.security');
    Route::get('/security/create', [WatchlistController::class, 'create'])->name('admin.security.create');
    Route::post('/security', [WatchlistController::class, 'store'])->name('admin.security.store');
    Route::get('/security/{watchlist}/edit', [WatchlistController::class, 'edit'])->name('admin.security.edit');
    Route::put('/security/{watchlist}', [WatchlistController::class, 'update'])->name('admin.security.update');
    Route::delete('/security/{watchlist}', [WatchlistController::class, 'destroy'])->name('admin.security.destroy');

    Route::get('/vehicles', [VehicleController::class, 'index'])->name('admin.vehicles');
    Route::get('/vehicles/registration', [VehicleController::class, 'create'])->name('admin.vehicles.registration');
    Route::post('/vehicles/registration', [VehicleController::class, 'store'])->name('admin.vehicles.store');
    Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('admin.vehicles.show');
    Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])->name('admin.vehicles.edit');
    Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('admin.vehicles.update');
    Route::patch('/vehicles/{vehicle}/status', [VehicleController::class, 'updateStatus'])->name('admin.vehicles.update-status');
    Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('admin.vehicles.destroy');

    Route::get('/deliveries', [DeliveryController::class, 'index'])->name('admin.deliveries');
    Route::get('/deliveries/create', [DeliveryController::class, 'create'])->name('admin.deliveries.create');
    Route::get('/deliveries/history', [DeliveryController::class, 'history'])->name('admin.deliveries.history');
    Route::post('/deliveries', [DeliveryController::class, 'store'])->name('admin.deliveries.store');
    Route::get('/deliveries/{delivery}', [DeliveryController::class, 'show'])->name('admin.deliveries.show');
    Route::get('/deliveries/{delivery}/edit', [DeliveryController::class, 'edit'])->name('admin.deliveries.edit');
    Route::put('/deliveries/{delivery}', [DeliveryController::class, 'update'])->name('admin.deliveries.update');
    Route::delete('/deliveries/{delivery}', [DeliveryController::class, 'destroy'])->name('admin.deliveries.destroy');

    Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports');
    Route::get('/settings', function () {
        return Inertia::render('admin/settings/index');
    })->name('admin.settings');

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('admin.notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('admin.notifications.mark-all-read');
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
