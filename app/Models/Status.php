<?php

namespace App\Models;

use App\Enum\StatusType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'from',
        'to',
        'project_id',
    ];

    protected $casts = [
        'type' => StatusType::class,
    ];

    const DEFAULT_STATUSES = [
        'draft'       => StatusType::DRAFT,
        'on hold'     => StatusType::HOLD,
        'backlog'     => StatusType::PLANNING,
        'planning'    => StatusType::PLANNING,
        'in progress' => StatusType::IN_PROGRESS,
        'design'      => StatusType::IN_PROGRESS,
        'development' => StatusType::IN_PROGRESS,
        'cancelled'   => StatusType::CLOSED,
        'completed'   => StatusType::CLOSED,
    ];

    // Relationships

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
