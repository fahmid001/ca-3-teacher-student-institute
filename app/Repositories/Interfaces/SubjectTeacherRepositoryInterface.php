<?php

namespace App\Repositories\Interfaces;

interface SubjectTeacherRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function create($data);
    public function update($id, $data);
    public function delete($id);
    public function getByTeacherId($teacher_id);
    public function getByClassRoomId($class_room_id);
}
