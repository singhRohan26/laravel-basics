<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request;

class AuthController extends Controller
{
    
    public function register(Request $res){
        
        $this->validate($res, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
 
        $user = User::create([
            'name' => $res->name,
            'email' => $res->email,
            'password' => bcrypt($res->password)
        ]);
        
        //creating passport token
        $token = $user->createToken('MyApp')-> accessToken;
        
        return response()->json(['msg' => 'Registration Success','token'=>$token], 200);         
        
    }
    
     public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => $success], 200); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
    
}
