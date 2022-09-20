<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function test()
    {
        return User::find(1)->address()->get();
    }

    public function index(Request $request)
    {
        $users = User::all();
        return view('admin/usersList', ['users' => $users]);
    }

    public function show($id)
    {
        return User::where('id', $id)->first();
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'email' => 'required||regex:/(.+)@(.+)\.(.+)/i',
            'password' => 'required_with:confirm_password|same:confirm_password',
            'address1' => 'required',
            'postal_code' => 'required',
        ]);

        $user = User::where('email', $request->input('email'))->count();
        if ($user > 0) {
            echo "email already exists";
        } else {
            $user = new User();
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name')??'';
            $user->email = $request->input('email');
            $user->password = $request->input('password');
            $user->mobile = $request->input('mobile')??'';
//            $file = Storage::disk('public')->putFile('images',$request->file('image'));
//            $name = explode('/',$file);
//            $user->image = $name[1];
            $user->save();
            $user->address()->create([
                'address1' => $request->input('address1'),
                'address2' => $request->input('address2')??'',
                'city' => $request->input('city')??'',
                'postal_code' => $request->input('postal_code')
            ]);
            return redirect()->route('users-list')->with('success', 'User added');
        }
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['success'=>'deleted successfully']);
    }
}
