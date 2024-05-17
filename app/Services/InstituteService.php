<?php

namespace App\Services;

use App\Repositories\InstituteRepository;

class InstituteService
{
    private $instituteRepository;

    public function __construct(InstituteRepository $instituteRepository)
    {
        $this->instituteRepository = $instituteRepository;
    }

    public function list()
    {
        return $this->instituteRepository->list();
    }

    public function storeInstituteHeadMaster($data)
    {
        return $this->instituteRepository->storeInstituteHeadMaster($data);
    }

    public function create($data)
    {
        return $this->instituteRepository->create($data);
    }

    public function getById($id)
    {
        return $this->instituteRepository->getById($id);
    }
    public function getByEiinId($id)
    {
        return $this->instituteRepository->getByEiinId($id);
    }
    public function getByInstituteUpazilaId($id)
    {
        return $this->instituteRepository->getByUpazilaId($id);
    }

    public function getUpazilaInstituteWithHeadMaster($upazila_id)
    {
        return $this->instituteRepository->getUpazilaInstituteWithHeadMaster($upazila_id);
    }

    public function getUpazilaTeachers($upazila_id) {
        return $this->instituteRepository->getUpazilaTeachers($upazila_id);
    }

    public function updateInstituteHeadMaster($data) {
        return $this->instituteRepository->updateInstituteHeadMaster($data);
    }
}
