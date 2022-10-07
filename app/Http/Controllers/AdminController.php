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
            $admin->is_logged_in = 1;
            $admin->save();
            return response()->json($admin, 200);

        } catch (\Exception $exception) {
            return response()->json(['message' => 'User Not Found'], 422);
        }
    }

    public function isLoggedIn(Request $request)
    {
        return Admin::where('is_logged_in',1)->count();
    }

    public function logout(Request $request)
    {
        return $request;
        Admin::where('email','=',$request->email)->update(['is_logged_in'=>0]);
    }
}
