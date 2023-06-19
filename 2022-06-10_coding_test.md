## zolando


abbabba : print size of maximun proper common prefix and suffix
prefix abba
suffix abba

class Solution {
    public int solution(String S) {
        // write your code in Java SE 8
        char[] arr = S.toCharArray();
        int count =0, pMax = 0;
        for(int i=0;i<arr.length && i<=arr.length-1-i;i++){
            
            if(arr[i] == arr[arr.length-1-i])
                count+=1;
            else 
                break;
            if(arr[arr.length-1-i] == arr[0])
                pMax = count;

        }


        return pMax;
    }
}




2. 

A2Le = 2pL1 ommited can be replaced as ? and then as 1 or ?? as 2

// you can also use imports, for example:
// import java.util.*;

// you can write to stdout for debugging purposes, e.g.
// System.out.println("this is a debug message");

class Solution {
    public boolean solution(String S, String T) {
        // write your code in Java SE 8
        int slen = S.length(), tlen = T.length();
        if( slen==0 && tlen == 0)
            return true;
        else if(slen ==0 && tlen>0 || slen >0 && tlen==0)
            return false;

        StringBuilder source = new StringBuilder();
        StringBuilder target = new StringBuilder();
        for(char c:S.toCharArray()){
            if(!Character.isAlphabetic(c))
                source.append('?');
            else     
                source.append(c);
        }

        for(char c:T.toCharArray()){
            if(!Character.isAlphabetic(c))
                target.append('?');
            else     
                target.append(c);            
        }
        slen = source.length() ;
        if(slen != target.length())
            return false;
        for(int i=0;i<slen;i++){
            if(source.charAt(i) == '?' || target.charAt(i) == '?' || source.charAt(i) == target.charAt(i))
                continue;
            else return false;
        }


        return true;
    }
}

3. smallest number

class Solution {
    int solution(int[] A) {
        int ans = Integer.MAX_VALUE;
        for (int i = 1; i < A.length; i++) {
            if (ans > A[i]) {
                ans = A[i];
            }
        }
        return ans;
    }
}


