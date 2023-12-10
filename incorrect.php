<?php

use Grpc\ChannelCredentials;
use Helloworld\GreeterClient;
use Helloworld\HelloReply;
use Helloworld\HelloRequest;
use const Grpc\STATUS_OK;

ini_set('display_errors', 1);

require(__DIR__ . '/vendor/autoload.php');
$secure = ['secrete-key' => ['so-secrete']];
//array(1) refcount(4){ ["secrete-key"]=> array(1) refcount(1){ [0]=> string(10) "so-secrete" refcount(1) } }
//debug_zval_dump($secure);

//Add references on array
array_walk_recursive($secure, function ($val) {});

//array(1) refcount(3){ ["secrete-key"]=> reference refcount(1) { array(1) refcount(1){ [0]=> reference refcount(1) { string(10) "so-secrete" refcount(2) } } } }
//debug_zval_dump($secure);

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
