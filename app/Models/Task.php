<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'priority',
        'deadline',
        'started_at',
        'done_at',
        'file',
        'user_id',
        'department_id',
        'status',
        'speed_rating',
        'accuracy_rating',
        'quality_rating'
    ];

    public function scopeFilter($query, array $filters)
    {
        if ($filters['search'] ?? false) {
            $query->where('name', 'like', '%' . request('search') . '%')
                ->orWhere('content', 'like', '%' . request('search') . '%')
                ->orWhere('id', 'like', request('search'));
        }
    }

    function user() {
        return $this->belongsTo(User::class);
    }

    function department() {
        return $this->belongsTo(Department::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function comments(): HasMany {
        return $this->hasMany(Comment::class);
    }
}
