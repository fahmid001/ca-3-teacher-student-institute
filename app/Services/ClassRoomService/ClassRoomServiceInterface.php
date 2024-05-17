<?php

namespace App\Services\ClassRoomService;

interface ClassRoomServiceInterface
{
    public function getAllClassRooms();
    public function getAllClassRoomsByEiin($eiin);
    public function getClassRoomById($id);
    public function createClassRoom($data);
    public function updateClassRoom($id, $data);
    public function deleteClassRoom($id);
    public function getAllClassRoomsByEiinWithPagination($eiin);
}
