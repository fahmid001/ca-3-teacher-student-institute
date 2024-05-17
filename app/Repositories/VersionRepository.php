<?php

namespace App\Repositories;

use App\Repositories\Interfaces\VersionRepositoryInterface;

use App\Models\Version;

class VersionRepository implements VersionRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function getAll()
    {
        return Version::get();
    }

    public function create($data)
    {
        return Version::create($data);
    }

    public function getById($id)
    {
        return Version::where('uid', $id)->first();
    }

    public function getByEiinId($eiin)
    {
        return Version::where('eiin', $eiin)->get();
    }

    public function getByEiinIdWithPagination($eiin)
    {
        return Version::where('eiin', $eiin)->paginate(20);
    }
}
