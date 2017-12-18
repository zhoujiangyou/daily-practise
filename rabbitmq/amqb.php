<?php
/**
 * Created by PhpStorm.
 * windows x64 xampp 安装相关扩展 安装7.0 Thread Safe (TS) x86 版本  下载地址：http://pecl.php.net/package/amqp/1.9.3/windows
 * User: zht
 * Date: 2017/12/16
 * Time: 14:27
 */

require_once 'vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
$conf_arr=[
    'host'=>'61.183.115.203',
    'port'=>5672,
    'login'=>'zht',
    'password'=>'zht',
    'vhost'=>'/',
];

$connection = new AMQPStreamConnection('61.183.115.203', 5672, 'zht', 'zht');
$channel = $connection->channel();
$channel->queue_declare('hello', false, false, false, false);

$data=implode('',array_slice($argv,1));
if(empty($data)) $data = "Hello World!";
$msg=new AMQPMessage($data);

$channel->basic_publish($msg,'','hello');
echo 'sent message:hello word';
$channel->close();
$connection->close();