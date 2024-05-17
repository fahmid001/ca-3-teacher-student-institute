<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Illuminate\Support\Facades\Http;
use App\Helper\UtilsCookie;

use App\Models\Teacher;
use Illuminate\Support\Facades\DB;


class TeacherRepository implements TeacherRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function list()
    {
        return Teacher::get();
    }

    public function create($data)
    {

        $birthday = '';
        if (isset($data['date_of_birth']) && !empty($data['date_of_birth'])) {
            $birthday = date("Y-m-d", strtotime($data['date_of_birth']));
        } elseif (isset($data['dateofbirth']) && !empty($data['dateofbirth'])) {
            $birthday = date("Y-m-d", strtotime($data['dateofbirth']));
        } else {
            $birthday = NULL;
        }

        $last_working_date = '';
        if (isset($data['last_working_date']) && !empty($data['last_working_date'])) {
            $last_working_date = date("Y-m-d", strtotime($data['last_working_date']));
        } elseif (isset($data['last_work_date_as_employee']) && !empty($data['last_work_date_as_employee'])) {
            $last_working_date = date("Y-m-d", strtotime($data['last_work_date_as_employee']));
        } else {
            $last_working_date = NULL;
        }

        $joining_date = '';
        if (isset($data['joining_date']) && !empty($data['joining_date'])) {
            $joining_date = date("Y-m-d", strtotime($data['joining_date']));
        } elseif (isset($data['date_first_join']) && !empty($data['date_first_join'])) {
            $joining_date = date("Y-m-d", strtotime($data['date_first_join']));
        } else {
            $joining_date = NULL;
        }

        if (!empty($data['pdsid'])) {
            $customEmail = $data['pdsid'] . '@noipunno.gov.bd';
        } else {
            $customEmail = '';
        }

        $teacher = new Teacher;
        $teacher->eiin = @$data['eiin'] ?? @$data['eiin_no'] ?? @$data['caid'];
        $teacher->caid = @$data['caid'];
        $teacher->pdsid = @$data['pdsid'] ?? @$data['emp_uid'];
        $teacher->name_en = @$data['name_en'] ?? @$data['fullname'] ?? @$data['employee_name'];
        $teacher->name_bn = @$data['name_bn'] ?? @$data['fullname_bn'] ?? @$data['employee_name_bn'];
        $teacher->fathers_name = @$data['fathers_name'] ?? @$data['fathersname'];
        $teacher->mothers_name = @$data['mothers_name'] ?? @$data['mothersname'];
        $teacher->email = @$data['email'] ?? @$customEmail;
        $teacher->mobile_no = @$data['mobile_no'] ?? @$data['mobileno'] ?? @$data['mobile_number'];
        $teacher->gender = @$data['gender'];
        $teacher->date_of_birth = $birthday;
        $teacher->institute_name = @$data['institute_name'] ?? @$data['institutename'];
        $teacher->institute_type = @$data['institute_type'] ?? @$data['levelname'];
        $teacher->institute_category = @$data['institute_category'] ?? @$data['institute_type_name'];
        $teacher->index_number = @$data['index_number'] ?? @$data['indexnumber'] ?? @$data['index_no'];
        $teacher->workstation_name = @$data['workstation_name'];
        $teacher->branch_institute_name = @$data['branch_institute_name'] ?? @$data['institute_name'] ?? @$data['institutename'];
        $teacher->branch_institute_category = @$data['branch_institute_category'] ?? @$data['institute_category'] ?? @$data['institute_type_name'];
        $teacher->service_break_institute = @$data['service_break_institute'];
        $teacher->designation = @$data['designation'] ?? @$data['designation_name'];
        $teacher->designation_id = @$data['designation_id'] ?? @$data['designationid'] ?? @$data['designation'];
        $teacher->division_id = @$data['division_id'] ?? @$data['divisionid'];
        $teacher->district_id = @$data['district_id'] ?? @$data['districtid'];
        $teacher->upazilla_id = @$data['upazilla_id'] ?? @$data['upazila_id'] ?? @$data['upazilaid'];
        $teacher->joining_year = date("Y", strtotime(@$data['joining_date']));
        $teacher->mpo_code = @$data['mpo_code'];
        $teacher->joining_date = $joining_date;
        $teacher->last_working_date = $last_working_date;
        $teacher->nid = @$data['nid'];
        $teacher->teacher_type = @$data['teacher_type'];
        // $teacher->access_type = @$data['access_type'];
        $teacher->role = @$data['role'];
        $teacher->ismpo = @$data['ismpo']; #mpo or not
        $teacher->isactive = @$data['isactive'] ?? 1; #teacher active or not
        $teacher->data_source = @$data['data_source']; #emis or bandbeis
        #$teacher->teacher_source = @$data['teacher_source'];
        $teacher->image = @$data['image'];
        $teacher->save();
        return $teacher;
    }

    public function update($data, $id, $is_restore = false)
    {
        if (!empty($data['pdsid'])) {
            $customEmail = $data['pdsid'] . '@noipunno.gov.bd';
        } else {
            $customEmail = '';
        }

        if ($is_restore) {
            Teacher::where('caid', $id)->orwhere('uid', $id)->onlyTrashed()->restore();
        }

        $teacher = Teacher::where('caid', $id)->orwhere('uid', $id)->first();

        $teacher->name_en = @$data['name_en'] ?? @$data['fullname'] ?? @$data['employee_name'];
        $teacher->pdsid = @$data['pdsid'] ?? @$data['emp_uid'];
        // if(!empty(@$data['eiin'] ?? @$data['eiin_no'] ?? @$data['caid'])) {
        //     $teacher->eiin = @$data['eiin'] ?? @$data['eiin_no'] ?? @$data['caid'];
        // }

        if (empty($teacher->caid) && !empty(@$data['caid'])) {
            $teacher->caid = @$data['caid'];
        }
        if (!empty(@$data['designation'] ?? @$data['designation_name'])) {
            $teacher->designation = @$data['designation'] ?? @$data['designation_name'];
        }
        if (!empty(@$data['designation_id'] ?? @$data['designationid'] ?? @$data['designation'])) {
            $teacher->designation_id = @$data['designation_id'] ?? @$data['designationid'] ?? @$data['designation'];
        }
        $teacher->name_bn = @$data['name_bn'] ?? @$data['fullname_bn'] ?? @$data['employee_name_bn'];
        $teacher->fathers_name = @$data['fathers_name'] ?? @$data['fathersname'];
        $teacher->mothers_name = @$data['mothers_name'] ?? @$data['mothersname'];
        $teacher->email = @$data['email'] ?? $customEmail;
        $teacher->mobile_no = @$data['mobile_no'] ?? @$data['mobileno'] ?? @$data['mobile_number'];
        // $teacher->division_id = @$data['division_id'] ?? @$data['divisionid'];
        // $teacher->district_id = @$data['district_id'] ?? @$data['districtid'];
        // $teacher->upazilla_id = @$data['upazilla_id'] ?? @$data['upazila_id'] ?? @$data['upazilaid'];
        $teacher->gender = @$data['gender'];
        $teacher->teacher_type = @$data['teacher_type'];
        // $teacher->access_type = @$data['access_type'];
        // $teacher->role = @$data['role'];
        $teacher->image = @$data['image'];
        $teacher->save();
        return $teacher;
    }

    public function getById($id)
    {
        return Teacher::where('uid', $id)->orwhere('caid', $id)->first();
    }

    public function getWithTrashedById($id)
    {
        return DB::table('teachers')->where('uid', $id)->orwhere('caid', $id)->orWhere('pdsid', $id)->first();
    }

    public function getByCaId($id)
    {
        return Teacher::where('caid', $id)->orWhere('pdsid', $id)->first();
    }

    public function getByEiinId($eiin, $is_not_paginate = null)
    {
        if ($is_not_paginate) {
            return Teacher::where('eiin', $eiin)->get();
        } else {
            return Teacher::where('eiin', $eiin)->paginate(100);
        }
    }

    public function getBanbeisTeachers()
    {
        return DB::table('banbeis_teacher')->get();
    }

    public function getBanbeisTeachersById($id)
    {
        return DB::table('banbeis_teacher')->where('emp_uid', $id)->first();
    }

    public function getBanbeisTeachersByEiinID($eiin)
    {
        return DB::table('banbeis_teacher')
            ->leftJoin('teachers', 'banbeis_teacher.emp_uid', '=', 'teachers.pdsid')
            ->whereNull('teachers.pdsid')
            ->where('banbeis_teacher.eiin_no', $eiin)
            ->get();
    }

    public function getEmisTeachers()
    {
        return DB::table('emis_teacher')
            ->whereIn('designationid', [1, 4, 7, 8, 11, 12, 13, 14, 15, 29, 30, 31, 32, 33, 37, 39, 43, 44, 45, 46, 47, 52, 53, 54, 56, 70, 71, 72, 73, 74, 77, 78, 79, 226])
            ->get();
    }

    public function getEmisTeachersById($pdsid)
    {
        return DB::table('emis_teacher')->where('pdsid', $pdsid)->first();
    }

    public function getEmisTeachersByEiinID($eiin)
    {
        return DB::table('emis_teacher')
            ->leftJoin('teachers', 'emis_teacher.pdsid', '=', 'teachers.pdsid')
            ->select('emis_teacher.*')
            ->where(function ($query) {
                $query->whereNull('teachers.pdsid');
                $query->orWhereNotNull('teachers.deleted_at');
            })
            ->where('emis_teacher.eiin', $eiin)
            // ->whereIn('emis_teacher.designationid', [1, 4, 7, 8, 11, 12, 13, 14, 15, 29, 30, 31, 32, 33, 37, 39, 43, 44, 45, 46, 47, 52, 53, 54, 56, 70, 71, 72, 73, 74, 77, 78, 79, 226])
            ->limit(500)
            ->get();
    }

    public function getEmisTeachersByEiinAndPdsID($eiin, $pdsid)
    {
        return DB::table('emis_teacher')
            ->select('emis_teacher.*')
            ->leftJoin('teachers', 'emis_teacher.pdsid', '=', 'teachers.pdsid')
            ->where(function ($query) use ($pdsid) {
                $query->where('emis_teacher.pdsid', 'LIKE', '%' . $pdsid . '%');
                $query->orWhereNotNull('teachers.deleted_at');
            })
            ->where('emis_teacher.eiin', $eiin)
            ->limit(500)
            // ->whereIn('emis_teacher.designationid', [1, 4, 7, 8, 11, 12, 13, 14, 15, 29, 30, 31, 32, 33, 37, 39, 43, 44, 45, 46, 47, 52, 53, 54, 56, 70, 71, 72, 73, 74, 77, 78, 79, 226])
            ->get();
    }


    public function authAccountCreateTeacher($data)
    {
        //         $accessToken = UtilsCookie::getCookie();
        // $endpoint = 'https://accounts.project-ca.com/api/v1/user/account-create';
        // $response = Http::withHeaders([
        //     'Authorization' =>  'Bearer ' . $accessToken,
        //     'Content-Type' => 'application/json'
        // ])->post($endpoint, [
        //     'name' => @$data['name_en'],
        //     'email' => @$data['email'],
        //     'phone_no' => @$data['mobile_no'],
        //     'password' => 123456,
        //     'eiin' => @app('sso-auth')->user()->eiin,
        //     'pdsid' => @$data['pdsid'],
        //     'user_type_id' => 1,
        //     'year' => 2023,
        // ]);

        // if (!$response->ok()) {
        //     return false;
        // }
        // $result =  json_decode($response->getBody(), true);
        // return $result;
        return;
    }

    public function getInstituteByEiin($eiin)
    {
        return DB::table('institutes')
            ->select('eiin', 'institute_name')
            ->where('eiin', $eiin)
            ->union(DB::table('banbeis_teacher')->select('eiin_no as eiin', 'institute_name')->where('eiin_no', $eiin))
            ->union(DB::table('emis_teacher')->select('eiin', 'institutename as institute_name')->where('eiin', $eiin))
            ->first();
    }

    public function delete($id)
    {
        $result = Teacher::where('uid', $id)->first();
        $result->delete();
        return true;
    }
}
