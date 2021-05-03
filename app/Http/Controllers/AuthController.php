<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = User::where('email', $request->input('email'))->first();

            if (!$user || !Hash::check($request->input('password'), $user->password)) {
                return redirect(route('login'))->withErrors([
                    'login' => 'Email or password is incorrect!'
                ])->withInput();
            }

            Auth::login($user);

            return redirect('/dashboard');
        }

        return view('auth/login');
    }

    public function register(Request $request)
    {
        //TODO
        if ($request->isMethod('post')) {
            $this-> validate($request, [
               'name' => 'required',
               'email'=> 'required|email',
               'password'=> 'required|confirmed'
               
            ]);

            $userCount= User::where('email',$request->input('email'))->count();
            if($userCount>0){
                
                return redirect()->route('register')->withErrors([
                    'register'=>'Email already registered'
                ]);
            }else{
                $user= new User;
                $user->name=$request['name'];
                $user->email=$request['email'];
                $user->password= bcrypt($request['password']);
                $user->save();

                return redirect()->route('login')->with('message','Acount created successfully!');
                                    
                
            }
            //create user
            // login user or send activate email
            //redirected to dashboard/login
        }

        //return view register
        return view('auth.register');
    }
} 