<?php

namespace App\Http\Controllers;

use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);//login, register methods won't go through the api guard
    }
    
    public function create(Request $request){
        //set validation
        $validator = Validator::make($request->all(), [
            'name'      => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        //create user
        $roleUser = RoleUser::create([
            'name'      => $request->name
        ]);

        //return response JSON user is created
        if($roleUser) {
            return response()->json([
                'success' => true,
                'message' => 'your role create success',
                'user'    => $roleUser,  
            ], 201);
        }
        
        //return JSON process insert failed 
        return response()->json([
            'success' => false,
            'message' => 'your role created failed',
        ], 409);
    }

    public function showRole()
    {
        return response()->json(['role' => RoleUser::all()]);
    }
}
