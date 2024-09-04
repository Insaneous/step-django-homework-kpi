<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function create() {
        if (Auth::user()->role_id != 1)
            abort(403);

        $formFields = request()->validate([
            'name' => ['required', Rule::unique('departments', 'name')]
        ]);

        Department::create($formFields);

        return back();
    }

    public function edit(Department $department) {
        if (Auth::user()->role_id != 1)
            abort(403);

        return view('admin.edit-department', [
            'department' => $department,
            'departments' =>Department::filter(request(['search']))->get()
        ]);
    }

    public function put(Department $department) {
        if (Auth::user()->role_id != 1)
            abort(403);

        $formFields = request()->validate([
            'name' => 'required'
        ]);

        $department->update($formFields);
        
        return redirect()->route('admin-departments');
    }

    public function delete(Department $department) {
        if (Auth::user()->role_id != 1)
            abort(403);
        
        if ($department->id != 1){
            $department->delete();
        }

        return redirect()->route('admin-departments');
    }
}
