---
title: nginx性能优化配置
date: 2018-2-3 13:58:02
tags: nginx
---

#### nginx配置相关优化总结：  
1. nginx进程数，建议按照cpu数目来定，一般跟cpu核数相同或者为他的倍数。  
worker_processes $num;    
2. 为每个进程分配cpu，worker_cpu_affinity ：nginx默认是没有开启利用多核cpu的配置的。需要通过增加worker_cpu_affinity
配置参数来充分利用多核cpu，cpu是任务处理，当计算最费时的资源的时候，cpu核数使用上用的越多，性能就最好。一般是跟worker_processes
配合使用。如下里例子：  
```php
//两个cpu情况
worker_processes     2;
worker_cpu_affinity 01 10;
//两个cpu开启四个进程
worker_processes     4;
worker_cpu_affinity 01 10 01 10;
//四个cpu 开启四个进程
worker_processes     4;
worker_cpu_affinity 0001 0010 0100 1000;
//四个cpu 开启两个进程
worker_processes     2;
worker_cpu_affinity 0101 1010;
```
3. 设置nginx进程打开的最多文件描述符数目，理论值应该是系统的最多打开文件数与nginx进程数相除，但是nginx分配请求并不是那么均匀，
所以最好ulimit-n的值保持一致。 65535.。。  
4. 使用epoll的I/O模型，用这个模型来高效的处理事件。
```php
use epoll;
```
5. 每个进程允许链接的最大数，理论上每台nginx服务器最大链接数为worker_processes(进程数)*worker_connections(每个进程连接数)
```php
worker_connections 65535;
```
6. http连接超时时间，默认为60s。功能是使客户端到服务器端的连接在设定的时间内持续有效，当出现对服务器的后继请求时，该功能避免了
建立或者重新建立连接。这个参数不能设置过大，不然会导致很多无效的http连接占着nginx的连接数。
```php
keepalive_time  60s;
```
7. 客户端请求头部的缓存区大小，这个一般是根据系统分页大小来进行设置。通过 getconf pagesize 来获取分页大小。
```php
client_header_buffer_size 4k;
```
8. 为打开的文件制定缓存，默认是没有开启。max指缓存数量，建议跟打开的文件数一致。inactive是指多久文件没有被请求之后删除。
```php
open_file_cache max=65535 inactive=20s; 
```
9. 指定多长时间检查一下缓存的有效信息：open_file_cache_valid:30s  
10. 隐藏响应头中的有关操作系统和web server版本号的信息。server_tokens off；  
11. sendfile可以在磁盘和tcp socket之间互相拷贝数据。pre-senfile是传送数据之前在用户空间申请数据缓冲区。
之后用read（）将数据从文件拷贝到这个缓冲区，write（）将缓冲区数据写入网络。sendfile（）是立即将数据从磁盘读到os缓存。
这种拷贝是在内核中完成的。所以被read &write以及打开关闭丢弃缓冲更加有效。
```php
sendfile on;
```
12. 告诉nginx在一个数据包里面发送所有头文件，而不是一个接一个的发送。就是说数据不会马上发送出去，而是会等数据包最大的
时候一次性传输出去，这样有助于解决网络堵塞。
```php
tcp_nopush on;
```
13. 当需要及时发送数据时，可以设置这个值：tcp_nodelay on ；


