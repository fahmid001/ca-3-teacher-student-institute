<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\District;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedUpdatedBy;
use App\Traits\CreatedUId;

class Institute extends Model
{
    use SoftDeletes, HasFactory;
    use CreatedUId;
    use CreatedUpdatedBy;


    protected $appends = ['district_name'];

    protected $fillable = [
        'uid',
        'eiin',
        'caid',
        'division_id',
        'district_id',
        'upazilla_id',
        'unions',
        'institute_name',
        'institute_type',
        'category',
        'level',
        'mpo',
        'phone',
        'head_caid',
        'head_of_institute_mobile',
        'mobile',
        'email',
        'address',
        'post_office',
        'message',
        'data_soruce',
        'institute_source',
        'role',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function getDistrictNameAttribute()
    {
        return !empty($this->district) ? $this->district->name : null;
    }

    public function headMaster()
    {
        return $this->belongsTo(Teacher::class, 'eiin', 'eiin')->where('designation_id', 76);
    }

    public function head_master()
    {
        return $this->hasMany(Teacher::class, 'eiin', 'eiin');
    }
    
}
