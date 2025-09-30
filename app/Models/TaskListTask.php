<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskListTask extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TABLE = 'task_list_tasks';

    public const ID = 'id';
    public const TASK_LIST_ID = 'task_list_id';
    public const DESCRIPTION = 'description';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const COMPLETED_AT = 'completed_at';
    public const DELETED_AT = 'deleted_at';

    protected $table = self::TABLE;
    protected $guarded = [self::ID];
    public $timestamps = true;

    // relations
    public function taskList(): BelongsTo
    {
        return $this->belongsTo(TaskList::class, self::TASK_LIST_ID, TaskList::ID);
    }
}
