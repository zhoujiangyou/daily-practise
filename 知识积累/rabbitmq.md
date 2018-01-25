---
title: rabbitmq消息队里相关
date: 2018-1-25 14:55:08
tags: rabbitmq
---

消息队列这边其实市面上知名的产品有很多，Rabbitmq，Activemq,Kafka,redis...等等很多产品。  
之前专门搭建过Rabbitmq的环境学习。不过相关概念时间久了确实会忘记，这边就针对这些概念性问题进行整理。  
#### 什么是消息队列  
消息队列，是一种应用间的通信方式，消息发送后可以立即返回。由消息系统来确保消息的可靠传递。消息发布者只管把消息  
发布到MQ中而不用管谁来取。消息使用者是需要从MQ中取得消息，而不用管是谁发布的。这样的发布者和使用者都不知道对方的存在。  
#### Rabbitmq特点  
1. 高可用性：信息持久化、传输确认、发布确认。  
2. 灵活的路由
3. 消息集群：多个rabbitmq服务器可以组成一个集群，形成一个逻辑broker。
4. 高可用：队列可以再集群中的机器上面进行镜像，使得部分节点出问题情况下仍是可用的。  
5. 多种协议：支持多种消息队列协议，smtp、mqtt等。
6. 管理界面：提供一个简单实用的界面，用户可以监控和管理。  
#### 概念模型  

所有的MQ产品从模型抽象上来说都是一样的过程，消费者订阅某个队列。
生产者创建消息，然后发布到队列中，最后将消息发送到监听的消费者。  
![一个抽象模型](https://upload-images.jianshu.io/upload_images/5015984-066ff248d5ff8eed.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/401)  
![具体内部结构](https://upload-images.jianshu.io/upload_images/5015984-367dd717d89ae5db.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/554)  
1. message :消息是不具名的，由消息头和消息体组成。消息体是不透明的，而消息头则由一系列的不可选属性组成，这些属性包括：  
routing-key(路由建)、priority（相对其他消息优先权）、delivery-mode（指出该消息可能需要持久性存储）  
2. publisher：消息生产者，也是想交换器发布消息的客户端应用程序  
3. exchange：交换器，用来接收生产者发送的消息并将这些消息路由给服务器中的队列。  
4. binding: 绑定，用于消息队列和交换器之间的关联。一个绑定就是基于路由键将交换器和信息队列链接起来的路由规则。
所以可以将交换器历程一个有绑定构成的路由表。  
5. queue：消息队列，用来保存消息直到发送给消费者。  
6. connection：网络链接，比如一个tcp链接  
7. channel: 信道，多路复用链接中的一条独立的双向数据流通道。信道是建立在真实的tcp链接内的虚拟连接。  
9. consumer：消费者，指从一个消息队列中取得消息的客户端应用程序。
10. virtualhost： 虚拟主机，表示一批交换器，消息队列和相关对象。
11. broker：表示消息队列服务器实体。  

Exchange类型：  
exchange分发消息时，根据类型的不同分发策略有所区别。  
direct: 消息中的路由键（routing key） 如果和binding中的binding key中一致，交换器就将消息发到对应的队列中。路由键与对列名完全匹配。  
如果一个队列绑定到交换机要求路由键为dog，则只转发routing-key标记为dog的消息，不会转发dog.pooy等，它是完全匹配单播的模式。
![direct](https://upload-images.jianshu.io/upload_images/5015984-2f509b7f34c47170.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/463)
fanout:  每个发送到fanout类型交换器上面的消息都会分到所有绑定的队列上面去。fanout路由不处理路由键。只是简单的将队列绑定到交换器上
每个发送到交换器的消息都会被转发到与该交换器绑定的所有队列上。就像子网广播，每台自网内的主机都获得了一份复制的消息。
fanout类型转发消息是最快的。  ![fanout](https://upload-images.jianshu.io/upload_images/5015984-2f509b7f34c47170.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/463)
topic:  topic交换器通过模式匹配分配消息的路由键属性，将路由键和某个模式进行匹配，次是队列需要绑定到一个模式上。他讲路由键和绑定建的
字符串切分成单词，这些单词之间用点隔开。他同样也会识别两个通配符（#表示多个单词）
![topic](https://upload-images.jianshu.io/upload_images/5015984-275ea009bdf806a0.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/558)
header:  headers 交换器和 direct 交换器完全一致，但性能差很多，目前几乎用不到了

