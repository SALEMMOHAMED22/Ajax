<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Governorate;
use Illuminate\Http\Request;

use function Laravel\Prompts\select;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(1);
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


    public function delete(Request $request){
        $user = User::findOrFail($request->id);


        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully',
            'status' => 200,
            'id' => $user->id,
        ]);

    }

    public function edit($id){
        $user = User::findOrFail($id);
        $governorates = Governorate::all();
        $cities = City::all();

        return view('users.edit' , compact('user' , 'governorates' , 'cities'));
    }

    public function update(Request $request ){
        $user = User::findOrFail($request->id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'governorate_id' => $request->governorate_id,
            'city_id' => $request->city_id
        ]);

        return response()->json([
            'message' => 'User updated successfully',
            'status' => 200,
        ]);
    }

    public function getCities(Request $request){
        $request->validate([
        'governorate_id' => 'required|exists:governorates,id',
    ]);

        $cities = City::where('governorate_id' , $request->governorate_id)->select('id' , 'name')->get();
        return response()->json($cities);
    }


    public function search(Request $request){
        
        $users = User::where('name' , 'like' , '%'.$request->search.'%')
        ->orWhere('email' , 'like' , '%'.$request->search.'%')
        ->orWhere(function ($query) use ($request) {
            $query->whereRelation('city', 'name', 'like', '%'.$request->search.'%');
            $query->orWhereRelation('governorate', 'name', 'like', '%'.$request->search.'%');
        })
        ->get();
        return view('users.search' , compact('users'));
    }


}
