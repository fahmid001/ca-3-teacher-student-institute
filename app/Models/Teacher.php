<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedUpdatedBy;
use App\Traits\CreatedUId;

class Teacher extends Model
{
    use SoftDeletes, HasFactory;
    use CreatedUId;
    use CreatedUpdatedBy;

    protected $fillable = [
        'eiin',
        'caid',
        'uid',
        'pdsid',
        'type',
        'incremental_no',
        'institute_type',
        'index_number',
        'institute_name',
        'workstation_name',
        'branch_institute_name',
        'email',
        'mobile_no',
        'gender',
        'branch_institute_category',
        'institute_category',
        'service_break_institute',
        'name_en',
        'name_bn',
        'fathers_name',
        'mothers_name',
        'designation',
        'subject',
        'date_of_birth',
        'mpo_code',
        'nid',
        'ismpo',
        'data_source',
        'teacher_source',
        'teacher_type',
        // 'access_type',
        'role',
        'designation_id',
        'division_id',
        'district_id',
        'upazilla_id',
        'joining_year',
        'joining_date',
        'last_working_date',
        'image',
        'isactive',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function assigned_subjects()
    {
        return $this->hasMany(SubjectTeacher::class, 'teacher_id', 'uid');
    }

    public function institute() {
        return $this->belongsTo(Institute::class, 'eiin', 'eiin');
    }

    public function designations()
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'uid');
    }
}
