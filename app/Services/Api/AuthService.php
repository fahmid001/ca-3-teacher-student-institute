<?php

namespace App\Services\Api;

use Illuminate\Support\Facades\Http;
use Exception;

use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;

use App\Helper\UtilsCookie;

class AuthService
{
    private $base_url;
    private $update_base_url;

    public function __construct()
    {
        $this->base_url = config('app.base_url') . 'user/account-create';
        $this->update_base_url = config('app.base_url') . 'user/account-update/';
    }

    public function institute($data, $send_sms = null, $send_password = 1)
    {
        try {
            $accessToken = request()->bearerToken() ?? UtilsCookie::getCookie();
            $payload = [
                'name' => @$data->institutename ?? @$data->institute_name,
                'email' => @$data['email'],
                'phone_no' => @$data->mobileno ?? @$data->mobile,
                'password' => $send_password ? rand(100000, 999999) : null,
                'eiin' => @$data->eiin,
                'suid' => '',
                'user_type_id' => 3,
                'is_disabled' => $send_sms,
                'zila_id' => @$data->districtid ?? @$data->district_id,
                'upazila_id' => @$data->upazilaid ?? @$data->upazilla_id,
                'year' =>  @$data['year'] ?? date("Y"),
                'role' => @$data->role ?? 'institute',
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
                'accept' => 'application/json',
            ])->post($this->base_url, $payload);
                if (!$response->successful()) {
                    $response->throw();
                }
                $result = (object) json_decode($response->getBody(), true);
                return $result;
            }  catch (Exception $e) {
                return (object) [
                    'status' => false,
                    'message' => $e->getMessage()
                ];
            }
    }

    public function teacher($data, $eiin = NULL, $permission = 4, $send_sms = null, $send_password = 1) {
        try {
            $accessToken = request()->bearerToken() ?? UtilsCookie::getCookie();
            $payload = [
                'name' => @$data['name_en'] ?? @$data['fullname'],
                'email' => @$data['email'] ?? @$data['pdsid'].'@noipunno.gov.bd',
                'phone_no' => @$data['mobile_no'] ?? @$data['mobileno'],
                'password' => $send_password ? rand(100000, 999999) : null,
                'eiin' => $eiin ?? @auth()->user()->eiin,
                'pdsid' => @$data['pdsid'],
                'user_type_id' => 1,
                // 'is_disabled' => $send_sms,
                'is_disabled' => 1,
                "permission_access_modules" => [$permission],
                'year' => @$data['year'] ?? '2024',
                'role' => @$data->role ?? 'teacher',
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
                'accept' => 'application/json',
            ])
             ->withOptions([
                'verify' => false
            ])
            ->post($this->base_url, $payload);

            if (!$response->successful()) {
                $response->throw();
            }
            $result = (object) json_decode($response->getBody(), true);

            return $result;
        }  catch (Exception $e) {
            return (object) [
                'status' => false,
                'message' => $e->getMessage()
            ];
      }
    }

    public function accountUpdate($data, $caid, $eiin = NULL, $send_sms = null, $send_password = 1) {
        try {
            $accessToken = request()->bearerToken() ?? UtilsCookie::getCookie();
            $payload = [
                // 'name' => @$data['name_en'] ?? @$data['fullname'] ?? @$data['student_name_en'],
                'email' => @$data['email'] ?? @$data['pdsid'] ? $data['pdsid'].'@noipunno.gov.bd' : '',
                'phone_no' => @$data['mobile_no'] ?? @$data['mobileno'] ?? @@$data['father_mobile_no'],
                // 'pdsid' => @$data['pdsid'],
                // 'password' => $send_password ? rand(100000, 999999) : null,
                // 'is_disabled' => $send_sms,
                'is_disabled' => 1,
                // 'role' => @$data['role'] ?? 'teacher',
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
                'accept' => 'application/json',
            ])->put($this->update_base_url . $caid, $payload);

            if (!$response->successful()) {
                $response->throw();
            }
            $result = (object) json_decode($response->getBody(), true);
            return $result;
        }  catch (Exception $e) {
            return (object) [
                'status' => false,
                'message' => $e->getMessage()
            ];
      }
    }

    public function student($data)
    {
        try {
            $accessToken = request()->bearerToken() ?? UtilsCookie::getCookie();
            $payload = [
                'name' => @$data['student_name_en'],
                'email' => @$data['email'],
                'phone_no' => @$data['father_mobile_no'],
                'password' => rand(100000, 999999),
                'eiin' => @auth()->user()->eiin,
                'suid' => '',
                'user_type_id' => 2,
                'is_disabled' => 1,
                'class_id' => @$data['class'],
                'year' => @$data['registration_year'] ,
                'role' => @$data->role ?? 'student',
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
                'accept' => 'application/json',
            ])->post($this->base_url, $payload);
                if (!$response->successful()) {
                    $response->throw();
                }
                $result = (object) json_decode($response->getBody(), true);
                return $result;
        }  catch (Exception $e) {
            return (object) [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /*
    Need to modift this studentsImport function
    change function type static and base url
    */
    public static function studentsImport($data, $classId=null, $year=null)
    {
        try {
            $accessToken = request()->bearerToken() ?? UtilsCookie::getCookie();
            $payload = [
                'name' => @$data['student_name_en'],
                'email' => @$data['email'],
                'phone_no' => @$data['father_mobile_no'],
                'password' => rand(100000, 999999),
                'eiin' => @auth()->user()->eiin,
                'suid' => '',
                'user_type_id' => 2,
                'is_disabled' => 1,
                'class_id' => @$classId,
                'year' => @$year,
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
                'accept' => 'application/json',
            ])->post(config('app.base_url') . 'user/account-create', $payload);
                if (!$response->successful()) {
                    $response->throw();
                }
                $result = (object) json_decode($response->getBody(), true);
                return $result;
            }  catch (Exception $e) {
                return (object) [
                    'status' => false,
                    'message' => $e->getMessage()
                ];
            }
    }

}
