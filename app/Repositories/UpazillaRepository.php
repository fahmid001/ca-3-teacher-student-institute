<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UpazillaRepositoryInterface;

use App\Models\Upazilla;

class UpazillaRepository implements UpazillaRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function list()
    {
        return Upazilla::get();
    }

    public function getByUId($id)
    {
        return Upazilla::where('uid', $id)->first();;
    }

    public function create($data)
    {
        $upazilla = new Upazilla;
        $upazilla->name = $data['name'];
        $upazilla->save();

        return $upazilla;
    }

    public function update($data, $id)
    {
        $upazilla = Upazilla::where('uid', $id)->first();   
        $upazilla->name = @$data['name'];  
        $upazilla->save();
        return $upazilla;      
    }

    public function delete($id)
    {
        
    }
}
