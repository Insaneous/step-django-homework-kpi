<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function task(Task $task){
        $assigned = false;

        foreach($task->users as $user) {
            if ($user->id == Auth::id()) {
                $assigned = true;
            }
        }

        if (!Carbon::parseFromLocale($task->deadline)->isFuture()) {
            $task->update([
                'status' => 'EXPIRED'
            ]);
        }elseif ($task->status == 'EXPIRED'){
            $task->update([
                'status' => 'NEW'
            ]);
        }

        return view('task.task', [
            'task' => $task,
            'assigned' => $assigned
        ]);
    }

    public function create() {
        if (!in_array(Auth::user()->role_id, [1, 2]))
            abort(403);

        $formFields = request()->validate([
            'title' => 'required',
            'deadline' => 'required',
            'priority' => 'required',
            'content' => 'required',
            'department_id' => ''
        ]);

        $formFields['user_id'] = Auth::id();
        if(!$formFields['department_id']){
            $formFields['department_id'] = Auth::user()->department_id;
        }

        if(request()->hasFile('file')) {
            $formFields['file'] = request()->file('file')->store('attachments', 'public');
        }

        $task = Task::create($formFields);

        $task->users()->attach(request()->assignees);

        return back();
    }

    public function edit(Task $task) {
        if (!in_array(Auth::user()->role_id, [1, 2]))
            abort(403);

        $users = User::where('department_id', Auth::user()->department_id)->get();

        $tasks = Task::where('department_id', Auth::user()->department_id)->filter(request(['search']))->get();

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

        return view('task.edit-task', [
            'task' => $task,
            'tasks' => $tasks,
            'users' => $users
        ]);
    }

    public function put(Task $task) {
        if (!in_array(Auth::user()->role_id, [1, 2]))
            abort(403);

        $formFields = request()->validate([
            'title' => 'required',
            'deadline' => 'required',
            'priority' => 'required',
            'content' => 'required',
        ]);

        if(request()->hasFile('file')) {
            $formFields['file'] = request()->file('file')->store('attachments', 'public');
        }

        $task->update($formFields);

        $task->users()->sync(request()->assignees);
        
        return redirect()->route('tasks');
    }

    public function delete(Task $task) {
        if (!in_array(Auth::user()->role_id, [1, 2]))
            abort(403);

        $task->users()->sync([]);

        $task->delete();

        return redirect()->route('tasks');
    }

    public function assign(Task $task) {
        $task->users()->attach(Auth::id());

        return back();
    }

    public function deassign(Task $task) {
        $task->users()->detach(Auth::id());

        return back();
    }

    public function progress(Task $task) {
        $task->update([
            'status' => 'IN PROGRESS'
        ]);
        $task->update([
            'started_at' => $task->updated_at
        ]);

        return back();
    }

    public function done(Task $task) {
        $task->update([
            'status' => 'DONE'
        ]);
        $task->update([
            'done_at' => $task->updated_at
        ]);

        return back();
    }

    public function cancel(Task $task) {
        $task->update([
            'status' => 'CANCELED'
        ]);

        return back();
    }

    public function mark(Task $task) {
        if (!in_array(Auth::user()->role_id, [1, 2]))
            abort(403);

        $formFields = request()->validate([
            'speed_rating' => '',
            'accuracy_rating' => '',
            'quality_rating' => '',
        ]);

        $task->update($formFields);

        return back();
    }
}
