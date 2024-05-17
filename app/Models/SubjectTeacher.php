<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedUpdatedBy;
use App\Traits\CreatedUId;

class SubjectTeacher extends Model
{
    use SoftDeletes, HasFactory;
    use CreatedUId;
    use CreatedUpdatedBy;

    protected $fillable = [
        'uid',
        'teacher_id',
        'subject_id',
        'class_room_id',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'created_by', 'updated_by',
    ];

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_room_id', 'uid')->select(['uid', 'eiin', 'class_teacher_id', 'class_id', 'section_id', 'branch_id', 'shift_id', 'version_id', 'session_year']);
    }
}
