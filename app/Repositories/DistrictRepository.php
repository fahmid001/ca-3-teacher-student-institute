<?php

namespace App\Repositories;

use App\Repositories\Interfaces\DistrictRepositoryInterface;

use App\Models\District;

class DistrictRepository implements DistrictRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function list()
    {
        return District::get();
    }

    public function getByUId($id)
    {
        return District::where('uid', $id)->first();;
    }

    public function create($data)
    {
        $district = new District;
        $district->name = @$data['name'];
        $district->save();
        return $district;
    }

    public function update($data, $id)
    {
        $district = District::where('uid', $id)->first();   
        $district->name = @$data['name'];  
        $district->save();
        return $district;      
    }

    public function delete($id)
    {
        
    }
}
