## Programs for competitive programming


import java.util.Arrays;
import java.util.HashMap;
import java.util.Map;

class Test2 {
    public int shipWithinDays(int[] weights, int days) {
        int max = 0,sum=0, mid;
        for(int i=0;i<weights.length;i++){
            if(max<weights[i])
                max = weights[i];
            sum+=weights[i];
        }
        while(max < sum){
            mid = ((sum+max)/2);
            if(isValid(weights,mid,days))
            {
                sum = mid;

            }
            else{
                max = mid+1;
            }
        }
        return max;
    }
    public boolean isValid(int[] weights, int sum, int days){
        int d =1, s=0;
        for(int i=0;i<weights.length;i++){
            s+=weights[i];
            if(s>sum){
                d +=1;
                s = weights[i];
            }
            if(d>days) return false;
        }
        return true;
    }
    public int minDays(int[] bloomDay, int m, int k) {
        int left=Integer.MAX_VALUE, right=0;
        if(m*k>bloomDay.length) return -1;
        for(int i:bloomDay){
            right = Math.max(right,i);
            left = Math.min(left,i);

        }

        while(left<right){
            int count=0, item=0, mid = (left +right)/2;
            for(int i:bloomDay){
                if(i>mid){
                    count = 0;
                }else if(++count>=k)
                    {
                        count = 0;
                        item++;
                    }
            }
            if(item<m)
                left = mid+1;
            else right = mid;

        }
        return left;
    }

    public int smallestDivisor(int[] A, int threshold) {
        int left = 1, right = 0;

        for(int i=0;i<A.length;i++)
            right+=A[i];
        while (left < right) {
            int m = (left + right) / 2, sum = 0;
            for (int i : A)
                sum += (i + m - 1) / m;
            if (sum > threshold)
                left = m + 1;
            else
                right = m;
        }
        return left;

    }
    public int findKthNumber(int m, int n, int k) {
        int left = 1, right=m*n;

        while(left<right){
            int count = 0, mid = left +(right-left)/2;
            // for(int i=1;i<=m;i++){
            //     int v = mid/i;
            //     int temp =v>n?n:v;
            //     if(temp ==0) break;
            //     count+=temp;
            // }
            count = countOfNumbersTillMid(mid,m,n);
            if(count>=k){
                right = mid;
            }else{
                left = mid+1;
            }
        }
        return left;
    }

    public static int countOfNumbersTillMid(int x, int m, int n) {
        int count = 0;
        int i = m;
        int j = 1;
        while (i >= 1 && j <= n)         // i goes from m to 1, j goes from 1 to n
        {
            if (i*j <= x)
            {
                count += i;
                j++;
            }
            else
                i--;
        }
        return count;
    }
    public int smallestDistancePair(int[] nums, int k) {

        Arrays.sort(nums);
        int left = 0, right = nums[nums.length-1]-nums[0];
        while (left < right) {
            int distance = (left + right) / 2, need = 1, cur = 0;

            int count = 0, r=1;
            for(int l=0;l<nums.length;l++){
                while(r < nums.length && nums[r]-nums[l] <= distance) r++;
                count+=r-l-1;
            }


            if (count < k) left = distance + 1;
            else right = distance;

        }
        return left;

    }

    public String fractionToDecimal(int numerator, int denominator) {
        double n = numerator;
        double d = denominator;
        double temp = n/d;
        String temp1 = ""+temp;
        int tempInt = (int)temp;
        boolean flag = false;
        int count = 0;
        if(temp1.length()>10){
            temp1 = temp1.substring(2);
            Map<Character,Integer> charFrequency = new HashMap<>();
            for (char ch : temp1.toCharArray())
                charFrequency.put(ch, charFrequency.getOrDefault(ch, 0) + 1);
            int prev = -1;
            for(int i:charFrequency.values()){
                if(prev == -1) {
                    prev = i;
                    count++;
                    continue;
                }
                if(prev == i) {
                    count++;
                    continue;
                }
                flag = true;
                break;
            }
            if(!flag){
                double temp2 = temp*Math.pow(10,count);
                double diff = (int) temp2;
                StringBuilder st = new StringBuilder()   ;
                diff = diff/Math.pow(10,count);
                st.append(""+diff);
                st.insert(2,"(",0,1);
                st.insert(3+count,")",0,1);
                return st.toString();
            }

        }
        else if((temp - (double) tempInt) ==0)
            return ""+tempInt;

        return ""+temp;
    }
    public static void main(String[] args) {
        int[] weights = {3,2,2,4,1,4};
        int[] bloom = {1,10,3,10,2};
        int[] blAoom = {1,2,5,9};
        int[] smallDistance = {1,2,3,3,4,5,5,7};
//        new Test2().shipWithinDays(weights, 3);
//        System.out.println(new Test2().minDays(bloom, 3, 1));
//        System.out.println(new Test2().smallestDivisor(blAoom, 5));
//        System.out.println(new Test2().smallestDistancePair(smallDistance, 15));
        System.out.println(new Test2().fractionToDecimal(2,3));
    }
}



************************************************************************
************************************************************************
************************************************************************




import java.io.*;
import java.math.*;
import java.security.*;
import java.text.*;
import java.util.*;
import java.util.concurrent.*;
import java.util.regex.*;



class Result {

    /*
     * Complete the 'weightCapacity' function below.
     *
     * The function is expected to return an INTEGER.
     * The function accepts following parameters:
     *  1. INTEGER_ARRAY weights
     *  2. INTEGER maxCapacity
     */

    public static int weightCapacity(List<Integer> weights, int maxCapacity) {
        // Write your code here\
        int count = 0, sum = 0;

        for (Integer i : weights) {
            if (i == maxCapacity)
                return i;

        }

        Collections.sort(weights);
        int maxWeight = 0;
        for(int j=weights.size()-1; j>=0; j--){
            int last = weights.get(j);
            if( last > maxCapacity) continue;
              sum =  last;
            for(int k=0;k<weights.size();k++){
                sum+=weights.get(k) ;
                if(sum > maxCapacity){
                    if(maxWeight < sum - weights.get(k))
                        maxWeight = sum - weights.get(k);
                    continue;
                }


            }
        }

     return maxWeight;
    }


}

public class Test {
    public static void main(String[] args) throws IOException {
        BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(System.in));
        BufferedWriter bufferedWriter = new BufferedWriter(new FileWriter(System.getenv("OUTPUT_PATH")));

        int weightsCount = Integer.parseInt(bufferedReader.readLine().trim());

        List<Integer> weights = new ArrayList<>();

        for (int i = 0; i < weightsCount; i++) {
            int weightsItem = Integer.parseInt(bufferedReader.readLine().trim());
            weights.add(weightsItem);
        }

        int maxCapacity = Integer.parseInt(bufferedReader.readLine().trim());

        int result = Result.weightCapacity(weights, maxCapacity);

        bufferedWriter.write(String.valueOf(result));
        bufferedWriter.newLine();

        bufferedReader.close();
        bufferedWriter.close();
    }
}



************************************************************************
************************************************************************
************************************************************************


import java.io.*;
import java.math.*;
import java.security.*;
import java.text.*;
import java.util.*;
import java.util.concurrent.*;
import java.util.regex.*;



class Result {

    /*
     * Complete the 'weightCapacity' function below.
     *
     * The function is expected to return an INTEGER.
     * The function accepts following parameters:
     *  1. INTEGER_ARRAY weights
     *  2. INTEGER maxCapacity
     */

    public static int weightCapacity(List<Integer> weights, int maxCapacity) {
        // Write your code here\
        int count = 0, sum = 0;

        for (Integer i : weights) {
            if (i == maxCapacity)
                return i;

        }

        Collections.sort(weights);
        int maxWeight = 0;
        for(int j=weights.size()-1; j>=0; j--){
            int last = weights.get(j);
            if( last > maxCapacity) continue;
              sum =  last;
            for(int k=0;k<weights.size();k++){
                sum+=weights.get(k) ;
                if(sum > maxCapacity){
                    if(maxWeight < sum - weights.get(k))
                        maxWeight = sum - weights.get(k);
                    continue;
                }


            }
        }

     return maxWeight;
    }


}

public class Test {
    public static void main(String[] args) throws IOException {
        BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(System.in));
        BufferedWriter bufferedWriter = new BufferedWriter(new FileWriter(System.getenv("OUTPUT_PATH")));

        int weightsCount = Integer.parseInt(bufferedReader.readLine().trim());

        List<Integer> weights = new ArrayList<>();

        for (int i = 0; i < weightsCount; i++) {
            int weightsItem = Integer.parseInt(bufferedReader.readLine().trim());
            weights.add(weightsItem);
        }

        int maxCapacity = Integer.parseInt(bufferedReader.readLine().trim());

        int result = Result.weightCapacity(weights, maxCapacity);

        bufferedWriter.write(String.valueOf(result));
        bufferedWriter.newLine();

        bufferedReader.close();
        bufferedWriter.close();
    }
}

