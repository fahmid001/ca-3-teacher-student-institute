<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedUpdatedBy;
use App\Traits\CreatedUId;
use Awobaz\Compoships\Compoships;

class ClassRoom extends Model
{
    use Compoships;
    use SoftDeletes, HasFactory;
    use CreatedUId;
    use CreatedUpdatedBy;

    protected $fillable = [
        'uid',
        'class_teacher_id',
        'eiin',
        'class_id',
        'section_id',
        'session_year',
        'branch_id',
        'shift_id',
        'version_id',
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

    public function class_teacher()
    {
        return $this->belongsTo(Teacher::class, 'class_teacher_id', 'uid');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'uid');
    }
    public function version()
    {
        return $this->belongsTo(Version::class, 'version_id', 'uid');
    }
    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'uid');
    }
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'uid');
    }
    public function students()
    {
        return $this->hasMany(
            Student::class,['eiin', 'branch', 'shift', 'version', 'class', 'section'], ['eiin', 'branch_id', 'shift_id', 'version_id', 'class_id', 'section_id']
        )->select(['uid', 'suid', 'caid', 'student_name_en', 'student_name_bn', 'eiin', 'branch', 'shift', 'version', 'class', 'section', 'date_of_birth', 'gender', 'religion', 'brid', 'registration_year', 'blood_group', 'father_name_en', 'father_name_bn', 'father_mobile_no', 'mother_name_en', 'mother_name_bn', 'mother_mobile_no']);
    }
}