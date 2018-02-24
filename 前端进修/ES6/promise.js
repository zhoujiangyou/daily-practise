/**
 * Created by Administrator on 2018/2/23.
 */


/**
 * 如果在调用resolve以及reject函数的时候带有参数，那么这个参数会被传递给回调函数。reject函数
 * 的参数通常是Error对象的实例，表示抛出错误，resolve函数的参数除了正常的值之外还可能是另一个promise实例
 * 但是这时候作为参数传递的promise对象的状态决定了调用promise对象的状态
 *
 * 还有一点需要注意，在调用resolve或者reject函数之后并不会终止promise的参数函数的执行。
 * */
/*
let pro1 = new Promise((resolve,reject)=>{
    setTimeout(()=>{reject(new Error("fail"))},3000);
});

let  pro2 = new Promise((resolve,reject)=>{

    setTimeout(()=>resolve(pro1),1000);
});

pro2.then(result=> console.log(result)).catch(error=> console.log(error));

/!**
 * console.log()函数还是会继续执行
 * *!/
new Promise((resolve, reject) => {
    resolve(1);
    console.log(2);
}).then(r => {
    console.log(r);
});

//Promise.all方法用于将多个 Promise 实例，包装成一个新的 Promise 实例。
//promise.all方法的参数可以不是数组，但是必须具有Iterator接口，且返回的每个成员都是promise实例、
//状态由p1,p2,p3决定，分为两种情况
// 参数的状态都变成fulfilled，p的状态才会变成fulfilled。
//参数中只要有一个状态是rejected，p的状态就会变成rejected，此时第一个被rejected的实例的返回值就会传递给p的回调函数。

const p = new Promise([p1,p2,p3,p4]);

*/



/**
 * 通过promise.try 来进行同步或者异步不区分编程状态改变后进行then，出现异常可以
 * 采用catch函数捕获
 * */

