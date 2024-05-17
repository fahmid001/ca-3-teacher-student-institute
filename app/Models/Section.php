<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedUpdatedBy;
use App\Traits\CreatedUId;

class Section extends Model
{
    use SoftDeletes, HasFactory;
    use CreatedUId;
    use CreatedUpdatedBy;

    protected $fillable = [
        'uid',
        'section_name',
        'section_details',
        'section_year',
        'class_id',
        'shift_id',
        'version_id',
        'branch_id',
        'eiin',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function branch()
    {
        return $this->hasOne(Branch::class, 'uid','branch_id');
    }

    public function version()
    {
        return $this->hasOne(Version::class, 'uid','version_id');
    }

    public function shift()
    {
        return $this->hasOne(Shift::class, 'uid','shift_id');
    }
}
