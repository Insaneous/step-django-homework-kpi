<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;

class IndexController extends Controller
{
    public function index() {
        $users = User::where('department_id', Auth::user()->department_id)->filter(request(['search']))->get();

        return view('index.dashboard', [
            'users' =>$users,
        ]);
    }

    public function users() {
        if (!in_array(Auth::user()->role_id, [1,2]))
            abort(403);

        $users = User::where('department_id', Auth::user()->department_id)->filter(request(['search']))->get();

        return view('index.users', [
            'roles' =>Role::all(),
            'departments' =>Department::all(),
            'users' =>$users,
        ]);
    }

    public function tasks() {
        $users = User::where('department_id', Auth::user()->department_id)->get();

        $tasks = Task::where('department_id', Auth::user()->department_id)->filter(request(['search']))
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

        return view('index.tasks', [
            'tasks' =>$tasks,
            'users' =>$users,
        ]);
    }
}