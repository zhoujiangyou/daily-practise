---
title: php运行机制
date: 2017-12-25 09:30:02
tags: php
---
php共有三个模块：内核、zend引擎、以及扩展层。php内核处理请求、文件流以及错误处理等相关操作。zend引擎用以将源文件转换成机器语言，然后在虚拟机上面运行。扩展层是一组函数、类库和流。php使用它们来执行一些特定的操作。  
php从下到上：  
1. zend引擎:zend整体用c实现，是php的内核部分，他将php代码翻译为可执行的opcode的处理并实现响应的处理方法、实现了基本的数据结构、内存分配以及管理、提供了相应api方法供外部调用。是一切的核心，所有外围功能均能围绕zend实现。  
2. extensions：围绕着zend引擎，extensions通过组件的方式提供各种基础服务，我们常见的各种内置函数（如array）、标准库等都是通过extension来实现。用户也可以根据自己的extension来打到功能扩展、性能优化的目的。  
3. sapi： 全称是server application programming interface。服务端应用编程接口。sapi通过一系列的钩子函数使得php可以与外围数据交互。
4. 上层应用：也就是我们平时编写的php程序，通过不同的sapi的方式得到各种各样的应用模式。
> 4.1 apache2handler：这是以apache作为webserver，采用mod_php模式运行时候的处理方式。也是现在引用最广泛的一种。  
> 4.2 cgi:zheshi 这是以apache作为webserver和php另一种直接的交互方式，现在fastcgi是应用最广泛的一种方式。
> 4.3 cli：命令行调用的应用模式  

php执行流程：  
php代码--->scanning，将php代码转换成语言片段tokens--->Parsing将tokne转换成简单而有意义的表达式--->将表达式编译成opcode--->顺次执行opcodes从而实现php脚本的功能。
