<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedUpdatedBy;
use App\Traits\CreatedUId;

class Branch extends Model
{
    use SoftDeletes, HasFactory;
    use CreatedUId;
    use CreatedUpdatedBy;

    protected $fillable = [
        'uid',
        'branch_id',
        'branch_name',
        'branch_location',
        'head_of_branch_id',
        'eiin',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function branchHead()
    {
        return $this->belongsTo(Teacher::class, 'head_of_branch_id', 'uid');
    }
    public function institute()
    {
        return $this->belongsTo(Institute::class, 'eiin', 'eiin');
    }
}
