## cyclic_sort_pattern


Pattern name: Cyclic Sort
Identification: given array of 0 to N, do some missing, repeated kind of operation
PigeonHole principle: If you have N boxes and >N items, atleast one box has more than 1 item.

    https://leetcode.com/problems/missing-number/
    Given an array nums containing n distinct numbers in the range [0, n], return the only number in the range that is missing from the array.

observation 1: among N+1 numbers we have only N boxes.
observation 2: for every number "i", correct index is "i"

so if array was sorted, we will just travel the array and the first number which doesn't match it's index would be answer.
Sorting part is where cycle sort comes in.
```
    int missingNumber(vector<int>& nums) {
        int i=0;
        int n = nums.size();
        while(i<n)
        {
			int correctIdx = nums[i]; //where this element should be in sorted array
            if(correctIdx<n && correctIdx != i) //if not already at correct position and correct position < n
            {
                swap(nums[i],nums[correctIdx]); //put current element at correct position
            } 
			else
				i++; // move to next index
        }
        for(int i=0;i<n; i++)
            if(nums[i]!=i)
                return i;
        return n;
    }
```
    https://leetcode.com/problems/find-all-duplicates-in-an-array/
    Given an integer array nums of length n where all the integers of nums are in the range [1, n] and each integer appears once or twice, return an array of all the integers that appears twice.
    You must write an algorithm that runs in O(n) time and uses only constant extra space.

observation 1: [1,n] integers and some appear twice, we can't put two elements in same box.
observation 2: for every element, correctIdx = nums[i] - 1 because instead of [0,n] we have [1,n] numbers
```
vector<int> findDuplicates(vector<int>& nums) {
        vector<int> ans;
        int i = 0;
        int n = nums.size();
        while(i<n)
        {
            int correct = nums[i]-1;
            if(nums[i] != nums[correct])
                swap(nums[i],nums[correct]);
            else
                i++;
        }
        for(int i=0; i<n; i++)
            if(nums[i] != i+1)
                ans.push_back(nums[i]);
        return ans;
    }
```
    https://leetcode.com/problems/find-all-numbers-disappeared-in-an-array/
    Given an array nums of n integers where nums[i] is in the range [1, n], return an array of all the integers in the range [1, n] that do not appear in nums.

observation 1: [1,n] integers and some appear twice, we can't put two elements in same box.
observation 2: for every element, correctIdx = nums[i] - 1 because instead of [0,n] we have [1,n] numbers
```
class Solution {
public:
    vector<int> findDisappearedNumbers(vector<int>& nums) {
        vector<int> ans;
        int n = nums.size();
        int i=0;
        while(i<n)
        {
            if(nums[nums[i]-1] != nums[i])
            {
                swap(nums[i],nums[nums[i]-1]);
            }
            else
                i++;
        }
        for(int i=0; i<n; i++)
            if(nums[i] != i+1)
                ans.push_back(i+1);
        return ans;
    }
};
```
    https://leetcode.com/problems/first-missing-positive/ (LC hard)
    Given an unsorted integer array nums, return the smallest missing positive integer.
    You must implement an algorithm that runs in O(n) time and uses constant extra space.
    N = nums.size()
    observation 1: in N size array, we can maximum have first N positive integers in box because we can't put two elements in same box.
    observation 2: if we sort the array, then at whichever index nums[i] != i+1, that will be first missing positive
    observation 1: we don't need to sort every element, we just need to sort elements from [1,N] so they are in right place, we don''t need to check further.
```
class Solution {
public:
    int firstMissingPositive(vector<int>& nums) {
        int n = nums.size();
        for(int i=0; i<n; i++)
        {
			long long correctIdx = (long long)nums[i]-1; //long long because if nums[i] = INT_MIN, then out of bound
            while(correctIdx>=0 && correctIdx<n && nums[correctIdx]!=nums[i]) 
            {
                swap(nums[i],nums[correctIdx]);
                correctIdx = (long long)nums[i]-1;
            }
        }
        for(int i=0; i<n; i++)
        {
            if(nums[i]!=i+1)
                return i+1;
        }
        return n+1;
    }
};

```
here while loop will run for maximum N types, because N elements can have only N poistions to swap

That's all for this pattern, Hope it helps!

related questions:
https://leetcode.com/problems/set-mismatch/
https://leetcode.com/problems/couples-holding-hands/
will add more later.

