<?php

namespace App\Services;

use App\Repositories\VersionRepository;

class VersionService
{
    private $versionRepository;

    public function __construct(VersionRepository $versionRepository)
    {
        $this->versionRepository = $versionRepository;
    }

    public function getAll()
    {
        return $this->versionRepository->getAll();
    }

    public function create($data)
    {
        return $this->versionRepository->create($data);
    }

    public function getById($id)
    {
        return $this->versionRepository->getById($id);
    }

    public function getByEiinId($eiin)
    {
        return $this->versionRepository->getByEiinId($eiin);
    }
    
    public function getByEiinIdWithPagination($eiin)
    {
        return $this->versionRepository->getByEiinIdWithPagination($eiin);
    }
}
