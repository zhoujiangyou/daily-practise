function * helloworldGenerate(){

    yield "hello";
    yield "world";
    yield "hehe";
}

function *data(){
    console.log("start ");
    console.log("start ");
    console.log(`1.${yield}`);
    console.log(`2.${yield}`);
    return "result";
}
var jan ={first: 'Jane', last: 'Doe'};
console.log(Reflect.ownKeys(jan));
