---
title: 杂碎知识点
date: 2017-12-32 17:47:02
tags: apache,nginx,php,mysql
---
本文很多内容来自网络，仅做参考。

>### nginx/apache运行模式  

apache三种运行模式详见之前文档。这里介绍一下nginx的运行模式.
nginx会按需同时运行多个进程：一个主进程（master）和几个工作进程（worker），配置了缓存是还会有缓存加载器进程（cache loader）和缓存管理器进程（cache manager）等。所有进程仅含有一个线程。并通过共享内存的机制实现进程间通信。  
如果负载以cpu密集型应用为主，如ssl或者压缩应用。则worker数应该与cpu数相同；如果是响应大量内容给客户端，则worker数应该是cpu个数的1.5或者2倍。    

---
nginx由内核和模块组成，其中，内核的设计非常微小和简介，完成的工作也非常简单，仅仅通过查找配置文件将客户端请求映射到一个location block，而在这个location中所配置的每个指令将会启动不同的模块去完成相应的工作。  
nginx模块从结构上分为核心模块、基础模块、第三方模块。
从功能上面也可以分为三类：
>> 1. handlers（处理器模块）：此模块直接处理请求，并进行输出内容和修改header信息等操作。handlers处理器一般只能有一个。
>> 2. filters（过滤器模块）：此模块主要针对其他处理器模块输出的内容进行修改操作，最后由nginx输出。
>> 3. proxies（代理类模块）：此模块是nginx的http upstream之类的模块。这些模块主要与后端一些服务比如fastcgi等进行交互，实现服务代理和负载均衡等功能。
具体可以见下图(来源自csdn):[nginx常规http请求响应过程](http://img.blog.csdn.net/20130515152325076)    

---
> ### nginx进程模型  
工作模式上面nginx分为但工作进程和多工作进程两种模式。单工作进程模式下，除主进程外，还有个工作进程。工作进程是单线程的；在多工作进程模式下，每个工作进程包含多个进程。nginx默认为单工作进程。  nginx启动之后 会有一个master主进程和多个worker进程。  
master进程：用来管理worker进程，包含向各个worker进程发送信号，监控worker进程的运行状态，当worker进程退出后（异常情况下），会自动重新启动新的worker进程。master进程充当整个进程组与用户的交互接口，同时对进程进行监护。他不需要处理网络事件，不负责业务的执行，只会通过管理worker进程来实现重启服务、平滑升级、更换日志文件、配置文件实时生效等功能。  
worker进程：基本的网络事件就是放在worker中进行处理了。多个worker进程之间是对等的。他们同等竞争来自客户端请求。各个进程之间互相是独立的。一个请求，只可能在一个worker进程中处理。worker进程的个数是可以设置的，一般我们会设置与机器cpu核数一致，这里面的原因与nginx进程模型以及事件处理模型是分不开的。
nginx进程模型如下图：[nginx进程模型](https://www.cnblogs.com/linguoguo/p/5511293.html)

---

#### 什么是fastcgi？  
fastcgi是一个可伸缩的、高速的在http server和动态脚本语言之间通信的接口。cgi是common getway interface 的缩写。  
fastcgi是从cgi发展改进而来、传统的cgi接口方式的主要缺点是性能很差，每次http服务器遇到动态程序时都需要重新启动脚本解析器来解析，然后将结果返回而给http服务器。在处理高并发访问的时候几乎是不可能的。另外传统的cgi接口方式安全性也很差，所以现在很少使用了。   
#### Nginx+fastcgi是运行原理  
nginx不支持对外部程序的直接调用或者解析。所有的外部程序包括php，必须通过fastcgi接口来调用。fastcgi接口在linux下面是socket（这个socket可以使文件socket也可以是ipsocket）。为了调用cgi程序，还需要一个fastcgi的wrapper（wrapper可以理解为用于启动另一个进程的程序）这个wrapper绑定在某个固定socket上面，可以是文件或者端口。nginx将cgi请求发送给这个socket的时候，通过fastcgi接口，wrapper接收到请求。然后fork出一个新的线程，这个县城调用解释器或者外部程序处理脚本并读取返回数据。接着wrapper将返回的数据通过fastcgi接口，沿着固定的socket传递给nginx，nginx将数据返回给客户端。详情见下图：
[nginx+fastcgi运行原理](http://img.blog.csdn.net/20130516093049837)  
