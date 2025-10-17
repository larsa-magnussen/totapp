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

    public const string TABLE = 'task_list_tasks';

    public const string ID = 'id';
    public const string TASK_LIST_ID = 'task_list_id';
    public const string DESCRIPTION = 'description';
    public const string CREATED_AT = 'created_at';
    public const string UPDATED_AT = 'updated_at';
    public const string COMPLETED_AT = 'completed_at';
    public const string DELETED_AT = 'deleted_at';

    protected $table = self::TABLE;
    protected $guarded = [self::ID];
    public $timestamps = true;

    // relations
    public function taskList(): BelongsTo
    {
        return $this->belongsTo(TaskList::class, self::TASK_LIST_ID, TaskList::ID);
    }
}
