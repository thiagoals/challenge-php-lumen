<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\File;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use DB;
use Carbon\Carbon;

class AMQPController extends BaseController
{
    private $request;

    public function __construct(Request $request){
        $this->connection = new AMQPStreamConnection(env('RABBITMQ_HOST'), env('RABBITMQ_PORT'), env('RABBITMQ_USER'), env('RABBITMQ_PASSWORD'),env('RABBITMQ_VHOST'));
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare('process-xml',true,true,false,null);
        $this->request = $request;
    }

    /**
     * @OA\Post(
     *     path="/amqp/push",
     *     tags={"Push to CloudAMQP"},
     *     @OA\Response(
     *         response="200",
     *         description="Publica na fila",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Erro ao enviar mensagem para o RabbitMQ",
     *     ),
     * )
     */
    public function push(){
        try{
            $file = $this->request->input('file');
            $path = $this->request->input('path');
            //Primeiro iremos adicionar à fila do RabbitMQ
            $msg = new AMQPMessage($path.'/'.$file,array('delivery_mode' => 2));
            $this->channel->basic_publish($msg,'','process-xml');
            $this->channel->close();
            $this->connection->close();
            //Depois adicionamos ao log de eventos do MySQL para que possamos verificar em caso de necessidade
            DB::table('log')->insert(
                array(
                    'arquivo'=>$file,
                    'caminho'=>$path,
                    'status'=>true,
                    'created_at'=>Carbon::now('GMT-3'),
                    'updated_at'=>Carbon::now('GMT-3')
                )
            );

            return response()->json([
                'msg'=>'Mensagem enviada com sucesso.'
            ],200);
        }catch(Exception $ex){
            DB::table('log')->insert(
                array(
                    'arquivo'=>$file,
                    'caminho'=>$path,
                    'status'=>false,
                    'created_at'=>Carbon::now('GMT-3'),
                    'updated_at'=>Carbon::now('GMT-3')
                )
            );
            return response()->json([
                'erro'=>'Ocorreu um erro ao tentar publicar a mensagem: '.$ex
            ],400);
        }
    }
}