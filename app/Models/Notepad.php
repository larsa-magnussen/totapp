<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notepad extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const string TABLE = 'notepads';

    public const string ID = 'id';
    public const string PROJECT_ID = 'project_id';
    public const string CREATED_AT = 'created_at';
    public const string UPDATED_AT = 'updated_at';
    public const string DELETED_AT = 'deleted_at';

    protected $table = self::TABLE;
    protected $guarded = [self::ID];
    public $timestamps = true;

    // relations
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
