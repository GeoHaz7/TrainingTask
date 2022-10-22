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
        $formFields['isActive'] = 1;
        $formFields['isLoggedIn'] = 0;

        //create user
        $user = User::create($formFields);

        //login
        auth()->login($user);

        // dd($user->id);


        User::where('id', $user->id)->update(array('isLoggedIn' => '1'));



        return redirect('/')->with('message', 'User created');
    }

    //Auth User
    public function auth(Request $request)
    {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (auth()->attempt($formFields)) {

            $user =
                User::where('email', $request->email)->first();

            if ($user->isActive == '0') {
                $request->session()->invalidate();
                abort(403, 'Account is not active please contact Admin');
            } else {
                $request->session()->regenerate();
                User::where('id', $user->id)->update(array('isLoggedIn' => '1'));

                return redirect('/')->with('message', 'YOU HAVE BEEN logged in');
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }

    //Logout User
    public function logout(Request $request)
    {
        User::where('id', auth()->user()->id)->update(array('isLoggedIn' => '0'));
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();




        return redirect('/')->with('message', 'You have been logged out!');
    }

    //Manage View 
    public function manage()
    {
        // dd(User::order()->all());
        return view('users.manageUsers', ['users' => User::order()->paginate(3)]);
    }

    //Edit User View
    public function editUser($id)
    {
        $user = User::findorfail($id);

        if (auth()->user()->isAdmin || $user->user_id == auth()->id()) {
            return view('users.editUser', ['user' => $user]);
        } else {

            // Make sure logged in user is owner
            abort(403, 'Unauthorized Action');
        }
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
            'password' => ['nullable', 'confirmed', 'min:6']
        ]);


        if ($formFields['password']) {
            $formFields['password'] = bcrypt($formFields['password']);
        } else {
            $formFields['password'] = $user->password;
        }


        $user->isAdmin = $request->has('isAdmin');

        $user->isActive = $request->input('isActive');

        $user->update($formFields);

        return back()->with('message', 'User updated successfully!');
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
        return redirect('/')->with('message', 'User deleted successfully');
    }
}
