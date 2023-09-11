<?php

namespace App\Http\Controllers;

use App\Models\GolonganDarah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GolonganDarahController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
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
        $golonganDarah = GolonganDarah::create([
            'name' => $request->name
        ]);

        //return response JSON user is created
        if($golonganDarah) {
            return response()->json([
                'success' => true,
                'message' => 'type golongan darah create success',
                'golongan_darah' => $golonganDarah
            ], 201);
        }
        
        //return JSON process insert failed 
        return response()->json([
            'success' => false,
            'message' => 'type golongan darah created failed',
        ], 409);
    }

    public function show()
    {
        return response()->json(['role' => GolonganDarah::all()]);
    }
}
