<?php

namespace App\Services;

use App\Repositories\StudentRepository;

class StudentService
{
    private $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function list()
    {
        return $this->studentRepository->list();
    }

    public function create($data)
    {
        return $this->studentRepository->create($data);
    }

    public function update($data, $id, $is_restore = false)
    {
        return $this->studentRepository->update($data, $id, $is_restore);
    }

    public function getById($id)
    {
        return $this->studentRepository->getById($id);
    }

    public function getByEiinId($id)
    {
        return $this->studentRepository->getByEiinId($id);
    }

    public function getBranchByEiinId($id)
    {
        return $this->studentRepository->getBranchByEiinId($id);
    }

    public function getVersionByEiinId($branch, $id)
    {
        return $this->studentRepository->getVersionByEiinId($branch, $id);
    }

    public function getShiftByEiinId($branch, $id)
    {
        return $this->studentRepository->getShiftByEiinId($branch, $id);
    }

    public function getSectionByEiinId($branch, $class, $shift, $version, $id)
    {
        return $this->studentRepository->getSectionByEiinId($branch, $class, $shift, $version, $id);
    }

    public function getByCaId($id)
    {
        return $this->studentRepository->getByCaId($id);
    }

    public function getByUId($id)
    {
        return $this->studentRepository->getByUId($id);
    }

    public function getWithTrashedById($data, $eiin)
    {
        return $this->studentRepository->getWithTrashedById($data, $eiin);
    }

    public function checkRollExists($caid, $roll)
    {
        return $this->studentRepository->checkRollExists($caid, $roll);
    }

    public function authAccountCreateStudent($data) {
        return $this->studentRepository->authAccountCreateStudent($data);
    }

    public function authAccountCreateInstitude($data) {
        return $this->studentRepository->authAccountCreateInstitude($data);
    }

    public function delete($id)
    {
        return $this->studentRepository->delete($id);
    }
}
