<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\Server(url="/api")
 * @OA\Info(
 *   title="Market APIs",
 *   version="1.0.0"
 * )
 * This class should be parent class for other API controllers
 * Class Controller
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
