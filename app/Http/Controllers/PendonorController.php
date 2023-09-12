<?php

namespace App\Http\Controllers;

use App\Models\Pendonor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class PendonorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api2', ['except' => ['register','login']]);
    }
    
    public function register(Request $request){
        //set validation
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:4|string',
            'tanggal_lahir' => 'required|date',
            'kode_pendonor' => 'unique:pendonors',
            'jenis_kelamin' => ['required', 'string', Rule::in(['laki-laki', 'perempuan'])],
            'id_golongan_darah'=> 'required',
            'berat_badan' => 'required|numeric',
            'kontak_pendonor' => 'required',
            'alamat_pendonor' => 'required',
            'password' => 'required',
            'stok_darah_tersedia',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $tanggal_lahir = Carbon::createFromFormat('d-m-Y', $request->tanggal_lahir)->format('Y-m-d');
        //create user
        $pendonor = Pendonor::create([
            'nama' => $request->nama,
            'tanggal_lahir' => $tanggal_lahir,
            'kode_pendonor' => 'dara'.rand(10000, 99999),
            'jenis_kelamin' => $request->jenis_kelamin,
            'id_golongan_darah'=> $request->id_golongan_darah,
            'berat_badan' => $request->berat_badan,
            'kontak_pendonor' => $request->kontak_pendonor,
            'alamat_pendonor' => $request->alamat_pendonor,
            'password' => bcrypt($request->password),
            'stok_darah_tersedia' => $request->stok_darah_tersedia,
        ]);

        //return response JSON user is created
        if($pendonor) {
            // $pendonor->load('golonganDarah');
            return response()->json([
                'success' => true,
                'message' => 'your pendonor create success',
                'user'    => $pendonor,
            ], 201);
        }
        
        //return JSON process insert failed 
        return response()->json([
            'success' => false,
            'message' => 'your pendonor created failed',
        ], 409);
    }

    public function login(Request $request)
    {
       //set validation
       $validator = Validator::make($request->all(), [
        'kode_pendonor' => 'required',
        'password'  => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //get credentials from request
        $credentials = $request->only('kode_pendonor', 'password');

        if (!$token = auth()->guard('api2')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Kode pendonor atau Password Anda salah'
            ], 401);
        }

        //if auth success
        return response()->json([
            'success' => true,
            'user'    => auth()->guard('api2')->user(),    
            'token'   => $token,
            'token_type' => 'bearer',
            'exp_token' => JWTAuth::factory()->getTTL()*1
        ], 200);
    }

    public function show()
    {
        return response()->json(['pendonor' => Pendonor::all()]);
    }

    public function logout()
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
