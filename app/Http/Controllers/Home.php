<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request;

class Home extends Controller
{
    
    public function index(){
        return view("register");
    }
    
    public function doRegister(Request $res){        
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
//        dd($user);
        if($user){
            echo 'Registration success';
        }
        else{
            echo 'failed';
        }
    }
    
    public function login(){
        return view("login");
    }
    
    public function doLogin(){
         if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
             echo 'Login success';
        } 
        else{ 
            echo 'Login failed';
        } 
    }
    
}
