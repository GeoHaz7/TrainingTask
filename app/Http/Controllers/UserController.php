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
    //Show Register Form
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

        $formFields['isAdmin'] = 0;

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

    //Logout User
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out!');
    }

    //Manage View 
    public function manage()
    {
        return view('users.manageUsers', ['users' => auth()->user()->get()]);
    }

    //Edit User View
    public function editUser($id)
    {
        $user = User::findorfail($id);

        return view('users.editUser', ['user' => $user]);
    }

    //Update User
    public function updateUser(Request $request, $id)
    {
        // Make sure logged in user is owner
        // if ($user->user_id != auth()->id()) {
        //     abort(403, 'Unauthorized Action');
        // }

        $user = User::findorfail($id);

        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'isAdmin' => ['boolean'],
            'password' => ['required', 'confirmed', 'min:6']
        ]);


        $formFields['password'] = bcrypt($formFields['password']);

        $user->isAdmin = $request->has('isAdmin');


        $user->update($formFields);

        return back()->with('message', 'Listing updated successfully!');
    }

    //Delete User
    public function deleteUser($id)
    {

        $user = User::findorfail($id);

        // Make sure logged in user is owner
        // if ($user->user_id != auth()->id()) {
        //     abort(403, 'Unauthorized Action');
        // }

        $user->delete();
        return redirect('/')->with('message', 'Listing deleted successfully');
    }
}
