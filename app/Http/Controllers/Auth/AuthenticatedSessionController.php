<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
  /**
   * Handle an incoming authentication request.
   */
  public function store(Request $request): RedirectResponse
  {
    $request->authenticate();
    $request->session()->regenerate();

    $user = auth()->user();

    if ($user->role === 'admin') {
      return redirect()->intended('/admin/dashboard');
    }

    if ($user->role === 'cashier') {
      return redirect()->intended('/cashier/menu');
    }

    return redirect('/');
  }


  /**
   * Destroy an authenticated session.
   */
  public function destroy(Request $request): Response
  {
    Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return response()->noContent();
  }
}
