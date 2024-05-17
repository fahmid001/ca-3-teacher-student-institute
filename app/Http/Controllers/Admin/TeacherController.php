<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Teacher;
use App\Services\TeacherService;
use App\Services\Api\AuthService;

use App\Services\DivisionService;
use App\Services\DistrictService;
use App\Services\UpazillaService;
use App\Services\DesignationService;
use App\Services\UserService;
use Exception;

class TeacherController extends Controller
{
    private $teacherService;
    private $authService;
    private $divisionService;
    private $districtService;
    private $upazillaService;
    private $designationService;
    private $userService;

    public function __construct(
        TeacherService $teacherService,
        AuthService $authService,
        DivisionService $divisionService,
        DistrictService $districtService,
        UpazillaService $upazillaService,
        DesignationService $designationService,
        UserService $userService
    )
    {
        $this->teacherService = $teacherService;
        $this->authService = $authService;
        $this->divisionService = $divisionService;
        $this->districtService = $districtService;
        $this->upazillaService = $upazillaService;
        $this->designationService = $designationService;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        try {
            $eiinId = auth()->user()->eiin;
            $institute = $this->teacherService->getInstituteByEiin($eiinId);
            $myTeachers = $this->teacherService->getByEiinId($eiinId, 1);
            $banbiesTeachers = $this->teacherService->getBanbeisTeachersByEiinID($eiinId);
            $emisTeachers = $this->teacherService->getEmisTeachersByEiinID($eiinId);
            if($request->eiin_pdsid){
                $emisTeachers = $emisTeachers->where('pdsid', $request->eiin_pdsid);
            }
            $designations = $this->designationService->list();
            $divisions = $this->divisionService->list();
            $districts = $this->districtService->list();
            $upazilas = $this->upazillaService->list();

            return view('frontend/noipunno/teacher-add/index', compact('myTeachers', 'banbiesTeachers', 'emisTeachers', 'institute', 'divisions', 'districts', 'upazilas', 'designations'));
        } catch (Exception $e) {
            return view('errors/404');
        }
    }

    public function store(Request $request)
    {
        // if($request->file('image')){
        //     $imagePath = $request->file('image')->store('uploads', 'public');
        // }
        // $request->merge([
        //     'image' => $imagePath ?? ''
        // ]);

        $request->validate([
            'pdsid' => 'nullable',
            'name_en' => 'required|max:150',
            'name_bn' => 'nullable|max:150',
            'email' => 'nullable',
            'mobile_no' => 'nullable',
            'date_of_birth' => 'nullable|date',
            'joining_date' => 'nullable|date',
            'last_working_date' => 'nullable|date',
            'mpo_code' => 'nullable|numeric',
            'nid' => 'nullable|string|unique:teachers',
            'ismpo' => 'nullable|numeric',
            'teacher_type' => 'required',
            'access_type' => 'required',
            'isactive' => 'nullable|numeric',
            'designation' => 'required',
            'division_id' => 'nullable|numeric',
            'district_id' => 'nullable|numeric',
            'upazilla_id' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ],
        [
            'name_en.required'=> 'শিক্ষকের াম প্রদান কুন',
            'teacher_type.required'=> 'শিক্ষকের পদবি প্রদান করুন',
            'access_type.required'=> 'শিক্ষকের ধর প্রদান করু',
            'designation.required'=> 'অ্যাক্সেসের ধরন প্রদান করুন'
        ]);

        try {
            if($request->access_type) {
                $role_list = $request->access_type;
                $role_list = implode(',', $role_list);
                $request['role'] = $role_list;
            }

            $authRequest = $this->authService->teacher($request->all(), @$request->eiin);

            if(@$authRequest->status == true) {
                $authData = (object) $authRequest->data;
                $request['caid'] = $authData->caid;
                // $request['eiin'] = app('sso-auth')->user()->eiin;
                $request['eiin'] = $authData->eiin;
                $this->teacherService->create($request->all());
                $this->userService->create($request->all());
                $notification = array(
                    'message' => 'Teacher Added successfully.',
                    'alert-type' => 'success'
                );
                return redirect()->back()->with($notification);
            } else {
                $notification = array(
                    'message' => $authRequest->message,
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function edit(Request $request, $id = null) {
        if ($id == null) {
            return redirect()->back()->with('error', 'Required Parameter Missing.');
        }

        $myteacher = $this->teacherService->getById($id);
        $eiinId = auth()->user()->eiin;
        $myTeachers = $this->teacherService->getByEiinId($eiinId);
        $banbiesTeachers = $this->teacherService->getBanbeisTeachersByEiinID($eiinId);
        $emisTeachers = $this->teacherService->getEmisTeachersByEiinID($eiinId);
        if($request->eiin_pdsid){
            $emisTeachers = $emisTeachers->where('pdsid', $request->eiin_pdsid);
        }
        $designations = $this->designationService->list();
        $divisions = $this->divisionService->list();
        $districts = $this->districtService->list();
        $upazilas = $this->upazillaService->list();
        return view('frontend/noipunno/teacher-add/edit', compact('myteacher', 'myTeachers', 'banbiesTeachers', 'emisTeachers', 'divisions', 'districts', 'upazilas', 'designations'));
    }

    public function fromEmis(Request $request, $pdsid = null) {
        if ($pdsid == null) {
            return redirect()->back()->with('error', 'Required Parameter Missing.');
        }

        $myteacher = $this->teacherService->getEmisTeachersById($pdsid);
        $eiinId = auth()->user()->eiin;
        $myTeachers = $this->teacherService->getByEiinId($eiinId);
        $banbiesTeachers = $this->teacherService->getBanbeisTeachersByEiinID($eiinId);
        $emisTeachers = $this->teacherService->getEmisTeachersByEiinID($eiinId);
        if($request->eiin_pdsid){
            $emisTeachers = $emisTeachers->where('pdsid', $request->eiin_pdsid);
        }
        $designations = $this->designationService->list();
        $divisions = $this->divisionService->list();
        $districts = $this->districtService->list();
        $upazilas = $this->upazillaService->list();
        return view('frontend/noipunno/teacher-add/edit', compact('myteacher', 'myTeachers', 'banbiesTeachers', 'emisTeachers', 'divisions', 'districts', 'upazilas', 'designations'));
    }

    public function fromBanbies(Request $request, $id = null) {
        if ($id == null) {
            return redirect()->back()->with('error', 'Required Parameter Missing.');
        }

        $myteacher = $this->teacherService->getBanbeisTeachersById($id);
        $eiinId = auth()->user()->eiin;
        $myTeachers = $this->teacherService->getByEiinId($eiinId);
        $banbiesTeachers = $this->teacherService->getBanbeisTeachersByEiinID($eiinId);
        $emisTeachers = $this->teacherService->getEmisTeachersByEiinID($eiinId);
        if($request->eiin_pdsid){
            $emisTeachers = $emisTeachers->where('pdsid', $request->eiin_pdsid);
        }
        $designations = $this->designationService->list();
        $divisions = $this->divisionService->list();
        $districts = $this->districtService->list();
        $upazilas = $this->upazillaService->list();
        return view('frontend/noipunno/teacher-add/edit', compact('myteacher', 'myTeachers', 'banbiesTeachers', 'emisTeachers', 'divisions', 'districts', 'upazilas', 'designations'));
    }

    public function update(Request $request, $id) {

        $request->validate([
            'pdsid' => 'nullable',
            'name_en' => 'nullable|max:150',
            'name_bn' => 'nullable|max:150',
            'email' => 'nullable',
            'mobile_no' => 'nullable',
            'date_of_birth' => 'nullable|date',
            'joining_date' => 'nullable|date',
            'last_working_date' => 'nullable|date',
            'mpo_code' => 'nullable|numeric',
            'nid' => 'nullable',
            'ismpo' => 'nullable|numeric',
            'teacher_type' => 'nullable',
            'access_type' => 'nullable',
            'isactive' => 'nullable|numeric',
            'designation' => 'nullable',
            'division_id' => 'nullable|numeric',
            'district_id' => 'nullable|numeric',
            'upazilla_id' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {

            DB::beginTransaction();
            $findByTrash = $this->teacherService->getWithTrashedById($id);

            if ($findByTrash && $findByTrash->caid) {
                $requestData = $request->all();

                if ($request->access_type) {
                    $role_list = $request->access_type;
                    $role_list = implode(',', $role_list);
                    $requestData['role'] = $role_list;
                }
                if ($request->access_type) {
                    $is_disabled = $request->is_disabled; //not sent message , msg send if null
                } else {
                    $is_disabled = null;
                }
                $requestData['caid'] = @$findByTrash->caid;
                $requestData['eiin'] = @$findByTrash->eiin;
                // $requestData['eiin'] =  app('sso-auth')->user()->eiin;

                if (!empty($findByTrash->deleted_at)) {
                    $this->teacherService->update($requestData, $findByTrash->uid, true);
                } else {
                    $this->teacherService->update($requestData, $findByTrash->uid);
                }

                $this->userService->update($findByTrash->caid, $requestData);
                $this->authService->accountUpdate($requestData, $findByTrash->caid, null, $is_disabled, 1);
                $notification = array(
                    'message' => 'Teacher Updated successfully.',
                    'alert-type' => 'success',
                );
                DB::commit();

                return redirect()->route('teacher.index')->with($notification);
            } else {
                $requestData = $request->all();
                
                if ($request->access_type) {
                    $role_list = $request->access_type;
                    $role_list = implode(',', $role_list);
                    $requestData['role'] = $role_list;
                }
                $myteacherJson = $requestData['myteacher'];
                $myteacher = json_decode($myteacherJson);
                $mergedData = array_merge($requestData, (array) $myteacher);
                $authRequest = $this->authService->teacher($mergedData, $mergedData['eiin']);
                
                if ($authRequest->data) {
                    $authData = (object) $authRequest->data;
                    $mergedData['caid'] = @$authData->caid;
                    $mergedData['eiin'] = @$authData->eiin;
                    // $mergedData['eiin'] = app('sso-auth')->user()->eiin;

                    $teacherExists = $this->teacherService->getWithTrashedById(@$authData->caid);
                    // $teacherExists = $this->teacherService->getWithTrashedById(@$findByTrash->caid ? @$authData->caid: @$findByTrash->pdsid);

                    if( $teacherExists) {
                        $is_restore = $teacherExists->deleted_at ? true: false;
                        $this->teacherService->update($mergedData, $teacherExists->uid, $is_restore);
                        $this->userService->update($authData->caid, $mergedData);
                    } else {
                        $this->teacherService->create($mergedData);
                        $this->userService->create($mergedData);
                    }
                    $notification = array(
                        'message' => 'Teacher Updated successfully.',
                        'alert-type' => 'success',
                    );
                    DB::commit();
                    return redirect()->route('teacher.index')->with($notification);
                } else {
                    DB::rollBack();

                    $notification = array(
                        'message' => 'Teacher Updated failed.',
                        'alert-type' => 'error',
                    );
                    return back()->with($notification);
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function getAllTeachersByPdsID(Request $request)
    {
        $eiinId = auth()->user()->eiin;
        $pdsid = $request->id;
        $emisTeachers = $this->teacherService->getEmisTeachersByEiinAndPdsID($eiinId, $pdsid);
        return response()->json($emisTeachers);
    }

    public function delete(Request $request){
        $this->teacherService->delete($request->id);
        return redirect()->back();
    }
}
