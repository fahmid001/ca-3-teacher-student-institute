<?php

namespace App\Repositories\Interfaces;

interface UpazillaRepositoryInterface
{
    public function list();

    public function create($data);

    public function update($data, $id);
    
    public function delete($id);

    public function getByUId($id);
}
