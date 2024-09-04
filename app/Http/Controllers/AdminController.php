<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function admin() {
        if (Auth::user()->role_id != 1)
            abort(403);

        return redirect()->route('admin-users');
    }

    public function users() {
        if (Auth::user()->role_id != 1)
            abort(403);

        $users = User::filter(request(['search']))->get();
        foreach ($users as $key => $value) {
            $value->role_id = Role::where('id', $value->role_id)->get()[0]->name;
            $value->department_id = Department::where('id', $value->department_id)->get()[0]->name;
        }

        return view('admin.users', [
            'roles' =>Role::all(),
            'departments' =>Department::all(),
            'users' =>$users,
        ]);
    }

    public function roles() {
        if (Auth::user()->role_id != 1)
            abort(403);

        return view('admin.roles', [
            'roles' =>Role::filter(request(['search']))->get()
        ]);
    }

    public function departments() {
        if (Auth::user()->role_id != 1)
            abort(403);

        return view('admin.departments', [
            'departments' =>Department::filter(request(['search']))->get()
        ]);
    }

    public function tasks(Department $department) {
        if (Auth::user()->role_id != 1)
            abort(403);
        
        $users = User::where('department_id', $department->id)->get();

        $tasks = Task::where('department_id', $department->id)->filter(request(['search']))
            ->orderBy(request('sort'), request('order')?request('order'):'asc')->get();

        foreach($tasks as $task) {
            if (!Carbon::parseFromLocale($task->deadline)->isFuture()) {
                $task->update([
                    'status' => 'EXPIRED'
                ]);
            }elseif ($task->status == 'EXPIRED'){
                $task->update([
                    'status' => 'NEW'
                ]);
            }
        }

        return view('admin.tasks', [
            'departments' => Department::all(),
            'department' => $department,
            'tasks' =>$tasks,
            'users' =>$users,
        ]);
    }
}
