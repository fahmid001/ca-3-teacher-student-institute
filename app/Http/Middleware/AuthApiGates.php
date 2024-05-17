<?php

namespace App\Http\Middleware;

use Closure;

use App\Helper\UtilsCookie;
use App\Helper\UtilsPassportToken;
use App\Helper\UtilsValidUser;
use App\Traits\ApiResponser;
use Exception;

class AuthApiGates
{
    use ApiResponser;
    public function handle($request, Closure $next)
    {
        try {
            $decoded_token = UtilsPassportToken::dirtyDecode(request()->bearerToken());
            if ($decoded_token['valid']) {
                $timeDifference = strtotime(date($decoded_token['expires_at'])) - strtotime(now());
                if ($timeDifference < 0) {
                    // return response()->json(['status' => 'false', "message" => "Unauthenticated.", 'code' => 401], 401);
                    return $this->errorResponse('Unauthenticated', 401);
                } else {
                    $user =  UtilsValidUser::getUser($decoded_token);
                    app('sso-auth')->setUser($user);
                }
            } else {
                return $this->errorResponse('Unauthenticated', 401);
            }
        } catch (Exception $exc) {
            return $this->errorResponse('Unauthenticated', 401);
        }

        return $next($request);
    }
}
