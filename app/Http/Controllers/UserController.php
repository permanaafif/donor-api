<?php

namespace App\Http\Controllers;

use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);//login, register methods won't go through the api guard
    }

    public function register(Request $request){
        //set validation
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'password'  => 'required|min:8',
            'address'     => 'required',
            'email'     => 'required|email|unique:users',
            'phone'     => 'required|min:11',
            'role_id'     => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        //create user
        $user = User::create([
            'name'      => $request->name,
            'password'  => bcrypt($request->password),
            'address'     => $request->address,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'role_id'     => $request->role_id,
        ]);

        //return response JSON user is created
        if($user) {
            return response()->json([
                'success' => true,
                'message' => 'your register success',
                'user'    => $user,  
            ], 201);
        }
        
        //return JSON process insert failed 
        return response()->json([
            'success' => false,
            'message' => 'your register failed',
        ], 409);
    }

    public function login(Request $request)
    {
       //set validation
       $validator = Validator::make($request->all(), [
        'email'     => 'required',
        'password'  => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //get credentials from request
        $credentials = $request->only('email', 'password');

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda salah'
            ], 401);
        }

        //if auth success
        return response()->json([
            'success' => true,
            'user'    => auth()->guard('api')->user(),    
            'token'   => $token,
            'token_type' => 'bearer',
            'exp_token' => JWTAuth::factory()->getTTL()*1
        ], 200);
    }

    public function show(){
        // Dapatkan semua pengguna bersama dengan data peran (role) mereka
        $usersWithRoles = User::with('role')->get();

        return response()->json([
            'message' => 'success',
            'users' => $usersWithRoles,
        ]);
    }
    
    public function find($id){
        // Dapatkan semua pengguna bersama dengan data peran (role) mereka
        if($usersWithRoles = User::find($id)){
            $usersWithRoles->load('role');
            return response()->json([
                'message' => 'success',
                'user' => $usersWithRoles,
            ]);
        }
        return response()->json(['message' => 'data user not found']);

    }

    public function logout(Request $request)
    {        
        //remove token
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if($removeToken) {
            //return response JSON
            return response()->json([
                'success' => true,
                'message' => 'Logout Berhasil!',  
            ]);
        }
    }
    
}
