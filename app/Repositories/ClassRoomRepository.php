<?php

namespace App\Repositories;

use App\Models\ClassRoom;
use App\Models\SubjectTeacher;
use App\Repositories\Interfaces\ClassRoomRepositoryInterface;

class ClassRoomRepository implements ClassRoomRepositoryInterface
{
    public function getAll()
    {
        return ClassRoom::all();
    }

    public function getAllByEiin($eiin)
    {
        return ClassRoom::where('eiin', $eiin)->get();;
    }

    public function getAllByEiinWithPagination($eiin)
    {
        return ClassRoom::where('eiin', $eiin)->paginate(20);
    }

    public function getById($id)
    {
        return ClassRoom::where('uid', $id)->first();;
    }

    public function create($data)
    {
        $class_room = new ClassRoom();

        $class_room->class_teacher_id = $data['class_teacher_id'];
        $class_room->eiin = app('sso-auth')->user()->eiin;
        $class_room->class_id = $data['class_id'];
        $class_room->section_id = $data['section_id'];
        $class_room->session_year = $data['session_year'];
        $class_room->branch_id = $data['branch_id'];
        $class_room->shift_id = $data['shift_id'];
        $class_room->version_id = $data['version_id'];
        $class_room->status = $data->status ?? 1;
        $class_room->save();

        foreach($data['teacher_ids'] as $subject_id=>$teacher_id){
            $subject_teacher = new SubjectTeacher();
            $subject_teacher->teacher_id = $teacher_id;
            $subject_teacher->subject_id = $subject_id;
            $subject_teacher->class_room_id = $class_room->uid;
            $subject_teacher->status = 1;
            $subject_teacher->save();
        }
        return true;
    }

    public function update($id, $data)
    {
        $class_room = ClassRoom::where('uid', $id)->first();

        $class_room->class_teacher_id = $data['class_teacher_id'];
        $class_room->eiin = app('sso-auth')->user()->eiin;
        $class_room->class_id = $data['class_id'];
        $class_room->section_id = $data['section_id'];
        $class_room->session_year = $data['session_year'];
        $class_room->branch_id = $data['branch_id'];
        $class_room->shift_id = $data['shift_id'];
        $class_room->version_id = $data['version_id'];
        $class_room->status = $data->status ?? 1;
        $class_room->save();

        foreach($data['teacher_ids'] as $subject_id=>$teacher_id){
            $subject_teacher = SubjectTeacher::where('class_room_id', $class_room->uid)->where('subject_id', $subject_id)->first();
            if($subject_teacher){
                $subject_teacher = $subject_teacher;
            }
            else{
                $subject_teacher = new SubjectTeacher();
            }
            $subject_teacher->teacher_id = $teacher_id;
            $subject_teacher->subject_id = $subject_id;
            $subject_teacher->class_room_id = $class_room->uid;
            $subject_teacher->status = 1;
            $subject_teacher->save();
        }
        return true;
    }

    public function delete($id)
    {
        $result = ClassRoom::where('uid', $id)->first();

        $subject_teacher = SubjectTeacher::where('class_room_id', $result->uid)->get();
        foreach($subject_teacher as $item){
            $item->delete();
        }
        $result->delete();
        return true;
    }
}
