<?php

namespace App\Repositories\Interfaces;

interface StudentRepositoryInterface
{
    public function list();

    public function create($data);

    public function update($data, $id);
    
    public function getById($id);

    public function getByEiinId($id);

    public function getBranchByEiinId($id);

    public function getVersionByEiinId($branch, $id);

    public function getShiftByEiinId($branch, $id);

    public function getWithTrashedById($data, $eiin);

    public function checkRollExists($caid, $roll);

    public function getSectionByEiinId($branch, $class, $shift, $version, $id);

    public function getByCaId($id);

    public function getByUId($id);

    public function authAccountCreateStudent($data);

    public function delete($id);
}
