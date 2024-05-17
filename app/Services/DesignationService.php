<?php

namespace App\Services;

use App\Repositories\DesignationRepository;

class DesignationService
{
    private $designationRepository;

    public function __construct(DesignationRepository $designationRepository)
    {
        $this->designationRepository = $designationRepository;
    }

    public function list()
    {
        return $this->designationRepository->list();
    }
}
