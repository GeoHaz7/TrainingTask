<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //Show Login Form
    public function login()
    {
        return view('users.login');
    }
    //Show Login Form
    public function register()
    {
        return view('users.register');
    }
    //create user
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        //Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        

        //create user
        $user = User::create($formFields);

        //login
        auth()->login($user);

        return redirect('/')->with('message', 'User created and logged in');
    }

    //Auth User
    public function auth(Request $request)
    {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'YOU HAVE BEEN logged in');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }
}
