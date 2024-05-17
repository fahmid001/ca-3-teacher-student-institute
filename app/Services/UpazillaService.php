<?php

namespace App\Services;

use App\Repositories\UpazillaRepository;

class UpazillaService
{
    private $upazillaRepository;

    public function __construct(UpazillaRepository $upazillaRepository)
    {
        $this->upazillaRepository = $upazillaRepository;
    }

    public function list()
    {
        return $this->upazillaRepository->list();
    }

    public function getByUId($id)
    {
        return $this->upazillaRepository->getByUId($id);
    }

    public function create($data)
    {
      $this->upazillaRepository->create($data);
    }

    public function update($id, $data)
    {
        return $this->upazillaRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->upazillaRepository->delete($id);
    }
}
