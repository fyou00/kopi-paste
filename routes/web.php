<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicMenuController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\TableController as AdminTableController;
use App\Http\Controllers\Cashier\DashboardController as CashierDashboardController;
use App\Http\Controllers\Cashier\OrderController;
use App\Http\Controllers\Cashier\TransactionController;

// ====== PUBLIC ROUTES (Tanpa Login) ======
Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/menu', [PublicMenuController::class, 'index'])->name('menu.public');
// Route::get('/tentang', [HomeController::class, 'about'])->name('about');

Route::middleware(['auth'])->group(function () {
  Route::redirect('settings', 'settings/profile');

  Route::get('settings/profile', Profile::class)->name('profile.edit');
  Route::get('settings/password', Password::class)->name('user-password.edit');
  Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

  Route::get('settings/two-factor', TwoFactor::class)
    ->middleware(
      when(
        Features::canManageTwoFactorAuthentication()
        && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
        ['password.confirm'],
        [],
      ),
    )
    ->name('two-factor.show');
});

// ====== AUTH ROUTES ======
require __DIR__.'/auth.php';

// ====== ADMIN ROUTES (Role: admin) ======
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Menu Management
    Route::resource('menu', AdminMenuController::class);
    
    // Table Management
    Route::resource('table', AdminTableController::class)->except(['show']);
});

// ====== CASHIER ROUTES (Role: cashier) ======
Route::middleware(['auth', 'role:cashier'])->prefix('cashier')->name('cashier.')->group(function () {
    Route::get('/dashboard', [CashierDashboardController::class, 'index'])->name('dashboard');
    
    // Order Management
    Route::get('/pesanan', [OrderController::class, 'index'])->name('order.index');
    Route::get('/pesanan/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('/pesanan', [OrderController::class, 'store'])->name('order.store');
    Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('order.show');
    Route::patch('/pesanan/{order}/status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
    Route::delete('/pesanan/{order}', [OrderController::class, 'destroy'])->name('order.destroy');
    
    // Transaction Management
    Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaction.index');
    Route::get('/transaksi/{transaction}', [TransactionController::class, 'show'])->name('transaction.show');
});

// ====== FALLBACK untuk user yang login tapi akses route salah ======
Route::middleware(['auth'])->group(function () {
    // Redirect ke dashboard sesuai role jika akses /dashboard
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->isCashier()) {
            return redirect()->route('cashier.dashboard');
        }
        abort(403, 'Unauthorized');
    })->name('dashboard');
});