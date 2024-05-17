<?php

namespace App\Services;

use App\Repositories\DivisionRepository;

class DivisionService
{
    private $divisionRepository;

    public function __construct(DivisionRepository $divisionRepository)
    {
        $this->divisionRepository = $divisionRepository;
    }

    public function list()
    {
        return $this->divisionRepository->list();
    }

    public function getByUId($id)
    {
        return $this->divisionRepository->getByUId($id);
    }

    public function create($data)
    {
        $this->divisionRepository->create($data);
    }

    public function update($id, $data)
    {
        return $this->divisionRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->divisionRepository->delete($id);
    }
}
