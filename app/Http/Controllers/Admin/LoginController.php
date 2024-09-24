<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginCheck(AdminLoginRequest $request): JsonResponse
    {
        if (Auth::guard('admin')->attempt(['email' => $request['email'], 'password' => $request['password']])) {
            if (Auth::guard('admin')->user()->status === 'active' && (int) Auth::guard('admin')->user()->is_deleted === 0) {
                return response()->json([
                    'message' => 'Login Successfully',
                ]);
            }

            return response()->json([
                'message' => 'Account Deactivated',
            ], 422);
        }

        return response()->json([
            'message' => 'Invalid Credentials',
        ], 422);
    }

    public function login()
    {
        if (auth()->guard('admin')->user()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login');
    }
}
