<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Jobs\SendEmailJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->sort ?? 'created_at';
        $order = $request->order && in_array($request->order, ['ascending', 'descending']) ? str_replace('ending', '', $request->order) : 'desc';

        $query = User::withCount('orders')->filter($request->only('search', 'status'));
        $query->withCount([
            'orders as total_spent' => function ($query) {
                $query->select(DB::raw("SUM(total_amount) as total_spent"));
            }
        ]);
        $query = $query->orderBy($sort, $order);
        $users = $query->paginate($request->limit);

        $users->map(function ($user) {
            foreach ($user->address as $address){
                if ($address->is_primary === 1){
                    $user->location = rtrim(ltrim(($address->city != "" || $address->state != "") ? $address->city . "," . $address->state : "", ","), ",");
                }
            }
        });
        return $users;

//        return view('admin/usersList', ['users' => $users]);
    }

    public function show($id)
    {
        $user = User::with('address','orders')->find($id);
        foreach ($user->address as $address){
            if ($address->is_primary ===1){
                $user['default_address'] = $address;
            }
        }
        return $user;
    }

    public function store(UserFormRequest $request)
    {
        try {
            $data = $request->only(['first_name', 'last_name', 'mobile', 'email']);
            $data['password'] = Str::random(20);
            $user = User::create($data);
            $user->address()->create($request->address);
            return response(['message' => "User has been created successfully!"]);
        } catch (\Exception $e) {
            return response(['error' => 'Something went wrong, Try again later!'], 500);
        }
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

        SendEmailJob::dispatch($data,$user);
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
}
