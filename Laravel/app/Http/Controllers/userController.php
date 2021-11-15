<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class userController extends Controller
{
    public function register(Request $request){
        $validator= Validator::make($request->all(), [
    		'email' => 'required|unique:users',
    		'password' => 'required',
    		'name' => 'required'
		]);
        if($validator->fails())
    	{
    		return response()->json(['error'=>$validator->errors()->all()]);
    	}
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = encrypt($request->password);
        $user->save();
        return response()->json(['message'=>'user registered successfully']);

    }

    public function login(Request $request){
        $validator= Validator::make($request->all(), [
    		'email' => 'required|unique:users',
    		'password' => 'required'
		]);
        if($validator->fails())
    	{
    		return response()->json(['error'=>$validator->errors()->all()]);
    	}
        $user =User::where('email',$request->email)->get()->first();
        $password = decrypt($request->password);
        if($user && $password == $request->password)
        {
            return response()->json(['user'=>$user]);
        }
        return response()->json(['error'=>'user not found!']);
        

    }
}
