<?php

namespace App\Http\Controllers;

use App\Models\GolonganDarah;
use App\Models\StokDarah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StokDarahController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }
    
    public function create(Request $request){
        //set validation
        $validator = Validator::make($request->all(), [
            'id_golongan_darah' => 'required|min:1',
            'jumlah'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        //create user
        $stokDarah = StokDarah::create([
            'id_golongan_darah' => $request->id_golongan_darah,
            'jumlah' => $request->jumlah
        ]);

        //return response JSON user is created
        if($stokDarah) {
            return response()->json([
                'success' => true,
                'message' => 'your stok darah create success',
                'stok_darah' => $stokDarah,  
                'golongan_darah' => GolonganDarah::find($stokDarah->id_golongan_darah)
            ], 201);
        }
        
        //return JSON process insert failed 
        return response()->json([
            'success' => false,
            'message' => 'your stok darah created failed',
        ], 409);
    }

    public function show()
    {
        return response()->json(['role' => StokDarah::all()]);
    }
}
