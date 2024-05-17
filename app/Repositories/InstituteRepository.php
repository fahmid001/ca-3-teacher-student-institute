<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

use App\Repositories\Interfaces\InstituteRepositoryInterface;

use App\Services\TeacherService;
use App\Services\Api\AuthService;

use App\Models\Institute;
use App\Models\Teacher;

use Exception;

class InstituteRepository implements InstituteRepositoryInterface
{
    private $teacherService;
    private $authService;

    public function __construct(
        TeacherService $teacherService,
        AuthService $authService
    ) {
        $this->teacherService = $teacherService;
        $this->authService = $authService;
    }


    public function list()
    {
        $search = request()->q;
        $headmaster = (boolean) request()->headmaster;
        $division_id = request()->division_id;
        $district_id = request()->district_id;
        $upazila_id = request()->upazila_id;
        $limit = request()->limit ?? 20;
        $institute = Institute::with(['head_master' => function ($query) use ($headmaster) {
            if($headmaster) {
                $query->where('designation_id', 76);
            } else {
                $query->where('designation_id', '!=', 76);
            }
        }])
        ->where(function ($query) use ($search, $division_id, $district_id, $upazila_id) {
            if (!empty($search)) {
                if(is_numeric($search)) {
                    $query->where('institutes.eiin', 'like', "%$search%");
                } else {
                    $query->where('institutes.institute_name', 'like', "%$search%");
                }
            }
            if (!empty($division_id)) {
                $query->where('division_id', $division_id);
            }

            if (!empty($district_id)) {
                $query->where('district_id', $district_id);
            }

            if (!empty($upazila_id)) {
                $query->where('upazilla_id', $upazila_id);
            }
        })
        ->paginate($limit);
        return $institute;
    }

    public function storeInstituteHeadMaster($data) {
        $emis_teacher = (array) DB::table('emis_teacher')->where('pdsid', $data['pdsid'])->first();
        if(!$emis_teacher) {
            throw new \ErrorException('Teacher not found');
        }
        
        $teacher = Teacher::where('pdsid', $data['pdsid'])->first();
        if(empty(@$teacher->uid)) {
            $emis_teacher['eiin'] = $data['eiin'];
            $emis_teacher['designation_id'] = @$data['designation_id'];

            $authRequest = $this->authService->teacher($emis_teacher, $data['eiin']);
            if(@$authRequest->status == true) {
                $authData = (object) $authRequest->data;
                $emis_teacher['caid'] = $authData->caid;
                $emis_teacher['eiin'] = $authData->eiin;
                $teacherService =  $this->teacherService->create($emis_teacher);
                if($emis_teacher['designation_id'] == 76) {
                    $this->addHeadTeacher($emis_teacher['caid'], $emis_teacher['eiin'] );
                }
                return $teacherService;
            } else {
                throw new \ErrorException($authRequest->message);
            }
        } else {
            $teacher->update(['eiin' => $data['eiin'], 'designation_id' => @$data['designation_id']]);
            if($teacher->designation_id == 76) {
               return $this->addHeadTeacher($teacher->caid, $teacher->eiin);
            }
        }
       return $teacher;
    }

    private function addHeadTeacher($caid, $eiin) {
        $institute = Institute::where('eiin', $eiin)->first();
        $institute->update(['head_caid' => $caid]);
        return $institute;
    }

    public function create($data)
    {

        $institute = new Institute;
        $institute->eiin = @$data['eiin'];
        $institute->caid  = @$data['caid'];
        $institute->division_id = @$data['division_id'];
        $institute->district_id = @$data['district_id'];
        $institute->upazilla_id = @$data['upazilla_id'];
        $institute->unions = @$data['unions'];
        $institute->institute_name = @$data['institute_name'];
        $institute->institute_type = @$data['institute_type'] ?? $data['type'];
        $institute->category = @$data['category'];
        $institute->level = @$data['level'];
        $institute->mpo = @$data['mpo'];
        $institute->phone = @$data['phone'];
        $institute->head_of_institute_mobile = @$data['head_of_institute_mobile'];
        $institute->mobile = @$data['mobile'];
        $institute->email = @$data['email'];
        $institute->address = @$data['address'];
        $institute->post_office = @$data['post_office'];
        $institute->message = @$data['message'];
        $institute->data_source = @$data['data_source'];
        #$institute->institute_source = @$data['institute_source'];
        $institute->save();
        return $institute;

    }

    public function getById($id)
    {
        return Institute::where('uid', $id)->first();;
    }
    public function getByEiinId($id)
    {
        return Institute::where('eiin', $id)->first();;
    }
    public function getByUpazilaId($id)
    {
        return Institute::with('headMaster')->where('upazilla_id', $id)->get();;
    }

    public function getUpazilaInstituteWithHeadMaster($upazila_id) {
        $search = request()->q;
        $limit = request()->limit ?? 20;
        $institutes = Institute::with(['head_master'])
                        ->where('upazilla_id', $upazila_id)
                        ->where(function ($query) use ($search) {
                            if (!empty($search)) {
                                if(is_numeric($search)) {
                                    $query->where('institutes.eiin', 'like', "%$search%");
                                } else {
                                    $query->where('institutes.institute_name', 'like', "%$search%");
                                }
                            }
                        })
                        ->paginate($limit);
        return $institutes;
    }

    public function getUpazilaTeachers($upazila_id) {
        // $search = request()->q;
        // $limit = request()->limit ?? 20;
        // $teachers = Teacher::with(['institute'])->where('upazilla_id', $upazila_id)
        //             ->where('designation_id', '!=', 76)
        //             ->where(function ($query) use ($search) {
        //                 if (!empty($search)) {
        //                     if(is_numeric($search)) {
        //                         $query->where('teachers.eiin', 'like', "%$search%");
        //                     } else {
        //                         $query->where('teachers.name_en', 'like', "%$search%")->orWhere('teachers.name_bn', 'like', "%$search%");
        //                     }
        //                 }
        //             })
        //             ->paginate($limit);
        $teachers = DB::table('emis_teacher')->where('upazilaid', $upazila_id) ->where('designationid', '!=', 76)->paginate(1000);

        return $teachers;
    }

    public function updateInstituteHeadMaster($data) {

       // eims database
       dd($data);
       $teacher_eims = DB::table('emis_teacher')->where('pdsid', $data['pdsid'])->first();
       if(!$teacher_eims) {
           throw new Exception('Teacher not found');
       }
       // api call auth
       $teacher = Teacher::where('pdsid', $data['pdsid'])->first();
       if (!$teacher) {
           $teacher_eims = [
               'eiin' => $data['eiin'],
               'pdsid' => $data['pdsid'],
               'name_en' => $teacher_eims['fullname'] ?? $teacher_eims['fullname_bn'],
               'email' => $data['email'],
               'phone_no' => $data['mobileno']
           ];
           $authRequest = $this->authService->teacher($teacher_eims);
           if(@$authRequest->status == true) {
               $authData = (object) $authRequest->data;
               $request['caid'] = $authData->caid;
               $request['eiin'] = $authData->eiin;
               $this->teacherService->create($request);
           }
       } else {
            $teacher->designation_id = @$data['designationid'];
            $teacher->save();
       }

       return $teacher;

    }
}
