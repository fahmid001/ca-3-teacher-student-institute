<?php

namespace App\Repositories;

use App\Repositories\Interfaces\DivisionRepositoryInterface;

use App\Models\Division;

class DivisionRepository implements DivisionRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function list()
    {
        return Division::get();
    }

    public function getByUId($id)
    {
        return Division::where('uid', $id)->first();;
    }

    public function create($data)
    {
        $division = new Division;
        $division->name = @$data['name'];
        $division->save();
        return $division;
    }

    public function update($data, $id)
    {
        $division = Division::where('uid', $id)->first();
        $division->name = @$data['name'];
        $division->save();
        return $division;
    }

    public function delete($id)
    {
    }
}
