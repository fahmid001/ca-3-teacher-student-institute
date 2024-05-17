<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedUpdatedBy;
use App\Traits\CreatedUId;

class PiEvaluation extends Model
{
    use SoftDeletes, HasFactory;
    use CreatedUId;
    use CreatedUpdatedBy;

    protected $fillable = [
        'uid',
        'evaluate_type',
        'bi_uid',
        'weight_uid',
        'student_uid',
        'teacher_uid',
        'class_room_uid',
        'submit_status',
        'is_approved',
        'remark',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
