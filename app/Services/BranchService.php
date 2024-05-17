<?php

namespace App\Services;

use App\Repositories\BranchRepository;

class BranchService
{
    private $branchRepository;

    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }

    public function getAll()
    {
        return $this->branchRepository->getAll();
    }

    public function create($data)
    {
        return $this->branchRepository->create($data);
    }

    public function getById($id)
    {
        return $this->branchRepository->getById($id);
    }

    public function getByEiinId($eiin)
    {
        return $this->branchRepository->getByEiinId($eiin);
    }

    public function getByEiinIdWithPagination($eiin)
    {
        return $this->branchRepository->getByEiinIdWithPagination($eiin);
    }

    public function removeBranch($id)
    {
        return $this->branchRepository->delete($id);
    }
}
