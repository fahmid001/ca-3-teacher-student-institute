<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Institute;

use Illuminate\Support\Facades\Validator;
use Exception;

use App\Traits\ApiResponser;
use App\Traits\ValidtorMapper;

use App\Services\InstituteService;

class InstituteController extends Controller
{
    use ApiResponser, ValidtorMapper;
    private $instituteService;

    public function __construct(InstituteService $instituteService)
    {
        $this->instituteService = $instituteService;
    }

    public function index(Request $request)
    {
        try {
            $institutes = $this->instituteService->list();
            return $this->successResponsePaginate($institutes, Response::HTTP_OK);
        } catch (Exception $exc) {
            return $this->errorResponse("Not found", Response::HTTP_NOT_FOUND);
        }
    }

    public function storeInstituteHeadMaster(Request $request)
    {
        try {
            $institutes = $this->instituteService->storeInstituteHeadMaster($request->all());
            return $this->successResponse($institutes, Response::HTTP_OK);
        } catch (Exception $exc) {
            return $this->errorResponse($exc->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'institute_name' => 'required',
            'institute_type' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($this->Validtor($validator->errors()), 422);
        }
        try {
            $institute = $this->instituteService->create($request->all());
            return $this->successResponse($institute, Response::HTTP_OK);
        } catch (Exception $exc) {
            return $this->errorResponse($exc->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    public function upazilaInstituteWithHeadMaster(Request $request, $upazila_id)
    {
        try {
            $institutes = $this->instituteService->getUpazilaInstituteWithHeadMaster($upazila_id);
            return $this->successResponsePaginate($institutes, Response::HTTP_OK);
        } catch (Exception $exc) {
            return $this->errorResponse("Not found", Response::HTTP_NOT_FOUND);
        }
    }

    public function upazilaTeachers(Request $request)
    {
        try {
            $teachers = $this->instituteService->getUpazilaTeachers($request->upazila_id);
            return $this->successResponsePaginate($teachers, Response::HTTP_OK);
        } catch (Exception $exc) {
            dd($exc);
            return $this->errorResponse("Not found", Response::HTTP_NOT_FOUND);
        }
    }

    public function updateInstituteHeadMaster(Request $request)
    {
        try {
            $teacher = $this->instituteService->updateInstituteHeadMaster($request->all());
            return $this->successResponse($teacher, Response::HTTP_OK);
        } catch (Exception $exc) {
            return $this->errorResponse($exc->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
