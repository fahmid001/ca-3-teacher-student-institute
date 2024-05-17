<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\PiEvaluation;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

use App\Traits\ApiResponser;
use App\Traits\ValidtorMapper;

use Exception;

class PiEvalutionController extends Controller
{
    use ApiResponser, ValidtorMapper;

    public function store(Request $request)
    {
        try {
            $evaluation_data = $request->all();
            foreach($evaluation_data as $list){
                $exist = PiEvaluation::where('student_uid', $list['student_uid'])->where('pi_uid', $list['pi_uid'])->first();
                if($exist){
                    $data = $exist;
                }
                else{
                    $data = new PiEvaluation();
                }
                $data->evaluate_type = $list['evaluate_type'];
                $data->competence_uid = $list['competence_uid'];
                $data->pi_uid = $list['pi_uid'];
                $data->weight_uid = $list['weight_uid'];
                $data->student_uid = $list['student_uid'];
                $data->teacher_uid = $list['teacher_uid'];
                $data->class_room_uid = @$list['class_room_uid'];
                $data->submit_status = $list['submit_status'];
                $data->is_approved = $list['is_approved'];
                $data->remark = $list['remark'];
                $data->save();
            }
            return $this->successResponse($data, Response::HTTP_OK);
        } catch (Exception $exc) {
            return $this->errorResponse($exc->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    public function getPiEvaluationByPi(Request $request)
    {
        try {
            $data['evaluation'] = PiEvaluation::where('class_room_uid', $request->class_room_uid)
                        ->where('pi_uid', $request->pi_uid)
                        ->where('evaluate_type', $request->evaluate_type)
                        ->get();
            return $this->successResponse($data, Response::HTTP_OK);
        } catch (Exception $exc) {
            return $this->errorResponse($exc->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
