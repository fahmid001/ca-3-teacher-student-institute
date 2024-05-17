<?php

namespace App\Services;

use App\Repositories\ShiftRepository;

class ShiftService
{
    private $shiftRepository;

    public function __construct(ShiftRepository $shiftRepository)
    {
        $this->shiftRepository = $shiftRepository;
    }

    public function getAll()
    {
        return $this->shiftRepository->getAll();
    }

    public function create($data)
    {
        return $this->shiftRepository->create($data);
    }

    public function getById($id)
    {
        return $this->shiftRepository->getById($id);
    }

    public function getByEiinId($eiin)
    {
        return $this->shiftRepository->getByEiinId($eiin);
    }
    
    public function getByEiinIdWithPagination($eiin)
    {
        return $this->shiftRepository->getByEiinIdWithPagination($eiin);
    }
}
