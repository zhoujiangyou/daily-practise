/**
 * Created by Administrator on 2018/2/22.
 */
/**
 * //变量赋值
let [a,b,c,d]=[1,2,3,4];
console.log(a);
//只要某种数据结构具有Itenator接口都可以采用数据形式的解构赋值。
let [x, y, z] = new Set(['a', 'b', 'c']);

//对象的解构赋值，对象的解构与数组的解构不同。数组的元素是按次序排序的，变量的取值由它的位置决定
//而对象的属性没有次序，变量必须与属性同名，才能取到正确的值。

//默认值生效的条件是，对象的属性值严格等于undefined。
var { message: msg = 'Something went wrong' } = {message:undefined};
console.log(msg);*/

/**
 * 变量解构赋值的作用
 *
 * */

/**
 // 交换变量的值
let x=1;
let y=2;
[x,y]=[y,x];

//从函数中返回多个值
function example(){
    return [1,2,3];

}
let [a,b,c]=example();

function example2(){
    return {
        foo:123,
        bar:345
    };
}
let {foo,bar}=example2();
//提取json数据

let jsonData={
    id:2,
    status:false,
    data:[123,123]
};
let {id,status,data:nums}=jsonData;


 */

/**
let functionname = (arr)=>({ info:(narr)=>({redf:(tarr)=>{console.log(arr+narr+tarr)}})});
functionname(123).info(456).redf(678);*/

/**
let arr =[1,2,3,4,5,6];
console.log(...arr);
console.log(Math.max(...arr));

console.log((new Date()).getTime());*/

/**
//对数据key遍历
for (let index of [1,2,3,4].keys()){
    console.log(index);
}


 //对数组value遍历
 for (let elem of ['a', 'b']) {
     console.log(elem);
 }

for(let [ind,elm] of [1,2,3,4].entries()){

    console.log(ind,elm);
}*/


