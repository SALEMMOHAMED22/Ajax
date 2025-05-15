<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Governorate;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $governorates = Governorate::all();
        $cities = City::all();
        return view('users.create' , compact('governorates' , 'cities'));
    }

    public function store(Request $request)
    {
        $request->validate($this->validateUser());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'governorate_id' => $request->governorate_id,
            'city_id' => $request->city_id
        ]);

        if($user){
            return response()->json([
                'message' => 'User created successfully',
                'status' => 200,
            ]);
        }



        
    }


    private function validateUser() :array
    {
        return [

            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'governorate_id' => 'required|exists:governorates,id',
            'city_id' => 'required|exists:cities,id',
        ];
    }


}
