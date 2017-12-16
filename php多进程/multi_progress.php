<?php
/**
 * Created by PhpStorm.
 * 多进程编程实践
 * User: zht
 * Date: 2017/12/16
 * Time: 10:19
 */

if(substr(php_sapi_name(),0,3)!=='cli'){
    die('please run in cli model');
}

set_time_limit(0);

$pid = posix_getpid();//获取进程id
$user=posix_getlogin();//获取用户名

while (true) {

    $prompt = "\n{$user}$ ";
    $input  = readline($prompt);

    readline_add_history($input);
    if ($input == 'quit') {
        break;
    }
    process_execute($input . ';');
}
exit(0);
function process_execute($input) {
    $pid = pcntl_fork(); //创建子进程
    if ($pid == 0) {//子进程
        $pid = posix_getpid();
        echo "* Process {$pid} was created, and Executed:\n\n";
        eval($input); //解析命令
        exit;
    } else {//主进程
        $pid = pcntl_wait($status, WUNTRACED); //取得子进程结束状态
        if (pcntl_wifexited($status)) {
            echo "\n\n* Sub process: {$pid} exited with {$status}";
        }
    }
}