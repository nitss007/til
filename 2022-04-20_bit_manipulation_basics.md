## bit_manipulation_basics


There is no boolean operator counterpart to bitwise exclusive-or, but there is a simple explanation. The exclusive-or operation takes two inputs and returns a 1 if either one or the other of the inputs is a 1, but not if both are. That is, if both inputs are 1 or both inputs are 0, it returns 0. Bitwise exclusive-or, with the operator of a caret, ^, performs the exclusive-or operation on each pair of bits. Exclusive-or is commonly abbreviated XOR.

-Set union A | B
- Set intersection A & B
- Set subtraction A & ~B
- Set negation ALL_BITS ^ A or ~A
- Set bit A |= 1 << bit
- Clear bit A &= ~(1 << bit)
- Test bit (A & 1 << bit) != 0
- Extract last bit A&-A or A&~(A-1) or x^(x&(x-1))
- Remove last bit A&(A-1)
- Get all 1-bits ~0

problem : Without using airthmatic add two numbers

```
https://leetcode.com/problems/sum-of-two-integers



```


Below problem try to solve the case where we cannot use arthmatic operator
to divide two numbers

```

/**
 * https://leetcode.com/problems/divide-two-integers/
 * 
 * (a - b >= 0) The entire game is based on understanding the Circle for example
 * : -2147483648 cannot become positive by Maths.abs() but ..........+2147483648
 * -1=+2147483647 which is exactly wats happening when we're doing
 * -2147483648-1=+2147483647.
 * 
 * Math.abs(Integer.MIN_VALUE) would cause an overflow and would cause an issue.
 * Yes, you are right about the first part. It indeed causes an overflow, but
 * this overflow is quickly countered by the underflow.
 * 
 * Math.abs(Integer.MIN_VALUE) is still Integer.MIN_VALUE. Give this a thought.
 * When you covert it to positive value, it would overflow by one. Adding one to
 * Integer.MAX_VALUE would lead to Integer.MIN_VALUE;
 * 
 * And the critical trick here is you need to use a - b >= 0 as the condition. a
 * right now is still Integer.MIN_VALUE, b is a positive number larger than 1
 * (since we handled the case where b is 1 explicitly). Now Integer.MIN_VALUE
 * minus a positive value would cause underflow, which wraps back to the
 * Integer.MAX_VALUE.
 * 
 * In summary, when dividend is Integer.MIN_VALUE, a is the overflow outcome.
 * However, it is not a problem, since a-b underflows. The final result a-b is
 * just the expected result, despite we just had one overflow and underflow.
 * This a-b >= 0 trick is important. If you change the condition to a >= b,
 * which is logically equivalent, you will get the wrong output.
 * 
 * It's not a bug, it's a feature. :)
 * 
 * Calculate complexity for below solution A doubly nested for loop that looks
 * like the following would have a time complexity of O(n^2):
 * 
 * for(int i = 0; i < n; i++){ for(int j = 0; j < i; j++){ //... }
 * 
 * }
 * 
 * Similarly, the code I'm running is doing the following: Let's say a is 100, b
 * is 2,4,8,16,32,64, stopping before 100. while( a - (b << 1 << x) >= 0){ x++;
 * } In our code, b is like the j pointer, a is like the i pointer. Then a is
 * decremented because of this line a -= b << x; so a would be readjusted to 36
 * ( 100 - 64 ). b starts again from 2. So b loops from 2,4,8,16,32, stopping
 * before 36.
 * 
 * So you can deduce by analogy the n^2 where n would be dividend. The reason
 * log comes into this is because we are squaring b at each step. The log is a
 * logarithm of base 2.
 * 
 * @author nisharma
 *
 */
public class DivideOverFlow {
	public int divide(int dividend, int divisor) {
		int count = 0;
		if (dividend == 1 << 31 && divisor == -1)
			return (1 << 31) - 1;
		int a = Math.abs(dividend);
		int b = Math.abs(divisor);
		int res = 0;
		for (int x = 31; x >= 0; x--) {
			if ((a >>> x) - b >= 0) {
				res += 1 << x;
				a -= b << x;
			}

		}
		return dividend > 0 == divisor > 0 ? res : -res;
	}

	public static void main(String[] args) {
		new DivideOverFlow().divide(-2147483648, -1);
	}
```



