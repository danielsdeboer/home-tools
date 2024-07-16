<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AuthController
{
	public function index(Request $request): RedirectResponse|Response
	{
		if (Auth::check()) {
			return redirect(RouteServiceProvider::HOME);
		}

		return Inertia::render('Auth/Pages/Login');
	}

	public function create(Request $request): RedirectResponse
	{
		$credentials = $request->validate([
			'email' => ['required', 'email'],
			'password' => ['required'],
		]);

		if (Auth::attempt($credentials, remember: true)) {
			$request->session()->regenerate();

			return redirect()->route('admin.index');
		}

		return back()
			->withErrors([
				'email' => 'The provided credentials do not match our records.',
			])
			->onlyInput('email');
	}
}
