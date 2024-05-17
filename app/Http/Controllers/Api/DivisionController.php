<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

use App\Models\Division;

use App\Traits\ApiResponser;
use App\Traits\ValidtorMapper;

use App\Services\DivisionService;

use Exception;

class DivisionController extends Controller
{
    use ApiResponser, ValidtorMapper;
    private $divisionService;

    public function __construct(DivisionService $divisionService)
    {
        $this->divisionService = $divisionService;
    }

    public function index(Request $request)
    {
        try {
            $divisions = $this->divisionService->list();
            return $this->successResponse($divisions, Response::HTTP_OK);
        } catch (Exception $exc) {
            return $this->errorResponse($exc->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:divisions'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($this->Validtor($validator->errors()), 422);
        }

        try {
            $division = $this->divisionService->create($request->all());

            return $this->successResponse($division, Response::HTTP_OK);
        } catch (Exception $exc) {
            return $this->errorResponse($exc->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    public function show($id)
    {
        try {
            return $this->successResponse($this->divisionService->getById($id), Response::HTTP_OK);
        } catch (Exception $exc) {
            return $this->errorResponse($exc->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
