<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Usuarios;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthController extends BaseController
{
    private $request;

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function jwt(Usuarios $user)
    {
        $payload = [
            'iss' => "lumen-jwt", 
            'sub' => $user->id, 
            'iat' => time(), 
            'exp' => time() + 60*60 
        ];
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    /**
     * @OA\Post(
     *     path="/authentication/login",
     *     tags={"Login"},
     *     @OA\Response(
     *         response="200",
     *         description="Faz o login do usuário.",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Erro: Usuário ou senha incorretos.",
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Retorna um token JWT do usuário"
     *     ),
     * )
     */
    public function login(Usuarios $user){
        //var_dump($this->request);
        // Validação dos dados
        $this->validate($this->request,[
            'email'=>'required|email',
            'senha'=>'required'
        ]);

        $user = Usuarios::where('email', $this->request->input('email'))->first();

        if(!$user){
            // Se não tiver nenhum dado de usuário, provavelmente ele não possui na base de dados
            return response()->json([
                'erro'=>'Usuário não encontrato em nossa base de dados.'
            ],400);
        }

        // Se o usuário foi encontrado, precisamos checar se a senha está correta (md5)
        if(md5($this->request->input('senha'))==$user->senha){
            return response()->json([
                'nome' => $user->nome,
                'token' => $this->jwt($user),
            ]);
        }

        // Por fim, lançar um bad request caso a senha esteja errada
        return response()->json([
            'erro'=>'Usuário não encontrato em nossa base de dados.'
        ],400);
    }


}