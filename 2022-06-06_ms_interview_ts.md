## MS_Interview_TS

1. ques on Consistent Hashing
2. ques on Partitioning
3. ques on parallel db commit  (raising)

coding:
FInd first patient, given a list of relations via list.

```
import java.util.*;

/**
 *
 *     1                          -> 1->2  1->3  , 1->5
 *   2     3     -> 2,3           ->  2->4 2->5 3->6
 *
 *                                         1->3->6
 * 4   5      6                             1->  2->5,4
 *
 *
 * @author nisharma
 */

class Pair{
    int x;
    int  y;
    public Pair(int x, int y){
        this.x = x;
        this.y = y;
    }
}
public class Test2 {


    public static  int getFirstPatient(List<Pair> containList){
        List<Integer> parentList = new ArrayList<>();
        List<Integer> childList = new ArrayList<>();

        for(Pair p: containList){
            if(!parentList.contains(p.x)) {
                if (!childList.contains(p.x)) {
                    parentList.add((p.x));
                    if (!childList.contains(p.y))
                        childList.add((p.y));
                    if (parentList.contains(p.y))
                        parentList.remove(parentList.indexOf(p.y));
                }
            }else{
                if (!childList.contains(p.y))
                    childList.add((p.y));
            }
        }
        if (parentList.size() ==0)
            return  -1;
        return  parentList.size()>1?-1:parentList.get(0);
    }

    public static void main(String[] args) {
        Pair p1 = new Pair(1,2);
        Pair p2 = new Pair(1,3);
        Pair p3 = new Pair(2,3);
        Pair p4 = new Pair(3,4);
        Pair p5 = new Pair(0,1);
        Pair p6 = new Pair(9,0);

        List<Pair> ap = new ArrayList<>();
        ap.add(p1);
        ap.add(p2);
        ap.add(p3);
        ap.add(p4);
        ap.add(p5);
        ap.add(p6);
        System.out.println(getFirstPatient(ap));

    }
}
```

