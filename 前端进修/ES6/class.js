/*
function Point(x, y) {
    this.x = x;
    this.y = y;
}

Point.prototype.toString = function () {
    return '改写这个方法 在调用的时候可以输出';
};


var p = new Point(1, 2);
console.log(p.x);
console.log(p.y);
console.log(p.toString());
*/
class Point{
    constructor(x,y){
       this.x=x;
        this.y=y;
    }
    toString(){
      console.log("this is tostring function ");
    }
}
/*var p1 = new Point(1, 2);
console.log(p1.x);
console.log(p1.y);
console.log(p1.toString());
console.log(Object.getOwnPropertyNames(Point.prototype));*/

/**
* 与 ES5 一样，在“类”的内部可以使用get和set关键字，对某个属性设置存值函数和取值函数，拦截该属性的存取行为。
* */
class myclass {
    constructor(){}
    get prop(){

    }
    set prop(value){

    }
}

class child extends myclass {
    constructor() {
        super();
        console.log(Object.getPrototypeOf(this));

    }
}

// @testable
// class MyTestableClass {
//     // ...
// }
//
// function testable(target) {
//     target.isTestable = true;
// }

import { area, circumference } from './mod';
console.log('圆面积：' + area(4));
console.log('圆周长：' + circumference(14));