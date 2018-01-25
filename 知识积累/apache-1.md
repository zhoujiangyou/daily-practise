---
title: apache-1
date: 2017-10-12 17:47:02
tags: apache
---
>### apache运行的三种模式    

#### 1. Prefork
prefork mpm 实现了一个非线程的，预派生的web服务器。它在apache启动之初，就会预派生出一些子进程，然后等待连接。  
这样做可以减少频繁穿件喝销毁进程的开销，每个进程只有一个线程，在一个时间点内只能处理一个请求。  
-- 优点： 成熟稳定、可以兼容老模块。不用担心线程安全问题。  
-- 缺点：一个进程相对占用资源，消耗大量内存，不擅长处理高并发场景  

__http.conf配置文件中的配置信息__
```
<IfModule mpm_prefork_module>
    StartServers             5 //启动服务器时建立的子进程数量 prefork默认是5
    MinSpareServers          5 //空闲子进程最小数量，默认是5。如果当前空闲子进程小于设置项，apache将会以每秒一个的数据产生新的进程
    MaxSpareServers         10 //空闲进程最大数量
    MaxRequestWorkers      250 // 限定服务器同一时间客户端最大接入的请求数量，默认是256
    MaxConnectionsPerChild   1000  //每个子进程在生命周期内允许最大的请求数量，当请求达到这个数量，子进程就会结束。如果设置为0，则进程永远不会结束。建议设置为非0。
</IfModule>
```

#### 2. worker  
worker使用了多进程以及多线程的混合模式，worker模式下面同样也会预派生出一些子进程，然后每个子进程创建一些线程，同时
包括一个监听线程。  
每个请求过来会被分配到一个线程来服务。线程比起进程会更加轻量。线程通过共享父进程的内存空间，从而在高并发场景下比prefork有更加好的表现。  
由于用到多进程多线程，所以需要考虑线程安全相关问题。在使用keepalive长连接的时候，某个线程hi一直被占用，即使中间没有请求，需要等待到超时才能被释放（prefork模式下同样存在）。  
__http.conf配置文件中的配置信息__
```
<IfModule mpm_worker_module>
    StartServers             3 //启动是建立的最大进程数量
    ServerLimit             16 //系统配置的最大进程数
    MinSpareThreads         75 //
    MaxSpareThreads        250
    ThreadsPerChild         25 //每个进程产生的线程数量
    MaxRequestWorkers      400 //限定服务器同一时间内客户端最大接入的请求数量.
    MaxConnectionsPerChild   1000
</IfModule>
```

worker模式下面能够同时处理请求的总数是由子进程总数乘以ThreadsPerChild 决定的。应该是大于等于MaxRequestWorkers

#### 3. event  
是apache最近的工作模式，跟worker模式很像，不同的是解决了keep-alive长连接的时候占用线程资源被浪费的问题。  
在event工作模式中会有一些专门的线程来管理这些被keep-alive的线程。当有真实请求过来的时候，将请求传递给服务器的线程。执行完毕后，允许释放。增加了在高并发场景下面的应用。  

__http.conf配置文件中的配置信息__
```
<IfModule mpm_worker_module>
    StartServers             3 //启动是建立的最大进程数量
    ServerLimit             16 //系统配置的最大进程数
    MinSpareThreads         75 //
    MaxSpareThreads        250
    ThreadsPerChild         25 //每个进程产生的线程数量
    MaxRequestWorkers      400 //限定服务器同一时间内客户端最大接入的请求数量.
    MaxConnectionsPerChild   1000
</IfModule>
```

+ Apache httpd 能更好的为有特殊要求的站点定制。例如，要求 更高伸缩性的站点可以选择使用线程的 MPM，即 worker 或 event； 需要可靠性或者与旧软件兼容的站点可以使用 prefork。
