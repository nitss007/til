## Dynamic_Programming

T(i,j) = max (T(i+1,j)[1]+ V[0]
              T(i+1,j)[0]+ V[1] ) 

class Solution {
    public boolean PredictTheWinner(int[] nums) {
        return PredictTheWin(nums, 0, nums.length-1, 1) >=0;

    }
    public int PredictTheWin(int[] nums, int start, int end, int turn) {
        if(start == end) 
            return turn * nums[start];
        int a = turn*nums[start] + PredictTheWin(nums, start+1,end,(-1)*turn);
        int b = turn*nums[end] + PredictTheWin(nums, start,end-1,(-1)*turn);
        return turn * Math.max(turn*a,turn*b);
        
    }
}








Given an array arr[] of N non-negative integers representing the height of blocks. If width of each block is 1, compute how much water can be trapped between the blocks during the rainy season. 
 

Example 1:

Input:
N = 6
arr[] = {3,0,0,2,0,4}
Output:
10
Explanation





class Solution{
    
    // arr: input array
    // n: size of array
    // Function to find the trapped water between the blocks.
    static long trappingWater(int arr[], int n) { 
 
      int start =0 , end = n-1, maxLeft=0,maxRight=0;
      long sum = 0;
      while(start<end){
          if(arr[start]<arr[end]){
              if(arr[start]>maxLeft){
                  maxLeft = arr[start];
              }
              sum +=maxLeft-arr[start++];
              
          }else{
              if(arr[end]>maxRight){
                  maxRight = arr[end];
              }
              sum +=maxRight-arr[end--];
              
          }
      }
      return sum;
    } 
}
