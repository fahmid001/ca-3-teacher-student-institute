<?php

namespace App\Repositories;

use App\Models\SubjectTeacher;
use App\Repositories\Interfaces\SubjectTeacherRepositoryInterface;

class SubjectTeacherRepository implements SubjectTeacherRepositoryInterface
{
    public function getAll()
    {
        return SubjectTeacher::all();
    }

    public function getById($id)
    {
        return SubjectTeacher::where('uid', $id)->first();;
    }

    public function create($data)
    {
        return SubjectTeacher::create($data);
    }

    public function update($id, $data)
    {
        $result = SubjectTeacher::findOrFail($id);
        $result->update($data);
    }

    public function delete($id)
    {
        $result = SubjectTeacher::findOrFail($id);
        $result->delete();
    }

    public function getByTeacherId($teacher_id)
    {
        $result = SubjectTeacher::with('classRoom.students')
        ->select('uid', 'teacher_id', 'subject_id', 'class_room_id')
        ->where('teacher_id', $teacher_id)->get();
        return $result;
    }

    public function getByClassRoomId($class_room_id)
    {
        $result = SubjectTeacher::with('classRoom')->where('class_room_id', $class_room_id)->get();
        return $result;
    }
}
