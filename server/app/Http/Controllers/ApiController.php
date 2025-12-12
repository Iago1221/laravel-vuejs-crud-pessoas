<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

/**
 * @since 10/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
class ApiController extends Controller
{
    protected static function errorResponse(\Throwable $t)
    {
        $code = $t->getCode() ?? 400;

        return response()->json([
            'error' => $t->getMessage(),
        ], $code);
    }
}
