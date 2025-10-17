<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskList extends Model
{
    use HasFactory;

    public const string TABLE = 'task_lists';

    public const string ID = 'id';
    public const string PROJECT_ID = 'project_id';
    public const string TITLE = 'title';
    public const string CREATED_AT = 'created_at';
    public const string UPDATED_AT = 'updated_at';

    protected $table = self::TABLE;
    protected $guarded = [self::ID];
    public $timestamps = true;

    // relations
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, self::PROJECT_ID, Project::ID);
    }

    public function taskListTasks(): HasMany
    {
        return $this->hasMany(TaskListTask::class, TaskListTask::TASK_LIST_ID, self::ID);
    }
}
