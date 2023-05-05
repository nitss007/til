## javascript_Day1_Closure_Hoisting



An awesome thing about JavaScript is your browser has a built-in execution environment. You can read more on how to execute code within your browser (and view a website's code) here.


### Function Syntax

```
function f(.. args){}
function -> keyword
f-> function name
.. args --> variable length parameters
function f(a,b){
    return a+b;
}
```

### Anonymous Function
function name can be optionally excluded in defination

```
var f = function (a,b) => {
    return a+b;
}
```

### Immediately invoked expressions (IIFE)
create a function and Immediately execute it
```
const result  = (function(a,b){
    const sum = a+b;
}(3,4));
```

It gives you the opportunity to encapsulate a variable within a new scope. For example, another developer can immediately see that sum can't be used anywhere outside the function body.


### Functions within functions

we can create function within Function and return them

function fun(){
    return function(a,b){
        const sum = a+b;
        return sum;
    }
}
const f = fun();
console.log(f(2,3));

In this example, createFunction() returns a new function. Then that function can be used as normal.

### Function Hoisting

when we use function before it is initialized

function fun(){
    return f;
    function f(a,b){
        const sum = a+b;
        return sum;
    }
}
const f = fun();
console.log(f(3,4));

In this example, the function is returned before it is initialized. Although it is valid syntax, it is sometimes considered bad practice as it can reduce readability.


## Closures
When a function is created, it has access to a reference to all the variables declared around it. Lexical environment.
the combination of environment and function is called closure.
function createAdder(a){
    function f(b){
        const  sum = a+b;
        return sum;
    }
    return f;
}
const f = createAdder(3);
console.log(f(a));

createAdder passes the first parameter a and the inner function has access to it. This way, createAdder serves as a factory of new functions, with each returned function having different behavior


## Arrow Syntax
function keyword can be excluded with =>

const f = ()=> {return "hello";}
const f = ()=>  "hello";

## Differences

There are 3 major differences between arrow syntax and function syntax.

    More minimalistic syntax. This is especially true for anonymous functions and single-line functions. For this reason, this way is generally preferred when passing short anonymous functions to other functions.
    No automatic hoisting. You are only allowed to use the function after it was declared. This is generally considered a good thing for readability.
    Can't be bound to this, super, and arguments or be used as a constructor. These are all complex topics in themselves but the basic takeaway should be that arrow functions are simpler in their feature set. You can read more about these differences https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/Arrow_functions

## Rest Arguments

You can use rest syntax to access all the passed arguments as an array. This isn't necessary for this problem, but it will be a critical concept for many problems. You can read more about ... syntax.


```
function f(...args) {
  const sum = args[0] + args[1];
  return sum;
}
console.log(f(3, 4));
```

### Why
creating generic factory functions that accepts any functon as input and return a new version of function with specific modification called higher order function.

eg logged function factory

function log(inputFunction){
    return function(..args){
        console.log("Input", args);
        const result = inputFunction(..args);
        console.log("Output", result);
        return result;
    }
}
