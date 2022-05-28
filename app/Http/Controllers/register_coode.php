<?php

namespace App\Http\Controllers;

use App\Models\register_code;
use App\Models\User;
use Illuminate\Http\Request;

class register_coode extends Controller
{
    public function create(Request $request){

    
        $checkAvailableRfid = register_code::where('rfid',$request->rfid)->first();
        $checkifAlreadyExist = User::where('rfid',$request->rfid)->first();
        $code = rand(10000, 99999);

        if($checkifAlreadyExist == null){
            if ($checkAvailableRfid == null) {
                register_code::create([
                    'rfid' => $request->rfid,
                    'code' => $code
                ]);
            } else {
                $checkAvailableRfid->update([
                    'rfid' => $request->rfid,
                    'code' => $code
                ]);
            }
            return response($code);

        }else{
            return response('Kartu telah terdaftar');
        }

       
    

    }
}
