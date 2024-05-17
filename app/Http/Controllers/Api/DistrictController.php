<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

use App\Models\District;

use App\Traits\ApiResponser;
use App\Traits\ValidtorMapper;

use App\Services\DistrictService;

use Exception;

class DistrictController extends Controller
{
    use ApiResponser, ValidtorMapper;
    private $districtService;

    public function __construct(DistrictService $districtService)
    {
        $this->districtService = $districtService;
    }

    public function index(Request $request)
    {
        try {
            $districts = $this->districtService->list();
            return $this->successResponse($districts, Response::HTTP_OK);
        } catch (Exception $exc) {
            return $this->errorResponse("Not found", Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:districts'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($this->Validtor($validator->errors()), 422);
        }

        try {
            $district = $this->districtService->create($request->all());

            return $this->successResponse($district, Response::HTTP_OK);
        } catch (Exception $exc) {
            return $this->errorResponse($exc->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($this->Validtor($validator->errors()), 422);
        }

        try {
            $districtExists = $this->districtService->getByUId($id);
            if ($districtExists) {
                $district = $this->districtService->update($request->all(), $id);
            } else {
                return $this->errorResponse("Not found", Response::HTTP_NOT_FOUND);
            }
            return $this->successResponse($district, Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
