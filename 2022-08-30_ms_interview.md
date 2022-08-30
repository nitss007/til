## ms_interview

minimum word distance from source word to target word through a given disctionary

/**
 ball -> fall, hall
 fall -> fell
 fell -> hell
 hell - help
 help ->


 */



```
import java.util.*;

// you can also use imports, for example:
// import java.util.*;

public class Test11 {

    public static void main(String [] args) {


        String[] words = {"fell", "bale", "bald", "hall", "hell", "help", "hemp"};
        String startWord = "fall", targetWord = "fell";
        Map<String, List<String>> wordMap = new HashMap<>();


        List<String> unitDistanceWords = new ArrayList<>();
        for(int j=0;j<words.length;j++){
            int distance = findWordDistance(startWord, words[j]);
            if(distance>1)
                continue;
            unitDistanceWords.add(words[j]);
        }
        wordMap.put(startWord, unitDistanceWords);
        List<String> unitDistanceWord;
        for(int i=0;i<words.length;i++){
            unitDistanceWord = new ArrayList<>();

            for(int j=0;j<words.length && words[j]!= words[i] ;j++){
                int distance = findWordDistance(words[i], words[j]);
                if(distance>1)
                    continue;
                unitDistanceWord.add(words[j]);
            }
            wordMap.put(words[i], unitDistanceWord);
        }

        Set<String> visited = new HashSet<>();
        // visited.add(startWord)
        System.out.print(dfs(startWord, targetWord, wordMap, visited));

    }
    static int min = Integer.MAX_VALUE-1;
    static int result = Integer.MAX_VALUE-1;
    public static int dfs(String source, String target, Map<String, List<String>> wordMap, Set<String> visited)
    {
        if(source.equals(target))
            return 0;

        if(visited.contains(source))
            return min;
        visited.add(source);
        List<String> words = wordMap.get(source);
        int jump =0;
        for(String word:words){

            jump = dfs(word, target, wordMap, visited)+1;
            min = Math.min(min, jump);
        }
        result = Math.min(min, result);
        visited.remove(source);
        return min;
    }
    public static int findWordDistance(String target, String source){
        int count = 0;
        char[] c = source.toCharArray();
        char[] t = target.toCharArray();
        for(int i=0;i<target.length();i++){

                if(c[i]!=t[i])
                    count++;
                if(count>1)
                    return Integer.MAX_VALUE;

        }
        return count;
    }

}
```


/**
     * Given a string, partition the string into palindromes
 * "dbaa"
 *
 * d baa --> b aa -> b a a  1
 *                -> b aa  1
 *          ba a  -> 0
 * db aa
 * dbbb
 * d bbb d b bb  -> d b b b
 *         -> d b bb
 *       d bb b
 *       d bbb
 */


```

import java.util.*;
public class Test12 {
    public static void main(String[] args) {
        String input = "dbaa";

        pPartition(input.toCharArray(), 0, input.length()-1, new HashMap<String, String>);

        for(List<String> set:result){
            System.out.println(set);
        }

    }
    static Set<List<String>> result = new HashSet<>();

    /**
     * d,b , aa
     * a a
     *
     * d ba a -> d b a a
     *
     * Map< start +end , String> dp = new HashMap<>();
     *
     */
    public static boolean pPartition(char[] input, int start, int end, Map<String, List<String>> cache ){
        if(start>=end)
            return true;

        if(isPalindrome(input, start, end)) {
            cache.put(""+start + ""+end,cache.getOrDefault(input, new ArrayList<>()).add(input));

        }


        // a | a a a a a
        for(int i=start;i<=end;i++){

            boolean isPalindrome = pPartition(input, start, i, cache) && pPartition(input, i+1, end, cache) ;

            if(isPalindrome) {
                if(start == 0 && end == input.length) {
                    result.add(cache.get(""+start + ""+end));
                    cache.clear();
                }else
                    return true;
            }
        }
        return  false;
    }

    public static boolean isPalindrome(char[] input,int  start,int end){
        int x = start;
        for(int i=end;i>=start;i--){
            if(input[x++] != input[i])
                return false;
        }
        return  true;
    }

}
```
