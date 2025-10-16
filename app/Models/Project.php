<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TABLE = 'projects';

    public const ID = 'id';
    public const USER_ID = 'user_id';
    public const TITLE = 'title';
    public const DESCRIPTION = 'description';
    public const PRIVATE = 'private';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const DELETED_AT = 'deleted_at';

    protected $table = self::TABLE;
    protected $guarded = [self::ID];
    public $timestamps = true;

    protected function casts(): array
    {
        return [self::PRIVATE => 'boolean'];
    }

    // relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, self::USER_ID, User::ID);
    }

    public function taskLists(): HasMany
    {
        return $this->hasMany(TaskList::class, TaskList::PROJECT_ID, self::ID);
    }

    public function notepad(): HasOne
    {
        return $this->hasOne(Notepad::class, Notepad::PROJECT_ID, self::ID);
    }
}
