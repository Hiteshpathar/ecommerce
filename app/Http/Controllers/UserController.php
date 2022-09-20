<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function test(){
        return User::find(1)->address()->get();
    }
    public function index(Request $request){
        return User::all();
    }
    public function show(Request $request){
        return User::where('id',$request->id)->first();
    }
}
