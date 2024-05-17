<?php

namespace App\Repositories;

use App\Repositories\Interfaces\StudentRepositoryInterface;

use Illuminate\Support\Facades\Http;
use App\Helper\UtilsCookie;
use App\Helper\UtilsApiEndpoint;

use App\Models\Student;
use App\Models\Branch;
use App\Models\Version;
use App\Models\Shift;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

use Auth;

class StudentRepository implements StudentRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function list()
    {
        return Student::get();
    }

    public function create($data)
    {
        $birthday = '';
        if (isset($data['date_of_birth']) && !empty($data['date_of_birth'])) {
            $birthday = date("Y-m-d", strtotime($data['date_of_birth']));
        } elseif (isset($data['dob']) && !empty($data['dob'])) {
            $birthday = date("Y-m-d", strtotime($data['dob']));
        } else {
            $birthday = NULL;
        }

        $father_date_of_birth = '';
        if (isset($data['father_date_of_birth']) && !empty($data['father_date_of_birth'])) {
            $father_date_of_birth = date("Y-m-d", strtotime($data['father_date_of_birth']));
        } else {
            $father_date_of_birth = NULL;
        }

        $mother_date_of_birth = '';
        if (isset($data['mother_date_of_birth']) && !empty($data['mother_date_of_birth'])) {
            $mother_date_of_birth = date("Y-m-d", strtotime($data['mother_date_of_birth']));
        } else {
            $mother_date_of_birth = NULL;
        }

        $student = new Student;
        $student->eiin = @$data['eiin'];
        $student->suid  = @$data['suid'];
        $student->caid  = @$data['caid'];
        $student->type  = @$data['type'];
        $student->incremental_no  = @$data['incremental_no'];
        $student->student_name_en = @$data['student_name_en'] ?? @$data['fullname_english'];
        $student->student_name_bn = @$data['student_name_bn'] ?? @$data['fullname_bangla'];
        $student->brid = @$data['brid'] ?? @$data['bin_brn'];
        $student->date_of_birth = $birthday;
        $student->registration_year = @$data['registration_year'];
        $student->religion = @$data['religion'];
        $student->birth_place = @$data['birth_place'] ?? @$data['birthplace'];
        $student->gender = @$data['gender'];
        $student->nationality = @$data['nationality'];
        $student->recent_study_class = @$data['recent_study_class'] ?? @$data['register_class'];
        $student->disability_status = @$data['disability_status'] ?? @$data['is_disability'];
        $student->blood_group = @$data['blood_group'];
        $student->student_mobile_no = @$data['student_mobile_no'];
        $student->ethnic_info = @$data['ethnic_info'] ?? @$data['small_ethnic_group'];
        $student->branch = @$data['branch'];
        $student->version = @$data['version'];
        $student->shift = @$data['shift'];
        $student->class = @$data['class'] ?? @$data['register_class'];
        $student->section = @$data['section'];
        $student->roll = @$data['roll'] ?? @$data['academic_roll_no'];
        $student->is_regular = @$data['is_regular'];
        $student->father_name_bn = @$data['father_name_bn'] ?? @$data['fathername_bangla'];
        $student->father_name_en = @$data['father_name_en'] ?? @$data['fathername_bangla'];
        $student->father_nid = @$data['father_nid'];
        $student->father_brid = @$data['father_brid'];
        $student->father_date_of_birth = $father_date_of_birth;
        $student->father_mobile_no = @$data['father_mobile_no'];
        $student->mother_name_bn = @$data['mother_name_bn'] ?? @$data['mothername_bangla'];
        $student->mother_name_en = @$data['mother_name_en'] ?? @$data['mothername_bangla'];
        $student->mother_nid = @$data['mother_nid'];
        $student->mother_brid = @$data['mother_brid'];
        $student->mother_date_of_birth = $mother_date_of_birth;
        $student->mother_mobile_no = @$data['mother_mobile_no'];
        $student->guardian_name_bn = @$data['guardian_name_bn'] ?? @$data['guardian_name'];
        $student->guardian_name_en = @$data['guardian_name_en'] ?? @$data['guardian_name'];
        $student->guardian_mobile_no = @$data['guardian_mobile_no'];
        $student->guardian_nid = @$data['guardian_nid'];
        $student->guardian_occupation = @$data['guardian_occupation'] ?? @$data['guardian_profession'];
        $student->relation_with_guardian = @$data['relation_with_guardian'] ?? @$data['relationship_with_guardian'];
        $student->present_address = @$data['present_address'] ?? @$data['present_address'];
        $student->permanent_address = @$data['permanent_address'] ?? @$data['present_address'];
        $student->post_office = @$data['post_office'] ?? @$data['present_post_office'];
        $student->division_id = @$data['division_id'] ?? @$data['presentdivisionid'];
        $student->district_id = @$data['district_id'] ?? @$data['presentdistrictid'];
        $student->upazilla_id = @$data['upazilla_id'] ?? @$data['presentthanaid'];
        $student->unions = @$data['unions'] ?? @$data['presentthanaid'];
        $student->image = @$data['image'] ?? @$data['presentthanaid'];
        $student->data_source = @$data['data_source']; #emis or bandbeis
        #$student->student_source = @$data['student_source'];
        $student->save();
        return $student;
    }

    public function update($data, $id, $is_restore = false)
    {
        $birthday = '';
        if (isset($data['date_of_birth']) && !empty($data['date_of_birth'])) {
            $birthday = date("Y-m-d", strtotime($data['date_of_birth']));
        } elseif (isset($data['dob']) && !empty($data['dob'])) {
            $birthday = date("Y-m-d", strtotime($data['dob']));
        } else {
            $birthday = NULL;
        }

        if($is_restore) {
            Student::where('caid', $id)->orwhere('uid', $id)->onlyTrashed()->restore();
        }

        $student = Student::where('caid', $id)->orwhere('uid', $id)->first();
        $student->branch = @$data['branch'];
        $student->version = @$data['version'];
        $student->shift = @$data['shift'];
        $student->class = @$data['class'];
        $student->section = @$data['section'];
        $student->registration_year = @$data['registration_year'];
        $student->roll = @$data['roll'];
        $student->student_name_en = @$data['student_name_en'];
        $student->student_name_bn = @$data['student_name_bn'];
        $student->brid = @$data['brid'];
        $student->date_of_birth = $birthday;
        $student->gender = @$data['gender'];
        $student->religion = @$data['religion'];
        $student->student_mobile_no = @$data['student_mobile_no'];
        $student->mother_name_bn = @$data['mother_name_bn'];
        $student->mother_name_en = @$data['mother_name_en'];
        $student->father_name_bn = @$data['father_name_bn'];
        $student->father_name_en = @$data['father_name_en'];
        $student->father_mobile_no = @$data['father_mobile_no'];
        $student->mother_mobile_no = @$data['mother_mobile_no'];
        $student->guardian_name_bn = @$data['guardian_name_bn'];
        $student->guardian_mobile_no = @$data['guardian_mobile_no'];
        $student->image = @$data['image'];
        $student->save();
        return $student;
    }

    public function getById($id)
    {
        return Student::where('uid', $id)->first();;
    }

    public function getByEiinId($eiin)
    {
        return Student::where('eiin', $eiin)->paginate(20);
    }

    public function getBranchByEiinId($eiin)
    {
        return Branch::where('eiin', $eiin)->get();
    }

    public function getVersionByEiinId($branch, $eiin)
    {
        if ($branch == '') {
            return Version::where('eiin', $eiin)->get();
        } else {
            return Version::where('branch_id', (int) @$branch)->where('eiin', $eiin)->get();
        }
    }

    public function getShiftByEiinId($branch, $eiin)
    {
        if ($branch == '') {
            return Shift::where('eiin', $eiin)->get();
        } else {
            return Shift::where('branch_id', (int) @$branch)->where('eiin', $eiin)->get();
        }
    }

    public function getSectionByEiinId($branch, $class, $shift, $version, $eiin)
    {
        if ($branch == '' && $class == '' && $shift == '' && $version == '') {
            return Section::where('eiin', $eiin)->get();
        } else {
            return Section::where('branch_id', (int) $branch)->where('class_id', (int) $class)->where('shift_id', (int) $shift)->where('version_id', (int) $version)->where('eiin', $eiin)->get();
        }
    }

    public function getByCaId($id)
    {
        return Student::where('caid', $id)->first();;
    }

    public function getByUId($id)
    {
        return Student::where('uid', $id)->first();;
    }

    public function getWithTrashedById($data, $eiin)
    {
        $branch = $data['branch'];
        $shift = $data['shift'];
        $version = $data['version'];
        $class = $data['class'];
        $section = $data['section'];
        $registration_year = $data['registration_year'];
        $roll = $data['roll'];
        return DB::table('students')->where(function ($query) use ($eiin, $branch, $shift, $version, $class, $section, $registration_year, $roll) {
            if (!empty($eiin)) {
                $query->where('eiin', $eiin);
            }
            if (!empty($branch)) {
                $query->where('branch', $branch);
            }
            if (!empty($shift)) {
                $query->where('shift', $shift);
            }
            if (!empty($version)) {
                $query->where('version', $version);
            }
            if (!empty($class)) {
                $query->where('class', $class);
            }
            if (isset($section) && !empty($section)) {
                $query->where('section', $section);
            }
            if (!empty($registration_year)) {
                $query->where('registration_year', $registration_year);
            }
            if (!empty($roll)) {
                $query->where('roll', $roll);
            }
        })->first();
    }

    public function checkRollExists($caid, $roll)
    {
        return Student::where('caid', $caid)->where('roll', '<>', $roll)->exists();
    }

    public function authAccountCreateStudent($data)
    {
        $accessToken = UtilsCookie::getCookie();
        $endpoint = 'https://accounts.project-ca.com/api/v1/user/account-create';

        // $endpoint = UtilsApiEndpoint::accountCreate();

        $response = Http::withHeaders([
            'Authorization' =>  'Bearer ' . $accessToken,
            'Content-Type' => 'application/json'
        ])->post($endpoint, [
            'name' => @$data['student_name_en'],
            'email' => @$data['email'],
            'phone_no' => @$data['father_mobile_no'],
            'password' => 123456,
            'eiin' => @app('sso-auth')->user()->eiin,
            'suid' => '',
            'user_type_id' => 2,
            'class_id' => @$data['class'],
            'year' => @$data['registration_year'],
        ]);

        if (!$response->ok()) {
            return false;
        }
        $result =  json_decode($response->getBody(), true);

        return $result;
    }

    public function authAccountCreateInstitude($data)
    {
        // dd($data->institutename);
        $accessToken = UtilsCookie::getCookie();
        $endpoint = 'https://accounts.project-ca.com/api/v1/user/account-create';

        // $endpoint = UtilsApiEndpoint::accountCreate();

        $response = Http::withHeaders([
            'Authorization' =>  'Bearer ' . $accessToken,
            'Content-Type' => 'application/json'
        ])->post($endpoint, [
            'name' => @$data->institutename,
            // 'email' => @$data['email'],
            'phone_no' => @$data->mobileno,
            'password' => 123456,
            'eiin' => @$data->eiin,
            'suid' => '',
            'user_type_id' => 3,
            'zila_id' => @$data->districtid,
            'upazila_id' => @$data->upazilaid,
            'year' => '2023',
        ]);

        // if (!$response->ok()) {
        //     return false;
        // }
        $result =  json_decode($response->getBody(), true);
        // dd($result);
        return $result;
    }

    public function delete($id)
    {
        $result = Student::where('uid', $id)->first();
        $result->delete();
        return true;
    }
}
