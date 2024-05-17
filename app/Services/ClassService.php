<?php

namespace App\Services;

use GuzzleHttp\Exception\ClientException;

class ClassService
{

    public function __construct()
    {
        
    }

    public function getAll()
    {
        $client = new \GuzzleHttp\Client(['verify' => false]);
        $res = $client->request('GET', config('configure.class_api'));
        $apiData = json_decode($res->getBody()->getContents(), true);
        return $apiData['data'];
    }

    // public function getAll()
    // {
    //     $client = new \GuzzleHttp\Client(['verify' => false]);

    //     $headers['Authorization'] = 'Bearer '.request()->bearerToken();
        
    //     $response = $client->request('GET', config('configure.class_api'),
    //         [
    //             'headers' => $headers
    //         ]
    //     );
    //     try{
    //         return $response->getBody()->getContents();
    //     }
    //     catch(ClientException $e){
    //         $response = $e->getResponse();
	// 		$statusCode = $response->getStatusCode();
	// 		$response_json = $response->getBody()->getContents();
	// 		$response_decode = json_decode($response_json, true);
	// 		return $response_decode;
    //     }
    // }
}
