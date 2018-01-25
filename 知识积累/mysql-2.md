---
title: mysql主从备份
date: 2017-10-21 10:30:02
tags: mysql
---

> ### mysql主从备份  

+ 备份前提条件准备：  
  两台装有mysql服务器，讲之前mysql binlog 日志全部删除、关闭防火墙、关闭selinux、时间同步、ssh可以互相通信。  
有两种方式：永久性以及临时
---
1. 第一种方式   
__master__:
   配置文件  
   [mysqld]  
   log-bin=mylog  
    server-id=1  
mysql>grant replication slave,reload,super  on *.* to slave@'XXXXXXXX'  identified by 'XXXX';  
__slave__:  
    配置文件  
    [mysqld]  
    server-id=2  
    master-host=masterhostIP  
    master-user=slave  
    master-password=password  
mysql> show slave status \G    
第二种方法：  
__master__:   
配置文件  
[mysqld]
log-bin=mylog  
server-id=1  
mysql>grant replication slave,reload,super  on *.* to slave@'XXXXXXX'  identified by 'XXXXXXX'；  
__slave__:  
配置文件：  
[mysqld]  
server-id=2  
mysql> change master to  MASTER_HOST='XXXXXXX',  MASTER_USER='slave',
MASTER_PASSWORD='123',   MASTER_PORT=3306,   MASTER_LOG_FILE='mylog.000001',    //在mastar上show master status查看  
MASTER_LOG_POS=106;              //在mastar上show master status查看  
mysql> start slave ;
mysql> show slave status \G

> #### 其他问题

1.  将5.5.19的从库指向5.6.33的主库，slave slave后，查看slave状态，发现报错,这是由于mysql5.6 的 binlog_checksum 默认设置的是 CRC32。5.5或者更早的版本没有这个变量binlog_checksum。  
方法：修改主库配置文件：添加binlog_checksum=none，然后重启主库master。 然后在主库show master status;在从库指定这个新的位置即可。  
2. mysql中有自增长字段，在做数据库的主主同步时需要设置自增长的两个相关配置：auto_increment_offset和auto_increment_increment。auto_increment_offset表示自增长字段从那个数开始，他的取值范围是1 .. 65535；auto_increment_increment表示自增长字段每次递增的量，其默认值是1，取值范围是1 .. 65535；  
在主主同步配置时，需要将两台服务器的auto_increment_increment增长量都配置为2而要把auto_increment_offset分别配置为1和2.  

```
log-bin=mysql-bin
binlog_format=mixed
server-id   = 1
auto_increment_offset = 1
auto_increment_increment = 2


log-bin=mysql-bin
binlog_format=mixed
server-id   = 1
auto_increment_offset = 2
auto_increment_increment = 2

```


![mysql](https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1507821962668&di=54f787a2791378f5a0363602522b620f&imgtype=0&src=http%3A%2F%2Fwww.dingzeit.com%2Fuploadfile%2F20140401163409388.png)
