/**
 * Created by Administrator on 2018/2/22.
 */

/**
 * let声明的变量只在其所在的代码块中有效
 */
// {
//     let a = 10;
//     var b = 20;
// }
// console.log(a); //报错 a is not defined
// console.log(b); //正常
//

/**
 * var a =[];
for(var i=0;i<10;i++){
    a[i]=function(){
        console.info(i);
    }
}
a[6](); // 输出结果为10*/


/**
var a =[];
for(let i=0;i<10;i++){
    a[i]=function(){
        console.info(i);
    }
}
a[6](); // 输出结果为6
*/

/**
 * for循环还有一个特别之处，设置循环变量的那部分是一个父作用域，循环体内是一个单独的作用域。
 * */

/**
   for (let i = 0; i < 3; i++) {
    let i = 'abc';
    console.log(i);
}
// abc
// abc
// abc
 */

/**
 * 不存在变量提升
 * 使用var声明变量的时候，变量可以在声明之前使用，值为undefined
 *
 * */
/**
// var 的情况
console.log(foo); // 输出undefined
var foo = 2;

// let 的情况
console.log(bar); // 报错ReferenceError
let bar = 2;
*/
/**
 * 暂时性死区TDZ 在代码块内，使用let命令声明变量之前，该变量都是不可用的。
 * 声明了没有赋值，就是undefined
 * */
/**
if (true) {
    // TDZ开始
    tmp = 'abc'; // ReferenceError
    console.log(tmp); // ReferenceError

    let tmp; // TDZ结束
    console.log(tmp); // undefined

    tmp = 123;
    console.log(tmp); // 123
}*/
/**
{
    let a =123;
    console.log(a);
}*/
const foo = Object.freeze({}); //对象封冻， 不可将对象指针地址更改
foo.poop=123;
console.log(foo.poop);
