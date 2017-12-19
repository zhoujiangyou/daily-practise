<?php
/**
 * Created by PhpStorm.
 * User: zht
 * publish/subscribe
 * Date: 2017/12/19
 * Time: 10:27
 */

require_once 'vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('61.183.115.203','5672','zht','zht');
$channel = $connection->channel();

//声明交换器
$channel->exchange_declare('logs','fanout',false,false,false);

$data = implode(' ', array_slice($argv, 1));
if(empty($data)) $data = "info: Hello World!";
$msg = new AMQPMessage($data);

$channel->basic_publish($msg,'logs'); //直接推送到exchange上面


echo " [x] Sent ", $data, "\n";

$channel->close();
$connection->close();

