<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedUpdatedBy;
use App\Traits\CreatedUId;
use Awobaz\Compoships\Compoships;

class Student extends Model
{
    use Compoships;
    use SoftDeletes, HasFactory;
    use CreatedUId;
    use CreatedUpdatedBy;

    protected $fillable = [
        'eiin',
        'suid',
        'uid',
        'caid',
        'type',
        'incremental_no',
        'student_name_bn',
        'student_name_en',
        'brid',
        'date_of_birth',
        'email',
        'registration_year',
        'religion',
        'birth_place',
        'gender',
        'nationality',
        'recent_study_class',
        'disability_status',
        'blood_group',
        'student_mobile_no',
        'ethnic_info',
        'branch',
        'version',
        'shift',
        'class',
        'section',
        'roll',
        'is_regular',
        'father_name_en',
        'father_name_bn',
        'father_nid',
        'father_brid',
        'father_date_of_birth',
        'father_mobile_no',
        'mother_name_en',
        'mother_name_bn',
        'mother_nid',
        'mother_brid',
        'mother_date_of_birth',
        'mother_mobile_no',
        'guardian_name_bn',
        'guardian_name_en',
        'guardian_mobile_no',
        'guardian_nid',
        'guardian_occupation',
        'relation_with_guardian',
        'present_address',
        'permanent_address',
        'post_office',
        'division_id',
        'district_id',
        'upazilla_id',
        'unions',
        'image',
        'role',
        'data_source',
        'student_source',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch', 'uid');
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

}
