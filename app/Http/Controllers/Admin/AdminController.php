<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\UserPremiumRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function login(): View
    {
        return view('admin.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            return redirect()->intended('admin/dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function dashboard(): View
    {
        $userPremiums = UserPremiumRepository::getAllUserPremiums();

        return view('admin.dashboard', [
            'menu' => 'dashboard',
            'userPremiums' => $userPremiums,
        ]);
    }

    public function logout(): RedirectResponse
    {
        auth()->logout();

        return redirect('admin/login');
    }
}
