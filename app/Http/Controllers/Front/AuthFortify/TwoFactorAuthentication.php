<?php

namespace App\Http\Controllers\Front\AuthFortify;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorAuthentication extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        return view('front.auth.two-factor-auth', compact('user'));
    }
}