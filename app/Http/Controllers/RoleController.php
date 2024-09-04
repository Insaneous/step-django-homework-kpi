<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function create() {
        if (Auth::user()->role_id != 1)
            abort(403);

        $formFields = request()->validate([
            'name' => ['required', Rule::unique('roles', 'name')]
        ]);
        
        Role::create($formFields);

        return back();
    }

    public function edit(Role $role) {
        if (Auth::user()->role_id != 1)
            abort(403);

        return view('admin.edit-role', [
            'role' => $role,
            'roles' =>Role::filter(request(['search']))->get()
        ]);
    }

    public function put(Role $role) {
        if (Auth::user()->role_id != 1)
            abort(403);

        $formFields = request()->validate([
            'name' => 'required'
        ]);

        $role->update($formFields);
        
        return redirect()->route('admin-roles');
    }

    public function delete(Role $role) {
        if (Auth::user()->role_id != 1)
            abort(403);
        
        if ($role->id != 1){
            $role->delete();
        }

        return redirect()->route('admin-roles');
    }
}
