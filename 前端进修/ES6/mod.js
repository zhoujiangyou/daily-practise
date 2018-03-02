var m = '123123';
var functionModule = function (){
    return 123;
}
export function area(radius) {
    return Math.PI * radius * radius;
}

export function circumference(radius) {
    return 2 * Math.PI * radius;
}
export {m,functionModule};
