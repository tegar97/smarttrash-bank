<?php

namespace App\Http\Controllers;

use App\Mail\sendNotification;
use App\Models\register_code;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('appToken')->accessToken;
            return response()->json([
                'success' => true,
                'token' => $success,
                'user' => $user,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'code' => ['required']
        ]);

        $checkAvailableRfid = register_code::where('code', $request->code)->first();


      


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => "Email sudah dipakai"
            ],
                401
            );
        }
   

        if ($checkAvailableRfid == null) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid code'
        
            ]);
        
        } else{

            $user = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'name' => $request->name,
                'code' => $request->code,
                'totalBottle' => 0,
                'balance' => 5000  ,
                'rfid' => $checkAvailableRfid['rfid']
            ]);
            $success['token'] = $user->createToken('appToken')->accessToken;

            return response()->json([
                'success' => true,
                'token' => $success,
                'user' => $user
            ]);
        }

       
    }


    public function addBalance(Request $request) {
        $user = User::where('rfid', $request->rfid)->first();


        if($user != null){
            $user->update([
                'balance' => $user['balance'] + $request->balance,
                'totalBottle' => $user['totalBottle'] + $request->totalBottle,
            ]);
            
            
            Mail::to($user->email)->send(new sendNotification($user->name,$request->balance,$request->totalBottle));
            return response($user->name);



        }else{
            return response('KARTU TIDAK TERDAFTAR');

        }


    

    }

    public function logout(Request $request)
    {
        if (Auth::user()) {
            $user = Auth::user()->token();
            $user->revoke();
            return response()->json([
                'success' => true,
                'message' => 'Logout successfully',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unable to Logout',
            ]);
        }
    }
}
