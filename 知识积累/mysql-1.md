---
title: mysql-1
date: 2017-10-12 17:47:02
tags: mysql
---

>#### mysql安装

##### 1.linux环境下安装
其实在就拿我的服务器centos来说，其实安装步骤相对而言还是比较简单的。废话不多说，看下面。
+ 安装mysql的repo的源  
```
wget http://repo.mysql.com/mysql-community-release-el7-5.noarch.rpm  
```

+ 安装repo源包  
```
rpm -ivh mysql-community-release-el7-5.noarch.rpm
```

+ 安装mysql  
```
yum install mysql-server
```

+ 重置mysql密码  
```
mysql -u root  
use mysql;  
update user set password=password('123456') where user='root';  
exit;  
```

###### action  
安装过程中可能会出现：__ERROR 2002 (HY000): Can‘t connect to local MySQL server through socket ‘/var/lib/mysql/mysql.sock‘ (2)__  
这个问题的话其实是/var/lib/mysql的访问权限问题。
把/var/lib/mysql的拥有者改为root(也有可能是改成mysql)。语句如下：  
```
chown -R root:root /var/lib/mysql
```
到这里，安装以及修改root密码已经完成。其他环境下面的安装就别找我了。。自行google、百度吧。。。。

>#### mysql权限  

1. 创建新用户，并且可以本地访问mysql  
```
grant all privileges on *.* to testuser@localhost identified by "123456" ;
```
2. 设置用户可以远程访问mysql  
```
grant all privileges on *.* to testuser@"%" identified by "123456" ;
grant all privileges on *.* to testuser@“192.168.1.100” identified by "123456" ;　　//设置用户testuser，只能在客户端IP为192.168.1.100上才能远程访问mysql ；
```
3. 设置用户访问数据库权限  
```
grant all privileges on test_db.* to testuser@localhost identified by "123456" ;　　//　　设置用户testuser，只能访问数据库test_db，其他数据库均不能访问 ；
grant all privileges on *.* to testuser@localhost identified by "123456" ;　　//　　设置用户testuser，可以访问mysql上的所有数据库 ；
grant all privileges on test_db.user_infor to testuser@localhost identified by "123456" ;　　//　　设置用户testuser，只能访问数据库test_db的表user_infor，数据库中的其他表均不能访问 ；
```
4. 设置用户操作权限  
```
grant all privileges on *.* to testuser@localhost identified by "123456" WITH GRANT OPTION ;　　//设置用户testuser，拥有所有的操作权限，也就是管理员 ；
grant select on *.* to testuser@localhost identified by "123456" WITH GRANT OPTION ;　　//设置用户testuser，只拥有【查询】操作权限 ；
grant select,insert on *.* to testuser@localhost identified by "123456"  ;　　//设置用户testuser，只拥有【查询\插入】操作权限 ；
grant select,insert,update,delete on *.* to testuser@localhost identified by "123456"  ;　　//设置用户testuser，只拥有【查询\插入】操作权限 ；
REVOKE select,insert ON what FROM testuser　　//取消用户testuser的【查询\插入】操作权限 ；
```

ok 关于数据库安装以及基础的用户权限相关就写这么多吧。。之后还有其他的会继续写。

![mysql](https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1507821962668&di=54f787a2791378f5a0363602522b620f&imgtype=0&src=http%3A%2F%2Fwww.dingzeit.com%2Fuploadfile%2F20140401163409388.png)
