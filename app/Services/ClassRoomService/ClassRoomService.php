<?php

namespace App\Services\ClassRoomService;

use App\Repositories\Interfaces\ClassRoomRepositoryInterface;
use App\Services\ClassRoomService\ClassRoomServiceInterface;

class ClassRoomService implements ClassRoomServiceInterface
{
    private $classRoomRepository;

    public function __construct(ClassRoomRepositoryInterface $classRoomRepository)
    {
        $this->classRoomRepository = $classRoomRepository;
    }

    public function getAllClassRooms()
    {
        return $this->classRoomRepository->getAll();
    }
    public function getAllClassRoomsByEiin($eiin)
    {
        return $this->classRoomRepository->getAllByEiin($eiin);
    }
    
    public function getAllClassRoomsByEiinWithPagination($eiin)
    {
        return $this->classRoomRepository->getAllByEiinWithPagination($eiin);
    }

    public function getClassRoomById($id)
    {
        return $this->classRoomRepository->getById($id);
    }

    public function createClassRoom($data)
    {
        return $this->classRoomRepository->create($data);
    }

    public function updateClassRoom($id, $data)
    {
        return $this->classRoomRepository->update($id, $data);
    }

    public function deleteClassRoom($id)
    {
        return $this->classRoomRepository->delete($id);
    }

}
