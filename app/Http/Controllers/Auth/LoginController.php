<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Redirect user after login based on role
     */
    protected function redirectTo()
    {
        $user = Auth::user();

        // Arahkan guru ke halaman tugas khusus guru
        if ($user->role === 'teacher') {
            return '/teacher/tasks'; // ubah dari /teacher/dashboard
        }

        // Arahkan murid ke halaman tugas umum
        return '/tasks';
    }
}
