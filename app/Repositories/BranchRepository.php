<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BranchRepositoryInterface;

use App\Models\Branch;

class BranchRepository implements BranchRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function getAll()
    {
        return Branch::get();
    }

    public function create($data)
    {
        return Branch::create($data);
    }

    public function getById($id)
    {
        return Branch::where('uid', $id)->first();
    }

    public function getByEiinId($eiin)
    {
        return Branch::where('eiin', $eiin)->get();
    }

    public function getByEiinIdWithPagination($eiin)
    {
        return Branch::where('eiin', $eiin)->paginate(20);
    }
}