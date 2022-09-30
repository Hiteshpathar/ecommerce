<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Jobs\SendEmailJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->sort ?? 'created_at';
        $order = $request->order && in_array($request->order, ['ascending', 'descending']) ? str_replace('ending', '', $request->order) : 'desc';

        $query = User::with('orders', 'address')->filter($request->only('search', 'status'));
        $query = $query->orderBy($sort, $order);
        $users = $query->paginate(25);
        foreach ($users as $user) {
            foreach ($user->orders as $order) {
                $user->total_spent += $order->total_amount;
            }
        }
        return $users;

//        return view('admin/usersList', ['users' => $users]);
    }

    public function show($id)
    {
        return User::with('address')->find($id);
    }

    public function store(UserFormRequest $request)
    {
//        try {
        $data = $request->only(['first_name', 'last_name', 'mobile', 'email']);
        $data['password'] = Str::random(20);
        $user = User::create($data);
        $user->address()->create($request->address);
        return response(['message' => "User has been created successfully!"]);
//        } catch (\Exception $e) {
//            return response(['error' => 'Something went wrong, Try again later!'], 500);
//        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('admin/showUser', ['user' => $user]);
    }

    public function update(UserFormRequest $request, $id)
    {
        $data = $request->only('first_name', 'last_name', 'email', 'mobile');
        try {
            User::where('id', $id)->update($data);
            return response(['message' => "User has been updated successfully!"]);
        } catch (\Exception $e) {
            return response(['error' => 'Something went wrong, Try again later!'], 500);
        }
    }

    public function sendMail($id)
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
        return response(['message' => "Mail been Sent successfully!"]);
    }

    public function destroy($id)
    {
        try {
            User::destroy($id);
            return response(['message' => "User has been deleted successfully!"]);
        } catch (\Exception $e) {
            return response(['error' => 'Something went wrong, Try again later!'], 500);
        }
    }

    public function address($id)
    {
        $address = User::find($id)->address;
        return view('admin/userAddress', ['address' => $address]);
    }
}
