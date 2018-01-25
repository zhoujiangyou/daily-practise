---
title: php多进程开发
date: 2017-11-6 14:20:02
tags: posix,pcntl,多进程
---

> ### php多进程开发

单个进程处理大量数据的时候耗时比较久，此时采用多进程的方式进行处理很大程度上是可以提高效率。  
进行php多进程开发，则需要在cli模式下进行。（windows平台不支持）  
在开始之前检测是否安装pcntl以及posix扩展。  
```
php -m
```
---
创建php进程是多进程的开始，需要使用pcntl_fork()函数来产生子进程。  
```
$ppid = getmypid(); // 获取当前进程id 也可以通过posix_getpid()获取进程id
$pid = pcntl_fork(); // 创建进程
if ($pid == -1) {
    die('fork failed'); //进程创建失败
} else if ($pid == 0) {
    $mypid = getmypid(); // 用getmypid()函数获取当前进程的PID
    echo 'I am child process. My PID is ' . $mypid . ' and my father\'s PID is ' .$ppid . PHP_EOL;
} else {
    echo 'Oh my god! I am a father now! My child\'s PID is ' . $pid . ' and mine is '. $ppid . PHP_EOL;
}
```
上面这个列子可能比较简单的说明进程的创建。下面一段代码来具体介绍一下实际应用中怎么解决实际问题。  
批量发送邮件通知，发送邮件的地址在三个文件中，通过循环文件数量，新增进程，一个进程处理一个文件里面的发送任务。

```
$cmds = [
    ['/Users/zht/www/work/text_mail.php','a'],
    ['/Users/zht/www/work/text_mail.php','b'],
    ['/Users/zht/www/work/text_mail.php','c']
];

foreach ($cmds as $cmd){
    $pid = pcntl_fork();
    if($pid == -1){
        exit('create process failed'); //创建进程失败
    }
    if($pid > 0){
        pcntl_wait($status,WNOHANG); //父进程监听子进程状态
    }else{
        pcntl_exec('/usr/bin/php',$cmd); //子进程进任务处理
    }
}
```

接下来介绍一些进程相关pcntl函数：  
1. pcntl_fork()   
为当前进程创建一个子进程，并且先运行父进程，返回的是子进程的PID，肯定大于零。在父进程的代码中可以用pcntl_wait（&$status）暂停父进程知道他的子进程有返回值。注意：父进程阻塞同时会阻塞子进程，但是父进程的结束不影响子进程的运行。
父进程运行玩了会接着运行子进程，这时子进程会从执行pcntl_fork()的那条语句开始执行（包括此函数），但是此时他返回的是零（代表这是一个子进程）。在子进程代码块中最好有exit语句，即执行完子进程之后就立刻结束，否则优惠重头开始执行这个脚本的某些部分。
注意：子进程最好有exit语句，防止不必要的出错。pcntl_fork语句见最好不要有其他语句。  
2. pcntl_alarm（$second）  
设置一个$second秒之后发送SIGALRM信号的计数器。
3. pcntl_signal（int $sigo,callback $handler[,bool $restart_syscall]）  
为$sigi设置一个处理改信号的回调函数。下面是一个隔5秒发送一个SIGALRM信号，并由signal_handler函数获取，然后打印一个“Caught SIGALRM”的例子：  

```
<?php
declare(ticks = 1);

function signal_handler($signal) {
  print "Caught SIGALRM\n";
  pcntl_alarm(5);
}

pcntl_signal(SIGALRM, "signal_handler", true);
pcntl_alarm(5);

for(;;) {
}

?>
```  
Zend引擎每执行1条低级语句就去执行一次 register_tick_function() 注册的函数
可以粗略的理解为每执行一句php代码（例如:$num=1;）就去执行下已经注册的tick函数。  

4. pcntl_exec ( string $path [, array $args [, array $envs ]] )  
在当前进程空间中执行指定程序，类似于c中的exec族函数。所谓当前空间，即载入指定程序的代码覆盖掉当前进程的空间，执行完该程序进程即结束。
5. pcntl_wait ( int &$status [, int $options ] )  
阻塞当前进程，直到当前进程的一个子进程退出或者受到一个结束当前进程的信号。使用$status返回子进程的状态码，并可以指定第二个参数来说明是否以阻塞状态调用。  
阻塞方式调用：函数返回值为子进程的pid，如果没有子进程返回值为-1；  
非阻塞方式调用：函数还可以再有子进程运行但没有结束的子进程时返回0.
6. pcntl_waitpid ( int $pid , int &$status [, int $options ] )  
功能等同pcntl_wait()，区别为waitid（）位等待指定pid的子进程，当pid为-1的时候，两个方法功能效果一样。  
7. pcntl_getpriority([ int $pid [, int $process_identifier ]] )  
取到进程的优先级，即nice值，默认为0.优先级为-20到19.-20级别最高，19级别最低。
8. pcntl_setpriority ( int $priority [, int $pid [, int $process_identifier ]] )  
设置进程的优先级
9. posix_kill
给进程发送信号
10.  pcntl_singal  
设置信号的回调函数  
当父进程退出时，子进程如何得知父进程的退出？
当父进程退出时，会有一个进程号为1的进程领养这个子进程。此时子进程可以使用getppid方法来获取当前父进程id。或者想原有父进程发送空信号（kill(pid,0)）。使用这个方法对某个进程的存在进行检查，而不会真的发送信号，如果返回-1则表示父进程已经退出。  

---
