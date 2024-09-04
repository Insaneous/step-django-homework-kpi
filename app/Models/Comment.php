<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'content',
        'file',
        'reply'
    ];

    function task() {
        return $this->belongsTo(Task::class);
    }

    function user() {
        return $this->belongsTo(User::class);
    }
}
