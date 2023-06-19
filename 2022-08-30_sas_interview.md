## sas_interview

Neeed for functional Interface
Ms database commit transaction rollback
Rest API requirement


```

@FunctionalInterface
interface MyRunnable{

	public void run();
}


@FunctionalInterface
interface MyRunnable1{

	public void run();
}


main(){
MyRunnable obj = ()->sout("done")
Thread t= new Thread(obj)

Thread t1= new Thread(obj)


}
```
// completablefuture java 8
// react
// hoisting
// hook

main(){
int[] arr = {1,2,3,4,5}; 4
               1 2 3 4

}


``` 
public int[] fun(int rotate, int[] arr){
int[] tmp = new int[arr.length];
if(rotate ==0)
return arr;
if(rotate>arr.length)
	rotate %= arr.length;
	
int j= 0;	
for(int i=rotate;i<arr.length;i++){
	tmp[i] = arr[j++];
}
//1  
    51234
    
//2 12345  // 4 //2
    45123 
    
//   i     1 2 
     j     0 1

for(int i=0;i<rotate;i++)
	tmp[i] = arr[j++];

return tmp;
}

```
