---
title: php-协程相关
date: 2017-10-16 16:58:02
tags: php
---

> ### php协程开发
+ ### 在进行协程相关只是介绍之前有必要了解一下相关的内容。如下：

>> #### 迭代和迭代器

迭代是指反复执行一个过程，每执行一次就是一次迭代。普通的遍历就是迭代。

```
$arr = [1, 2, 3, 4, 5];
foreach($arr as $key => $value) {
    echo $key . ' => ' . $value . "\n";
}
```

php提供了统一的迭代器接口：
```
Iterator extends Traversable {

    // 返回当前的元素
    abstract public mixed current(void)
    // 返回当前元素的键
    abstract public scalar key(void)
    // 向下移动到下一个元素
    abstract public void next(void)
    // 返回到迭代器的第一个元素
    abstract public void rewind(void)
    // 检查当前位置是否有效
    abstract public boolean valid(void)
}
```
通过实现Iterator接口，我们可以自行决定如何遍历对象。

>> #### yield与生成器

一个生成器看起来像是一个普通的函数，不同的是普通函数返回的是一个值，而一个生成器可以yield生成许多它所需要的值。  
当一个生成器被调用的时候，它返回一个可以被遍历的对象，当你遍历这个对象的时候（例如foreach循环），php将会在每次需要值的时候调用生成器函数，并在产生一个值之后保存生成器的状态。这样就可以在需要产生下一个值的时候恢复调用状态。

+ __yield关键字__  
生成器函数的核心就是yield关键字，最简单的调用形式看起来像一个return声明，不同之处在于普通return会返回值并终止函数的执行，而yield会返回一个值给循环调用此生成器的代码并且只是暂停执行生成器函数。

```
<?php
function gen_one_to_three() {
    for ($i = 1; $i <= 3; $i++) {
        //注意变量$i的值在不同的yield之间是保持传递的。
        yield $i;
    }
}

$generator = gen_one_to_three();
foreach ($generator as $value) {
    echo "$value\n";
}
```
以上会输出：
```
1
2
3
```

>> #### 协程  

什么是协程？这个问题其实是比较难解答的，php官方文档中并没有对协程的叙述。（反正我是没搜索到。。。）  
参考鸟哥的blog上面的解释：  
`协程的支持是在迭代生成器的基础上, 增加了可以回送数据给生成器的功能(调用者发送数据给被调用的生成器函数). 这就把生成器到调用者的单向通信转变为两者之间的双向通信.`  

传递数据的动能由生成器中的send方法实现。
```
function printer() {
    while(true) {
        echo 'receive: ' . yield . "\n";
    }
}

$printer = printer();
$printer->send('Hello');
$printer->send('world');
```  
使用send传输数据给生成器函数。

> 协程实现多任务调度 （参考鸟哥blog [laruence](http://www.laruence.com/2015/05/28/3038.html) )  
