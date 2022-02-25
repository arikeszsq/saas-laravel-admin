<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;
use App\Traits\UserTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(title="GlobalXP API", version="1.0")
 * @OA\SecurityScheme(
 *   type="http",
 *   in="header",
 *   name="bearerAuth",
 *   scheme="bearer",
 *   securityScheme="bearerAuth",
 *   bearerFormat="JWT"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ResponseTrait, UserTrait;
}
