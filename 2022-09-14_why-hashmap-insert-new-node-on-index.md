## Why HashMap insert new Node on index (n - 1) & hash?


 If n is power of 2, n-1 will be of the format 0111....1 which would make x & (n-1) equivalent to x%n.

A good description by harold but I feel it is inadequate without an example. So heres one -

Whenever a new Hasmap is created the array size of internal Node[] table is always power of 2 and following method guarantees it -

static final int tableSizeFor(int cap) {
    int n = cap - 1;
    n |= n >>> 1;
    n |= n >>> 2;
    n |= n >>> 4;
    n |= n >>> 8;
    n |= n >>> 16;
    return (n < 0) ? 1 : (n >= MAXIMUM_CAPACITY) ? MAXIMUM_CAPACITY : n + 1;
}

So lets say you provide initial capacity as 5

cap = 5
n = cap - 1 =  4 = 0 1 0 0
n |= n >>> 1;    0 1 0 0 | 0 0 1 0 = 0 1 1 0 = 6
n |= n >>> 2;    0 0 1 1 | 0 1 1 0 = 0 1 1 1 = 7
n |= n >>> 4;    0 0 0 0 | 0 1 1 1 = 0 1 1 1 = 7
n |= n >>> 8;    0 0 0 0 | 0 1 1 1 = 0 1 1 1 = 7
n |= n >>> 16;   0 0 0 0 | 0 1 1 1 = 0 1 1 1 = 7
return n + 1     7 + 1 = 8 

So table size is 8 = 2^3

Now possible index values you can put your element in map are 0-7 since table size is 8. Now lets look at put method. It looks for bucket index as follows -

Node<K,V> p =  tab[i = (n - 1) & hash];

where n is the array size. So n = 8. It is same as saying

Node<K,V> p =  tab[i = hash % n];

So all we need to see now is how

hash % n == (n - 1) & hash

Lets again take an example. Lets say hash of a value is 10.

hash = 10
hash % n = 10 % 8 = 2
(n - 1) & hash = 7 & 10 = 0 1 1 1 & 1 0 1 0 = 0 0 1 0 = 2


