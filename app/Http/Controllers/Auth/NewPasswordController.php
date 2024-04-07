<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewPasswordController extends Controller
{
    public function __invoke(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }
}
