<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class FileController extends BaseController
{
    private $request;

    public function __construct(Request $request){
        $this->request = $request;
    }

    /**
     * @OA\Post(
     *     path="/authentication/login",
     *     tags={"login","authentication"},
     *     @OA\Response(
     *         response="200",
     *         description="Retorna um token JWT do usuário",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *     ),
     * )
     */
    public function read(){
        var_dump('deu certo');
    }
}