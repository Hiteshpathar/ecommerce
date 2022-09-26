<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function test($is_approved)
    {
        return $is_approved==1?'approved':'not_approved';
    }

    public function index(Request $request)
    {
        $sort = $request->sort ?? 'created_at';
        $order = 'desc';
        $query = User::Sortable()->filter($request->only('search', 'status'));
        $query = $query->orderBy($sort, $order);
        $users = $query->paginate(25);
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
            'address1' => 'required',
            'postal_code' => 'required',
        ]);

        $user = User::where('email', $request->input('email'))->count();
        if ($user > 0) {
            echo "email already exists";
        } else {
            $user = new User();
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name') ?? '';
            $user->email = $request->input('email');
            $user->password = Str::random(10);
            $user->mobile = $request->input('mobile') ?? '';
            $user->is_active = $request->input('status') ?? '';
            $user->address1 = $request->input('address1')??'';
            $user->address2 = $request->input('address2')??'';
            $user->city = $request->input('city')??'';
            $user->country = $request->input('country')??'';
            $user->postal_code = $request->input('postal_code')??'';
            $user->save();
            return redirect()->route('users-list')->with('success', 'User added');
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('admin/showUser', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name') ?? '';
        $user->email = $request->input('email');
        $user->password = Str::random(10);
        $user->mobile = $request->input('mobile') ?? '';
        $user->is_active = $request->input('status') ?? '';
        $user->address1 = $request->input('address1')??'';
        $user->address2 = $request->input('address2')??'';
        $user->city = $request->input('city')??'';
        $user->country = $request->input('country')??'';
        $user->postal_code = $request->input('postal_code')??'';
        $user->save();
        return redirect()->route('users-list')->with('success', 'User updates successfully');

    }

    function sendMail($id)
    {
        $user = User::find($id);

        $name = $user->first_name . ' ' . $user->last_name;
        $data = ['name' => $name,
            'password' => $user->password,
            'to' => $user->email,
            'from' => 'admin@gmail.com',
            'subject' => 'Your Credentials from ...'];

        $user->is_email_sent = true;
        $user->save();
        SendEmailJob::dispatch($data);
        return redirect()->back()->with('success', 'Mail Sent Successfully');
    }

    function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['success' => 'deleted successfully']);
    }
}
