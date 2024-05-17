<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

use Illuminate\Validation\Rule;
// use App\Rules\TimeNotLessThan;

use App\Models\Teacher;
use App\Models\Branch;
use App\Models\Version;
use App\Models\Shift;
use App\Models\Section;
use App\Services\TeacherService;
use App\Services\BranchService;
use App\Services\ClassService;
use App\Services\InstituteService;
use App\Services\SubjectService;
use App\Services\ClassRoomService\ClassRoomServiceInterface;
use App\Services\SubjectTeacherService\SubjectTeacherServiceInterface;
use App\Services\ShiftService;
use App\RolePermission\RolePermission;
use App\Services\VersionService;

class HomeController extends Controller
{
    private $teacherService;
    private $branchService;
    private $classRoomService;
    private $classService;
    private $subjectService;
    private $instituteService;
    private $subjectTeacherService;
    private $shiftService;
    private $versionService;

    public function __construct(TeacherService $teacherService, BranchService $branchService, ClassRoomServiceInterface $classRoomService, ClassService $classService, SubjectService $subjectService, InstituteService $instituteService, SubjectTeacherServiceInterface $subjectTeacherService, ShiftService $shiftService, VersionService $versionService)
    {
        $this->teacherService = $teacherService;
        $this->branchService = $branchService;
        $this->classRoomService = $classRoomService;
        $this->classService = $classService;
        $this->subjectService = $subjectService;
        $this->instituteService = $instituteService;
        $this->subjectTeacherService = $subjectTeacherService;
        $this->shiftService = $shiftService;
        $this->versionService = $versionService;
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function login()
    {
        return view('frontend/auth/login');
    }

    public function register()
    {
        return view('frontend/auth/register');
    }
    public function dashboard()
    {
        return view('frontend/dashboard/dashboard');
    }

    public function noipunnoDashboard()
    {
        // dd(app('role')->roles());
        // (app('role')->setRole(RolePermission::$TEACHER));
        // dd(app('role')->permissions()->category->can_view);
        $user = auth()->user();
        $institute = $this->teacherService->getInstituteByEiin($user->eiin);
        return view('frontend/noipunno/dashboard/index', compact('institute', 'user'));
    }

    public function noipunnoDashboard2()
    {
        $user = auth()->user();
        $institute = $this->teacherService->getInstituteByEiin($user->eiin);
        return view('frontend/noipunno/dashboard/dashborad-other', compact('institute', 'user'));
    }

    public function noipunnoDashboardUpazilla()
    {
        return view('frontend/noipunno/dashboard/upazilla-dashboard');
    }

    public function noipunnoDashboardSchoolDetails()
    {
        return view('frontend/noipunno/school-details/index');
    }

    public function noipunnoDashboardSchoolFocal()
    {
        return view('frontend/noipunno/school-focal/index');
    }

    // public function noipunnoDashboardStudentAdd()
    // {
    //     $branchList = Branch::select('*')->get();

    //     return view('frontend/noipunno/student-add/index',compact('branchList'));
    // }

    // public function noipunnoDashboardStudentEdit()
    // {
    //     return view('frontend/noipunno/student-add/edit');
    // }

    // public function noipunnoDashboardTeacherAdd()
    // {
    //     // return $results = DB::table('emis_teacher_1')
    //     // ('designationid', 'designation')
    //     // ->groupBy('designationid')
    //     // ->groupBy('designation')
    //     // ->get();

    //     $eiinId = 100003;
    //     $myTeachers = $this->teacherService->getByEiinId($eiinId);
    //     $banbiesTeachers = $this->teacherService->getBanbeisTeachersByEiinID(100002);
    //     $emisTeachers = $this->teacherService->getEmisTeachersByEiinID(129596);

    //     return view('frontend/noipunno/teacher-add/index', compact('myTeachers', 'banbiesTeachers', 'emisTeachers'));
    // }

    public function noipunnoDashboardTeacherEdit()
    {
        return view('frontend/noipunno/teacher-add/edit');
    }

    public function noipunnoDashboardClassRoomAdd()
    {
        // try {
        $eiinId = auth()->user()->eiin;
        $data['branches'] = $this->branchService->getByEiinId($eiinId);
        // $data['classes'] = $this->classService->getAll();
        $data['teachers'] = $this->teacherService->getByEiinId($eiinId);
        $data['class_rooms'] = $this->classRoomService->getAllClassRoomsByEiinWithPagination($eiinId);

        return view('frontend/noipunno/classroom/index', $data);
        // } catch (Exception $e) {
        //     return view('errors/404');
        // }
    }

    public function noipunnoDashboardClassRoomStore(Request $request)
    {
        $request->validate([
            'class_teacher_id' => 'required',
            'section_id' => 'required',
            'branch_id' => 'required',
            'version_id' => 'required',
            'shift_id' => 'required',
            'class_id' => 'required',
        ], [
            'class_teacher_id.required' => 'Class Teacher is required',
            'section_id.required' => 'Section is required',
            'branch_id.required' => 'Branch is required',
            'version_id.required' => 'Version is required',
            'shift_id.required' => 'Shift is required',
            'class_id.required' => 'Class is required',
        ]);

        try {
            $this->classRoomService->createClassRoom($request->all());
            $notification = array(
                'message' => 'Data Created successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('noipunno.dashboard.classroom.add')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }
    public function noipunnoDashboardClassRoomEdit($id)
    {
        $eiinId = auth()->user()->eiin;
        $data['branches'] = $this->branchService->getByEiinId($eiinId);
        // $data['classes'] = $this->classService->getAll();
        $data['teachers'] = $this->teacherService->getByEiinId($eiinId);
        $data['class_rooms'] = $this->classRoomService->getAllClassRoomsByEiinWithPagination($eiinId);

        $data['class_room'] = $this->classRoomService->getClassRoomById($id);
        $data['subject_teachers'] = $this->subjectTeacherService->getSubjectByTeacherClassRoomId($id);

        return view('frontend/noipunno/classroom/edit', $data);
    }

    public function noipunnoDashboardClassRoomUpdate($uid, Request $request)
    {
        $request->validate([
            'class_teacher_id' => 'required',
            'section_id' => 'required',
            'branch_id' => 'required',
            'version_id' => 'required',
            'shift_id' => 'required',
            'class_id' => 'required',
        ], [
            'class_teacher_id.required' => 'Class Teacher is required',
            'section_id.required' => 'Section is required',
            'branch_id.required' => 'Branch is required',
            'version_id.required' => 'Version is required',
            'shift_id.required' => 'Shift is required',
            'class_id.required' => 'Class is required',
        ]);
        
        try {
            $this->classRoomService->updateClassRoom($uid, $request->all());
            $notification = array(
                'message' => 'Data Updated successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('noipunno.dashboard.classroom.add')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function noipunnoDashboardClassRoomDelete(Request $request)
    {
        $this->classRoomService->deleteClassRoom($request->id);
        return redirect()->back();
    }

    public function noipunnoDashboardBranchAdd()
    {
        $eiinId = auth()->user()->eiin;
        // $branchList = Branch::with(['branchHead'])->select('*')->paginate(5);
        $branchList = $this->branchService->getByEiinIdWithPagination($eiinId);
        $myTeachers = $this->teacherService->getByEiinId($eiinId);

        return view('frontend/noipunno/branch/index', compact('branchList', 'myTeachers', 'eiinId'));
    }

    public function noipunnoDashboardBranchStore(Request $request)
    {
        $this->validate(request(), [
            'head_of_branch_id' => [
                'required',
                        Rule::unique('branches')
                        ->where('head_of_branch_id', $request->head_of_branch_id)
                        ->where('eiin', auth()->user()->eiin)
            ],
        ],[
            'head_of_branch_id.required'=> 'অনুগ্রহ করে প্রধান শিক্ষক এর নাম প্রদান করুন',
            'head_of_branch_id.unique'=> 'একই প্রধান শিক্ষক একাধিক ব্রাঞ্চ প্রধান হতে পারে না',
        ]);

        $this->validate(request(), [
            'branch_location' => 'required|string',
            'branch_name' => [
                'required',
                        Rule::unique('branches')
                        ->where('eiin', auth()->user()->eiin)
            ],
            'head_of_branch_id' => [
                'required',
                        Rule::unique('branches')
                        ->where('branch_name', $request->branch_name)
                        ->where('head_of_branch_id', $request->head_of_branch_id)
                        ->where('eiin', auth()->user()->eiin)
            ],
        ],[
            'branch_location.required'=> 'অনুগ্রহ করে ব্রাঞ্চ ঠিকানা প্রদান করুন',
            'branch_name.required'=> 'অনুগ্রহ করে ব্রাঞ্চ নাম প্রদান করুন',
            'branch_name.unique'=> 'একই নামের ব্রাঞ্চ একই স্কুল এ দেয়া যাবেনা',
            'head_of_branch_id.required'=> 'অনুগ্রহ করে প্রধান শিক্ষক এর নাম প্রদান করুন',
            'head_of_branch_id.unique'=> 'একই প্রধান শিক্ষক একাধিক ব্রাঞ্চ প্রধান হতে পারে না',
        ]);
        
        try {
            Branch::create([
                'branch_id' => $request->branch_id,
                'branch_name' => $request->branch_name,
                'branch_location' => $request->branch_location,
                'head_of_branch_id' => $request->head_of_branch_id,
                'eiin' => auth()->user()->eiin,
            ]);

            $notification = array(
                'message' => 'Data Created successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('noipunno.dashboard.branch.add')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function noipunnoDashboardBranchUpdate(Request $request)
    {
        $branch_exists = Branch::where('uid', $request->id)->where('eiin',auth()->user()->eiin)->first();

        $validation_rules = [];

        if($branch_exists->branch_name != $request->branch_name) {
          $validation_rules['branch_name'] = [
            'required',
              Rule::unique('branches')
              ->where('eiin', auth()->user()->eiin)
          ];
        }

        if($branch_exists->head_of_branch_id != $request->head_of_branch_id) {
          $validation_rules['head_of_branch_id'] = [
            'required',
                Rule::unique('branches')
                ->where('head_of_branch_id', $request->head_of_branch_id)
                ->where('eiin', auth()->user()->eiin)
          ];
        }

        if($request->branch_location == null) {
          $validation_rules['branch_location'] = 'required|string';
        }

        $this->validate(request(), $validation_rules, [
          'branch_location.required'=> 'অনুগ্রহ করে ব্রাঞ্চ ঠিকানা প্রদান করুন',
          'branch_name.required'=> 'অনুগ্রহ করে ব্রাঞ্চ নাম প্রদান করুন',
          'branch_name.unique'=> 'একই নামের ব্রাঞ্চ একই স্কুল এ দেয়া যাবেনা',
          'head_of_branch_id.required'=> 'অনুগ্রহ করে প্রধান শিক্ষক এর নাম প্রদান করুন',
          'head_of_branch_id.unique'=> 'একই প্রধান শিক্ষক একাধিক ব্রাঞ্চ প্রধান হতে পারে না',
        ]);
        
        try {
            $branch = Branch::where('uid', $request->id)->first();

            $branch->update([
                'branch_id' => $request->branch_id,
                'branch_name' => $request->branch_name,
                'branch_location' => $request->branch_location,
                'head_of_branch_id' => $request->head_of_branch_id,
                'eiin' => auth()->user()->eiin,
            ]);

            $branch->save();

            $notification = array(
                'message' => 'Data Updated successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('noipunno.dashboard.branch.add')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function noipunnoDashboardBranchEdit(Request $request)
    {
        $branchData = Branch::where('uid', $request->id)->get()->first();
        $eiinId = auth()->user()->eiin;
        $branchList = $this->branchService->getByEiinIdWithPagination($eiinId);
        $myTeachers = $this->teacherService->getByEiinId($eiinId);

        return view('frontend/noipunno/branch/edit', compact('branchData', 'branchList', 'eiinId', 'myTeachers'));
    }

    public function noipunnoDashboardBranchDelete(Request $request)
    {
        $this->branchService->removeBranch($request->id);
        return redirect()->back();
    }

    public function noipunnoDashboardVersionAdd()
    {
        $eiinId = auth()->user()->eiin;
        // $versionList = Version::select('*')->get();
        $versionList = $this->versionService->getByEiinIdWithPagination($eiinId);
        $myBranches = $this->branchService->getByEiinId($eiinId);

        return view('frontend/noipunno/version/index', compact('versionList', 'myBranches', 'eiinId'));
    }

    public function noipunnoDashboardVersionStore(Request $request)
    {
        $this->validate(request(), [
            'version_name' => [
                'required',
                Rule::unique('versions')
                    ->where(function ($query) use ($request) {
                        return $query ->where('eiin', auth()->user()->eiin)
                                      ->where('branch_id', $request->branch_id);
                    })
            ],
        ], [
            'version_name.required' => 'অনুগ্রহ করে ভার্সন নাম প্রদান করুন',
            'version_name.unique' => 'একই ভার্সন একাধিকবার দেয়া সম্ভব না',
        ]);
        
        try {
            $eiinId = auth()->user()->eiin;

            Version::create([
                'branch_id' => $request->branch_id,
                'version_name' => $request->version_name,
                'eiin' => $eiinId,
            ]);

            $notification = array(
                'message' => 'Data Created successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('noipunno.dashboard.version.add')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function noipunnoDashboardVersionUpdate(Request $request)
    {
        $version_exists = Version::where('uid', $request->id)
                            ->where('eiin',auth()->user()->eiin)
                            ->first();

        if($version_exists->version_name != $request->version_name || $version_exists->branch_id != $request->branch_id) {
          $this->validate(request(), [
            'version_name' => [
                'required',
                Rule::unique('versions')
                    ->where(function ($query) use ($request) {
                        return $query ->where('eiin', auth()->user()->eiin)
                                      ->where('branch_id', $request->branch_id);
                    })
            ],
          ],[
              'version_name.unique' => 'একই ভার্সন একাধিকবার দেয়া সম্ভব না',
              'version_name.required' => 'অনুগ্রহ করে ভার্সন নাম প্রদান করুন',
          ]);
        }

        try {
            $version = Version::where('uid', $request->id)->first();
            $eiinId = auth()->user()->eiin;

            $version->update([
                'branch_id' => $request->branch_id,
                'version_id' => $request->version_id,
                'version_name' => $request->version_name,
                'eiin' => $eiinId,
            ]);

            $version->save();

            $notification = array(
                'message' => 'Data Updated successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('noipunno.dashboard.version.add')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function noipunnoDashboardVersionEdit(Request $request)
    {
        $eiinId = auth()->user()->eiin;
        $myBranches = $this->branchService->getByEiinId($eiinId);

        $versionData = Version::where('uid', $request->id)->first();
        $versionList = $this->versionService->getByEiinIdWithPagination($eiinId);

        return view('frontend/noipunno/version/edit', compact('versionData', 'versionList', 'myBranches'));
    }

    public function noipunnoDashboardShiftAdd()
    {
        $eiinId = auth()->user()->eiin;
        $branchList = $this->branchService->getByEiinId($eiinId);
        // $shiftList = Shift::select('*')->get();
        $shiftList = $this->shiftService->getByEiinIdWithPagination($eiinId);

        return view('frontend/noipunno/shift/index', compact('branchList', 'shiftList', 'eiinId'));
    }

    public function noipunnoDashboardShiftStore(Request $request)
    {
        $this->validate(request(), [
            'shift_name' => [
                'required',
                Rule::unique('shifts')
                ->where('eiin', auth()->user()->eiin)
                ->where('branch_id', $request->branch_id),
            ],
        ],[
            'shift_name.unique'=> 'একই শিফট একাধিকবার দেয়া সম্ভব না',
        ]);

        $this->validate(request(), [
            'shift_name' => [
                'required',
                Rule::unique('shifts')
                ->where('eiin', auth()->user()->eiin)
                ->where('shift_start_time', $request->shift_start_time)
                ->where('shift_end_time', $request->shift_end_time)
                ->where('branch_id', $request->branch_id),
            ],
            'shift_start_time' => [
                'required',    
                        Rule::unique('shifts')
                        ->where('eiin', auth()->user()->eiin)
                        ->where('branch_id', $request->branch_id),
            ],
            'shift_end_time' => [
                'required',  
                'date_format:H:i',
                'after:shift_start_time',
                        Rule::unique('shifts')
                        ->where('eiin', auth()->user()->eiin)
                        ->where('branch_id', $request->branch_id),
            ],
        ],[
            'shift_name.required'=> 'অনুগ্রহ করে শিফট নাম প্রদান করুন',
            'shift_name.unique'=> 'একই শিফট একাধিকবার দেয়া সম্ভব না',
            'shift_start_time.required'=> 'অনুগ্রহ করে শিফট শুরু হওয়ার সময় প্রদান করুন',
            'shift_start_time.unique'=> 'এই সময় স্লট আর খালি নেই',
            'shift_end_time.required'=> 'অনুগ্রহ করে শেষ হওয়ার সময় প্রদান করুন',
            'shift_end_time.unique'=> 'এই সময় স্লট আর খালি নেই',
            'shift_end_time.after'=> 'শেষ হওয়ার সময় অবশ্যই শুরুর পরবর্তী সময় হতে হবে',
        ]);
        
        try {
            Shift::create([
                'shift_name' => $request->shift_name,
                'shift_details' => $request->shift_details,
                'branch_id' => $request->branch_id,
                'shift_start_time' => $request->shift_start_time,
                'shift_end_time' => $request->shift_end_time,
                'eiin' => auth()->user()->eiin,
            ]);
 
            $notification = array(
                'message' => 'Data Created successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('noipunno.dashboard.shift.add')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function noipunnoDashboardShiftUpdate(Request $request)
    {
        $shift_exists = Shift::where('uid', $request->id)
                            ->where('eiin',auth()->user()->eiin)
                            ->first();
        
        $validation_rules = [];

        if($shift_exists->shift_name != $request->shift_name) {
          $validation_rules['shift_name'] = [
            'required',
                  Rule::unique('shifts')
                  ->where('eiin', auth()->user()->eiin)
                  ->where('branch_id', $request->branch_id),
          ];
        }

        if($shift_exists->shift_start_time != $request->shift_start_time) {
              $validation_rules['shift_start_time'] = [
                'required',    
                Rule::unique('shifts')
                ->where('eiin', auth()->user()->eiin)
                ->where('shift_start_time', $request->shift_start_time)
                ->where('branch_id', $request->branch_id)
            ];
        }

        if($shift_exists->shift_end_time != $request->shift_end_time) {
          $validation_rules['shift_end_time'] = [
            'required',  
            'date_format:H:i',
            'after:shift_start_time',
                    Rule::unique('shifts')
                    ->where('eiin', auth()->user()->eiin)
                    ->where('shift_end_time', $request->shift_end_time)
                    ->where('branch_id', $request->branch_id),
          ];
        }

        $this->validate(request(), $validation_rules ,[
            'shift_name.required'=> 'অনুগ্রহ করে শিফট নাম প্রদান করুন',
            'shift_name.unique'=> 'একই শিফট একাধিকবার দেয়া সম্ভব না',
            'shift_start_time.required'=> 'অনুগ্রহ করে শিফট শুরু হওয়ার সময় প্রদান করুন',
            'shift_start_time.unique'=> 'এই সময় স্লট আর খালি নেই',
            'shift_end_time.required'=> 'অনুগ্রহ করে শেষ হওয়ার সময় প্রদান করুন',
            'shift_end_time.unique'=> 'এই সময় স্লট আর খালি নেই',
            'shift_end_time.after'=> 'শেষ হওয়ার সময় অবশ্যই শুরুর পরবর্তী সময় হতে হবে',
        ]);
        
        try {
            $shift = Shift::where('uid', $request->id)->first();

            $shift->update([
                'shift_name' => $request->shift_name,
                'shift_details' => $request->shift_details,
                'branch_id' => $request->branch_id,
                'shift_start_time' => $request->shift_start_time,
                'shift_end_time' => $request->shift_end_time,
                'eiin' => auth()->user()->eiin,
            ]);

            $shift->save();

            $notification = array(
                'message' => 'Data Updated successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('noipunno.dashboard.shift.add')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function noipunnoDashboardShiftEdit(Request $request)
    {
        $shiftData = Shift::where('uid', $request->id)->first();
        $eiinId = auth()->user()->eiin;

        // $shiftList = Shift::select('*')->get();
        // $branchList = Branch::select('*')->get();
        $branchList = $this->branchService->getByEiinId($eiinId);
        $shiftList = $this->shiftService->getByEiinIdWithPagination($eiinId);

        return view('frontend/noipunno/shift/edit', compact('shiftData', 'shiftList', 'branchList'));
    }

    public function noipunnoDashboardSectionAdd()
    {
        $eiinId = auth()->user()->eiin;
        $branchList = $this->branchService->getByEiinId($eiinId);
        $versionList = $this->versionService->getByEiinId($eiinId);
        $shiftList = $this->shiftService->getByEiinId($eiinId);
        $sectionList = Section::select('*')->where('eiin', $eiinId)->with('branch', 'version', 'shift')->paginate(20);
        // $classList = $this->classService->getAll();

        return view('frontend/noipunno/section/index', compact('branchList', 'shiftList', 'versionList', 'sectionList', 'eiinId'));
    }

    public function noipunnoDashboardSectionStore(Request $request)
    {
        $this->validate(request(), [
            'section_name' => [
                'required',
                Rule::unique('sections')
                        ->where('class_id', $request->class_id)
                        ->where('section_year', $request->section_year)
                        ->where('branch_id', $request->branch_id)
                        ->where('eiin', auth()->user()->eiin)
            ],
            'section_year' => 'required',
            'class_id' => 'required',
        ],[
            'section_name.required'=> 'অনুগ্রহ করে সেকশন নাম প্রদান করুন',
            'section_name.unique'=> 'একই সেকশন একাধিকবার দেয়া সম্ভব না',
            'section_year.required'=> 'অনুগ্রহ করে শিক্ষাবর্ষ প্রদান করুন',
            'class_id.required'=> 'অনুগ্রহ করে ক্লাস প্রদান করুন',
        ]);

        try {
            Section::create([
                'section_name' => $request->section_name,
                'section_details' => $request->section_details,
                'section_year' => $request->section_year,
                'class_id' => $request->class_id,
                'shift_id' => $request->shift_id,
                'version_id' => $request->version_id,
                'branch_id' => $request->branch_id,
                'eiin' => auth()->user()->eiin,
            ]);
            $notification = array(
                'message' => 'Data Created successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('noipunno.dashboard.section.add')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function noipunnoDashboardSectionUpdate(Request $request)
    {
          $section_exists = Section::where('uid', $request->id)
          ->where('eiin',auth()->user()->eiin)
          ->first();

          $this->validate(request(), [
                'section_name' => 'required',
                'section_year' => 'required',
                'class_id' => 'required',
          ],[
              'section_year.required'=> 'অনুগ্রহ করে শিক্ষাবর্ষ প্রদান করুন',
              'class_id.required'=> 'অনুগ্রহ করে ক্লাস প্রদান করুন',
              'class_id.required'=> 'অনুগ্রহ করে ক্লাস প্রদান করুন',
              'section_name.required'=> 'অনুগ্রহ করে সেকশন নাম প্রদান করুন',
          ]);
        
          if($section_exists->section_name != $request->section_name || $section_exists->branch_id != $request->branch_id 
          || $section_exists->section_year != $request->section_year || $section_exists->class_id != $request->class_id) {
            
            $this->validate(request(), [
            'section_name' => [
            'required',
                    Rule::unique('sections')
                    ->where('class_id', $request->class_id)
                    ->where('branch_id', $request->branch_id)
                    ->where('section_year', $request->section_year)
                    ->where('eiin', auth()->user()->eiin)
            ],
            ],[
                'section_name.required'=> 'অনুগ্রহ করে সেকশন নাম প্রদান করুন',
                'section_name.unique'=> 'একই সেকশন একাধিকবার দেয়া সম্ভব না',
                'section_year.required'=> 'অনুগ্রহ করে শিক্ষাবর্ষ প্রদান করুন',
                'class_id.required'=> 'অনুগ্রহ করে ক্লাস প্রদান করুন',
            ]);
          }
          
     
        try {
            $section = Section::where('uid', $request->id)->first();

            $section->update([
                'section_name' => $request->section_name,
                'section_details' => $request->section_details,
                'section_year' => $request->section_year,
                'class_id' => $request->class_id,
                'shift_id' => $request->shift_id,
                'version_id' => $request->version_id,
                'branch_id' => $request->branch_id,
                'eiin' => auth()->user()->eiin,
            ]);

            $section->save();

            $notification = array(
                'message' => 'Data Updated successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('noipunno.dashboard.section.add')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function noipunnoDashboardSectionEdit(Request $request)
    {
        $eiinId = auth()->user()->eiin;
        $sectionData = Section::where('uid', $request->id)->get()->first();
        $sectionList = Section::select('*')->where('eiin', $eiinId)->with('branch', 'version', 'shift')->paginate(20);
        $branchList = $this->branchService->getByEiinId($eiinId);
        $versionList = $this->versionService->getByEiinId($eiinId);
        $shiftList = $this->shiftService->getByEiinId($eiinId);
        // $classList = $this->classService->getAll();

        return view('frontend/noipunno/section/edit', compact('sectionData', 'branchList', 'versionList', 'shiftList', 'sectionList'));
    }

    public function noipunnoDashboardSessionAdd()
    {
        return view('frontend/noipunno/session/index');
    }

    public function noipunnoDashboardSessionEdit()
    {
        return view('frontend/noipunno/session/edit');
    }

    public function noipunnoDashboardComponents()
    {
        return view('frontend/noipunno/style-components/index');
    }

    public function branchWiseVersion(Request $request)
    {
        $data['versions'] = Version::where('eiin', $request->eiin)->where('branch_id', $request->branch_id)->get();
        $data['shifts'] = Shift::where('eiin', $request->eiin)->where('branch_id', $request->branch_id)->get();

        return response()->json($data);
    }
    public function classWiseSubject(Request $request)
    {
        $data['subjects'] = $this->subjectService->getAll($request);
        return response()->json($data);
    }
    public function classWiseSection(Request $request)
    {
        $data['sections'] = Section::where('eiin', $request->eiin)
            ->where('branch_id', $request->branch_id)
            ->where('class_id', $request->class_id)
            ->where('shift_id', $request->shift_id)
            ->where('version_id', $request->version_id)
            ->get();

        return response()->json($data);
    }

    public function sectionWiseYear(Request $request)
    {
        $data['section'] = Section::where('uid', $request->section_id)->first();
        return response()->json($data);
    }

    public function noipunnoDashboardStudentsReport()
    {
        return view('frontend/noipunno/students-report/index');
    }
}
