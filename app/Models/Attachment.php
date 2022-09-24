<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use ReflectionClass;

class Attachment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'extension',
        'filename',
        'filepath',
        'model',
        'model_id',
        'user_id',
    ];

    protected $appends = ['parent_model'];

    // Relationships

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function parentModel(): Attribute
    {
        $reflection = new ReflectionClass($this->model);
        $model = $reflection->newInstance();
        return Attribute::make(
            get: fn () => $model::find($this->model_id),
        );
    }
}
