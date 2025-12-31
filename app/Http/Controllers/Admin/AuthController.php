<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\AdminDetail;
use Carbon\Carbon;
use Exception;

class AuthController extends Controller
{
    //
    public function adminLogin()
    {
        return view('admin.auth.login');
    }

    public function adminLoggedIn(Request $request)
    {
        $request->validate([
            'admin_login_id' => 'required|string',
            'password'       => 'required|string',
        ]);

        try {
            // Find admin by login ID
            $admin = AdminDetail::where('admin_login_id', $request->admin_login_id)->first();

            if (!$admin) {
                return response()->json([
                    'message' => 'Invalid credentials',
                    'errors' => [
                        'admin_login_id' => ['The provided credentials do not match our records.'],
                    ]
                ], 401);
            }

            // Check password (plain text - as per client requirement)
            if ($admin->admin_password !== $request->password) {
                return response()->json([
                    'message' => 'Invalid credentials',
                    'errors' => [
                        'password' => ['The provided credentials do not match our records.'],
                    ]
                ], 401);
            }

            // Login using admin guard
            Auth::guard('admin')->login($admin, $request->boolean('remember'));

            $request->session()->regenerate();

            return response()->json([
                'success'  => true,
                'redirect' => route('admin.dashboard'),
            ]);
        } catch (\Exception $e) {
            Log::error('Admin login error: ' . $e->getMessage(), [
                'admin_login_id' => $request->admin_login_id ?? 'unknown',
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Something went wrong',
                'errors' => [
                    'error' => ['Something went wrong. Please try again.'],
                ]
            ], 500);
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function forgotPassword()
    {
        return view('admin.auth.forgotPassword');
    }
}
