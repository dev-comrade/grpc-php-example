<?php

use Grpc\RpcServer;
use Grpc\ServerContext;
use Helloworld\HelloReply;

include 'vendor/autoload.php';

class HelloService extends Helloworld\GreeterStub
{
    public function SayHello(
        Helloworld\HelloRequest $request,
        ServerContext $context
    ): ?Helloworld\HelloReply {
        return new HelloReply([
            'message' => "Hello " . $request->getName(),
        ]);
    }
}

$server = new RpcServer([]);
$server->addHttp2Port('0.0.0.0:50052');
$server->handle(new HelloService());
$server->run();