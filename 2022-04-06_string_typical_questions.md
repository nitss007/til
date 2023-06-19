## string_typical_questions




/**
 * https://leetcode.com/contest/biweekly-contest-75/problems/number-of-ways-to-select-buildings/
 * 
 * https://leetcode.com/problems/number-of-ways-to-select-buildings/submissions/
 * 
 * You are given a 0-indexed binary string s which represents the types of
 * buildings along a street where:
 * 
 * s[i] = '0' denotes that the ith building is an office and s[i] = '1' denotes
 * that the ith building is a restaurant. As a city official, you would like to
 * select 3 buildings for random inspection. However, to ensure variety, no two
 * consecutive buildings out of the selected buildings can be of the same type.
 * 
 * For example, given s = "001101", we cannot select the 1st, 3rd, and 5th
 * buildings as that would form "011" which is not allowed due to having two
 * consecutive buildings of the same type. Return the number of valid ways to
 * select 3 buildings.
 * 
 * @author nisharma
 *
 */


i```
public class NWays2SelectBuilding {
	public static void main(String[] args) {
		System.out.println(numberOfWays("001101"));
	}

	public static int numberOfWaysBetter(String s) {

		long _ = 0, _0 = 0, _1 = 0, _01 = 0, _10 = 0, _010 = 0, _101 = 0;
		for (char c : s.toCharArray())
			if (c == '0') {
				_010 += _01;
				_10 += _1;
				_0 += 1;
			} else {
				_101 += _10;
				_01 += _0;
				_1 += 1;
			}

		return (int) (_101 + _010);
	}

	public static long numberOfWays(String s) {
		int zeroCount = 0, oneCount = 0;
		for (char c : s.toCharArray())
			if (c == '0')
				zeroCount++;
		oneCount = s.length() - zeroCount;

		int firstOne = s.charAt(0) == '1' ? 1 : 0;
		int firstZero = s.charAt(0) == '0' ? 1 : 0;
		long count = 0;
		for (int i = 1; i < s.length(); i++) {
			if (s.charAt(i) == '0') {
				count += firstOne * (oneCount - firstOne);
				firstZero++;
			} else {
				count += firstZero * (zeroCount - firstZero);
				firstOne++;
			}
		}
		return count;

	}

	public static int numberOfWaysBrute(String s) {
		int counter = 0, start = 0;
		int j = start + 1;
		while (start < s.length()) {

			j = start + 1;
			while (j < s.length()) {
				while (j < s.length() && (s.charAt(start) ^ s.charAt(j)) == 0) {
					j++;
				}
				int k = j + 1;

				while (k < s.length()) {
					while (k < s.length() && (s.charAt(k) ^ s.charAt(j)) == 0)
						k++;
					if (k < s.length() && (s.charAt(k) ^ s.charAt(j)) == 1)
						counter++;
					k++;
				}

				j++;
			}

			start++;

		}
		return counter;

	}
}
```
