<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'short_description',
        'description',
        'tags',
        'assignee_id',
        'status_id',
        'stage_id',
        'project_id',
        'parent_task_id',
        'original_due_at',
        'due_at',
    ];

    protected $casts = [
        'original_due_at' => 'datetime',
        'due_at'          => 'datetime',
    ];

    protected $appends = ['parent_task', 'attachments', 'child_tasks'];

    // Relationships

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(Assignee::class);
    }

    protected function parentTask(): Attribute
    {
        $parent = Task::find($this->parent_task_id);
        return Attribute::make(
            get: fn () => $parent,
        );
    }

    protected function attachments(): Attribute
    {
        $class = get_class($this);

        return Attribute::make(
            get: fn () => Attachment::whereModel($class)->whereModelId($this->id)->get(),
        );
    }

    protected function childTasks(): Attribute
    {
        return Attribute::make(
            get: fn () => Task::whereParentTaskId($this->id)->get(),
        );
    }
}
