<?php

namespace App\Services;

use App\Repositories\TeacherRepository;

class TeacherService
{
    private $teacherRepository;

    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    public function list()
    {
        return $this->teacherRepository->list();
    }

    public function create($data)
    {
        return $this->teacherRepository->create($data);
    }

    public function update($data, $id, $is_restore = false)
    {
        return $this->teacherRepository->update($data, $id, $is_restore);
    }

    public function getById($id)
    {
        return $this->teacherRepository->getById($id);
    }

    public function getWithTrashedById($id)
    {
        return $this->teacherRepository->getWithTrashedById($id);
    }

    public function getByCaId($id)
    {
        return $this->teacherRepository->getByCaId($id);
    }

    public function getByEiinId($id, $is_not_paginate=null)
    {
        return $this->teacherRepository->getByEiinId($id, $is_not_paginate);
    }

    public function getBanbeisTeachers() {
        return $this->teacherRepository->getBanbeisTeachers();
    }

    public function getBanbeisTeachersById($id) {
        return $this->teacherRepository->getBanbeisTeachersById($id);
    }

    public function getBanbeisTeachersByEiinID($eiin) {
        return $this->teacherRepository->getBanbeisTeachersByEiinID($eiin);
    }

    public function getEmisTeachers() {
        return $this->teacherRepository->getEmisTeachers();
    }

    public function getEmisTeachersById($pdsid) {
        return $this->teacherRepository->getEmisTeachersById($pdsid);
    }

    public function getEmisTeachersByEiinID($eiin) {
        return $this->teacherRepository->getEmisTeachersByEiinID($eiin);
    }

    public function getEmisTeachersByEiinAndPdsID($eiin, $pdsid) {
        return $this->teacherRepository->getEmisTeachersByEiinAndPdsID($eiin, $pdsid);
    }

    public function authAccountCreateTeacher($data) {
        return $this->teacherRepository->authAccountCreateTeacher($data);
    }

    public function getInstituteByEiin($eiin) {
        return $this->teacherRepository->getInstituteByEiin($eiin);
    }

    public function delete($id)
    {
        return $this->teacherRepository->delete($id);
    }

}
