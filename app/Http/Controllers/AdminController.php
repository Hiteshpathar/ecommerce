<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function verifyAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'password' => 'required',
        ]);

        try {
            $admin = Admin::where([
                ['email', '=', $request->input('email')],
                ['password', '=', $request->input('password')],
            ])->firstOrFail();
            $request->session()->put('admin_email', $request->input('email'));
            return response()->json($admin, 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'User Not Found'], 422);
        }
    }

    public function isLoggedIn(Request $request)
    {
        return $request->session()->has('admin_email');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
    }
}
