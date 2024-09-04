<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;

class AuthController extends Controller
{
    public function login() {
        return view('auth.login', [

        ]);
    }

    public function auth(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
 
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');

    }

    public function create() {
        if (!in_array(Auth::user()->role_id, [1, 2]))
            abort(403);

        $formFields = request()->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed'],
            'lastname' => 'required',
            'role_id' => '',
            'department_id' => '',
        ]);

        if (!isset($formFields['role_id'])) {
            $formFields['role_id'] = 3;
            $formFields['department_id'] = Auth::user()->department_id;
        }

        User::create($formFields);

        return back();
    }

    public function edit(User $user) {
        if (!in_array(Auth::user()->role_id, [1, 2]))
            abort(403);

        $users = User::filter(request(['search']))->get();
        foreach ($users as $key => $value) {
            $value->role_id = Role::where('id', $value->role_id)->get()[0]->name;
            $value->department_id = Department::where('id', $value->department_id)->get()[0]->name;
        }

        return view('admin.edit-user', [
            'user' => $user,
            'roles' =>Role::all(),
            'departments' =>Department::all(),
            'users' =>$users,
        ]);
    }

    public function put(User $user) {
        if (!in_array(Auth::user()->role_id, [1, 2]))
            abort(403);

        $formFields = request()->validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => 'confirmed',
            'lastname' => 'required',
            'role_id' => '',
            'department_id' => '',
        ]);

        if (!$formFields['password']){
            unset($formFields['password']);
        }
        
        $user->update($formFields);
        
        return back();
    }

    public function delete(User $user) {
        if (!in_array(Auth::user()->role_id, [1, 2]))
            abort(403);
        
        if ($user->id != 1){
            $user->tasks()->sync([]);
            $user->delete();
        }

        return back();
    }
}
