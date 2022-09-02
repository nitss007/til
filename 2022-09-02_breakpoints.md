## breakpoints

 Breakpoints
Have you ever asked yourself how breakpoints work? If the answer is yes - you are in the right place. Generally, they are two types of breakpoints: “Software Breakpoints” and “Hardware Breakpoints”. But before we dive into both of them there are still some assumptions you should be aware of. 

First, the compiler we are using needs to include information inside the executable in order for the debugger to match between the source code and the code in the executable. However, in case we don’t have the code or we are using a breakpoint based on a specific memory address it is not needed.

Second, the compiler should not optimize the code in a manner that it’s almost impossible to match between source code and code inside the executable (unless for the same reason as above). We can ensure that by debugging without using any optimizations or with selected ones only. 

In the case of “Hardware Breakpoints” there is a need for CPU support. What most CPUs (which support this type of breakpoint) support is to define an address which we want the CPU to breakpoint on. What the CPU does is to compare the program counter (PC) to the given address in case of a match the CPU will break the execution. Due to the need of hardware support this type of breakpoints are always limited. For example in the case of x68 architecture there are 6 debug registers (4 for address to break on, 1 debug control and 1 debug status) - for more information you can read - https://bit.ly/3RtR6sL. Also, here you can read an example about hardware breakpoints in ARM -https://bit.ly/3KEC9lu.

On the other end, “Software Breakpoints” there is no need for specific hardware (such as debug registers). In this case the debugger just modifies the original binary loaded into memory. So, setting a “Software Breakpoint” is replacing the instruction we want to break on with a “special instruction” that will let the debugger know we got into a breakpoint. Due to the fact the debugged point can be a different process than the debugger the common implementation is that the “special instruction” will trigger an interrupt/exception that the debugger can catch. Don’t forget the code is marked mostly as read and execute and not writable, so if we want to modify something we need some kind of support  (it can be done by the OS, without support it can’t work - I promise to detail it in a future post).  In x86 the “CC” is the “special instruction”(1 byte long) which causes “Interrupt 3” (we can also use “int 0x3” in two bytes for it). Under ARM we can use something like the “BKPT” instruction (https://bit.ly/3TAK5s2). Also, the debugger needs to remember what series of byte/bytes it replaced with the “magic instruction” in order to show that as part of the code to the user.  

In the image below there is a demonstration of the flow that happens in case of a “Software Breakpoint”.

