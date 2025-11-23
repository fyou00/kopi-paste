<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
  return view('welcome');
})->name('home');

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

Route::middleware(['role:admin'])
  ->prefix('admin')
  ->group(
    function () {
      Route::get('/dashboard', function () {
        return view('admin.dashboard');
      })->name('admin.dashboard');
      Route::get('/menu', function () {
        return view('admin.menu');
      })->name('admin.menu');
      Route::get('/table', function () {
        return view('admin.table');
      })->name('admin.table');
    }
  );

Route::middleware(['role:cashier'])
  ->prefix('cashier')
  ->group(
    function () {
      Route::get('/menu', function () {
        return view('cashier.menu');
      })->name('cashier.menu');
      Route::get('/pesanan', function () {
        return view('cashier.pesanan');
      })->name('cashier.pesanan');
      Route::get('/transaction', function () {
        return view('cashier.transaction');
      })->name('cashier.transaction');
    }
  );
