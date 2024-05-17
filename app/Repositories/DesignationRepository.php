<?php

namespace App\Repositories;

use App\Repositories\Interfaces\DesignationRepositoryInterface;

use App\Models\Designation;

class DesignationRepository implements DesignationRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function list()
    {
        return Designation::get();
    }
}
