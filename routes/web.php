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

Route::middleware(['role:cashier'])
  ->prefix('cashier')
  ->group(function () {

    Route::get('/menu', function () {
      return view('cashier.menu');
    });

    Route::get('/product', function () {
      return view('cashier.product');
    });

    Route::get('/transaction', function () {
      return view('cashier.transaction');
    });

  }
);