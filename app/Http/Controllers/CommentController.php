<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    public function create(Task $task) {
        $formFields = request()->validate([
            'content' => 'required'
        ]);

        $formFields['user_id'] = Auth::id();
        $formFields['task_id'] = $task->id;

        if(request()->hasFile('file')) {
            $formFields['file'] = request()->file('file')->store('attachments', 'public');
        }

        Comment::create($formFields);

        return back();
    }

    public function reply(Comment $comment) {
        if ($comment->task->user_id != Auth::id())
            abort(403);

        $formFields = request()->validate([
            'reply' => 'required'
        ]);

        $comment->update($formFields);

        return back();
    }

    public function put(Comment $comment) {
        if ($comment->user_id != Auth::id())
            abort(403);

        $formFields = request()->validate([
            'content' => 'required'
        ]);

        if(request()->hasFile('file')) {
            $formFields['file'] = request()->file('file')->store('attachments', 'public');
        }

        $comment->update($formFields);

        return back();
    }

    public function delete(Comment $comment) {
        if ($comment->user_id != Auth::id())
            abort(403);

        $comment->delete();

        return back();
    }
}
