<?php

namespace App\Http\Controllers;

use App\Models\Admin;
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
            Admin::where([
                ['email', '=', $request->input('email')],
                ['password', '=', $request->input('password')],
            ])->firstOrFail();
            return redirect()->route('users-list')->with('success', 'Welcome');
        } catch (\Exception $exception) {
            $request->session()->flash('error', 'User Not Found!');
            return redirect()->route('login');
        }
    }
}
