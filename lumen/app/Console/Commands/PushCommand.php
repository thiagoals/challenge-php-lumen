<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Mail;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class PushCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for pushing to rabbitmq';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $connection;
    protected $channel;
    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(env('RABBITMQ_HOST'), env('RABBITMQ_PORT'), env('RABBITMQ_USER'), env('RABBITMQ_PASSWORD'),env('RABBITMQ_VHOST'));
        $this->channel = $this->connection->channel();
        parent::__construct();
    }

    /**
     * Push to rabbitmq
     * 
     * @throws AMQPProtocolChannelException
     */
    public function handle()
    {
        $this->channel->queue_declare('process-xml',true,true,false,null);
        $msg = new AMQPMessage('Hello world!');
        $this->channel->basic_publish($msg,'','process-xml');

        echo "[x] Sent 'Hello World!'\n";
        //return $this->pushRaw('teste', 'process-xml', []);
        $this->channel->close();
        $this->connection->close();
    }
    
}