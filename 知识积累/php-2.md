---
title: php-session安全性相关
date: 2017-10-17 14:36:02
tags: php
---

> ### session  

在默认的配置中sessionid都是存储在cookie中的。下面以php为列：  
* 第一次访问服务器时，服务端脚本开启session- session_start()；  
* 服务端会声称要一个不重复的sessionid，通过session_id（），并在返回信息response中加入http头：set-cookie=phpsession=XXXXX；
* 客户端接收到response，并且将phpsession写入cookie中；
* 第二次访问时请求头request中就会带有写入的cookie相关信息，发送到服务端；
* 服务端识别sessionid，并根据这个id去session目录中查找相对应的session文件；找到文件后，检查是否过期，如果没有过期就去读取session文件中的配置；如果已经过期就清空其中的配置。
---
所以如果客户端禁用了cooike，那session还能用么？答案是显而易见的 不能使用。。。
当然。。这个答案如果让sessionid通过url来传递，然后用session_id($\_GET['session_id'])，来强制指定当前session_id.这样的话还是可以。  
不过这样容易被盗用，所以一般都是设置cookie为httponly并加密。


>> ####php.ini中session相关配置

+ session.save_path:代表session文件保存目录，默认情况下在temp目录下面。  
在使用session变量的时候，为了保证服务器的安全性，最好将register_globals设置为off，以保证全局变量不混淆。这样获取session的时候就是通过$\_SESSION[] 这样来访问.可以使用N;[MODE;]/path这样的模式定义路径。N是一个整数，表示使用N层深度的子目录，而不是所有的数据文件都保存在同一个目录下面，[mode:]必须使用8进制数，默认600表示每个目录下面最多保存的回话文件数量。  
+ session.save_handler='files'：以文件方式存取session数据，如果想使用自定义的处理器来存取session，比如数据库，则设置为user。
可以使用session_set_save_handler来进行session自定义存写操作。  
+ session.use_cookie：表示是否用cookies在客户端保存回话sessionid，默认采用cookie
+ session.use_only_coolies =0 :是否仅仅使用cookie在客户端保存会话sessionid，可以禁止用户通过url传递id。默认为0.
+ session.cookie_lifetime = 0：传递session的cookie的有效期。0表示在浏览器打开期间有效。
+ session.auto_start = 0： 是否自动启动session，默认为不启动。我们知道在使用session功能时，我们基本上在每个php脚本头部都会通过session_start
+ session.gc_probability = 1 ；session.gc_divisor = 1 这两个变量定义每次初始化绘画室启动垃圾回收程序的概率。  
计算公式如下：session.gc_probability/session.gc_divisor


---

> #### session安全相关

1. 防止攻击者获取用户回话ID
获取会话ID的方式很多，攻击者可以通过查看明文通信来获取，所以把会话ID放在URL中或者放在通过未加密连接传输的Cookie中是很危险的；还有在URL中（作为_get()参数）传递会话ID也是不安全的，因为浏览器历史缓存中会存储URL，这样就很容易被读取。（可以考虑使用ssh进行加密传输）  
还有一种更为隐蔽的攻击手段，攻击者通过一个被脚本攻击突破的Web站点，把被突破的这个站点上的用户重新定向到另一个站点，然后在重新定向的站点的URL中插入以下代码：  
?PHPSESSID=213456465412312365465412312;  
最后发送到Web应用程序。当用户查看Web应用程序时，PHP会发现没有与这个会话ID相关联的数据并且会创建一些数据。用户不知道发生了什么，但攻击者却知道了会话ID，就可以利用这个会话ID进入应用程序。
要防止这种攻击，有两种方法。  
（1）检查php.ini中是否打开了session.use_only_cookie。如果是这种情况，PHP会拒绝基于URL的会话ID。  
（2）当启动会话时，在会话数据中放一个变量，这个变量表示会话是用户创建的；如果发现会话数据中没有这个变量，那就说明会话ID是假的，  就可以调用session_regenerate_id函数，给现有会话分配一个新的会话ID。  

2. 限制攻击者获取会话ID  

限制攻击者获取会话ID的方法如下。
（1）使用一个函数（md5）计算User-Agent头加上某些附加字符串数据后的散列值（hash）。（散列函数（hash function）接受一个任意大的数据集，并且将它转换为一个看起来完全不同的数据，这个数据很短。产生的散列值是完全不可重现的，也不可能由另一个输入产生。）

在User-Agent字符串后面添加一些数据，攻击者就无法通过对常见的代理值计算md5编码来试探User-Agent字符串。

（2）将这个经过编码的字符串保存在用户的会话数据中。
（3）每次从这个用户接收到请求时，检查这个散列值。  

其实这种做法就是根据头信息生成一个token，之后用户每次请求的时候带上这个token。后端服务器验证token以及sessionid是否正确。
