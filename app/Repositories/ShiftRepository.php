<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ShiftRepositoryInterface;

use App\Models\Shift;

class ShiftRepository implements ShiftRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function getAll()
    {
        return Shift::get();
    }

    public function create($data)
    {
        return Shift::create($data);
    }

    public function getById($id)
    {
        return Shift::where('uid', $id)->first();
    }

    public function getByEiinId($eiin)
    {
        return Shift::where('eiin', $eiin)->get();
    }

    public function getByEiinIdWithPagination($eiin)
    {
        return Shift::where('eiin', $eiin)->paginate(20);
    }
}
