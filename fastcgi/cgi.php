<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/2
 * Time: 11:08
 */

echo "这是一个例子知道的例子";

fastcgi_finish_request();
file_put_contents('log.txt', '生存还是毁灭,这是个问题.',FILE_APPEND);