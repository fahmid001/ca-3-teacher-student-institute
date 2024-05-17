<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function __construct()
    {
        //
    }


    public function create($data)
    {
        $u_data = [
            'caid' => @$data['caid'],
            'eiin' => @$data['eiin'],
            'pdsid' => @$data['pdsid'],
            'suid' => @$data['suid'],
            'phone_no' => @$data['phone_no'],
            'role' => $role ?? 'institute',
            'name' => @$data['name'] ?? 'Noipunno',
            'email' => @$data['email'] ?? 'admin@admin.com',
            'user_type_id' => @$data['user_type_id'] ?? 4,
            'password' => Hash::make(@$data['caid']),
        ];
        return User::create($u_data);
    }
    public function update($id, $data)
    {
        /**
         * user update
         * we change this logic because teacher will be
         * switch one school to another then we need to update EIIN number accourdly
         * which priviously need to auth verification
         * step are
         * 1. not need to send EIIN number to auth
         * 2. it will be change teacher module
         *
         */
        // dd($data);
        $user = User::where('caid', $id)->first();
        if($user){
            $u_data = [
                'eiin' => @$data['eiin'],
                'phone_no' => @$data['phone_no'],
                'email' => @$data['email'] ?? 'admin@admin.com',
            ];
            return $user->update($u_data);
        }
        else{
            return $this->create($data);
        }
    }

    public function getByCaid($caid)
    {
        return User::where('caid', $caid)->first();
    }


}
