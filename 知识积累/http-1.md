---
title: http-1
date: 2017-10-14 14:20:02
tags: http
---

> ### http

http协议是一个属于应用层的面向对象的协议，由于其简捷快速的方式，适用于分布式超媒体信息系统。  
http协议的特点如下：  
1. 支持客户/服务器模式  
2. 简单快速：客户向服务器请求服务时，只需要传送请求方法和路径。
3. 灵活：允许传输任意类型的数据对象，传输的类型由content-type标记。  
4. 无连接：无连接的含义是限制每次连接只处理一个请求。服务器处理完客户请求，并收到客户的应答后即断开连接。
5. 无状态：对事物的处理没有记忆能力，要处理相同的请求必须重新传输。

>> #### http请求

http请求由三部分组成：
请求行、消息报头、请求正文

请求行以一个方法符号开头，以空格分开，后面跟着请求的URI和协议的版本，格式如下：Method Request-URI HTTP-Version CRLF  
其中 Method表示请求方法；Request-URI是一个统一资源标识符；HTTP-Version表示请求的HTTP协议版本；CRLF表示回车和换行（除了作为结尾的CRLF外，不允许出现单独的CR或LF字符）。  

请求方法（所有方法全为大写）有多种，各个方法的解释如下：  
GET     请求获取Request-URI所标识的资源  
POST    在Request-URI所标识的资源后附加新的数据  
HEAD    请求获取由Request-URI所标识的资源的响应消息报头  
PUT     请求服务器存储一个资源，并用Request-URI作为其标识  
DELETE  请求服务器删除Request-URI所标识的资源  
TRACE   请求服务器回送收到的请求信息，主要用于测试或诊断  
CONNECT 保留将来使用  
OPTIONS 请求查询服务器的性能，或者查询与资源相关的选项和需求  
应用举例：  
GET方法：在浏览器的地址栏中输入网址的方式访问网页时，浏览器采用GET方法向服务器获取资源，eg:GET /form.html HTTP/1.1 (CRLF)     

POST方法要求被请求服务器接受附在请求后面的数据，常用于提交表单。   
eg：POST /reg.jsp HTTP/ (CRLF)    
Accept:image/gif,image/x-xbit,... (CRLF)  
...
HOST:www.guet.edu.cn (CRLF)  
Content-Length:22 (CRLF)  
Connection:Keep-Alive (CRLF)  
Cache-Control:no-cache (CRLF)  
(CRLF)         //该CRLF表示消息报头已经结束，在此之前为消息报头  
user=jeffrey&pwd=1234  //此行以下为提交的数据  

HEAD方法与GET方法几乎是一样的，对于HEAD请求的回应部分来说，它的HTTP头部中包含的信息与通过GET请求所得到的信息是相同的。利用这个方法，不必传输整个资源内容，就可以得到Request-URI所标识的资源的信息。该方法常用于测试超链接的有效性，是否可以访问，以及最近是否更新。

>> #### http响应

在接收和解释请求消息后，服务器返回一个HTTP响应消息。  

HTTP响应也是由三个部分组成，分别是：状态行、消息报头、响应正文  
1、状态行格式如下：  
HTTP-Version Status-Code Reason-Phrase CRLF  
其中，HTTP-Version表示服务器HTTP协议的版本；Status-Code表示服务器发回的响应状态代码；Reason-Phrase表示状态代码的文本描述。  
状态代码有三位数字组成，第一个数字定义了响应的类别，且有五种可能取值：  
1xx：指示信息--表示请求已接收，继续处理  
2xx：成功--表示请求已被成功接收、理解、接受  
3xx：重定向--要完成请求必须进行更进一步的操作  
4xx：客户端错误--请求有语法错误或请求无法实现  
5xx：服务器端错误--服务器未能实现合法的请求  
常见状态代码、状态描述、说明：   
200 OK      //客户端请求成功   
400 Bad Request  //客户端请求有语法错误，不能被服务器所理解   
401 Unauthorized //请求未经授权，这个状态代码必须和WWW-Authenticate报头域一起使用  
403 Forbidden  //服务器收到请求，但是拒绝提供服务   
404 Not Found  //请求资源不存在，eg：输入了错误的URL     
500 Internal Server Error //服务器发生不可预期的错误    
503 Server Unavailable  //服务器当前不能处理客户端的请求，一段时间后可能恢复正常   
eg：HTTP/1.1 200 OK （CRLF）

***

>> ### http协议相关补充

高层协议：ftp 文件传输协议、电子邮件传输协议：smtp、域名系统服务：dns

中介有三种：代理、网关、通道  
代理：中间程序，可以充当一个服务器。也可以充当一个客户机，为其他客户建立请求。 是一种特殊的网络服务，允许一个网络中断通过这个服务与另一个网络终端进行非直接的连接提供代理服务的电脑系统过着其他类型的网络终端称之为代理服务器。例如nginx。
网关：又称网间连接器、协议转换器。网关在传输层上以实现网络互联，是最复杂的网络互联设备，仅用于两个高层协议不同的网络互连。
