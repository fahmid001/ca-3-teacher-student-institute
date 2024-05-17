<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Student;
use App\Models\Version;
use App\Models\Shift;
use App\Models\Section;

use Illuminate\Support\Facades\Validator;
use Exception;

use App\Traits\ApiResponser;
use App\Traits\ValidtorMapper;

use App\Services\StudentService;

class StudentController extends Controller
{
    use ApiResponser, ValidtorMapper;
    private $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function index(Request $request)
    {
        try {
            $students = $this->studentService->list();
            return $this->successResponse($students, Response::HTTP_OK);
        } catch (Exception $exc) {
            return $this->errorResponse("Not found", Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'eiin' => 'required|numeric',
            'student_name_en' => 'nullable|max:150',
            'student_name_bn' => 'nullable|max:150',
            'is_regular' => 'nullable|numeric',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($this->Validtor($validator->errors()), 422);
        }
        try {
            $student = $this->studentService->create($request->all());
            return $this->successResponse($student, Response::HTTP_OK);
        } catch (Exception $exc) {
            return $this->errorResponse($exc->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    public function getAllRequiredDropdownForStudents(Request $request){
        $versionList = Version::where('branch_id',$request->branchId)->get();
        $shiftList = Shift::where('branch_id',$request->branchId)->get();
        $sectionList = Section::where('branch_id',$request->branchId)->get();
        
        $response = [
            'status'=> 'ok',
            'data'=> [
                'versionList'=> $versionList,
                'shiftList'=> $shiftList,
                'sectionList'=> $sectionList,
            ]
        ];

        return $response;
    }
}
