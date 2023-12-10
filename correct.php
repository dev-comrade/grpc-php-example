<?php

use Grpc\ChannelCredentials;
use Helloworld\GreeterClient;
use Helloworld\HelloReply;
use Helloworld\HelloRequest;
use const Grpc\STATUS_OK;

ini_set('display_errors', 1);

require(__DIR__ . '/vendor/autoload.php');
$secure = ['secrete-key' => ['so-secrete']];

$config['update_metadata'] = function ($metadata) use ($secure) {
    return array_merge($metadata, $secure);
};

$config['credentials'] = ChannelCredentials::createInsecure();
/* @var $response HelloReply */
$stub = new GreeterClient("127.0.0.1:50052", $config);
[$response, $status] = $stub->SayHello(new HelloRequest(["name" => "Alex"]))->wait();
if ($status->code == STATUS_OK) {
    echo "Service said : " . $response->getMessage() . PHP_EOL;
} else {
    echo "Server status code: " . $status->code;
}
