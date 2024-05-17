<?php

namespace App\Services;

use App\Repositories\DistrictRepository;

class DistrictService
{
    private $districtRepository;

    public function __construct(DistrictRepository $districtRepository)
    {
        $this->districtRepository = $districtRepository;
    }

    public function list()
    {
        return $this->districtRepository->list();
    }

    public function getByUId($id)
    {
        return $this->districtRepository->getByUId($id);
    }

    public function create($data)
    {
      $this->districtRepository->create($data);
    }

    public function update($id, $data)
    {
        return $this->districtRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->districtRepository->delete($id);
    }
}
