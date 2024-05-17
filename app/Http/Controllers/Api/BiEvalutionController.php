<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BiEvaluation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

use App\Traits\ApiResponser;
use App\Traits\ValidtorMapper;

use Exception;

class BiEvalutionController extends Controller
{
    use ApiResponser, ValidtorMapper;

    public function store(Request $request)
    {
        try {
            $evaluation_data = $request->all();
            foreach($evaluation_data as $list){
                $exist = BiEvaluation::where('student_uid', $list['student_uid'])->where('bi_uid', $list['bi_uid'])->first();
                if($exist){
                    $data = $exist;
                }
                else{
                    $data = new BiEvaluation();
                }
                $data->evaluate_type = $list['evaluate_type'];
                $data->bi_uid = $list['bi_uid'];
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

    public function getBiEvaluationByBi(Request $request)
    {
        try {
            $data['evaluation'] = BiEvaluation::where('class_room_uid', $request->class_room_uid)
                        // ->where('bi_uid', $request->bi_uid)
                        ->where('student_uid', $request->student_uid)
                        ->where('evaluate_type', $request->evaluate_type)
                        ->get();
            return $this->successResponse($data, Response::HTTP_OK);
        } catch (Exception $exc) {
            return $this->errorResponse($exc->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
