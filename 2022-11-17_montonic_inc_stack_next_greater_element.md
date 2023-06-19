## montonic_inc_stack_Next_Greater_Element

https://leetcode.com/problems/next-greater-element-i/submissions/

The next greater element of some element x in an array is the first greater element that is to the right of x in the same array.

You are given two distinct 0-indexed integer arrays nums1 and nums2, where nums1 is a subset of nums2.

For each 0 <= i < nums1.length, find the index j such that nums1[i] == nums2[j] and determine the next greater element of nums2[j] in nums2. If there is no next greater element, then the answer for this query is -1.

Return an array ans of length nums1.length such that ans[i] is the next greater element as described above.

 

Example 1:

Input: nums1 = [4,1,2], nums2 = [1,3,4,2]
Output: [-1,3,-1]
Explanation: The next greater element for each value of nums1 is as follows:
- 4 is underlined in nums2 = [1,3,4,2]. There is no next greater element, so the answer is -1.
- 1 is underlined in nums2 = [1,3,4,2]. The next greater element is 3.
- 2 is underlined in nums2 = [1,3,4,2]. There is no next greater element, so the answer is -1.

## Solution


n this approach, we make use of pre-processing first so as to make the results easily available later on. We make use of a stack (stackstackstack) and a hashmap (mapmapmap). mapmapmap is used to store the result for every posssible number in nums2nums2nums2 in the form of (element,next_greater_element)(element, next\_greater\_element)(element,next_greater_element). Now, we will look at how to make entries in mapmapmap.

We iterate over the nums2nums2nums2 array from the left to right. We push every element nums2[i]nums2[i]nums2[i] on the stack if it is less than the previous element on the top of the stack (stack[top]stack[top]stack[top]). No entry is made in mapmapmap for such nums2[i]nums2[i]nums2[i]'s right now. This happens because the nums2[i]nums2[i]nums2[i]'s encountered so far are coming in a descending order.

If we encounter an element nums2[i]nums2[i]nums2[i] such that nums2[i]nums2[i]nums2[i] > stack[top]stack[top]stack[top], we keep on popping all the elements from stack[top]stack[top]stack[top] until we encounter stack[k]stack[k]stack[k] such that stack[k]stack[k]stack[k] ≥ nums2[i]nums2[i]nums2[i]. For every element popped out of the stack stack[j]stack[j]stack[j], we put the popped element along with its next greater number (result) into the hashmap mapmapmap, in the form (stack[j],nums2[i])(stack[j], nums2[i])(stack[j],nums2[i]). Now, the next greater element for all elements stack[j]stack[j]stack[j], such that kkk < jjj ≤ toptoptop is nums2[i]nums2[i]nums2[i] (since this larger element caused all the stack[j]stack[j]stack[j]'s to be popped out). We stop popping the elements at stack[k]stack[k]stack[k] because this nums2[i]nums2[i]nums2[i] can't act as the next greater element for the next elements on the stack.

Thus, an element is popped out of the stack whenever a next greater element is found for it. Therefore, the elements remaining in the stack are the ones for which no next greater element exists in the nums2nums2nums2 array. Thus, at the end of the iteration over nums2nums2nums2, we pop the remaining elements from the stackstackstack and put their entries in hashhashhash with a -1\text{-1}-1 as their corresponding results.

Then, we can simply iterate over the nums1nums1nums1 array to find the corresponding results from mapmapmap directly.




```
class Solution {
    public int[] nextGreaterElement(int[] nums1, int[] nums2) {
        int[] res = new int[nums1.length];
        int j;
        Arrays.fill(res, -1);
        Map<Integer, Integer> map = new HashMap<>();

        Stack<Integer> stack = new Stack<>();

        for(int i=0;i<nums2.length;i++){
            while(!stack.isEmpty() && nums2[i]>stack.peek()){
                map.put(stack.pop(), nums2[i]);
            }
            stack.push(nums2[i]);
        }
        for(int i=0;i<nums1.length;i++){
            if(map.containsKey(nums1[i]))
                res[i] = map.get(nums1[i]);
        }
        return res;
    }
    //  public int[] nextGreaterElement(int[] nums1, int[] nums2) {
    //     int[] res = new int[nums1.length];
    //     int j;

    //     Arrays.fill(res, -1);

    //     Map<Integer, Integer> map = new HashMap<>();
    //     for(int i=0;i<nums2.length;i++)
    //         map.put(nums2[i],i);

    //     for (int i = 0; i < nums1.length; i++) {
    //         if(!map.containsKey(nums1[i]))
    //             continue;
    //         for (j = map.get(nums1[i]); j < nums2.length; j++) {
    //             if (nums2[j] > nums1[i]) {
    //                 res[i] = nums2[j];
    //                 break;
    //             }
    
    //         }
    //     }
    
    //     return res;
    // }
}```

