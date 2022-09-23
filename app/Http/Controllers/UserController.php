<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function test()
    {
        return User::find(1)->cart()->get();
    }

    public function index(Request $request)
    {
        $users = User::filter($request->only('search', 'status'))->paginate(25);
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
//            $file = Storage::disk('public')->putFile('images',$request->file('image'));
//            $name = explode('/',$file);
//            $user->image = $name[1];
            $user->save();
            $user->address()->create([
                'address1' => $request->input('address1'),
                'address2' => $request->input('address2') ?? '',
                'city' => $request->input('city') ?? '',
                'postal_code' => $request->input('postal_code')
            ]);
            return redirect()->route('users-list')->with('success', 'User added');
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        $address = isset($user->address[0])??[];
        return view('admin/showUser', ['user' => $user,'address'=>$address]);
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name') ?? '';
        $user->email = $request->input('email');
        $user->password = Str::random(10);
        $user->mobile = $request->input('mobile') ?? '';
//            $file = Storage::disk('public')->putFile('images',$request->file('image'));
//            $name = explode('/',$file);
//            $user->image = $name[1];
        $user->address()->update([
            'address1' => $request->input('address1'),
            'address2' => $request->input('address2') ?? '',
            'city' => $request->input('city') ?? '',
            'postal_code' => $request->input('postal_code')
        ]);
//        if ($request->image == null) {
//            $student->image = $student->image;
//        } else {
//            $file = Storage::disk('public')->putFile('images', $request->file('image'));
//            $name = explode('/', $file);
//            $student->image = $name[1];
//        }
        $user->save();
        return redirect()->route('users-list')->with('success', 'User updates successfully');

    }

    public
    function approve($id, $is_active)
    {
        $user = User::find($id);
        $is_active == 1 ? $user->is_active = 0 : $user->is_active = 1;
        $user->save();
        return redirect()->route('users-list')->with('success', 'status changed successfully');
    }

    public
    function sendMail(Request $request)
    {
        $user = User::find($request->id)->first();
        $name = $user->first_name . ' ' . $user->last_name;
        $data = ['name' => $name,
            'password' => $user->password,
            'to' => $user->email,
            'from' => 'admin@gmail.com',
            'subject' => 'Your Credentials from ...'];

        SendEmailJob::dispatch($data);
        return redirect()->back()->with('success', 'Mail Sent Successfully');
    }

    public
    function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['success' => 'deleted successfully']);
    }
}
