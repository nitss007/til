# [**T**oday **I** **L**earned](https://mihaeu.github.io/til) 🤯

*(For usage refer to [USAGE.md](USAGE.md))*

## Multi-Project with Gradle

Gradle supports including other projects as dependencies. A good example for this can be found [here](https://github.com/pkainulainen/gradle-examples/tree/master/multi-project-build) as explained in the [blog post](http://www.petrikainulainen.net/programming/gradle/getting-started-with-gradle-creating-a-multi-project-build/).

The author summarises the three msot important things as:

 > - A multi-project build must have the settings.gradle file in the root directory of the root project because it specifies the projects that are included in the multi-project build.
 > - If we have to add common configuration or behavior to all projects of our multi-project build, we should add this configuration (use allprojects) to the build.gradle file of our root project.
 > - If we have to add common configuration or behavior to the subprojects of our root project, we should add this configuration (use subprojects) to the build.gradle file of our root project.

I ended up using this approach for a game I'm developing. The core module is one project and all the frontends are other projects.
## Partial Add with Git

Using `git add -p` you can interactively choose which parts of your work you want to add/stage. This even allows you to add different parts of a file, while leaving out others.

Source: https://www.youtube.com/watch?v=duqBHik7nRo
## Copy paste for files in linux

`xclip` is an awesome tool which can be used to pipe output to the clipboard. Use `-selection c` so that you can paste using `Ctrl` + `V`.

```bash
# example
xclip -selection c ~/somefile.txt
```
## `forceCoversAnnotation` in PHPUnit

Up until now I've always been using the `beStrictAboutCovers` in the `phpunit.xml` configuration file. Today I learned about the `forceCoversAnnotation` annotation.

The effect is similar: only the code specified by `@covers` will count towards the total code coverage. With `forceCoversAnnotation` however the `@uses` annotation is not required. I like `@uses` but if often clogs up a test class when using lots of small value objects.
## Screenkey for Live Coding

[screenkey](https://github.com/wavexx/screenkey) is a python app which shows key presses in an overlay on the screen. Nice for live coding to show off key combinations and shortcuts.

`--mods-only` shows only modifiers, because normal letters are probably not interesting and `--vis-shift` shows shift every time it is pressed.

No installation required, just start the app after cloning the repo `./screenkey --mods-only --vis-shift`
## Free HTTPS from Lets Encrypt

[Let's Encrypt](https://letsencrypt.org/) provides free certificates for everyone. 90 day renewal can be automated through cronjobs.

Explained by a developer: https://www.youtube.com/watch?v=zJ0JMl1B7yY
## Solve difficult merges with git-imerge

[git-imerge](https://github.com/mhagger/git-imerge) solves the problem of resolving many merge conflicts in large merge operations.

Video by the developer: http://www.youtube.com/watch?v=FMZ2_-Ny_zc
## bcat pipes cli output to the browser

I finally decided to find out how to pipe HTML straight to a browser without having to write it 
to a file and then open that file in the browser and then deleting the file etc.

The solution is a small ruby gem called [bcat](https://rtomayko.github.io/bcat/) and it's usage is 
just as you'd imagine (taken from the project's website):

```bash
# With build tools:

make test |bcat
rake test |bcat

# As a clipboard viewer:

pbpaste  |bcat   # macos
xclip -o |bcat   # X11

# For previewing HTML:

markdown README.md |bcat
redcloth README.textile |bcat
erb -T - template.erb |bcat
mustache < template.mustache |bcat
pygmentize -Ofull,style=colorful -f html main.c |bcat
```
## Additive and multiplicative complexity

B. Meyer makes an interesting point (among many from his book Agile! - The Good, the Hype, and the Ugly) about the different types of complexities in software projects. He compares the two types to pasta:

- Additive complexity is like lasagne. You just keep piling new parts on top of the existing parts and it works (this is, of course, an ideal for agile projects).
- Multiplicative complexity, however, is more like linguine (or spaghetti), meaning the parts are entangled and hard to separate. Projects which have lots of this types of complexities (which is more than one might think) require some upfront planning to reduce waste (which would be the result of treating these tasks in pure agile manner).## Native Watch Using `inotify-tools`

Don't bother installing node or ruby gems when you can simply run the following inline command on any UNIX system with inotify-tools installed:

```bash
# watch a single file for any type of changes and display on change
while inotifywait someText.txt; do cat someText.txt; done

# watch a folder for any type of change and run make if there is
while inotifywait -r src; do make; done
```

## Magic Variables in Bash

 - `$0` - `$99`
    x-th argument provided to the script/function. `$0` is always the script name even when accessed from within a function. `$1+` will work in functions.

 - `$?`
    Exit code of the last process.

 - `$_`
    Last argument.

 - `$!`
    PID of last process.

 - `$@`
    All arguments.

Note: Always quote variables to avoid word-splitting (except when using `[[` for tests). Run `shellcheck` to make sure.
## Test for Symlinks in Bash

Use `-L` instead of `-h` for compatibility.

```bash
if [[ -L /path/to/suspected_symlink ]]; then
  echo "is symlink"
else
  echo "no symlink"
fi  
```

## Bash Arrays

Declare a variable with `ARRAY=(one two three)` and reference it using `echo ${ARRAY[*]}` or `echo ${ARRAY[2]}` for a single element.

Note that brackets are not required in for statements: `for i in 1 2 3; do echo $i; done`

## Generate content for Postman requests

Postman provides dynamic variables which can be used to generate content for requests e.g.

```json
{
    "name": "Test Variant {{$randomInt}}",
    "id": "{{$guid}}"
}
```

See: https://learning.postman.com/docs/postman/variables-and-environments/variables-list/

## KDEWallet

By using `kwalletcli` you can poll for entries using e.g.

```bash
kwallet-query -l kdewallet -f Toolbox -r 'JetBrains Account OAuth'
```

## Use git for-each-ref instead of git branch

`git for-each-ref` is better suited for automated branch parsing than `git branch`.

Example usage which deletes branches which aren't on upstream:

```bash
git for-each-ref --shell --format='ref=%(refname:short); gone=%(if:equals=[gone])%(upstream:track)%(then)gone%(end); if [ "gone" = "$gone" ]; then echo "upstream for $ref is gone, will delete."; git branch -D "$ref"; else echo "will not delete $ref."; fi' 'refs/heads/**' | while read cmd; do eval "$cmd"; done
```

## Jira - Find Tickets you Commented On

```
issueFunction in commented("by currentUser()")
```

## Renew an expired PGP key

```bash
gpg --list-keys 2>/dev/null | grep <your_email> -C2
gpg --edit-key <the_key_id_you_want>

# interactive prompt starts
key 0 
# note you will not see a * next to the key, but unless there
# is an error the key is selected
expire
1y
key 1
expire
1y
# ... for all keys and subkeys
save

# publish the change
gpg --keyserver pgp.mit.edu --send-keys <the_key_id_you_want>
```

## Shortcut for KDE Window Settings

KDE special window settings can be accessed even without a titlebar by using the shortcut Alt + F3. From there you can set opacity, window size, borders etc.

## Show hardware configuration on Unix systems

`inxi` is a convenient tool to display system information in a readable well formatted way. Use the `-F` flag to display all information and optionally `-c 0` in order to turn off colors (because it looked weird on my terminal).

Example:

```bash
inxi -F -c 0
System:    Host: lin-haeuslmannm Kernel: 4.15.0-159-generic x86_64 bits: 64 Desktop: KDE Plasma 5.12.9
           Distro: Ubuntu 18.04.6 LTS
Machine:   Device: laptop System: Dell product: XPS 15 9560 serial: N/A
           Mobo: Dell model: 05FFDN v: A00 serial: N/A UEFI: Dell v: 1.23.1 date: 05/25/2021
Battery    BAT0: charge: 61.4 Wh 100.0% condition: 61.4/97.0 Wh (63%)
           hidpp__0: charge: N/A condition: NA/NA Wh
CPU:       Quad core Intel Core i7-7700HQ (-MT-MCP-) cache: 6144 KB
           clock speeds: max: 3800 MHz 1: 800 MHz 2: 800 MHz 3: 800 MHz 4: 800 MHz 5: 800 MHz 6: 800 MHz
           7: 800 MHz 8: 800 MHz
Graphics:  Card-1: Intel Device 591b
           Card-2: NVIDIA GP107M [GeForce GTX 1050 Mobile]
           Display Server: x11 (X.Org 1.19.6 ) driver: i915
           Resolution: 1920x1080@60.01hz, 1920x1080@60.00hz, 1920x1080@60.00hz
           OpenGL: renderer: Mesa DRI Intel HD Graphics 630 (KBL GT2) version: 4.6 Mesa 20.0.8
Audio:     Card-1 Intel CM238 HD Audio Controller driver: snd_hda_intel Sound: ALSA v: k4.15.0-159-generic
           Card-2 Asahi Kasei Microsystems AK5370 I/F A/D Converter driver: USB Audio
           Card-3 Logitech OrbiCam driver: USB Audio
           Card-4 Realtek driver: USB Audio
Network:   Card-1: Qualcomm Atheros QCA6174 802.11ac Wireless Network Adapter driver: ath10k_pci
           IF: wlp2s0 state: up mac: 9c:b6:d0:e9:ca:77
           Card-2: Atheros
           IF: null-if-id state: N/A speed: N/A duplex: N/A mac: N/A
Drives:    HDD Total Size: 1024.2GB (45.5% used)
           ID-1: /dev/nvme0n1 model: PC300_NVMe_SK_hynix_1TB size: 1024.2GB
Partition: ID-1: / size: 407G used: 378G (98%) fs: ext4 dev: /dev/nvme0n1p8
           ID-2: swap-1 size: 64.00GB used: 0.00GB (0%) fs: swap dev: /dev/nvme0n1p7
RAID:      No RAID devices: /proc/mdstat, md_mod kernel module present
Sensors:   System Temperatures: cpu: 65.5C mobo: N/A
           Fan Speeds (in rpm): cpu: 3678 fan-2: 3713
Info:      Processes: 484 Uptime: 1:53 Memory: 13523.0/32017.9MB Client: Shell (zsh) inxi: 2.3.56
```

## Filter JSON array using jq

If you are trying to find a specific element within a JSON array you can use jq's `select()` filter.

Example:

```bash
jq '.services[] | select(.name == "awesome-service") | .version' services.json
```

## Linux Administration


```bash
cat hello
#!/bin/bash
echo "Hello, world"
echo "ERROR: Houston, we have a problem." >&3

./hello 3> hello.log
echo $? $_ $@ $!
for packages in $(rpm -qa | grep kernel); do echo $packages; done

for EVEN in $(seq 2 2 10); do echo "$EVEN"; done

test 1 -gt 2 ; echo $?

```
Tests can be performed using the Bash test command syntax, [ <TESTEXPRESSION> ].
[[ <TESTEXPRESSION> ]], > Bash version 2.02 and provides features such as glob pattern matching and regex pattern matching

$ [ 1 -gt 0 ] ; echo $?
0
$ [ 1 -gt 2 ] ; echo $?
1
https://tldp.org/LDP/abs/html/comparison-ops.html

regex

^cat$
/c.\{2\}t  exactly 2 in bw c and t
c[aou]t
. The period (.) matches any single character.
? The preceding item is optional and will be matched at most once.
* The preceding item will be matched zero or more times.
+ The preceding item will be matched one or more times.
{n,m} The preceding item is matched at least n times, but not more than m times.
[:alnum:] Alphanumeric characters: '[:alpha:]' and '[:digit:]'; in the 'C' locale and ASCII
character encoding, this is the same as '[0-9A-Za-z]'.
[:alpha:] Alphabetic characters: '[:lower:]' and '[:upper:]'; in the

[:print:] Printable characters: '[:alnum:]', '[:punct:]', and space.

[:punct:] Punctuation characters; in the 'C' locale and ASCII character encoding, this
is! " # $ % & ' ( ) * + , - . / : ; < = > ? @ [ \ ] ^ _ ' { | } ~. In other character sets,
these are the equivalent characters, if any.

[:space:] Space characters: in the 'C' locale, this is tab, newline, vertical tab, form
feed,carriage return, and space.

[:upper:] Upper-case letters: in the 'C' locale and ASCII character encoding, this is A
B C D E F G H I J K L M N O P Q R S T U V W X Y Z.

[:xdigit:] Hexadecimal digits: 0 1 2 3 4 5 6 7 8 9 A B C D E F a b c d e f.
\b Match the empty string at the edge of a word.
\B Match the empty string provided it is not at the edge of a word.
\< Match the empty string at the beginning of word

[:cntrl:] Control characters. In ASCII, these characters have octal codes 000
through 037, and 177 (DEL). In other character sets, these are the
equivalent characters, if any.

[:digit:] Digits: 0 1 2 3 4 5 6 7 8 9.

[:graph:] Graphical characters: '[:alnum:]' and '[:punct:]'.

[:lower:] Lower-case letters; in the 'C' locale and ASCII chara

grep -v '^[#;]' /etc/ethertypes
-v Only display lines that do not contain matches to the regular
expression.
-r Apply the search for data matching the regular expression recursively
to a group of files or directories.
-A NUMBER Display NUMBER of lines after the regular expression match.
-B NUMBER Display NUMBER of lines before the regular expression match.
-e Multiple regexs in grep
cat /var/log/secure | grep -e 'pam_unix' -e 'user root' -e 'Accepted publickey' | less


# RHSA day2

## Scheduling future tasks
``` bash
  at 0639pm Dec 17 < hello 3>hello1.log
  at 06:39pm Dec 17 < hello 3>hello1.log
  at 06:40pm Dec 17 < hello 3>hello1.log
  cat hello1.log 
  at allow
  sudo systemctl status at
  at
  at teatime
  at now 
  sudo systemctl status atd
  at now +1 min
  atq
  atrm 7
  atq
  at now +1 min
  atq
  at now +1 min
  ls ps*
  atq
  ls ps*
  cat ps.txt 
  at now +1 min

 1163  ls /usr/lib/tmpfiles.d
 1164  cat /usr/lib/tmpfiles.d/krb5-krb5kdc.conf 
 1165  man tmpfiles.d
 1166  cat /usr/lib/tmpfiles.d/tmp.conf 
 1167  vim /etc/tmpfiles.d/momentary.conf
 1168  sudo vim /etc/tmpfiles.d/momentary.conf
 1169  systemd-tmpfiles --create /etc/tmpfiles.d/momentary.conf
 1170  sudo systemd-tmpfiles --create /etc/tmpfiles.d/momentary.conf
 1171  ls -ld /run/momentary
 1172  watch ls -ld /run/momentary
 1173  touch /run/momentary/testfile
 1174  sudo touch /run/momentary/testfile
 1175  sleep 30
 1176  systemd-tmpfiles --clean /etc/tmpfiles.d/momentary.conf
 1177  sjudo systemd-tmpfiles --clean /etc/tmpfiles.d/momentary.conf
 1178  sudo systemd-tmpfiles --clean /etc/tmpfiles.d/momentary.conf
 1179  watch ls -ld /run/momentary
 1180   ls -ld /run/momentary
 1181  top
 1182  ps axo pid,comm,nice,cls --sort=-nice
 1183  nice sha1sum /dev/zero
 1184  nice sha1sum /dev/zero &
 1185  ps -o pid,comm,nice 455261
 1186  renice  -n 0 455261
 1187  sudo renice  -n 0 455261

```


## Binary search Tree trivial problems

First thing first, here is the code:

def smallestDivisor(nums: List[int], threshold: int) -> int:
    def condition(divisor) -> bool:
        return sum((num - 1) // divisor + 1 for num in nums) <= threshold

    left, right = 1, max(nums)
    while left < right:
        mid = left + (right - left) // 2
        if condition(mid):
            right = mid
        else:
            left = mid + 1
    return left

I have built a powerful generalized binary search template and used it to solve many problems easily. Below is the detailed and clear introduction to this template. I believe it will be worth your time :)

Intro

Binary Search is quite easy to understand conceptually. Basically, it splits the search space into two halves and only keep the half that probably has the search target and throw away the other half that would not possibly have the answer. In this manner, we reduce the search space to half the size at every step, until we find the target. Binary Search helps us reduce the search time from linear O(n) to logarithmic O(log n). But when it comes to implementation, it's rather difficult to write a bug-free code in just a few minutes. Some of the most common problems include:

    When to exit the loop? Should we use left < right or left <= right as the while loop condition?
    How to initialize the boundary variable left and right?
    How to update the boundary? How to choose the appropriate combination from left = mid, left = mid + 1 and right = mid, right = mid - 1?

A rather common misunderstanding of binary search is that people often think this technique could only be used in simple scenario like "Given a sorted array, find a specific value in it". As a matter of fact, it can be applied to much more complicated situations.

After a lot of practice in LeetCode, I've made a powerful binary search template and solved many Hard problems by just slightly twisting this template. I'll share the template with you guys in this post. I don't want to just show off the code and leave. Most importantly, I want to share the logical thinking: how to apply this general template to all sorts of problems. Hopefully, after reading this post, people wouldn't be pissed off any more when LeetCoding, "Holy sh*t! This problem could be solved with binary search! Why didn't I think of that before!"

Most Generalized Binary Search

Suppose we have a search space. It could be an array, a range, etc. Usually it's sorted in ascend order. For most tasks, we can transform the requirement into the following generalized form:

Minimize k , s.t. condition(k) is True

The following code is the most generalized binary search template:

def binary_search(array) -> int:
    def condition(value) -> bool:
        pass

    left, right = 0, len(array)
    while left < right:
        mid = left + (right - left) // 2
        if condition(mid):
            right = mid
        else:
            left = mid + 1
    return left

What's really nice of this template is that, for most of the binary search problems, we only need to modify three parts after copy-pasting this template, and never need to worry about corner cases and bugs in code any more:

    Correctly initialize the boundary variables left and right. Only one rule: set up the boundary to include all possible elements;
    Decide return value. Is it return left or return left - 1? Remember this: after exiting the while loop, left is the minimal k​ satisfying the condition function;
    Design the condition function. This is the most difficult and most beautiful part. Needs lots of practice.

Below I'll show you guys how to apply this powerful template to many LeetCode problems.

Basic Application
278. First Bad Version [Easy]

You are a product manager and currently leading a team to develop a new product. Since each version is developed based on the previous version, all the versions after a bad version are also bad. Suppose you have n versions [1, 2, ..., n] and you want to find out the first bad one, which causes all the following ones to be bad. You are given an API bool isBadVersion(version) which will return whether version is bad.

Example:

Given n = 5, and version = 4 is the first bad version.

call isBadVersion(3) -> false
call isBadVersion(5) -> true
call isBadVersion(4) -> true

Then 4 is the first bad version. 

First, we initialize left = 1 and right = n to include all possible values. Then we notice that we don't even need to design the condition function. It's already given by the isBadVersion API. Finding the first bad version is equivalent to finding the minimal k satisfying isBadVersion(k) is True. Our template can fit in very nicely:

class Solution:
    def firstBadVersion(self, n) -> int:
        left, right = 1, n
        while left < right:
            mid = left + (right - left) // 2
            if isBadVersion(mid):
                right = mid
            else:
                left = mid + 1
        return left

69. Sqrt(x) [Easy]

Implement int sqrt(int x). Compute and return the square root of x, where x is guaranteed to be a non-negative integer. Since the return type is an integer, the decimal digits are truncated and only the integer part of the result is returned.

Example:

Input: 4
Output: 2

Input: 8
Output: 2

Quite an easy problem. We need to search for maximal k satisfying k^2 <= x, so we can easily come up with the solution:

def mySqrt(x: int) -> int:
    left, right = 0, x
    while left < right:
        mid = left + (right - left) // 2
        if mid * mid <= x:
            left = mid + 1
        else:
            right = mid
    return left - 1

There's one thing I'd like to point out. Remember I say that we usually look for the minimal k value satisfying certain condition? But in this problem we are searching for maximal k value instead. Feeling confused? Don't be. Actually, the maximal k satisfying condition(k) is False is just equal to the minimal k satisfying condition(k) is True minus one. This is why I mentioned earlier that we need to decide which value to return, left or left - 1.

35. Search Insert Position [Easy]

Given a sorted array and a target value, return the index if the target is found. If not, return the index where it would be if it were inserted in order. You may assume no duplicates in the array.

Example:

Input: [1,3,5,6], 5
Output: 2

Input: [1,3,5,6], 2
Output: 1

Very classic application of binary search. We are looking for the minimal k value satisfying nums[k] >= target, and we can just copy-paste our template. Notice that our solution is correct regardless of whether the input array nums has duplicates. Also notice that the input target might be larger than all elements in nums and therefore needs to placed at the end of the array. That's why we should initialize right = len(nums) instead of right = len(nums) - 1.

class Solution:
    def searchInsert(self, nums: List[int], target: int) -> int:
        left, right = 0, len(nums)
        while left < right:
            mid = left + (right - left) // 2
            if nums[mid] >= target:
                right = mid
            else:
                left = mid + 1
        return left

Advanced Application

The above problems are quite easy to solve, because they already give us the array to be searched. We'd know that we should use binary search to solve them at first glance. However, more often are the situations where the search space and search target are not so readily available. Sometimes we won't even realize that the problem should be solved with binary search -- we might just turn to dynamic programming or DFS and get stuck for a very long time.

As for the question "When can we use binary search?", my answer is that, If we can discover some kind of monotonicity, for example, if condition(k) is True then condition(k + 1) is True, then we can consider binary search.

1011. Capacity To Ship Packages Within D Days [Medium]

days. The i-th package on the conveyor belt has a weight of weights[i]. Each day, we load the ship with packages on the conveyor belt (in the order given by weights). We may not load more weight than the maximum weight capacity of the ship.

Return the least weight capacity of the ship that will result in all the packages on the conveyor belt being shipped within D days.

Example :

Input: weights = [1,2,3,4,5,6,7,8,9,10], D = 5
Output: 15
Explanation: 
A ship capacity of 15 is the minimum to ship all the packages in 5 days like this:
1st day: 1, 2, 3, 4, 5
2nd day: 6, 7
3rd day: 8
4th day: 9
5th day: 10

Note that the cargo must be shipped in the order given, so using a ship of capacity 14 and splitting the packages into parts like (2, 3, 4, 5), (1, 6, 7), (8), (9), (10) is not allowed. 

Binary search probably would not come to our mind when we first meet this problem. We might automatically treat weights as search space and then realize we've entered a dead end after wasting lots of time. In fact, we are looking for the minimal one among all feasible capacities. We dig out the monotonicity of this problem: if we can successfully ship all packages within D days with capacity m, then we can definitely ship them all with any capacity larger than m. Now we can design a condition function, let's call it feasible, given an input capacity, it returns whether it's possible to ship all packages within D days. This can run in a greedy way: if there's still room for the current package, we put this package onto the conveyor belt, otherwise we wait for the next day to place this package. If the total days needed exceeds D, we return False, otherwise we return True.

Next, we need to initialize our boundary correctly. Obviously capacity should be at least max(weights), otherwise the conveyor belt couldn't ship the heaviest package. On the other hand, capacity need not be more thansum(weights), because then we can ship all packages in just one day.

Now we've got all we need to apply our binary search template:

def shipWithinDays(weights: List[int], D: int) -> int:
    def feasible(capacity) -> bool:
        days = 1
        total = 0
        for weight in weights:
            total += weight
            if total > capacity:  # too heavy, wait for the next day
                total = weight
                days += 1
                if days > D:  # cannot ship within D days
                    return False
        return True

    left, right = max(weights), sum(weights)
    while left < right:
        mid = left + (right - left) // 2
        if feasible(mid):
            right = mid
        else:
            left = mid + 1
    return left

410. Split Array Largest Sum [Hard]

Given an array which consists of non-negative integers and an integer m, you can split the array into m non-empty continuous subarrays. Write an algorithm to minimize the largest sum among these m subarrays.

Example:

Input:
nums = [7,2,5,10,8]
m = 2

Output:
18

Explanation:
There are four ways to split nums into two subarrays. The best way is to split it into [7,2,5] and [10,8], where the largest sum among the two subarrays is only 18.

If you take a close look, you would probably see how similar this problem is with LC 1011 above. Similarly, we can design a feasible function: given an input threshold, then decide if we can split the array into several subarrays such that every subarray-sum is less than or equal to threshold. In this way, we discover the monotonicity of the problem: if feasible(m) is True, then all inputs larger than m can satisfy feasible function. You can see that the solution code is exactly the same as LC 1011.

def splitArray(nums: List[int], m: int) -> int:        
    def feasible(threshold) -> bool:
        count = 1
        total = 0
        for num in nums:
            total += num
            if total > threshold:
                total = num
                count += 1
                if count > m:
                    return False
        return True

    left, right = max(nums), sum(nums)
    while left < right:
        mid = left + (right - left) // 2
        if feasible(mid):
            right = mid     
        else:
            left = mid + 1
    return left

But we probably would have doubts: It's true that left returned by our solution is the minimal value satisfying feasible, but how can we know that we can split the original array to actually get this subarray-sum? For example, let's say nums = [7,2,5,10,8] and m = 2. We have 4 different ways to split the array to get 4 different largest subarray-sum correspondingly: 25:[[7], [2,5,10,8]], 23:[[7,2], [5,10,8]], 18:[[7,2,5], [10,8]], 24:[[7,2,5,10], [8]]. Only 4 values. But our search space [max(nums), sum(nums)] = [10, 32] has much more that just 4 values. That is, no matter how we split the input array, we cannot get most of the values in our search space.

Let's say k is the minimal value satisfying feasible function. We can prove the correctness of our solution with proof by contradiction. Assume that no subarray's sum is equal to k, that is, every subarray sum is less than k. The variable total inside feasible function keeps track of the total weights of current load. If our assumption is correct, then total would always be less than k. As a result, feasible(k - 1) must be True, because total would at most be equal to k - 1 and would never trigger the if-clause if total > threshold, therefore feasible(k - 1) must have the same output as feasible(k), which is True. But we already know that k is the minimal value satisfying feasible function, so feasible(k - 1) has to be False, which is a contradiction. So our assumption is incorrect. Now we've proved that our algorithm is correct.

875. Koko Eating Bananas [Medium]

Koko loves to eat bananas. There are N piles of bananas, the i-th pile has piles[i] bananas. The guards have gone and will come back in H hours. Koko can decide her bananas-per-hour eating speed of K. Each hour, she chooses some pile of bananas, and eats K bananas from that pile. If the pile has less than K bananas, she eats all of them instead, and won't eat any more bananas during this hour.

Koko likes to eat slowly, but still wants to finish eating all the bananas before the guards come back. Return the minimum integer K such that she can eat all the bananas within H hours.

Example :

Input: piles = [3,6,7,11], H = 8
Output: 4

Input: piles = [30,11,23,4,20], H = 5
Output: 30

Input: piles = [30,11,23,4,20], H = 6
Output: 23

Very similar to LC 1011 and LC 410 mentioned above. Let's design a feasible function, given an input speed, determine whether Koko can finish all bananas within H hours with hourly eating speed speed. Obviously, the lower bound of the search space is 1, and upper bound is max(piles), because Koko can only choose one pile of bananas to eat every hour.

def minEatingSpeed(piles: List[int], H: int) -> int:
    def feasible(speed) -> bool:
        # return sum(math.ceil(pile / speed) for pile in piles) <= H  # slower        
        return sum((pile - 1) / speed + 1 for pile in piles) <= H  # faster

    left, right = 1, max(piles)
    while left < right:
        mid = left  + (right - left) // 2
        if feasible(mid):
            right = mid
        else:
            left = mid + 1
    return left

1482. Minimum Number of Days to Make m Bouquets [Medium]

Given an integer array bloomDay, an integer m and an integer k. We need to make m bouquets. To make a bouquet, you need to use k adjacent flowers from the garden. The garden consists of n flowers, the ith flower will bloom in the bloomDay[i] and then can be used in exactly one bouquet. Return the minimum number of days you need to wait to be able to make m bouquets from the garden. If it is impossible to make m bouquets return -1.

Examples:

Input: bloomDay = [1,10,3,10,2], m = 3, k = 1
Output: 3
Explanation: Let's see what happened in the first three days. x means flower bloomed and _ means flower didn't bloom in the garden.
We need 3 bouquets each should contain 1 flower.
After day 1: [x, _, _, _, _]   // we can only make one bouquet.
After day 2: [x, _, _, _, x]   // we can only make two bouquets.
After day 3: [x, _, x, _, x]   // we can make 3 bouquets. The answer is 3.

Input: bloomDay = [1,10,3,10,2], m = 3, k = 2
Output: -1
Explanation: We need 3 bouquets each has 2 flowers, that means we need 6 flowers. We only have 5 flowers so it is impossible to get the needed bouquets and we return -1.

Now that we've solved three advanced problems above, this one should be pretty easy to do. The monotonicity of this problem is very clear: if we can make m bouquets after waiting for d days, then we can definitely finish that as well if we wait more than d days.

def minDays(bloomDay: List[int], m: int, k: int) -> int:
    def feasible(days) -> bool:
        bonquets, flowers = 0, 0
        for bloom in bloomDay:
            if bloom > days:
                flowers = 0
            else:
                bonquets += (flowers + 1) // k
                flowers = (flowers + 1) % k
        return bonquets >= m

    if len(bloomDay) < m * k:
        return -1
    left, right = 1, max(bloomDay)
    while left < right:
        mid = left + (right - left) // 2
        if feasible(mid):
            right = mid
        else:
            left = mid + 1
    return left

668. Kth Smallest Number in Multiplication Table [Hard]

Nearly every one have used the Multiplication Table. But could you find out the k-th smallest number quickly from the multiplication table? Given the height m and the length n of a m * n Multiplication Table, and a positive integer k, you need to return the k-th smallest number in this table.

Example :

Input: m = 3, n = 3, k = 5
Output: 3
Explanation: 
The Multiplication Table:
1	2	3
2	4	6
3	6	9

The 5-th smallest number is 3 (1, 2, 2, 3, 3).

For Kth-Smallest problems like this, what comes to our mind first is Heap. Usually we can maintain a Min-Heap and just pop the top of the Heap for k times. However, that doesn't work out in this problem. We don't have every single number in the entire Multiplication Table, instead, we only have the height and the length of the table. If we are to apply Heap method, we need to explicitly calculate these m * n values and save them to a heap. The time complexity and space complexity of this process are both O(mn), which is quite inefficient. This is when binary search comes in. Remember we say that designing condition function is the most difficult part? In order to find the k-th smallest value in the table, we can design an enough function, given an input num, determine whether there're at least k values less than or equal to num. The minimal num satisfying enough function is the answer we're looking for. Recall that the key to binary search is discovering monotonicity. In this problem, if num satisfies enough, then of course any value larger than num can satisfy. This monotonicity is the fundament of our binary search algorithm.

Let's consider search space. Obviously the lower bound should be 1, and the upper bound should be the largest value in the Multiplication Table, which is m * n, then we have search space [1, m * n]. The overwhelming advantage of binary search solution to heap solution is that it doesn't need to explicitly calculate all numbers in that table, all it needs is just picking up one value out of the search space and apply enough function to this value, to determine should we keep the left half or the right half of the search space. In this way, binary search solution only requires constant space complexity, much better than heap solution.

Next let's consider how to implement enough function. It can be observed that every row in the Multiplication Table is just multiples of its index. For example, all numbers in 3rd row [3,6,9,12,15...] are multiples of 3. Therefore, we can just go row by row to count the total number of entries less than or equal to input num. Following is the complete solution.

def findKthNumber(m: int, n: int, k: int) -> int:
    def enough(num) -> bool:
        count = 0
        for val in range(1, m + 1):  # count row by row
            add = min(num // val, n)
            if add == 0:  # early exit
                break
            count += add
        return count >= k                

    left, right = 1, n * m
    while left < right:
        mid = left + (right - left) // 2
        if enough(mid):
            right = mid
        else:
            left = mid + 1
    return left 

In LC 410 above, we have doubt "Is the result from binary search actually a subarray sum?". Here we have a similar doubt: "Is the result from binary search actually in the Multiplication Table?". The answer is yes, and we also can apply proof by contradiction. Denote num as the minimal input that satisfies enough function. Let's assume that num is not in the table, which means that num is not divisible by any val in [1, m], that is, num % val > 0. Therefore, changing the input from num to num - 1 doesn't have any effect on the expression add = min(num // val, n). So enough(num) would also return True, just like enough(num). But we already know num is the minimal input satisfying enough function, so enough(num - 1) has to be False. Contradiction! The opposite of our original assumption is true: num is actually in the table.

719. Find K-th Smallest Pair Distance [Hard]

Given an integer array, return the k-th smallest distance among all the pairs. The distance of a pair (A, B) is defined as the absolute difference between A and B.

Example :

Input:
nums = [1,3,1]
k = 1
Output: 0 
Explanation:
Following are all the pairs. The 1st smallest distance pair is (1,1), and its distance is 0.
(1,3) -> 2
(1,1) -> 0
(3,1) -> 2

Very similar to LC 668 above, both are about finding Kth-Smallest. Just like LC 668, We can design an enough function, given an input distance, determine whether there're at least k pairs whose distances are less than or equal to distance. We can sort the input array and use two pointers (fast pointer and slow pointer, pointed at a pair) to scan it. Both pointers go from leftmost end. If the current pair pointed at has a distance less than or equal to distance, all pairs between these pointers are valid (since the array is already sorted), we move forward the fast pointer. Otherwise, we move forward the slow pointer. By the time both pointers reach the rightmost end, we finish our scan and see if total counts exceed k. Here is the implementation:

def enough(distance) -> bool:  # two pointers
    count, i, j = 0, 0, 0
    while i < n or j < n:
        while j < n and nums[j] - nums[i] <= distance:  # move fast pointer
            j += 1
        count += j - i - 1  # count pairs
        i += 1  # move slow pointer
    return count >= k

Obviously, our search space should be [0, max(nums) - min(nums)]. Now we are ready to copy-paste our template:

def smallestDistancePair(nums: List[int], k: int) -> int:
    nums.sort()
    n = len(nums)
    left, right = 0, nums[-1] - nums[0]
    while left < right:
        mid = left + (right - left) // 2
        if enough(mid):
            right = mid
        else:
            left = mid + 1
    return left

1201. Ugly Number III [Medium]

Write a program to find the n-th ugly number. Ugly numbers are positive integers which are divisible by a or b or c.

Example :

Input: n = 3, a = 2, b = 3, c = 5
Output: 4
Explanation: The ugly numbers are 2, 3, 4, 5, 6, 8, 9, 10... The 3rd is 4.

Input: n = 4, a = 2, b = 3, c = 4
Output: 6
Explanation: The ugly numbers are 2, 3, 4, 6, 8, 9, 10, 12... The 4th is 6.

Nothing special. Still finding the Kth-Smallest. We need to design an enough function, given an input num, determine whether there are at least n ugly numbers less than or equal to num. Since a might be a multiple of b or c, or the other way round, we need the help of greatest common divisor to avoid counting duplicate numbers.

def nthUglyNumber(n: int, a: int, b: int, c: int) -> int:
    def enough(num) -> bool:
        total = mid//a + mid//b + mid//c - mid//ab - mid//ac - mid//bc + mid//abc
        return total >= n

    ab = a * b // math.gcd(a, b)
    ac = a * c // math.gcd(a, c)
    bc = b * c // math.gcd(b, c)
    abc = a * bc // math.gcd(a, bc)
    left, right = 1, 10 ** 10
    while left < right:
        mid = left + (right - left) // 2
        if enough(mid):
            right = mid
        else:
            left = mid + 1
    return left

1283. Find the Smallest Divisor Given a Threshold [Medium]

Given an array of integers nums and an integer threshold, we will choose a positive integer divisor and divide all the array by it and sum the result of the division. Find the smallest divisor such that the result mentioned above is less than or equal to threshold.

Each result of division is rounded to the nearest integer greater than or equal to that element. (For example: 7/3 = 3 and 10/2 = 5). It is guaranteed that there will be an answer.

Example :

Input: nums = [1,2,5,9], threshold = 6
Output: 5
Explanation: We can get a sum to 17 (1+2+5+9) if the divisor is 1. 
If the divisor is 4 we can get a sum to 7 (1+1+2+3) and if the divisor is 5 the sum will be 5 (1+1+1+2). 

After so many problems introduced above, this one should be a piece of cake. We don't even need to bother to design a condition function, because the problem has already told us explicitly what condition we need to satisfy.

def smallestDivisor(nums: List[int], threshold: int) -> int:
    def condition(divisor) -> bool:
        return sum((num - 1) // divisor + 1 for num in nums) <= threshold

    left, right = 1, max(nums)
    while left < right:
        mid = left + (right - left) // 2
        if condition(mid):
            right = mid
        else:
            left = mid + 1
    return left

End

Wow, thank you so much for making it to the end, really appreciate that. As you can see from the python codes above, they all look very similar to each other. That's because I copy-pasted my template all the time. No exception. This is the strong proof of my template's powerfulness. I believe everyone can acquire this binary search template to solve many problems. All we need is just more practice to build up our ability to discover the monotonicity of the problem and to design a beautiful condition function.

Hope this helps.

Reference

    [C++ / Fast / Very clear explanation / Clean Code] Solution with Greedy Algorithm and Binary Search
    Approach the problem using the "trial and error" algorithm
    Binary Search 101 The-Ultimate-Binary-Search-Handbook - LeetCode
    ugly-number-iii Binary Search with picture & Binary Search Template - LeetCode


## -h

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

## regex search sort


==== Regex ===
\\s \\S
\\d \\D
\\w \\W
w{2,3}
\\p{Punct}


(?<![\\w_]) wordToLook (?![\w_])  // reject foo_goo but search for foo

(?!) - negative lookahead
(?=) - positive lookahead
(?<=) - positive lookbehind
(?<!) - negative lookbehind

(?>) - atomic group

bar(?=bar)     finds the 1st bar ("bar" which has "bar" after it)
bar(?!bar)     finds the 2nd bar ("bar" which does not have "bar" after it)
(?<=foo)bar    finds the 1st bar ("bar" which has "foo" before it)
(?<!foo)bar    finds the 2nd bar ("bar" which does not have "foo" before it)


== Atomic Groups  ==
 
Consider /the (big|small|biggest) (cat|dog|bird)/

Matches in bold

the big dog
the small bird
the biggest dog
the small cat





## Cherry_Pick
To begin with, you may be surprised by the basic ideas to approach the problem: simply simulate each of the round trips and choose the one that yields the maximum number of cherries.

But then what's the difficulty of this problem? The biggest issue is that there are simply too many round trips to explore -- the number of round trips scales exponentially as the size N of the grid. This is because each round trip takes (4N-4) steps, and at each step, we have two options as to where to go next (in the worst case). This puts the total number of possible round trips at 2^(4N-4). Therefore a naive implementation of the aforementioned idea would be very inefficient.

II -- Initial attempt of DP

Fortunately, a quick look at the problem seems to reveal the two features of dynamic programming: optimal substructure and overlapping of subproblems.

Optimal substructure: if we define T(i, j) as the maximum number of cherries we can pick up starting from the position (i, j)(assume it's not a thorn) of the grid and following the path (i, j) ==> (N-1, N-1) ==>(0, 0), we could move one step forward to either (i+1, j) or (i, j+1), and recursively solve for the subproblems starting from each of those two positions (that is, T(i+1, j) and T(i, j+1)), then take the sum of the larger one (assume it exists) together with grid[i][j] to form a solution to the original problem. (Note: the previous analyses assume we are on the first leg of the round trip, that is, (0, 0) ==> (N-1, N-1); if we are on the second leg, that is, (N-1, N-1) ==> (0, 0), then we should move one step backward from (i, j) to either (i-1, j) or (i, j-1).)

Overlapping of subproblems: two round trips may overlap with each other in the middle, leading to repeated subproblems. For example, the position (i, j) can be reached from both positions (i-1, j) and (i, j-1), which means both T(i-1, j) and T(i, j-1) are related to T(i, j). Therefore we may cache the intermediate results to avoid recomputing these subproblems.

This sounds promising, since there are at most O(N^2) starting positions, meaning we could solve the problem in O(N^2) time with caching. But there is an issue with this naive DP -- it failed to take into account the constraint that "once a cherry is picked up, the original cell (value 1) becomes an empty cell (value 0)", so that if there are overlapping cells between the two legs of the round trip, those cells will be counted twice. In fact, without this constraint, we can simply solve for the maximum number of cherries of the two legs of the round trip separately (they should have the same value), then take the sum of the two to produce the answer.

III -- Second attempt of DP that modifies the grid matrix

So how do we account for the aforementioned constraint? I would say, why don't we reset the value of the cell from 1 to 0 after we pick up the cherry? That is, modify the grid matrix as we go along the round trip.

1. Can we still divide the round trip into two legs and maximize each of them separately ?

Well, you may be tempted to do so as it seems to be right at first sight. However, if you dig deeper, you will notice that the maximum number of cherries of the second leg actually depends on the choice of path for the first leg. This is because if we pluck some cherry in the first leg, it will no longer be available for the second leg (remember we reset the cell value from 1 to 0). So the above greedy idea only maximize the number of cherries for the first leg, but not necessarily for the sum of the two legs (that is, local optimum does not necessarily lead to global optimum).

Here is a counter example:

grid = [[1,1,1,0,1],
        [0,0,0,0,0],
        [0,0,0,0,0],
        [0,0,0,0,0],
        [1,0,1,1,1]].

The greedy idea above would suggest a Z-shaped path for the first leg, i.e., (0, 0) ==> (0, 2) ==> (4, 2) ==> (4, 4), which garners 6 cherries. Then for the second leg, the maximum number of cherries we can get is 1 (the one at the lower-left or upper-right corner), so the sum will be 7. This is apparently less than the best route by traveling along the four edges, in which all 8 cherries can be picked.

2. What changes do we need to make on top of the above naive DP if we are modifying the grid matrix ?

The obvious difference is that now the maximum number of cherries of the trip not only depends on the starting position (i, j), but also on the status of the grid matrix when that position is reached. This is because the grid matrix may be modified differently along different paths towards the same position (i, j), therefore, even if the starting position is the same, the maximum number of cherries may be different since we are working with different grid matrix now.

Here is a simple example to illustrate this. Assume we have this grid matrix:

grid = [[0,1,0],
        [0,1,0],
        [0,0,0].

and we are currently at position (1, 1). If this position is reached following the path (0, 0) ==> (0, 1) ==> (1, 1), the grid matrix will be:

grid = [[0,0,0],
        [0,1,0],
        [0,0,0].

However, if it is reached following the path (0, 0) ==> (1, 0) ==> (1, 1), the grid matrix will be the same as the initial one:

grid = [[0,1,0],
        [0,1,0],
        [0,0,0].

Therefore starting from the same initial position (1, 1), the maximum number of cherries will be 1 for the former and 2 for the latter.

So now each of our subproblems can be denoted symbolically as T(i, j, grid.status), where the status of the grid matrix may be represented by a string with cell values joined row by row. Our original problem will be T(0, 0, grid.initial_status) and the recurrence relations are something like:

T(i, j, grid.status) = -1, if grid[i][j] == -1 || T(i + d, j, grid.status1) == -1 && T(i + d, j, grid.status2) == -1;

T(i, j, grid.status) = grid[i][j] + max(T(i + d, j, grid.status1), T(i, j + d, grid.status2)), otherwise.

Here d depends on which leg we are during the round trip (d = +1 for the first leg and d = -1 for the second leg), both grid.status1 and grid.status2 can be obtained from grid.status.

To cache the intermediate results, we may create an N-by-N matrix of HashMaps, where the one at position (i, j) will map each grid.status to the maximum number of cherries obtained starting from position (i, j) on the grid with that particular status.

3. What is the issue with this new version of DP ?

While we can certainly develop a solution using this new version of DP, it does NOT help reduce the time complexity substantially. While it does help improve the performance, the worst case time complexity is still exponential. The reason is that the number of grid.status is very large -- in fact, it is exponential too, as each path may lead to a unique grid.status and the number of paths to some position is exponential. So the possibility of overlapping subproblems becomes so slim that we are forced to compute most of the subproblems, leading to the exponential time complexity.

IV -- Final attempt of DP without modifying the grid matrix

So we have seen that modifying the grid matrix isn't really the way to go. But if we leave it intact, how do we account for the aforementioned constraint? The key here is to avoid the duplicate counting. But for now, let's pretend the constraint does not exist and see what we can do later to overcome it when it shows up.

1. Can we reuse the definition of DP problem in Part II ?

Not really. The recurrence relation of the DP problem in Part II says that
T(i, j) = grid[i][j] + max{T(i+1, j), T(i, j+1)}, which means we already counted grid[i][j] towards T(i, j). To avoid the duplicate counting, we somehow need to make sure that grid[i][j] will not be counted towards any of T(i+1, j) and T(i, j+1). This can only happen if the position (i, j) won't appear on the paths for either of the two trips: (i+1, j) ==> (N-1, N-1) ==>(0, 0) or (i, j+1) ==> (N-1, N-1) ==>(0, 0), which is something we cannot guarantee. For example, since we have no control over the path that will be chosen for the sub-trip (N-1, N-1) ==>(0, 0) of both trips, it may pass the position (i, j) again, resulting in duplicate counting.

2. Can we shorten our round trip so that we don't have to go all the way to the lower right corner ?

Maybe. We can redefine T(i, j) as the maximum number of cherries for the shortened round trip: (0, 0) ==> (i, j) ==> (0, 0) without modifying the grid matrix. The original problem then will be denoted as T(N-1, N-1). To obtain the recurrence relations, note that for each position (i, j), we have two options for arriving at and two options for leaving it: (i-1, j) and (i, j-1), so the above round trip can be divide into four cases:

Case 1: (0, 0) ==> (i-1, j) ==> (i, j) ==> (i-1, j) ==> (0, 0)
Case 2: (0, 0) ==> (i, j-1) ==> (i, j) ==> (i, j-1) ==> (0, 0)
Case 3: (0, 0) ==> (i-1, j) ==> (i, j) ==> (i, j-1) ==> (0, 0)
Case 4: (0, 0) ==> (i, j-1) ==> (i, j) ==> (i-1, j) ==> (0, 0)

By definition, Case 1 is equivalent to T(i-1, j) + grid[i][j] and Case 2 is equivalent to T(i, j-1) + grid[i][j]. However, our definition of T(i, j) does not cover the last two cases, where the end of the first leg of the trip and the start of the second leg of the trip are different. This suggests we should generalize our definition from T(i, j) to T(i, j, p, q), which denotes the maximum number of cherries for the two-leg trip (0, 0) ==> (i, j); (p, q) ==> (0, 0) without modifying the grid matrix.

3. Will this two-leg DP definition work ?

We don't really know. But at least, we can work out the recurrence relations for T(i, j, p, q). Similar to the analyses above, there are two options for arriving at (i, j), and two options for leaving (p, q), so the two-leg trip again can be divided into four cases:

Case 1: (0, 0) ==> (i-1, j) ==> (i, j); (p, q) ==> (p-1, q) ==> (0, 0)
Case 2: (0, 0) ==> (i-1, j) ==> (i, j); (p, q) ==> (p, q-1) ==> (0, 0)
Case 3: (0, 0) ==> (i, j-1) ==> (i, j); (p, q) ==> (p-1, q) ==> (0, 0)
Case 4: (0, 0) ==> (i, j-1) ==> (i, j); (p, q) ==> (p, q-1) ==> (0, 0)

and by definition, we have:

Case 1 is equivalent to T(i-1, j, p-1, q) + grid[i][j] + grid[p][q];
Case 2 is equivalent to T(i-1, j, p, q-1) + grid[i][j] + grid[p][q];
Case 3 is equivalent to T(i, j-1, p-1, q) + grid[i][j] + grid[p][q];
Case 4 is equivalent to T(i, j-1, p, q-1) + grid[i][j] + grid[p][q];

Therefore, the recurrence relations can be written as:

T(i, j, p, q) = grid[i][j] + grid[p][q] + max{T(i-1, j, p-1, q), T(i-1, j, p, q-1), T(i, j-1, p-1, q), T(i, j-1, p, q-1)}

Now to make it work, we need to impose the aforementioned constraint. As mentioned above, since we already counted grid[i][j] and grid[p][q] towards T(i, j, p, q), to avoid duplicate counting, both of them should NOT be counted for any of T(i-1, j, p-1, q), T(i-1, j, p, q-1), T(i, j-1, p-1, q) and T(i, j-1, p, q-1). It is obvious that the position (i, j) won't appear on the paths of the trips (0, 0) ==> (i-1, j) or (0, 0) ==> (i, j-1), and similarly the position (p, q) won't appear on the paths of the trips (p-1, q) ==> (0, 0) or (p, q-1) ==> (0, 0). Therefore, if we can guarantee that (i, j) won't appear on the paths of the trips (p-1, q) ==> (0, 0) or (p, q-1) ==> (0, 0), and (p, q) won't appear on the paths of the trips (0, 0) ==> (i-1, j) or (0, 0) ==> (i, j-1), then no duplicate counting can ever happen. So how do we achieve that?

Take the trips (0, 0) ==> (i-1, j) and (0, 0) ==> (i, j-1) as an example. Although we have no control over the paths that will be taken for them, we do know the boundaries of the paths: all positions on the path for the former will be lying within the rectangle [0, 0, i-1, j] and for the latter will be lying within the rectangle [0, 0, i, j-1], which implies all positions on the two paths combined will be lying within the rectangle [0, 0, i, j], except for the lower right corner position (i, j). Therefore, if we make sure that the position (p, q) is lying outside the rectangle [0, 0, i, j] (except for the special case when it overlaps with (i, j)), it will never appear on the paths of the trips (0, 0) ==> (i-1, j) or (0, 0) ==> (i, j-1).

The above analyses are equally applicable to the trips (p-1, q) ==> (0, 0) and (p, q-1) ==> (0, 0), so we conclude that the position (i, j) has to be lying outside the rectangle [0, 0, p, q] (again except for the special case) in order to avoid duplicate counting. So in summary, one of the following three conditions should be true:

    i < p && j > q
    i == p && j == q
    i > p && j < q

This indicates that our definition of the two-leg trip T(i, j, p, q) is not valid for all values of the four indices, but instead, they will be subjected to the above three conditions. This is problematic, as it would break the self-consistency of the original definition of T(i, j, p, q) when such conditions do not exist. A direct consequence is that the above recurrence relations derived for T(i, j, p, q) won't work anymore. For example, T(3, 1, 2, 3) is valid under these conditions but one of the terms in the recurrence relations, T(2, 1, 2, 2), would be invalid, and we have no idea how to get its value under current definition of T(i, j, p, q).

4. Self-consistent two-leg DP definition

Though the above two-leg DP definition does not work, we are pretty close to a real solution. We know that in order to avoid duplicate counting, the four indices, (i, j, p, q), have to be correlated to each other (i.e., they are not independent variables). The above three conditions are only the most general way for specifying what the correlations should be, but not necessarily the best one. We can as well choose a subset of those three conditions and define T(i, j, p, q) over that subset, then still no duplicate counting will ever happen for this new definition. This is because if the four indices fall within the range delimited by the subset, they will be guaranteed to satisfy the above three conditions, which is the most general form of conditions we have derived to eliminate the possibilities of duplicate counting (this is like to say, we want to have a < 10, and if we always choose a such that a < 5, then it is guaranteed that a < 10).

So our goal now is to select a subset of the conditions that can restore the self-consistency of T(i, j, p, q) so we can have a working recurrence relation. The key observation comes from the fact that when i (p) increases, we need to decrease j (q) in order to make the above conditions hold, and vice versa -- they are anti-correlated. This suggests we can set the sum of i (p) and j (q) to some constant, n = i + j = p + q. Then it is straightforward to verify that the above conditions is met automatically, meaning n = i + j = p + q is indeed a subset of the above conditions. (Note in this subset of conditions, n can be interpreted as the number of steps from the source position (0, 0). I have also tried other anti-correlated functions for i and j such as their product is a constant but it did not work out. The recurrence relations here play a role and constant sum turns out to be the simplest one that works.)

With the new conditions in place, we can now redefine our T(i, j, p, q) such that n = i + j = p + q, which can be rewritten, in terms of independent variables, as T(n, i, p), where T(n, i, p) = T(i, n-i, p, n-p). Note that under this definition, we have:

T(i-1, n-i, p-1, n-p) = T(n-1, i-1, p-1)
T(i-1, n-i, p, n-p-1) = T(n-1, i-1, p)
T(i, n-i-1, p-1, n-p) = T(n-1, i, p-1)
T(i, n-i-1, p, n-p-1) = T(n-1, i, p)

Then from the recurrence relation for T(i, j, p, q), we obtain the recurrence relation for T(n, i, p) as:

T(n, i, p) = grid[i][n-i] + grid[p][n-p] + max{T(n-1, i-1, p-1), T(n-1, i-1, p), T(n-1, i, p-1), T(n-1, i, p)}.

Of course, in the recurrence relation above, only one of grid[i][n-i] and grid[p][n-p] will be taken if i == p (i.e., when the two positions overlap). Also note that all four indices, i, j, p and q, are in the range [0, N), meaning n will be in the range [0, 2N-1) (remember it is the sum of i and j). Lastly we have the base case given by T(0, 0, 0) = grid[0][0].

Now using the recurrence relation for T(n, i, p), it is straightforward to code for the O(N^3) time and O(N^3) space solution. However, if you notice that T(n, i, p) only depends on those subproblems with n - 1, we can iterate on this dimension and cut down the space to O(N^2). So here is the final O(N^3) time and O(N^2) space solution, where we use -1 to indicate that a two-leg trip cannot be completed, and iterate in backward direction for indices i and p to get rid of the temporary matrix that is otherwise required for updating the dp matrix.

public int cherryPickup(int[][] grid) {
    int N = grid.length, M = (N << 1) - 1;
    int[][] dp = new int[N][N];
    dp[0][0] = grid[0][0];
	    
    for (int n = 1; n < M; n++) {
		for (int i = N - 1; i >= 0; i--) {
			for (int p = N - 1; p >= 0; p--) {
				int j = n - i, q = n - p;
                
				if (j < 0 || j >= N || q < 0 || q >= N || grid[i][j] < 0 || grid[p][q] < 0) {
                    dp[i][p] = -1;
                    continue;
                 }
		 
				 if (i > 0) dp[i][p] = Math.max(dp[i][p], dp[i - 1][p]);
				 if (p > 0) dp[i][p] = Math.max(dp[i][p], dp[i][p - 1]);
				 if (i > 0 && p > 0) dp[i][p] = Math.max(dp[i][p], dp[i - 1][p - 1]);
		 
				 if (dp[i][p] >= 0) dp[i][p] += grid[i][j] + (i != p ? grid[p][q] : 0)
             }
		 }
    }
    
    return Math.max(dp[N - 1][N - 1], 0);
}

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
## MinimumWindowSubString

```
1. Use two pointers: start and end to represent a window.
2. Move end to find a valid window.
3. When a valid window is found, move start to find a smaller window.

```

To check if a window is valid, we use a map to store (char, count) for chars in t. And use counter for the number of chars of t to be found in s. The key part is m[s[end]]--;. We decrease count for each char in s. If it does not exist in t, the count will be negative.

To really understand this algorithm, please see my code which is much clearer, because there is no code like if(map[s[end++]]++>0) counter++;.




 templated code with optimisation (using array instead of map). The runtime dropped for e.g. in min window from 143ms -> 7ms.

Minimum window
```
  public String minWindow(String s, String t) {
    int [] map = new int[128];
    for (char c : t.toCharArray()) {
      map[c]++;
    }
    int start = 0, end = 0, minStart = 0, minLen = Integer.MAX_VALUE, counter = t.length();
    while (end < s.length()) {
      final char c1 = s.charAt(end);
      if (map[c1] > 0) counter--;
      map[c1]--;
      end++;
      while (counter == 0) {
        if (minLen > end - start) {
          minLen = end - start;
          minStart = start;
        }
        final char c2 = s.charAt(start);
        map[c2]++;
        if (map[c2] > 0) counter++;
        start++;
      }
    }

    return minLen == Integer.MAX_VALUE ? "" : s.substring(minStart, minStart + minLen);
  }
```
Longest Substring - at most K distinct characters
```
  public int lengthOfLongestSubstringKDistinct(String s, int k) {
    int[] map = new int[256];
    int start = 0, end = 0, maxLen = Integer.MIN_VALUE, counter = 0;

    while (end < s.length()) {
      final char c1 = s.charAt(end);
      if (map[c1] == 0) counter++;
      map[c1]++;
      end++;

      while (counter > k) {
        final char c2 = s.charAt(start);
        if (map[c2] == 1) counter--;
        map[c2]--;
        start++;
      }

      maxLen = Math.max(maxLen, end - start);
    }

    return maxLen;
  }
```
Longest Substring - at most 2 distinct characters
```
public int lengthOfLongestSubstringTwoDistinct(String s) {
    int[] map = new int[128];
    int start = 0, end = 0, maxLen = 0, counter = 0;

    while (end < s.length()) {
      final char c1 = s.charAt(end);
      if (map[c1] == 0) counter++;
      map[c1]++;
      end++;

      while (counter > 2) {
        final char c2 = s.charAt(start);
        if (map[c2] == 1) counter--;
        map[c2]--;
        start++;
      }

      maxLen = Math.max(maxLen, end - start);
    }

    return maxLen;
  }
```
LongestSubstring - without repeating characters
```
  public int lengthOfLongestSubstring2(String s) {
    int[] map = new int[128];
    int start = 0, end = 0, maxLen = 0, counter = 0;

    while (end < s.length()) {
      final char c1 = s.charAt(end);
      if (map[c1] > 0) counter++;
      map[c1]++;
      end++;

      while (counter > 0) {
        final char c2 = s.charAt(start);
        if (map[c2] > 1) counter--;
        map[c2]--;
        start++;
      }

      maxLen = Math.max(maxLen, end - start);
    }

    return maxLen;
  }
```
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
15 day tech startup launch plan:
- Domain on GoDaddy - 5 minutes
- Logo ideas on Dribbble - 5 minutes
- Brand assets on Figma - 40 minutes
- Website template design on Wix.com - 2 hours
- Webpage on Webflow - 2 hours
- Website to backend workflow on Zapier and Notion - 2 hours
- Early user testimonial videos on Testimonial - 30 minutes
- Early app building on FlutterFlow - 7 days
- Step by step instructions on using app on UserGuiding - 2 hours
- Payment collection on Stripe or Bolt - 2 hours
- App distribution on ProductHunt - 5 hours
- Newsletter plan on Substack- 7 days
- SEO on Ahrefs - 5 hours
- Landing page chatbot on Landbot - 1 hour
- CRM on HubSpot - 1 hour

The plan is simple.

1. Build a landing page with reusable assets
2. Get featured on major sites
3. Newsletter + SEO + chatbot to get customers in
4. Backend management system to manage inbound customers

A general approach to backtracking questions in Java (Subsets, Permutations, Combination Sum, Palindrome Partioning)

This structure might apply to many other backtracking questions, but here I am just going to demonstrate Subsets, Permutations, and Combination Sum.

Subsets : https://leetcode.com/problems/subsets/
```
public List<List<Integer>> subsets(int[] nums) {
    List<List<Integer>> list = new ArrayList<>();
    Arrays.sort(nums);
    backtrack(list, new ArrayList<>(), nums, 0);
    return list;
}

private void backtrack(List<List<Integer>> list , List<Integer> tempList, int [] nums, int start){
    list.add(new ArrayList<>(tempList));
    for(int i = start; i < nums.length; i++){
        tempList.add(nums[i]);
        backtrack(list, tempList, nums, i + 1);
        tempList.remove(tempList.size() - 1);
    }
}
Subsets II (contains duplicates) : https://leetcode.com/problems/subsets-ii/

public List<List<Integer>> subsetsWithDup(int[] nums) {
    List<List<Integer>> list = new ArrayList<>();
    Arrays.sort(nums);
    backtrack(list, new ArrayList<>(), nums, 0);
    return list;
}

private void backtrack(List<List<Integer>> list, List<Integer> tempList, int [] nums, int start){
    list.add(new ArrayList<>(tempList));
    for(int i = start; i < nums.length; i++){
        if(i > start && nums[i] == nums[i-1]) continue; // skip duplicates
        tempList.add(nums[i]);
        backtrack(list, tempList, nums, i + 1);
        tempList.remove(tempList.size() - 1);
    }
} 
Permutations : https://leetcode.com/problems/permutations/

public List<List<Integer>> permute(int[] nums) {
   List<List<Integer>> list = new ArrayList<>();
   // Arrays.sort(nums); // not necessary
   backtrack(list, new ArrayList<>(), nums);
   return list;
}

private void backtrack(List<List<Integer>> list, List<Integer> tempList, int [] nums){
   if(tempList.size() == nums.length){
      list.add(new ArrayList<>(tempList));
   } else{
      for(int i = 0; i < nums.length; i++){ 
         if(tempList.contains(nums[i])) continue; // element already exists, skip
         tempList.add(nums[i]);
         backtrack(list, tempList, nums);
         tempList.remove(tempList.size() - 1);
      }
   }
} 
Permutations II (contains duplicates) : https://leetcode.com/problems/permutations-ii/

public List<List<Integer>> permuteUnique(int[] nums) {
    List<List<Integer>> list = new ArrayList<>();
    Arrays.sort(nums);
    backtrack(list, new ArrayList<>(), nums, new boolean[nums.length]);
    return list;
}

private void backtrack(List<List<Integer>> list, List<Integer> tempList, int [] nums, boolean [] used){
    if(tempList.size() == nums.length){
        list.add(new ArrayList<>(tempList));
    } else{
        for(int i = 0; i < nums.length; i++){
            if(used[i] || i > 0 && nums[i] == nums[i-1] && !used[i - 1]) continue;
            used[i] = true; 
            tempList.add(nums[i]);
            backtrack(list, tempList, nums, used);
            used[i] = false; 
            tempList.remove(tempList.size() - 1);
        }
    }
}
Combination Sum : https://leetcode.com/problems/combination-sum/

public List<List<Integer>> combinationSum(int[] nums, int target) {
    List<List<Integer>> list = new ArrayList<>();
    Arrays.sort(nums);
    backtrack(list, new ArrayList<>(), nums, target, 0);
    return list;
}

private void backtrack(List<List<Integer>> list, List<Integer> tempList, int [] nums, int remain, int start){
    if(remain < 0) return;
    else if(remain == 0) list.add(new ArrayList<>(tempList));
    else{ 
        for(int i = start; i < nums.length; i++){
            tempList.add(nums[i]);
            backtrack(list, tempList, nums, remain - nums[i], i); // not i + 1 because we can reuse same elements
            tempList.remove(tempList.size() - 1);
        }
    }
}
Combination Sum II (can't reuse same element) : https://leetcode.com/problems/combination-sum-ii/

public List<List<Integer>> combinationSum2(int[] nums, int target) {
    List<List<Integer>> list = new ArrayList<>();
    Arrays.sort(nums);
    backtrack(list, new ArrayList<>(), nums, target, 0);
    return list;
    
}

private void backtrack(List<List<Integer>> list, List<Integer> tempList, int [] nums, int remain, int start){
    if(remain < 0) return;
    else if(remain == 0) list.add(new ArrayList<>(tempList));
    else{
        for(int i = start; i < nums.length; i++){
            if(i > start && nums[i] == nums[i-1]) continue; // skip duplicates
            tempList.add(nums[i]);
            backtrack(list, tempList, nums, remain - nums[i], i + 1);
            tempList.remove(tempList.size() - 1); 
        }
    }
} 
Palindrome Partitioning : https://leetcode.com/problems/palindrome-partitioning/

public List<List<String>> partition(String s) {
   List<List<String>> list = new ArrayList<>();
   backtrack(list, new ArrayList<>(), s, 0);
   return list;
}

public void backtrack(List<List<String>> list, List<String> tempList, String s, int start){
   if(start == s.length())
      list.add(new ArrayList<>(tempList));
   else{
      for(int i = start; i < s.length(); i++){
         if(isPalindrome(s, start, i)){
            tempList.add(s.substring(start, i + 1));
            backtrack(list, tempList, s, i + 1);
            tempList.remove(tempList.size() - 1);
         }
      }
   }
}

public boolean isPalindrome(String s, int low, int high){
   while(low < high)
      if(s.charAt(low++) != s.charAt(high--)) return false;
   return true;
} 
```
## bit_manipulation_basics

links to check : 
http://graphics.stanford.edu/~seander/bithacks.html
https://leetcode.com/problems/sum-of-two-integers/discuss/84278/A-summary%3A-how-to-use-bit-manipulation-to-solve-problems-easily-and-efficiently

in case the links are not working, adding few important items below.

There is no boolean operator counterpart to bitwise exclusive-or, but there is a simple explanation. The exclusive-or operation takes two inputs and returns a 1 if either one or the other of the inputs is a 1, but not if both are. That is, if both inputs are 1 or both inputs are 0, it returns 0. Bitwise exclusive-or, with the operator of a caret, ^, performs the exclusive-or operation on each pair of bits. Exclusive-or is commonly abbreviated XOR.

- Set union A | B
- Set intersection A & B
- Set subtraction A & ~B
- Set negation ALL_BITS ^ A or ~A
- Set bit A |= 1 << bit
- Clear bit A &= ~(1 << bit)
- Test bit (A & 1 << bit) != 0
- Extract last bit A&-A or A&~(A-1) or x^(x&(x-1))
- Remove last bit A&(A-1)
- Get all 1-bits ~0



Examples
1. Count the number of ones in the binary representation of the given number

```
int count_one(int n) {
    while(n) {
        n = n&(n-1);
        count++;
    }
    return count;
}

```


2. Is power of four

```
bool isPowerOfFour(int n) {
    return !(n&(n-1)) && (n&0x55555555);  // check if it is power of 2 and 
    //check the 1-bit location;          // and & with 10101010101..101 -> power of 4
}

```

3. Sum of Two Integers

```

int getSum(int a, int b) {
	return b==0?a:getSum(a^b,(a&b)<<1);

}
```

4.
Missing Number
Given an array containing n distinct numbers taken from 0, 1, 2, ..., n, find the one that is missing from the array. For example, Given nums = [0, 1, 3] return 2. (Of course, you can do this by math.)

```
int missingNumber(vector<int>& nums) {
    int ret = 0;
    for(int i = 0; i < nums.size(); ++i) {
        ret ^= i;
        ret ^= nums[i];
    }
    return ret^=nums.size();
}
```

5.
Find the largest power of 2 (most significant bit in binary form), which is less than or equal to the given number N.

```
long largest_power(long N) {
    //changing all right side bits to 1.
    N = N | (N>>1);
    N = N | (N>>2);
    N = N | (N>>4);
    N = N | (N>>8);
    N = N | (N>>16);
    return (N+1)>>1;
}
```

6.
Reverse Bits
Reverse bits of a given 32 bits unsigned integer.

Solution

```
uint32_t reverseBits(uint32_t n) {
    unsigned int mask = 1<<31, res = 0;
    for(int i = 0; i < 32; ++i) {
        if(n & 1) res |= mask;
        mask >>= 1;
        n >>= 1;
    }
    return res;
}
```

Another left endian approach

```
uint32_t reverseBits(uint32_t n) {
	uint32_t mask = 1, ret = 0;
	for(int i = 0; i < 32; ++i){
		ret <<= 1;
		if(mask & n) ret |= 1;
		mask <<= 1;
	}
	return ret;
}
```

Another alternative
Just selecting certain bits

Reversing the bits in integer

```
x = ((x & 0xaaaaaaaa) >> 1) | ((x & 0x55555555) << 1);
x = ((x & 0xcccccccc) >> 2) | ((x & 0x33333333) << 2);
x = ((x & 0xf0f0f0f0) >> 4) | ((x & 0x0f0f0f0f) << 4);
x = ((x & 0xff00ff00) >> 8) | ((x & 0x00ff00ff) << 8);
x = ((x & 0xffff0000) >> 16) | ((x & 0x0000ffff) << 16);
```


7.

LHearen's avatar
LHearen
6492
Last Edit: October 26, 2018 12:21 PM

243.4K VIEWS

Wiki
Bit manipulation is the act of algorithmically manipulating bits or other pieces of data shorter than a word. Computer programming tasks that require bit manipulation include low-level device control, error detection and correction algorithms, data compression, encryption algorithms, and optimization. For most other tasks, modern programming languages allow the programmer to work directly with abstractions instead of bits that represent those abstractions. Source code that does bit manipulation makes use of the bitwise operations: AND, OR, XOR, NOT, and bit shifts.

Bit manipulation, in some cases, can obviate or reduce the need to loop over a data structure and can give many-fold speed ups, as bit manipulations are processed in parallel, but the code can become more difficult to write and maintain.

Details
Basics
At the heart of bit manipulation are the bit-wise operators & (and), | (or), ~ (not) and ^ (exclusive-or, xor) and shift operators a << b and a >> b.

There is no boolean operator counterpart to bitwise exclusive-or, but there is a simple explanation. The exclusive-or operation takes two inputs and returns a 1 if either one or the other of the inputs is a 1, but not if both are. That is, if both inputs are 1 or both inputs are 0, it returns 0. Bitwise exclusive-or, with the operator of a caret, ^, performs the exclusive-or operation on each pair of bits. Exclusive-or is commonly abbreviated XOR.

Set union A | B
Set intersection A & B
Set subtraction A & ~B
Set negation ALL_BITS ^ A or ~A
Set bit A |= 1 << bit
Clear bit A &= ~(1 << bit)
Test bit (A & 1 << bit) != 0
Extract last bit A&-A or A&~(A-1) or x^(x&(x-1))
Remove last bit A&(A-1)
Get all 1-bits ~0
Examples
Count the number of ones in the binary representation of the given number

```
int count_one(int n) {
    while(n) {
        n = n&(n-1);
        count++;
    }
    return count;
}
```

Is power of four (actually map-checking, iterative and recursive methods can do the same)

```
bool isPowerOfFour(int n) {
    return !(n&(n-1)) && (n&0x55555555);
    //check the 1-bit location;
}
```

^ tricks
Use ^ to remove even exactly same numbers and save the odd, or save the distinct bits and remove the same.

Sum of Two Integers
Use ^ and & to add two integers

```
int getSum(int a, int b) {
    return b==0? a:getSum(a^b, (a&b)<<1); //be careful about the terminating condition;
}
```

Missing Number
Given an array containing n distinct numbers taken from 0, 1, 2, ..., n, find the one that is missing from the array. For example, Given nums = [0, 1, 3] return 2. (Of course, you can do this by math.)

```
int missingNumber(vector<int>& nums) {
    int ret = 0;
    for(int i = 0; i < nums.size(); ++i) {
        ret ^= i;
        ret ^= nums[i];
    }
    return ret^=nums.size();
}
```

| tricks
Keep as many 1-bits as possible

Find the largest power of 2 (most significant bit in binary form), which is less than or equal to the given number N.

```
long largest_power(long N) {
    //changing all right side bits to 1.
    N = N | (N>>1);
    N = N | (N>>2);
    N = N | (N>>4);
    N = N | (N>>8);
    N = N | (N>>16);
    return (N+1)>>1;
}
```

Reverse Bits
Reverse bits of a given 32 bits unsigned integer.

```
Solution
uint32_t reverseBits(uint32_t n) {
    unsigned int mask = 1<<31, res = 0;
    for(int i = 0; i < 32; ++i) {
        if(n & 1) res |= mask;
        mask >>= 1;
        n >>= 1;
    }
    return res;
}
uint32_t reverseBits(uint32_t n) {
	uint32_t mask = 1, ret = 0;
	for(int i = 0; i < 32; ++i){
		ret <<= 1;
		if(mask & n) ret |= 1;
		mask <<= 1;
	}
	return ret;
}
```

& tricks
Just selecting certain bits

Reversing the bits in integer

```
x = ((x & 0xaaaaaaaa) >> 1) | ((x & 0x55555555) << 1);
x = ((x & 0xcccccccc) >> 2) | ((x & 0x33333333) << 2);
x = ((x & 0xf0f0f0f0) >> 4) | ((x & 0x0f0f0f0f) << 4);
x = ((x & 0xff00ff00) >> 8) | ((x & 0x00ff00ff) << 8);
x = ((x & 0xffff0000) >> 16) | ((x & 0x0000ffff) << 16);
```

Bitwise AND of Numbers Range
Given a range [m, n] where 0 <= m <= n <= 2147483647, return the bitwise AND of all numbers in this range, inclusive. For example, given the range [5, 7], you should return 4.

Solution
```
int rangeBitwiseAnd(int m, int n) {
    int a = 0;
    while(m != n) {
        m >>= 1;
        n >>= 1;
        a++;
    }
    return m<<a; 
}
```
8.
Number of 1 Bits
Write a function that takes an unsigned integer and returns the number of ’1' bits it has (also known as the Hamming weight).

Solution
```
int hammingWeight(uint32_t n) {
	int count = 0;
	while(n) {
		n = n&(n-1);
		count++;
	}
	return count;
}
int hammingWeight(uint32_t n) {
    ulong mask = 1;
    int count = 0;
    for(int i = 0; i < 32; ++i){ //31 will not do, delicate;
        if(mask & n) count++;
        mask <<= 1;
    }
    return count;
}
```


Applications
```
Application
Repeated DNA Sequences
All DNA is composed of a series of nucleotides abbreviated as A, C, G, and T, for example: "ACGAATTCCG". When studying DNA, it is sometimes useful to identify repeated sequences within the DNA. Write a function to find all the 10-letter-long sequences (substrings) that occur more than once in a DNA molecule.
For example,
Given s = "AAAAACCCCCAAAAACCCCCCAAAAAGGGTTT",
Return: ["AAAAACCCCC", "CCCCCAAAAA"].

Solution
class Solution {
public:
    vector<string> findRepeatedDnaSequences(string s) {
        int sLen = s.length();
        vector<string> v;
        if(sLen < 11) return v;
        char keyMap[1<<21]{0};
        int hashKey = 0;
        for(int i = 0; i < 9; ++i) hashKey = (hashKey<<2) | (s[i]-'A'+1)%5;
        for(int i = 9; i < sLen; ++i) {
            if(keyMap[hashKey = ((hashKey<<2)|(s[i]-'A'+1)%5)&0xfffff]++ == 1)
                v.push_back(s.substr(i-9, 10));
        }
        return v;
    }
};
But the above solution can be invalid when repeated sequence appears too many times, in which case we should use unordered_map<int, int> keyMap to replace char keyMap[1<<21]{0}here.

Majority Element
Given an array of size n, find the majority element. The majority element is the element that appears more than ⌊ n/2 ⌋ times. (bit-counting as a usual way, but here we actually also can adopt sorting and Moore Voting Algorithm)

Solution
int majorityElement(vector<int>& nums) {
    int len = sizeof(int)*8, size = nums.size();
    int count = 0, mask = 1, ret = 0;
    for(int i = 0; i < len; ++i) {
        count = 0;
        for(int j = 0; j < size; ++j)
            if(mask & nums[j]) count++;
        if(count > size/2) ret |= mask;
        mask <<= 1;
    }
    return ret;
}
Single Number III
Given an array of integers, every element appears three times except for one. Find that single one. (Still this type can be solved by bit-counting easily.) But we are going to solve it by digital logic design

Solution
//inspired by logical circuit design and boolean algebra;
//counter - unit of 3;
//current   incoming  next
//a b            c    a b
//0 0            0    0 0
//0 1            0    0 1
//1 0            0    1 0
//0 0            1    0 1
//0 1            1    1 0
//1 0            1    0 0
//a = a&~b&~c + ~a&b&c;
//b = ~a&b&~c + ~a&~b&c;
//return a|b since the single number can appear once or twice;
int singleNumber(vector<int>& nums) {
    int t = 0, a = 0, b = 0;
    for(int i = 0; i < nums.size(); ++i) {
        t = (a&~b&~nums[i]) | (~a&b&nums[i]);
        b = (~a&b&~nums[i]) | (~a&~b&nums[i]);
        a = t;
    }
    return a | b;
}
;
Maximum Product of Word Lengths
Given a string array words, find the maximum value of length(word[i]) * length(word[j]) where the two words do not share common letters. You may assume that each word will contain only lower case letters. If no such two words exist, return 0.

Example 1:
Given ["abcw", "baz", "foo", "bar", "xtfn", "abcdef"]
Return 16
The two words can be "abcw", "xtfn".

Example 2:
Given ["a", "ab", "abc", "d", "cd", "bcd", "abcd"]
Return 4
The two words can be "ab", "cd".

Example 3:
Given ["a", "aa", "aaa", "aaaa"]
Return 0
No such pair of words.

Solution
Since we are going to use the length of the word very frequently and we are to compare the letters of two words checking whether they have some letters in common:

using an array of int to pre-store the length of each word reducing the frequently measuring process;
since int has 4 bytes, a 32-bit type, and there are only 26 different letters, so we can just use one bit to indicate the existence of the letter in a word.
int maxProduct(vector<string>& words) {
    vector<int> mask(words.size());
    vector<int> lens(words.size());
    for(int i = 0; i < words.size(); ++i) lens[i] = words[i].length();
    int result = 0;
    for (int i=0; i<words.size(); ++i) {
        for (char c : words[i])
            mask[i] |= 1 << (c - 'a');
        for (int j=0; j<i; ++j)
            if (!(mask[i] & mask[j]))
                result = max(result, lens[i]*lens[j]);
    }
    return result;
}
Attention
result after shifting left(or right) too much is undefined
right shifting operations on negative values are undefined
right operand in shifting should be non-negative, otherwise the result is undefined
The & and | operators have lower precedence than comparison operators
Sets
All the subsets
A big advantage of bit manipulation is that it is trivial to iterate over all the subsets of an N-element set: every N-bit value represents some subset. Even better, if A is a subset of B then the number representing A is less than that representing B, which is convenient for some dynamic programming solutions.

It is also possible to iterate over all the subsets of a particular subset (represented by a bit pattern), provided that you don’t mind visiting them in reverse order (if this is problematic, put them in a list as they’re generated, then walk the list backwards). The trick is similar to that for finding the lowest bit in a number. If we subtract 1 from a subset, then the lowest set element is cleared, and every lower element is set. However, we only want to set those lower elements that are in the superset. So the iteration step is just i = (i - 1) & superset.

vector<vector<int>> subsets(vector<int>& nums) {
    vector<vector<int>> vv;
    int size = nums.size(); 
    if(size == 0) return vv;
    int num = 1 << size;
    vv.resize(num);
    for(int i = 0; i < num; ++i) {
        for(int j = 0; j < size; ++j)
            if((1<<j) & i) vv[i].push_back(nums[j]);   
    }
    return vv;
}
Actually there are two more methods to handle this using recursion and iteration respectively.

Bitset
A bitset stores bits (elements with only two possible values: 0 or 1, true or false, ...).
The class emulates an array of bool elements, but optimized for space allocation: generally, each element occupies only one bit (which, on most systems, is eight times less than the smallest elemental type: char).

// bitset::count
#include <iostream>       // std::cout
#include <string>         // std::string
#include <bitset>         // std::bitset

int main () {
  std::bitset<8> foo (std::string("10110011"));
  std::cout << foo << " has ";
  std::cout << foo.count() << " ones and ";
  std::cout << (foo.size()-foo.count()) << " zeros.\n";
  return 0;
}
```

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



## System_Design



𝟭)𝗕𝗟𝗢𝗢𝗠 𝗙𝗜𝗟𝗧𝗘𝗥
It is a data structure designed to tell you, rapidly and memory-efficiently, whether an element is present in a set.
𝙐𝙨𝙚 𝙘𝙖𝙨𝙚: Build a Web crawler

𝟮)𝗙𝗥𝗨𝗚𝗔𝗟 𝗦𝗧𝗥𝗘𝗔𝗠𝗜𝗡𝗚
It uses only one unit of memory per group to compute a quantile for each group.
𝙐𝙨𝙚 𝙘𝙖𝙨𝙚: Find the nth percentile of the data stream.

𝟯)𝗚𝗘𝗢𝗛𝗔𝗦𝗛/ 𝗦𝟮 𝗚𝗘𝗢𝗠𝗘𝗧𝗥𝗬
A collection of efficient yet exact mathematical predicates for testing relationships among geometric primitives.
𝙐𝙨𝙚 𝙘𝙖𝙨𝙚:Location-based search results with DynamoDb and Geohash.

𝟰)𝗛𝗬𝗣𝗘𝗥𝗟𝗢𝗚𝗟𝗢𝗚
It is an algorithm for the count-distinct problem, approximating the number of distinct elements in a multiset.
𝙐𝙨𝙚 𝙘𝙖𝙨𝙚: privacy-preserving traffic heat map for the city.

𝟱)𝗟𝗘𝗔𝗞𝗬 𝗕𝗨𝗖𝗞𝗘𝗧/ 𝗧𝗢𝗞𝗘𝗡 𝗕𝗨𝗖𝗞𝗘𝗧
A mechanism to control the amount and the rate of the traffic sent to the network.
𝙐𝙨𝙚 𝙘𝙖𝙨𝙚: Design a scalable rate-limiting algorithm.

𝟲)𝗟𝗢𝗦𝗦𝗬 𝗖𝗢𝗨𝗡𝗧
It is used to identify elements in a data stream whose frequency count exceeds a user-given threshold.
𝙐𝙨𝙚 𝙘𝙖𝙨𝙚: Frequency count over the data streams.

𝟳)𝗢𝗣𝗘𝗥𝗔𝗧𝗜𝗢𝗡𝗔𝗟 𝗧𝗥𝗔𝗡𝗦𝗙𝗢𝗥𝗠𝗔𝗧𝗜𝗢𝗡
It is used for supporting a range of collaboration functionalities in advanced collaborative software systems.
𝙐𝙨𝙚 𝙘𝙖𝙨𝙚: Handling editing collision in Google docs.

𝟴)𝗤𝗨𝗔𝗗𝗧𝗥𝗘𝗘/ 𝗥𝗧𝗥𝗘𝗘
It is a two-dimensional analog of octrees and is most often used to partition a two-dimensional space by recursively subdividing it into four quadrants or regions.
𝙐𝙨𝙚 𝙘𝙖𝙨𝙚: find nearby interest points

𝟵)𝗥𝗔𝗬 𝗖𝗔𝗦𝗧𝗜𝗡𝗚
It is the most basic of many computer graphics rendering algo that uses geometric algo of ray tracing.
𝙐𝙨𝙚 𝙘𝙖𝙨𝙚: using longitude and latitude, return the Country of the point.

𝟭𝟬)𝗥𝗘𝗩𝗘𝗥𝗦𝗘 𝗜𝗡𝗗𝗘𝗫
It is an index of keywords that stores records of documents that contain keywords in the list.
𝙐𝙨𝙚 𝙘𝙖𝙨𝙚: Create a complete Tweet index.

𝟭𝟭)𝗥𝗦𝗬𝗡𝗖 𝗔𝗟𝗚𝗢𝗥𝗜𝗧𝗛𝗠
Used for reducing the cost of a file transfer by avoiding the transfer of blocks that are already at the destination.
𝙐𝙨𝙚 𝙘𝙖𝙨𝙚:: Streaming file Sync


 𝐀𝐋𝐋 𝐒𝐘𝐒𝐓𝐄𝐌 𝐃𝐄𝐒𝐈𝐆𝐍 𝐘𝐎𝐔𝐓𝐔𝐁𝐄 𝐂𝐇𝐀𝐍𝐍𝐄𝐋𝐒 𝐓𝐇𝐀𝐓 𝐇𝐀𝐕𝐄 𝐆𝐑𝐄𝐀𝐓 𝐂𝐎𝐍𝐓𝐄𝐍𝐓.

𝟏)𝐁𝐘𝐓𝐄 𝐁𝐘 𝐁𝐘𝐓𝐄
https://lnkd.in/dB3GqYCG

𝟐)𝐓𝐄𝐂𝐇 𝐓𝐀𝐊𝐒𝐇𝐈𝐋𝐀
https://lnkd.in/d8k5jhUj

𝟑)𝐃𝐄𝐅𝐎𝐆 𝐓𝐄𝐂𝐇
https://lnkd.in/dBavD7dv

𝟒)𝐇𝐔𝐒𝐒𝐄𝐈𝐍 𝐍𝐀𝐒𝐒𝐄𝐑
https://lnkd.in/d_eMmmGE

𝟓)𝐒𝐘𝐒𝐓𝐄𝐌 𝐃𝐄𝐒𝐈𝐆𝐍 𝐈𝐍𝐓𝐄𝐑𝐕𝐈𝐄𝐖
https://lnkd.in/dkKDyFUs

𝟔)𝐬𝐮𝐝𝐨𝐂𝐎𝐃𝐄 (by Yogita Sharma )
https://lnkd.in/djxWJtJ9

𝟕)𝐜𝐨𝐝𝐞𝐊𝐚𝐫𝐥𝐞
https://lnkd.in/d37-enAN

𝟖)𝐂𝐌𝐔 𝐃𝐀𝐓𝐀𝐁𝐀𝐒𝐄 𝐆𝐑𝐎𝐔𝐏
https://lnkd.in/dhqHi3nA

𝟗)𝐢𝐧𝐭𝐞𝐫𝐯𝐢𝐞𝐰𝐢𝐧𝐠.𝐢𝐨
https://lnkd.in/d2eciNxC

10)Gaurav Sen
https://lnkd.in/dKTWUJhd

𝟏𝟏)𝐄𝐍𝐆𝐈𝐍𝐄𝐄𝐑𝐈𝐍𝐆 𝐖𝐈𝐓𝐇 𝐔𝐓𝐒𝐀𝐕
https://lnkd.in/d3H4qTHz

𝟏𝟐)𝐌𝐀𝐑𝐓𝐈𝐍 𝐊𝐋𝐄𝐏𝐏𝐌𝐀𝐍𝐍
https://lnkd.in/dWQbAP9c

𝟏𝟑)𝐄𝐗𝐏𝐎𝐍𝐄𝐍𝐓
https://lnkd.in/d3WJTDMS

𝟏𝟒)𝐌𝐈𝐓
https://lnkd.in/dvu5jUWR

𝟏𝟓)𝐓𝐇𝐈𝐍𝐊 𝐒𝐎𝐅𝐓𝐖𝐀𝐑𝐄
https://lnkd.in/dw_zTT9R

𝟏𝟔)𝐒𝐔𝐂𝐂𝐄𝐒𝐒 𝐈𝐍 𝐓𝐄𝐂𝐇
https://lnkd.in/dz76hYDc

𝟏𝟕)𝐓𝐄𝐂𝐇 𝐃𝐔𝐌𝐌𝐈𝐄𝐒 𝐍𝐀𝐑𝐄𝐍𝐃𝐑𝐀 𝐋
https://lnkd.in/dDFd8Wbn

𝟏𝟖)𝐎𝐊𝐓𝐀𝐃𝐄𝐕
https://lnkd.in/dfTW8tHY 
## divide-2-nums-overflow


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
}
```
## International_Org_Sponser_Visa_India


London

    Google
    Amazon
    Apple
    Meta
    Bloomberg
    Spotify
    SnapChat
    Yelp
    Vercel
    Bulb
    Mobiquity
    Expensify
    Free Now
    EF Education First
    Canva
    Intercom
    Curve
    The Lego group
    Plaid
    Transferwise
    Palantir Technologies
    Algolia
    Revolut
    PayFit
    SumUp
    Trainline
    Deliveroo
    Collibra
    Hashicorp

Berlin, Germany

    Amazon
    Zalando
    Ubisoft
    Klarna
    Delivery Hero
    Adnymics
    Hive.app
    N26
    Signavio
    Wayfair
    Free Now
    Trivago
    Babbel
    Personio
    RapidAPI
    HelloFresh
    PayFit
    SumUp
    Taxfix
    Blinkist
    SoundCloud
    Pitch
    Qonto
    Gorillas
    Hashicorp
    Project44
    TradeRepublic

Amsterdam, Netherlands

    Databricks
    Optiver
    Vercel
    Booking.com
    Mobiquity
    Miro
    Plaid
    SumUp
    Gorillas
    Hashicorp

Dublin

    Microsoft
    Amazon
    Vercel
    Verizon Connect
    Free Now
    Intercom
    Meta
    SquareSpace
    DataDog

Luxembourg

    Amazon

Glasgow, Scotland

    JPMC

Warsaw, Poland

    Google
    Glovo

Zurich, Switzerland

    EF Education First

Italy

    Bending spoons

Paris

    BlaBlaCar
    Getaround
    DataDog
    Deezer

Japan

    Mercari
    Fastretailing

Singapore

    Bytedance
    Shopee
    Grab

Bangkok, Thailand

    Agoda

Toronto

    Capital One

Spain

    Taxfix
    Blinkist


## faq_dynamic_programming


```
Dice Throw Problem: Given n dice each with m faces, numbered from 1 to m, find the number of ways to get sum X. X is the summation of values on each face when all the dice are thrown.
 https://leetcode.com/problems/number-of-dice-rolls-with-target-sum/


Coin Change: You are given n types of coin denominations of values v(1) < v(2) < ... < v(n) (all integers). Assume v(1) = 1, so you can always make change for any amount of money C. Give an algorithm which makes change for an amount of money C with as few coins as possible.
Coin Change: https://leetcode.com/problems/coin-change/ and https://leetcode.com/problems/coin-change-2/

Counting Boolean Parenthesizations: You are given a boolean expression consisting of a string of the symbols 'true', 'false', 'and', 'or', and 'xor'. Count the number of ways to parenthesize the expression such that it will evaluate to true. For example, there is only 1 way to parenthesize 'true and false xor true' such that it evaluates to true.

Subset Sum Problem: Given a set of non-negative integers, and a value sum, determine if there is a subset of the given set with sum equal to given sum.

Minimum Number of Jumps: Given an array of integers where each element represents the maximum number of steps that can be made forward from that element, find the minimum number of jumps to reach the end of the array (starting from the first element).
 https://leetcode.com/problems/jump-game-ii/

Two-Person Traversal of a Sequence of Cities: You are given an ordered sequence of n cities, and the distances between every pair of cities. You must partition the cities into two subsequences (not necessarily contiguous) such that person A visits all cities in the first subsequence (in order), person B visits all cities in the second subsequence (in order), and such that the sum of the total distances travelled by A and B is minimized. Assume that person A and person B start initially at the first city in their respective subsequences.

Balanced Partition: You have a set of n integers each in the range 0 ... K. Partition these integers into two subsets such that you minimize |S1 - S2|, where S1 and S2 denote the sums of the elements in each of the two subsets.

https://leetcode.com/problems/partition-equal-subset-sum/


Optimal Strategy for a Game: Consider a row of n coins of values v(1) ... v(n), where n is even. We play a game against an opponent by alternating turns. In each turn, a player selects either the first or last coin from the row, removes it from the row permanently, and receives the value of the coin. Determine the maximum possible amount of money we can definitely win if we move first.
https://leetcode.com/problems/predict-the-winner/


Maximum Value Contiguous Subsequence: Given a sequence of n real numbers A(1) ... A(n), determine a contiguous subsequence A(i) ... A(j) for which the sum of elements in the subsequence is maximized.
https://leetcode.com/problems/maximum-subarray/


Edit Distance: Given two text strings A of length n and B of length m, you want to transform A into B with a minimum number of operations of the following types: delete a character from A, insert a character into A, or change some character in A into a new character. The minimal number of such operations required to transform A into B is called the edit distance between A and B.
 https://leetcode.com/problems/edit-distance/




```
## Database_Selection

Cache
Options: Redis, Memcache
Use: Redis (Redis is an modern version of Memcache). Redis understands data structures like list etc, so performing list append fast in Redis wrt Memcache which sees all values as a blob.

File storage
Why? To store images, videos, files etc. These are blob storages. DBMS is used when we have to query on the data. But file is something we just serve.
Options: S3

Text search engine
Why?
Netflix: search for a movie
Amazon: search for a product
Uber: search for a location
Options: Elastic Search, Solar (build over lucene)
Important: They are search engines, not databases. They give availability and redundancy but no guarantee on data, so data may be lost. Store critical data somewhere else.

Fuzzy text search
Why? User may type wrong spelling. For eg, instead of Airport, may type Ariport.
Options: Elasticsearch, Solar

Timeseries database
Why? For metrics
Options: InfluxDB, OpenTSDB 
Note: These are kind of RDBMS with some customization. In it, user will write always in append-only mode and wont edit old data. Also, queries will be bulk queries on a time range. So, optimized for that.

Data Warehouse/ Big Data
Why? Want to store huge data for analytics. Eg for Amazon, which country giving more revenue, which geography has more transactions, which product sold where most etc.
Options: Hadoop
Note: This is more for offline processing.

RDBMS
Why? When information is structured. And when we need ACID guarantees. For eg, in banking, amount debited but not credited, different account balance for different queries etc
Options: MySQL, PostgreSQL, Oracle

NoSQL (Document DB)
Why? For Amazon, building catalogue. Catalogue can have different type of items with different attributes. Eg, T-shirt, Washing machine, Refrigerator, Milk, Medicine etc. This can be stored as json in RDBMS but NoSQL DBs are designed to handle such kind of queries in a more optimized manner.
Options: MongoDB, CouchBase

NoSQL (Columnar DB)
Why? When data is ever increasing. Eg, Uber drivers keep sending their location data every few minutes. And if drivers keep increasing, data will keep growing exponentially. But queries will be low only on this huge data, like what locations for a given driver id.
Options: Cassandra, Hbase
## google_maps


Below content is taken from https://www.codekarle.com/system-design/Google_Maps-system-design.html 

I have kept it here for personal use only, to have access to it, incase original server is down.


Google maps has surely made life easy for all of us hasn’t it. Whether it is to explore a new city, 
planning a road trip, find the quickest route to the airport, avoid traffic on the way to office! 
Just type in your destination and you have the perfect route! Seems so simple!! But all that goes 
on in the background from typing your destination to getting your route is anything BUT simple. 
So let's have a look at what does go on behind the scenes. Lets design Google Maps today!
Functional Requirements

    To be able to identify roads and routes
    Find distance and ETA while travelling between 2 points
    Should be a pluggable model in case we want to build up on those good to have requirements

Non Functional Requirements

    High Availability - This system can never be down. We don’t want our users to get lost in the 
    middle of nowhere.
    Good Accuracy - The ETA we predict should not deviate too much from the actual time of travel.
    Responds promptly - The response should be ready within a few seconds.
    Scalable - A system like google maps receives huge number of requests per second, so it should 
    be designed in a way that it can handle these requests and any surges in the number of requests.

Challenges while building

    There are millions of roads across the globe. It is a massive data set and not very easily available.
     Maybe not even very accurate.
    Some attributes that can effect ETA are very unpredictable and can not be quantified like road quality,
     accidents, construction work, etc.
    Disputed Areas… but we will come back to this later.

The solution to most of these challenges lies in Dynamic Programming. And this is where we will introduce 
something called Segment.
Segment

A segment is a small area that we can operate on easily. For example, a city can be divided into hundreds 
of segments of size, let’s say, 1km X 1km. Each segment will have four coordinates and based on these 
coordinates we can identify which segment the user is in. We will map the globe into segments, find paths
 within these segments and keep building up our solution till we find the path between two required locations. Just to clarify here, when we say coordinates we mean latitude and longitude of the location. The easiest way to visualise a road network is as a graph, where each junction will be a node and each road will be an edge. Each edge can have multiple weights like distance, time, traffic etc. which we can use to find the shortest/quickest path. From this graph visualisation we can safely say there will be multiple paths between various points, so we will run any of the graph algorithms to find shortest paths between various points within the segment. Also to avoid recalculating these paths again and again, we will cache this information and we will call this shortest path a calculated edge or calculated path.
Google maps system design - segments
Exit of a Segment

We will also cache the distances and calculated edges of each vertex from exit points of the segment. 
Once we know the distance from segment exits we can easily calculate inter-segment distances.

When we are navigating inter-segment, it is important that we identify how many segments we need to consider
 for our algorithm, because we can’t run a Dijkstra’s for all the segments across the globe. To restrict 
 the number of segments we use the aerial distance between the 2 points. Suppose aerial distance between 
 points A and B is 10km, we can consider 10 segments across each direction i.e 400 segments, which is 
 much better than the otherwise massive graph.

Once the number of segments is restricted, we can restrict our graph such that the exit points of each 
segment will become the vertices of the graph and the calculated paths between the two points and all 
the exit points will become the edges of the graph. Now all we need to do to find the route is run a 
Dijkstra’s on this graph.
Mega Segment

So we have now divided the map into segments and we know how to calculate inter-segment routes. But what 
if the route spans over thousands of segments. Running Dijkstra’s on this huge graph will be very time 
consuming. So we introduce another level of nesting called Mega Segments. We will now divide the map 
into mega-segments which will be further divided into segments. Similar to how we cached calculated 
edges between exit points for segments, we will also cache calculated paths between exit points for 
mega-segments and run dijktra’s on this graph of exit points of mega segments.

Now that we have a graph, how do we come up with weights for the edges? As we mentioned previously, 
our edges can have multiple weights. There can be -

    Distance
    ETA
    Average Speed

We will not consider traffic, weather etc as weights because the are not that easily quantifiable. 
Instead we will consider them as attributes that can effect the average speed. But now the question 
is how to update the route when traffic/weather conditions change? Any change in these attributes 
will change the average speed and in turn the ETA. As soon as the weight(ETA, avg speed) of the edges 
is impacted the computed paths are recalculated to come up with a new route. This recalculation is 
only done when the weight changes more than a threshold percentage. For eg, if the ETA changes by 
more than x%, we will recalculate the path, otherwise we will stick to the current route.

And that is the algorithm used by google maps to compute the route between two points. Now let us 
have a look at the system architecture.
System Architecture

For ease of understanding we will understand the architecture in two parts. First we will see how 
the users are connected to the application and how their location information is captured. In the 
next part we will see the architecture for navigation flow.
Google maps system architecture design

    Capturing user location information Google maps system design capture user location information
            If the user’s location setting is On, we will get regular pings from them.
            We have a Web socket handler service that talks to all user devices.
            Due to the large number of users, one web socket handler is not enough for our system. 
            Multiple Web socket handlers will talk to different users. A Web socket manager will 
            keep track of which handler is talking to which device.
            A Redis which is connected to the web socket manager will store all this information.
            We have a location service which is a repo of all location related information that 
            we collect from the users.
            The location service will store all this location permanently in a Cassandra data store.
            As we receive location pings from user, Location service will send pings to Kafka.
            All location pings coming into Kafka will be read by a spark streaming service, which 
            can then use this information to add unidentified roads in our data, identify hot spots, 
            identify change in avg speed etc.
            If a new road needs to be added, spark streaming service will send a ping to Kafka which 
            in turn will tell the map update service. Map update service will update segments related 
            information in Cassandra data store with the help of graph processing service.
            If spark streaming service identifies any change in avg speed it writes to Kafka which 
            communicates with traffic update service.
            Traffic update service again talks graph processing service to recalculate the new paths
             and update in Cassandra data store.
            All this constantly flowing data to spark streaming service is also dumped in a Hadoop
             cluster from where it can be used for other jobs like user profiling, running ML algorithms
              to identify size of new roads, to identify how many two wheelers or four wheelers are 
              travelling the road etc.

    User navigation flow Google maps user navigation flow architecture design
            An area search service will convert address or area searched by the user to lat long coordinates.
            A navigation service will keep track of user while they are travelling and send notifications 
            if the user deviates from the suggested path.
            A map service will receive navigation requests from the users and forward it to the graph 
            processing service.
            Graph processing service will talk to segment service which talks to Cassandra to get the 
            segment related information.
            If the Graph processing service has the cached route, it will immediately respond back 
            otherwise it will start processing further, for which it takes information from Cassandra.
            The Graph processing service will also receive notifications from third party data managers 
            for live traffic, weather, accident related data. If this data is not available it might also 
            query the historical data service for ETA.
            Historical data service will maintain ETA related info according to the days and hours in a 
            Cassandra data store, which can be used to identify ETA when traffic related information is 
            not available.
            Once GPS has a route it will communicate the response to the Map service will will further 
            communicate with the user.
            Now through this flow Kafka has been constantly receiving events for each search.This data 
            can be used to identify information like which are the popular areas, what are the most 
            frequented areas for each users, etc. This data we can use to do some optimisations or even 
            for user profiling. This data can also be used to identify hoe reliable our third party 
            services are. For example, if the ETA as per our traffic service is does not match with 
            the real time information we are recording from the user, then that service is not reliable.
            Kafka also interacts with the spark streaming service to runs some real time analytics 
            like which road the user is on, which of our routes are unpopular etc.

And that is all from architecture point of view. I am sure you guys have some questions about why we are 
using which service like why Redis, why Cassandra, why Kafka. Well that is content for another article. 
We have written an article on Choosing The Best Storage Solutions For Your Requirements. You can go through
 it to understand when to use which databases or services and their alternatives.

Now if you remember when we discussed some of the challenges while building this system, we mentioned 
something called Disputed areas.
Disputed Areas...? What is that!

Let us consider the example of the dispute between the countries of India, China and Pakistan over the 
state of Kashmir. How does Google mark the boundaries of the state when Pakistan claims some part of the
 state belongs to them, China makes similar claims about another part of the state while India claims 
 whole of Kashmir is under their jurisdiction. Here Google does something really cool. They mark the 
 boundaries based on the country you are coming from! If the user is coming from India, whole of Kashmir 
 will be marked as a part of India, where as if the user is travelling from Pakistan, the part that 
 Pakistan claims to be under their territory is marked as Pakistan’s land and the part that is disputed
  between India and china is marked as a dotted line and same for China.

## Amazon_OA

There were 2 questions, to be completed in 90 minutes.

Q1. Given a sequence of coins each one facing upward (Head) or downward (Tail), we say it is a 'beautiful' sequence if all heads are before the tails.
More formally, a beatiful sequence is of the form HH...TTT. For example HHTT, HHHTT, HTTT are beatiful sequences while HHTHT, THHTT are not.
Note that also only heads or only tails sequence are considered beautiful, e.g. HHH or TTT.
Write a program that takes as input a string representing the coins sequence and output the minimum number of coin flips (H -> T or T->H) necessary to make the sequence beatiful.

For example, given the sequence HHTHTT, the answer should be 1 since it sufficient to flip the last H to make it beatiful (HHTTTT).

Ans - Can be solved using https://leetcode.com/problems/flip-string-to-monotone-increasing/ replacing "0" with "H" and "1" with "T".

Q2. Given an array ranks of ranks of students in a school. All students need to be split into groups k. Find the total 'imbalance' of all groups. An imabalance of a group can be found as :

    Sorting each group in the order of their ranks.
    A group contributes to imbalance if any 2 students in the sorted array have a rank difference of more than 1.

Find the total sum of imbalance of all such groups.

This is the example that was given :
[4,1,3,2]
[1] contributes 0 to imbalance
[2] contributes 0 to imbalance
[3] contributes 0 to imbalance
[4] contributes 0 to imbalance
[4,1] contributes 1 to imbalance
[4,3] contributes 0 to imbalance
[4,2] contributes 1 to imbalance
[4,1,3,2] contributes 0 to imbalance
[1,3] contributes 1 to imbalance
[1,2] contributes 0 to imbalance
[3,2] contributes 0 to imbalance
Answer = 1 + 1 + 1 = 3


```
public static long imbalance(List<Integer> rank) {
	long imbalance = 0;
	int r = 0;
	TreeSet<Integer> set = new TreeSet<>();
	while(r < rank.size()-1) {
		set.clear();
		set.add(rank.get(r));
		long curImbalance = 0;
		for(int i=r+1; i<rank.size(); i++) {
			Integer e = rank.get(i);
			set.add(e);
			Integer f = set.lower(e);
			Integer c = set.higher(e);
			
			if(f == null) { // added at beginning
				curImbalance += (((c - e) > 1) ? 1 : 0);
			}
			else if(c == null) {// added at end
				curImbalance += (((e - f) > 1) ? 1 : 0);
			}
			else {
				curImbalance += (c - f) > 1 ? -1 : 0;
				curImbalance += (((c - e) > 1) ? 1 : 0);
				curImbalance += (((e - f) > 1) ? 1 : 0);
			}
			imbalance += curImbalance;
		}
		r++;
	}
	return imbalance;
}


def numswaps(binary):
    n = len(binary)
    count = 0 
    for i in range(n // 2):
        if binary[i] != binary[n - i - 1]:
            count += 1
    if count % 2 == 1 and n % 2 == 0:
        return -1
    return (count + 1) // 2

```
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

## ubs_interview

## Hotstar_Interview

- Coding round 1
Min Steps to target
https://leetcode.com/problems/word-ladder/

A transformation sequence from word beginWord to word endWord using a dictionary wordList is a sequence of words beginWord -> s1 -> s2 -> ... -> sk such that:

    Every adjacent pair of words differs by a single letter.
    Every si for 1 <= i <= k is in wordList. Note that beginWord does not need to be in wordList.
    sk == endWord

Given two words, beginWord and endWord, and a dictionary wordList, return the number of words in the shortest transformation sequence from beginWord to endWord, or 0 if no such sequence exists.

 

Example 1:

Input: beginWord = "hit", endWord = "cog", wordList = ["hot","dot","dog","lot","log","cog"]
Output: 5
Explanation: One shortest transformation sequence is "hit" -> "hot" -> "dot" -> "dog" -> cog", which is 5 words long.

Example 2:

Input: beginWord = "hit", endWord = "cog", wordList = ["hot","dot","dog","lot","log"]
Output: 0
Explanation: The endWord "cog" is not in wordList, therefore there is no valid transformation sequence.

 

Constraints:

    1 <= beginWord.length <= 10
    endWord.length == beginWord.length
    1 <= wordList.length <= 5000
    wordList[i].length == beginWord.length
    beginWord, endWord, and wordList[i] consist of lowercase English letters.
    beginWord != endWord
    All the words in wordList are unique.



Solution as png in gitrepo

- Coding round 2

given a string A>B;B>C;C>A -> Invalid | A>B;B>C;A>C -> Valid
evalue the list of expressions as valid or invalid.

solution : 2 hashmaps to save parent + child & child- parent mapping and iterate to check if child is already a parent to value. return false.





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


## Ainterview_WquestionS

## AWS_CERTIFICATION


FREE AWS solution architect:

1. AWS Certified Solutions Architect Associate Introduction
https://lnkd.in/d4eR5gsW
2. Amazon Web Services - Learning and Implementing AWS Solution
https://lnkd.in/dATppQUa
3. Amazon Web Services (AWS) - Zero to Hero
https://lnkd.in/dMM9CgmU
4. Starting your Career with Amazon AWS
https://lnkd.in/dU7RYfJb
5. Amazon AWS Core services- EC2, VPC, S3, IAM, DynamoDB, RDS
https://lnkd.in/diRYukpz
6. Learn Amazon Web Services (AWS) easily to become Architect
https://lnkd.in/d4wx6yYv
7. Amazon Web Services (AWS) EC2: An Introduction
https://lnkd.in/drUvNuFk
8. Amazon Web Services (AWS): CloudFormation
https://lnkd.in/dAc65c-H
9. AWS VPC Transit Gateway - Hands On Learning!
https://lnkd.in/dTzjiTVv
10. Introduction to Cloud Computing for Beginners in 30 mins
https://lnkd.in/dfzCaPEN
11. AWS Lambda - from ZERO to HERO
https://lnkd.in/dfBRy2NE
12. Cloud Computing With Amazon Web Services
https://lnkd.in/dGD3FnAW
13. Amazon AWS Cloud IAM Hands-On
https://lnkd.in/ddSBhiST
14. Master Amazon EC2 Basics with 10 Labs
https://lnkd.in/d9jQ6cmN
15. Multitier architecture with AWS
https://lnkd.in/diKgCeSW
16. Create and manage VPC on AWS Cloud
https://lnkd.in/dumuhvnG
17. Mastering AWS: Featuring IAM
https://lnkd.in/dUs4NZeV
18. AWS + Serverless
https://lnkd.in/dtGAZmUK
19. Amazon AWS Cloud EC2 Hands-On
https://lnkd.in/dTc93nkq
20. A Practical Introduction to Cloud Computing
https://lnkd.in/dSMcrC_U
21. Hosting your static website on Amazon AWS S3 service
https://lnkd.in/dBw4RKs2
22. AWS Tutorials - DynamoDB and Database Migration Service
https://lnkd.in/dhSY8j7T
23. Getting Started with Amazon Web Services
https://lnkd.in/dvabaewb
24. Build and Deploy a LAMP server on AWS
https://lnkd.in/dNP6msQy
25. All About AWS Lambda and Serverless
https://lnkd.in/dip9ZWm5
26. Serverless computing in AWS
https://lnkd.in/dGsj5JTm

## druva


first round happend 2 weeks back via interviewvector
question:
in a sorted  rotated array find the number in log n complextiy.

```
\\ buggy solution
class Test {
    public int search(int[] nums, int target) {
        
        
        int start =0, end = nums.length-1;
        int prevMax = Integer.MIN_VALUE;
        
        if(nums[start] == target)
        	return start;
        else if(nums[end] == target)
        	return end;
        while(start<end){
            int mid =  start + (end-start)/2;
            if(nums[mid] == target)
            	return mid;
            if(nums[mid] >nums[mid-1] && nums[mid] > nums[mid+1]) {
            	prevMax = mid;
            	break;
            }
            	
            if(nums[prevMax] <nums[mid] && nums[mid] > nums[start] && nums[mid]> nums[end]){
                prevMax= mid;
                start = mid+1;
            }else if(nums[mid]<nums[start] && nums[mid]<nums[end]){
                end = mid;
            }
        }
        
        if(target >= nums[start] && target <= nums[prevMax]) {
        	end = start;
        	start = 0;
        }
        else if(target<nums[start] && target>= nums[start+1])
        {
        	end = nums.length-1;
        }
        
        while(start<end) {
        	int mid = start + (end-start)/2;
        	if(nums[mid] < target)
        		start = mid+1;
        	else if(nums[mid]> target)
        		end = mid;
        }
		return nums[start] ==target? start :-1;
    }
    
    public static void main(String[] args) {
    	
    	int[] arr = { 3, 6, 9, 11 ,0, 1,2};
		new Test().search(arr, 0);
	}
}
```



Round 2 time 1: hour
Interviewer was late,  after joining spent 5 more minutes in system setup, I was left with 45-50 mins.
Intro + rate myself another 5 mins
question 1: dbms
```
Student table
name id 

Subject Table
id name 

Result table

sub_id student_id marks


Expeceted get toppers names, marks of each subject, in case of tie get all student names:

Questions 2 :

write jaava program to print a tree in zig zag manner :


he wanted to ask questions from Networking and Operating system as well. But time got over


Not recommended




## NMiro

https://leetcode.com/problems/meeting-rooms-ii/
Given an array of meeting time intervals intervals where intervals[i] = [starti, endi], return the minimum number of conference rooms required.

 

Example 1:

Input: intervals = [[0,30],[5,10],[15,20]]
Output: 2

Example 2:

Input: intervals = [[7,10],[2,4]]
Output: 1


## deliveryHero

Round 1
HR Shortlist, few technical questions

Round 2
Coding round + project and system understanding
question : reorder colors according to the given ordering sequence i.e.
given : List<String> colors & List<String> ordering . reorder colors list

e.g. colors: black blue green black blue green red
     ordering: black blue green
     output: black black blue blue green green red


## 1671. Minimum Number of Removals to Make Mountain Array


You may recall that an array arr is a mountain array if and only if:

    arr.length >= 3
    There exists some index i (0-indexed) with 0 < i < arr.length - 1 such that:
        arr[0] < arr[1] < ... < arr[i - 1] < arr[i]
        arr[i] > arr[i + 1] > ... > arr[arr.length - 1]

Given an integer array nums​​​, return the minimum number of elements to remove to make nums​​​ a mountain array


eg
Input: nums = [2,1,1,5,6,2,3,1]
Output: 3
Explanation: One solution is to remove the elements at indices 0, 1, and 5, making the array nums = [1,5,6,3,1].


Solution
nlogn

```
class Solution {
    public int minimumMountainRemovals(int[] nums) {
        int n = nums.length, lbs = 0; // lbs -> longest bitomic subsequence
        int [] left = new int[n], right = new int[n]; // dp[i] -> lis end at index i, dp2[i] -> lds end at index i
        List<Integer> lis = new ArrayList<>();
        
        for(int i=0;i<n-1;i++){
            
            
            if(lis.isEmpty() || lis.get(lis.size()-1) < nums[i])
                lis.add(nums[i]);
            else{
                int ind = Collections.binarySearch(lis,nums[i]);
                if(ind<0)
                    lis.set(-ind-1, nums[i]);
            }
            left[i] = lis.size();
            
        }
        
        lis = new ArrayList<>();
        for(int i=n-1;i>=1;i--){
                                    
            if(lis.isEmpty() || lis.get(lis.size()-1) < nums[i])
                lis.add(nums[i]);
            else{
                int ind = Collections.binarySearch(lis,nums[i]);
                if(ind<0)
                    lis.set(-ind-1, nums[i]);
            }
            right[i] = lis.size();
            
            if(left[i]>1 && right[i]>1)
                lbs = Math.max(lbs, left[i]+right[i]-1);
        }

        return n-lbs;
    }
    
}
```

## leetcode_bookmark

https://leetcode.com/discuss/study-guide/448285/List-of-questions-sorted-by-common-patterns.



    2 Heaps https://leetcode.com/list/xlemvyvd
    Arrays https://leetcode.com/list/xleo1moc
    Backtracking https://leetcode.com/list/xlere2g3
    Dynamic Programming https://leetcode.com/list/xlern30i
    Fast & Slow pointers https://leetcode.com/list/xlerlepr
    Graph Traversal https://leetcode.com/list/xler60c5
    In-place traversal of LL https://leetcode.com/list/xler4hke
    K-way merge https://leetcode.com/list/xlepm8xi
    Merge Intervals https://leetcode.com/list/xlepvmyj
    Modified Binary Search https://leetcode.com/list/xleplgq3
    Sliding window https://leetcode.com/list/xlep8di5
    Top K elements https://leetcode.com/list/xlepz4mv
    Topological Sorting https://leetcode.com/list/xlepbnhh
    Tree BFS https://leetcode.com/list/xlepfebm
    Tree DFS https://leetcode.com/list/xlemouqi
    Two Pointers https://leetcode.com/list/xlemouqi




## booking_interview
1. Online Assesment for 3 lc medium level questions

2. F2F virtual interview with 3 persons.
Questions based on Currency Conversion

given a table of currency conversions amount and source and target currency with given amount. return exchanged amount in target currency.

Additionaly, there  is a surcharge tax on each txn, so if 
1 EUR = 1.1 INR
1 INR = 10 USD
->
1 EUR = 11 USD - 0.2*2 txn = 0.7 uSD

Add on : return no of txn happened in the process.

## BuyAndSellStocks
refernce from https://leetcode.com/problems/best-time-to-buy-and-sell-stock-iii/discuss/1326824/Complete-explanation-of-the-Buy-and-Sell-Stock-problems-using-DP. 

I will be going over what I have learned while trying to solve these problems. I was initially using Kadane's algorithm to do these problems. Infact, completed the first, second, and third Buy and Sell Stock problems using Kadane's but the fourth problem gave me a concussion so, I embarked on a journey to learn a framework using which I can solve the complete set of these problems and handle any tweaks that an interviewer might throw at me in the future. I visited a number of resources, watched a number of videos and here is the culmination of everything I have picked so far.

These are all the problems we have in the Buy and Sell Stock set.

    Best Time to Buy and Sell Stock
    Best Time to Buy and Sell Stock II
    Best Time to Buy and Sell Stock III
    Best Time to Buy and Sell Stock IV
    Best Time to Buy and Sell Stock with Cooldown
    Best Time to Buy and Sell Stock with Transaction Fee

First, we will see how we can come up with a framework which we can apply for all the above problems. A framework which is flexible enough to accomodate any tweaks an interviewer might throw at us in the future. A framework which exhausts all the possible outcomes and then come up with the best solution. A recursive solution would be exhaustive but we will use "states" for exhaustion in these problems. We will consider each day and see how many possible "states" do we have for each day and then find "choices" corresponding to each state.

Let's talk about the constraints first.

    Sell must be after Buy.
    Buy must be after Sell.
    Limit on the number of transaction(k), k>0.

For each day we have three choices.

    Buy.
    Sell.
    Rest. Which further has two states.
    a. Rest after buy. Here we are holding the stock. We are not selling or buying. We are just resting.
    b. Rest after selling. Here we are not holding any stocks. We are not selling or buying. We are just resting.

Let's talk about the states now.

    The day we are on i.e i.
    The maximum number of allowed transactions i.e k.
    The holding state i.e the resting state we talked about before. This is either 1(holding stock) or 0(not holding stock).

Now, we can put all the combinations of these states in a 3D matrix like so :

for 0 <= i <= n:             // n is the number of days
	for i <= k <= k:        // k is the maximum number of transactions
		for s in {1,0}:    // s is the rest state
				dp[i][k][s] = max(buy,sell,rest)

For every problem we have to find the dp[n-1][k][0], which is the maximum profit for the maximum number of transactions allowed on the last day.

One important observation. Why didn't we say dp[n-1][k][1] instead of saying dp[n-1][k][0]? because if the resting state S is 1, it means we are still holding a stock and the profit cannot be maximum until and unless we are done selling all the stocks we have.

Now, let's think about what choices do we have for each state and how we can update the "state". Let's write our state transition equations. They will be something like this.

dp[i][k][0] = Max(dp[i-1][k][0], dp[i-1][k][1] + prices[i]) // prices is the array of stocks

This equation corresponds to when you are not holding a stock. You are not holding a stock today because perhaps you didn't have any stocks yesterday which we could sell today or maybe you have stocks that you want to sell today, so at the end of the day we will not be holding any stocks.

dp[i][k][1] = Max(dp[i-1][k][1], dp[i-1][k-1][0] - prices[i])

This equation corresponds to when you are holding a stock. You are holding a stock today because perhaps you had stocks yesterday or maybe you want to buy stocks today, so at the end of the day we will be holding stocks.

This explanation should be clear. If you buy, you need to subtract prices[i] from the profit, and if you sell, you need to increase prices[i] to the profit.

Now, let's talk about the base cases.

    dp[-1][k][0] = 0 // Because the day starts with 0 and here i is -1
    dp[-1][k][1] = -Infinity // Because we can't hold any stocks before the first day
    dp[i][0][0] = 0 // Because k = 0. There won't be any transactions so the profit will be zero
    dp[i][0][1] = -Infinity // Because k = 0. We can't hold any stocks without starting a transaction

So, to summarize the above base conditions and state transition equations

base case：
dp[-1][k][0] = dp[i][0][0] = 0
dp[-1][k][1] = dp[i][0][1] = -infinity

state transition equation：
dp[i][k][0] = max(dp[i-1][k][0], dp[i-1][k][1] + prices[i])
dp[i][k][1] = max(dp[i-1][k][1], dp[i-1][k-1][0] - prices[i])

Now, let's begin with the problems.

    When k = 1

We will put k = 1 directly in the state transition equations and see for ourselves.

dp[i][1][0] = Max(dp[i-1][1][0], dp[i-1][1][1] + prices[i];
dp[i][1][1] = Max(dp[i-1][1][1], dp[i-1][0][0] - prices[i];
	        = Max(dp[i-1][1][1], 0 - prices[i];  // from the above base case when k is 0

We can also see that the presence of k when it is 1 does not change the state in any way so, we can simply ignore it.

dp[i][0] = max(dp[i-1][0], dp[i-1][1] + prices[i])
dp[i][1] = max(dp[i-1][1], -prices[i])

We can write the solution for it like so:

var maxProfit = function(prices){
  let n = prices.length;
  let dp = [];
  
  for(let i=0; i<n; i++){
    dp[i] = [];
    if(i-1 === -1){
      dp[i][0] = 0; 
        // Explanation：
        //   dp[i][0] 
        // = max(dp[-1][0], dp[-1][1] + prices[i])
        // = max(0, -infinity + prices[i]) = 0
      dp[i][1] = -prices[i];
        // Explanation：
        //   dp[i][1] 
        // = max(dp[-1][1], dp[-1][0] - prices[i])
        // = max(-infinity, 0 - prices[i]) 
        // = -prices[i]
      continue;
    }
    dp[i][0] = Math.max(dp[i-1][0], dp[i-1][1] + prices[i]);
    dp[i][1] = Math.max(dp[i-1][1],  -prices[i])
  }
  return dp[n-1][0];
}

We can reduce the Space complexity to 0(1) by not constructing the DP matrix as the new state is only related to an adjacent state. So, instead of the DP matrix we can store the states in a single variable. One variable for not holding and one for holding.

Code for that would look something like :

var maxProfit = function(prices){
  let d_i10 = 0;
  let d_i11 = -Infinity;
  
  for(let i=0; i<prices.length;i++){
    d_i10 = Math.max(d_i10, d_i11 + prices[i]);
    d_i11 = Math.max(d_i11, 0 - prices[i]);
  }
  return d_i10;
}

    When k = + Infinity

When k is Infinity, k and k-1 are practically the same. We will use that in our state transition equations.

dp[i][k][0] = max(dp[i-1][k][0], dp[i-1][k][1] + prices[i])
dp[i][k][1] = max(dp[i-1][k][1], dp[i-1][k-1][0] - prices[i])
            = max(dp[i-1][k][1], dp[i-1][k][0] - prices[i]) // k and k-1 are the same

Since, the presence of k is not really impacting the states, we will ignore it.

dp[i][0] = max(dp[i-1][0], dp[i-1][1] + prices[i])
dp[i][1] = max(dp[i-1][1], dp[i-1][0] - prices[i])

And the solution would look like this :

var maxProfit = function(prices){
  let d_ik0 = 0;
  let d_ik1 = -Infinity;
  
  for(let i=0;i<prices.length;i++){
    d_ik0 = Math.max(d_ik0 , d_ik1 + prices[i]);
    d_ik1 = Math.max(d_ik1, d_ik0 - prices[i]);
  }
  return d_ik0;
}

    When k = 2

Now, we need to exhaust the value of k as well. Before this we were ignoring k because it was not impacting our states. We need to hold the states for the second transaction as well along with the first transaction.

dp[i][2][0] = max(dp[i-1][2][0], dp[i-1][2][1] + prices[i])
dp[i][2][1] = max(dp[i-1][2][1], dp[i-1][1][0] - prices[i])
dp[i][1][0] = max(dp[i-1][1][0], dp[i-1][1][1] + prices[i])
dp[i][1][1] = max(dp[i-1][1][1], -prices[i])

The solution would look like this :

var maxProfit = function(prices){
  let d_i20 = 0;
  let d_i21 = -Infinity; // base case for second transaction
  let d_i10 = 0;
  let d_i11 = -Infinity; //base case for second transaction
  
  for(let i=0; i<prices.length; i++){
    d_i10 = Math.max(d_i10, d_i11 + prices[i]);
    d_i11 = Math.max(d_i11,  0 - prices[i]);
    d_i20 = Math.max(d_i20, d_i21 + prices[i]);
    d_i21 = Math.max(d_i21, d_i10 - prices[i]);
   
  }
  return d_i20
}

    When k = + interger

Important observation : A transaction consists of buying and selling, which takes atleast 2 days. Therefore, the effective limit k should not exceed n/2( n is the number of days). If it exceeds, there is no contraint effect which makes k equivalent to +Infinity.

This is the only problem from this set which is a little difficult.

Solution would look like this

var maxProfit = function(k, prices) {
    if(prices.length == 0) return 0;
    
    // When k becomes so much larger than the number of prices we can make transactions whenever.
    if(k > (prices.length / 2) ){
      let d_ik0 = 0;
      let d_ik1 =  -Infinity;
      for(let i =0; i<prices.length;i++){
        d_ik0 = Math.max(d_ik0, d_ik1 + prices[i]);
        d_ik1 = Math.max(d_ik1, d_ik0 - prices[i]);
      }
      return d_ik0
    }
    else{
        let dp = [];
        let size = prices.length;
        for(let i=0; i<size; i++){
          dp[i] = [];
          for(let j=0; j<=k; j++){
            dp[i][j] = []
            if(i-1 === -1 || j-1 === -1){
              dp[i][j][0] = 0;
              dp[i][j][1] = -prices[i];
              continue;
            }
            dp[i][j][0] = Math.max(dp[i-1][j][0], dp[i-1][j][1] + prices[i]);
            dp[i][j][1] = Math.max(dp[i-1][j][1], dp[i-1][j-1][0] - prices[i])
          }
        }
      return dp[size-1][k][0]
    }
};

    When k = +Infinity with cooldown

We must wait one day after selling a stock to continue trading. We can write the state transition equations as :

dp[i][0] = max(dp[i-1][0], dp[i-1][1] + prices[i])
dp[i][1] = max(dp[i-1][1], dp[i-2][0] - prices[i])
Explanation: When we choose to buy on day i, the state of i-2 should be transferred instead of i-1

Code would look like

var maxProfit = function(prices){
  let d_ik0 = 0;
  let d_ik1 = -Infinity;
  let d_ik0_pre = 0;
  
  for(let i=0;i<prices.length;i++){
    let d_ik0_old = d_ik0; 
    d_ik0 = Math.max(d_ik0 , d_ik1 + prices[i]);
    d_ik1 = Math.max(d_ik1, d_ik0_pre - prices[i]);
    d_ik0_pre = d_ik0_old;
  }
  return d_ik0;
}

    When k = +Infinity with transaction fee

Since now we need to pay some fee for each transaction made, the profit after buying or selling the stock on the i-th day should be subtracted by this amount, therefore the new recurrence relations will be either

dp[i][k][0] = max(dp[i-1][k][0], dp[i-1][k][1] + prices[i])
dp[i][k][1] = max(dp[i-1][k][1], dp[i-1][k][0] - prices[i] - fee)

or

dp[i][k][0] = max(dp[i-1][k][0], dp[i-1][k][1] + prices[i] - fee)
dp[i][k][1] = max(dp[i-1][k][1], dp[i-1][k][0] - prices[i])

Code can we written as :

var maxProfit = function(prices, fee){
  let d_ik0 = 0;
  let d_ik1 = -Infinity;
  
  for(let i=0;i<prices.length;i++){
    d_ik0 = Math.max(d_ik0 , d_ik1 + prices[i]);
    d_ik1 = Math.max(d_ik1, d_ik0 - prices[i] - fee);
  }
  return d_ik0;
}


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
## qualays_2nd_interview




fr : create student management system
  1. Student 
  2. Courses
  3. Admission
  
  
  @NoArgConstructor
  @Getter
  @Setter
  class Student{
  	String studentName
  	String id
  	String class
  	string Section 
  	
  
  }
  
  @NoArgConstructor
  @Getter
  @Setter
  class Subject{
  	int id;
  	String subjectName;
  	
  }
    @NoArgConstructor
  @Getter
  @Setter
  class Batch{
  	int id;
  	Character section;
  	List<Student> listOfStudents;
  
  
  }
  
  @NoArgConstructor
  @Getter
  @Setter
  class School{
  	List<Batch> allBatchStudents;
  	String principalName;
  	String directorName;
 	String address;
 	String rating;
 	String isApproved;
 	String schoolName;
 	Long id;
 	
 	getSchool
  
  }
  
  // Ui - backend
  // backend to dbms
  
  
  1234
  
  4  123
  43 12
  4321
  

## sas_interview

Neeed for functional Interface
Ms database commit transaction rollback
Rest API requirement


```

@FunctionalInterface
interface MyRunnable{

	public void run();
}


@FunctionalInterface
interface MyRunnable1{

	public void run();
}


main(){
MyRunnable obj = ()->sout("done")
Thread t= new Thread(obj)

Thread t1= new Thread(obj)


}
```
// completablefuture java 8
// react
// hoisting
// hook

main(){
int[] arr = {1,2,3,4,5}; 4
               1 2 3 4

}


``` 
public int[] fun(int rotate, int[] arr){
int[] tmp = new int[arr.length];
if(rotate ==0)
return arr;
if(rotate>arr.length)
	rotate %= arr.length;
	
int j= 0;	
for(int i=rotate;i<arr.length;i++){
	tmp[i] = arr[j++];
}
//1  
    51234
    
//2 12345  // 4 //2
    45123 
    
//   i     1 2 
     j     0 1

for(int i=0;i<rotate;i++)
	tmp[i] = arr[j++];

return tmp;
}

```
## paws


You are given n tasks labeled from 0 to n - 1 represented by a 2D integer array tasks, where tasks[i] = [enqueueTimei, processingTimei] means that the 
ith task will be available to process at enqueueTimei and will take processingTimei to finish processing.
You have a single-threaded CPU that can process at most one task at a time and will act in the following way:
If the CPU is idle and there are no available tasks to process, the CPU remains idle.
If the CPU is idle and there are available tasks, the CPU will choose the one with the shortest processing time. If multiple tasks have the same shortest
processing time, it will choose the task with the smallest index.
Once a task is started, the CPU will process the entire task without stopping.
The CPU can finish a task then start a new one instantly.
Return the order in which the CPU will process the tasks.
 
Example 1:
Input: tasks = [[1,2],[2,4],[3,2],[4,1]]    //[enqueueTimei, processingTimei]
Output: [0,2,3,1] 
Explanation: The events go as follows: 
- At time = 1, task 0 is available to process. Available tasks = {0}.
- Also at time = 1, the idle CPU starts processing task 0. Available tasks = {}.
- At time = 2, task 1 is available to process. Available tasks = {1}.
- At time = 3, task 2 is available to process. Available tasks = {1, 2}.
- Also at time = 3, the CPU finishes task 0 and starts processing task 2 as it is the shortest. Available tasks = {1}.
- At time = 4, task 3 is available to process. Available tasks = {1, 3}.
- At time = 5, the CPU finishes task 2 and starts processing task 3 as it is the shortest. Available tasks = {1}.
- At time = 6, the CPU finishes task 3 and starts processing task 1. Available tasks = {}.
- At time = 10, the CPU finishes task 1 and becomes idle.

Example 2:
Input: tasks = [[7,10],[7,12],[7,5],[7,4],[7,2]]
Output: [4,3,2,0,1]
Explanation: The events go as follows:
- At time = 7, all the tasks become available. Available tasks = {0,1,2,3,4}.
- Also at time = 7, the idle CPU starts processing task 4. Available tasks = {0,1,2,3}.
- At time = 9, the CPU finishes task 4 and starts processing task 3. Available tasks = {0,1,2}.
- At time = 13, the CPU finishes task 3 and starts processing task 2. Available tasks = {0,1}.
- At time = 18, the CPU finishes task 2 and starts processing task 0. Available tasks = {1}.
- At time = 28, the CPU finishes task 0 and starts processing task 1. Available tasks = {}.
- At time = 40, the CPU finishes task 1 and becomes idle.


 1       3
[[1,2],[2,4],[3,2],[10,3]] 
{1,4}, [1,2]

Time complexity: O(nlog(n))
public List<Integer> getShortestTimeToComepleteFirst(List<Integer[]> tasks){
    
    
    if(tasks.size()< 0)
        return Collection.EMPTY_LIST;
    if(tasks.size()< 0)
        return Arrays.asList(tasks.get(0)[0]);
    PrioriyQueue<Integer[]> shortestTimeTaskQueue = new PriorityQueue<>((a, b) ->  a[1]==b[1]? a[0]-b[0]: a[1]-b[1]); // heap for shortest time to complete task
    
    shortestTimeTaskQueue.offer(tasks.get(0));
    
    Collections.sort(tasks, (a,b)-> a[0]-b[0] );  //  sorted tasks on the basis of arrival time
    
    int currentTime = tasks.get(0)[0];
    int ind =1;
    
    List<Integer> result = new ArrayList<>();  
    while(!shortestTimeTaskQueue.isEmpty()){   //3 4
        Integer[] task = shortestTimeTaskQueue.poll();     
        result.add(task[0]);
        
        int endtime = currentTime + task[1];          // 5   
        for(;ind<tasks.size();){
            if(tasks.get(ind)[0]<=endTime){
                shortestTimeTaskQueue.offer(tasks.get(ind));
                ind++;
            }
            else break;
                
        }
        currentTime = endtime;  //8
        
        if(shortestTimeTaskQueue.isEmpty() && ind <tasks.size()-1){
            shortestTimeTaskQueue.offer(tasks.get(++ind));
            
        }
        
    }
    
    return result;
    
    
    
}



Q:

Given an integer array nums, return the length of the longest strictly increasing subsequence.
A subsequence is a sequence that can be derived from an array by deleting some or no elements without changing the order of the remaining elements. For example, [3,6,2,7] is a subsequence of the array [0,3,1,6,2,2,7].
 
Example 1:
Input: nums = [10,9,2,5,3,7,101,18]
Output: 4
Explanation: The longest increasing subsequence is [2,3,7,101], therefore the length is 4.

Example 2:
Input: nums = [0,1,0,3,2,3]
Output: 4

Example 3:
Input: nums = [7,7,7,7,7,7,7]
Output: 1


int nums[] = [10,9,2,5,3,7,101,18];
int[][] dp = int[nums.length+1][nums.length+1];

public int fun(nums){
    if(nums.length<1)   
        return -1;
    else if(nums.length ==1)    
        return 1;
    int curMax =0, max= 0;    
    for(int i=;i<nums.length;i++)
    Arrays.fill(dp,-1);
    for(int i=0;i<nums.length;i++)    {
        curMax = fun(nums, 0);
        max= Math.max(curMax, max);
    }
    return max;
        
}
public int fun(nums, int ind){
    if(ind>=nums.length)
    return 1;
    
    if(dp[ind][ind != -1)
     return dp[ind][ind];
    
    for(int i=ind+1;i<nums.length;i++)
        if(nums[i]) >nums[ind])
               return 1+fun(nums, i);
                
}




## OSI_model

Computer Networking - Part 1: Introduction

Our goal in this series is to interconnect between computer systems, or basically talk about how the Internet works.

Basically a network architecture is a set of layers and protocols. A protocol is a set of rules which are agreed among peers on how communication should be conducted. Overall computer networking is made up of multiple protocols at different layers (differ between networks). Regarding the layers, there is a protocol the hierarchy sometimes called “protocol stack”. 

On the sending side, every layer sends information (data and control) to the layer below until we get to the lowest layer. On the receiving side the information flows from the lower layer to the most upper one. Probably the most well known conceptual model for describing networking is the “OSI Model”. This model has 7 layers each handling different aspects of networking (as described next).

“Physical Layer” which is responsible for transferring bits over some medium (such as RF or optical cables).
 
“Data Link Layer” which is responsible for splitting the “flow of bits” into frames and ensuring there are no transmission errors (they are protocols which can also fix some transmission errors and thus avoid the retransmissions by upper layers).

“Network Layer” which is responsible for routing the packets between a sender and a receiver. There are two families of protocols in this layer: routed protocols (holding source and destination information needed for routing) and routing protocols (managing the routing tables among the routers across the network) - more on them in future write-ups.

“Transport Layer” which has two major protocol families: connectionless (not starting a connection before sending data and best effort) and connection oriented (creating a connection before sending data and adding acknowledgement mechanism to ensure data was received). Lastly, this layer also allows multiplexing a couple of applications for communication on the same hosts (like TCP/UDP ports).

“Session Layer” which is responsible for initiating and creating a session between both ends of the communication. 
 
“Presentation Layer” which is responsible for ensuring the data passed between the sender and the receiver is understandable between both parties.

“Application Layer” which is responsible for the protocol used by the application (web browsing, email, messaging, etc.) itself. 

Also, it is important to remember that the “OSI Model” is a reference only, and not all the protocol stacks implement the entire 7 layers (which we will talk about in the future). In the table below we can see for each layer a small list of protocols as an example (https://bit.ly/3x8e411). 

## breakpoints

 Breakpoints
Have you ever asked yourself how breakpoints work? If the answer is yes - you are in the right place. Generally, they are two types of breakpoints: “Software Breakpoints” and “Hardware Breakpoints”. But before we dive into both of them there are still some assumptions you should be aware of. 

First, the compiler we are using needs to include information inside the executable in order for the debugger to match between the source code and the code in the executable. However, in case we don’t have the code or we are using a breakpoint based on a specific memory address it is not needed.

Second, the compiler should not optimize the code in a manner that it’s almost impossible to match between source code and code inside the executable (unless for the same reason as above). We can ensure that by debugging without using any optimizations or with selected ones only. 

In the case of “Hardware Breakpoints” there is a need for CPU support. What most CPUs (which support this type of breakpoint) support is to define an address which we want the CPU to breakpoint on. What the CPU does is to compare the program counter (PC) to the given address in case of a match the CPU will break the execution. Due to the need of hardware support this type of breakpoints are always limited. For example in the case of x68 architecture there are 6 debug registers (4 for address to break on, 1 debug control and 1 debug status) - for more information you can read - https://bit.ly/3RtR6sL. Also, here you can read an example about hardware breakpoints in ARM -https://bit.ly/3KEC9lu.

On the other end, “Software Breakpoints” there is no need for specific hardware (such as debug registers). In this case the debugger just modifies the original binary loaded into memory. So, setting a “Software Breakpoint” is replacing the instruction we want to break on with a “special instruction” that will let the debugger know we got into a breakpoint. Due to the fact the debugged point can be a different process than the debugger the common implementation is that the “special instruction” will trigger an interrupt/exception that the debugger can catch. Don’t forget the code is marked mostly as read and execute and not writable, so if we want to modify something we need some kind of support  (it can be done by the OS, without support it can’t work - I promise to detail it in a future post).  In x86 the “CC” is the “special instruction”(1 byte long) which causes “Interrupt 3” (we can also use “int 0x3” in two bytes for it). Under ARM we can use something like the “BKPT” instruction (https://bit.ly/3TAK5s2). Also, the debugger needs to remember what series of byte/bytes it replaced with the “magic instruction” in order to show that as part of the code to the user.  

In the image below there is a demonstration of the flow that happens in case of a “Software Breakpoint”.

## Papple

Why is the maximum port range 65535 in the TCP/IP Suite?
Look at the packet format for the TCP segment. The port identifiers are unsigned 16-bit integers, meaning that the largest number you can put in there is 216-1 = 65535.

file not created even 10gb storage space available
cap theoram
primitive vs object
kubernates services types - ClusterIP, NodePort, ExternalName, LoadBalancer

given a list of Strings count occurence of each string
- count tokens in each string
- give map of sorted tokens by their count.

## oci

```
import java.io.*;
import java.util.*;
import java.text.*;
import java.math.*;
import java.util.regex.*;
// abcd
// dcbabcd



// aa -> aaaa
// aaccb bccaaccb  -> bcc

// in[i] == in[j] && (dp[i+1][j-1]) || j-i<=2

// dp[i][j] = true
// a ac c
public class Solution {
    private static boolean[][] dp;
    static int getPalindromicStringLength(String input) {
        for(int i=0;i<dp.length;i++)
            Arrays.fill(dp[i], true);
        for(int i=1;i<dp.length-1;i++){
            for(int j=i+1;j<dp.length-1;j++){
                if(input.charAt(i) == input.charAt(j) && (j-i<3 || dp[i+1][j-1]))
                    dp[i][j] = true;
                
            }
            
        }
        for(int i=dp.length-1;i>=0;i--){
            if(dp[0][i])
                return i;
            
        }
        
      	return 0; 
   }

 public static void main(String[] args) {
        Scanner in = new Scanner(System.in);
        String a = in.next();
        
        StringBuilder sb = new StringBuilder(a);
        sb = reverse(a);
        dp = new boolean[a.length()+1][a.length()+1];
        int sum = getPalindromicStringLength(a);
        if(sum !=0){
            while(sum-- >0)
                sb =sb.deleteCharAt(sb.length()-1);
        }
        System.out.println(sb.append(a));
   }
   
   public static StringBuilder reverse(String input) {
           StringBuilder res = new StringBuilder();
           for(int i=input.length()-1;i>=0;i--)
                res.append(input.charAt(i));
            return res;
   }
}
```


second program

```
import java.io.*;
import java.util.*;
import java.text.*;
import java.math.*;
import java.util.regex.*;

//i/p : [1,4,0,9,1,0]

//o/p: [1,4,0,0,1,9]


// [1, 4, 0, 9, 1,2, 0,1,2,3 ]
                    //   start, end
// [1, 4, 0, 0, 9,1, 2,0,0,1 ]  

public class Solution {

    public static void main(String[] args) {
      
      
      
      int[] in = new int[]{1,4,0,9,1,0};
      if(in.length <=1)
        return;
      
      int zeroCount = 0;
      
      int n = in.length;
      for(int i=0;i<n;i++)
        if(i==0){
            zeroCount++;
            n--;
        }
      if(zeroCount ==0)      
        return;
      int start  = in.length-1-zeroCount;
      int end = in.length-1;
    
      for(int i=start;i>=0;i--)      {
          if(in[i] == 0){
                in[end] = 0;
                in[end-1] = 0;
                end -=2;
           }else
            in[end--] = in[i];
      }
      
      Arrays.stream(in).forEach(System.out::println);
   }
}
```

## tairtel

First Round
LLD :
Design facebook homepage feed system
user with no interest also should get feeds
https://app.diagrams.net/#G1o4rKnNoZx7TWQHBjRs35h7B7VI-cPU8l
## oa

given parcels for n storage centres find min num of days to send all in min no of days

2 3 4 3 3
0 1 2 1 1
0 0 1 0 0
0 0 0 0 0

O/p 3



Find the total sum of the imbalance of all possible groups

Input: nums = [1,2,3]
Output: 4
Explanation: The 6 subarrays of nums are the following:
[1], range = largest - smallest = 1 - 1 = 0 
[2], range = 2 - 2 = 0
[3], range = 3 - 3 = 0
[1,2], range = 2 - 1 = 1
[2,3], range = 3 - 2 = 1
[1,2,3], range = 3 - 1 = 2
So the sum of all ranges is 0 + 0 + 0 + 1 + 1 + 2 = 4.
Question 1. Monotonic Array Leetcode Solution Problem Statement: The Monotonic Array Leetcode Solution – Given an array is monotonic if it is either monotone increasing or monotone decreasing. An array nums is monotone increasing if for all i <= j, nums[i] <= nums[j]. An array nums is monotone decreasing if for all i <= j, nums[i] >= nums[j]. Given an integer array nums, return true if the given ...

Read more

Question 2. Maximum Size Subarray Sum Equals k Leetcode Solution Problem Statement: The Maximum Size Subarray Sum Equals k Leetcode Solution – Given an integer array nums and integer k, return the maximum length of a subarray that sums to k. If there is not one, return 0 instead. Example: Input: nums = [1,-1,5,-2,3], k = 3 Output: 4 Explanation:   The ...

Read more

Question 3. H-Index Leetcode Solution Problem Statement: H-Index Leetcode solution says that – Given an array of integers “citations” where citations[i] is the number of citations a researcher received for their ith paper, return researcher’s H-Index. If several H-Index values are present, return the maximum among them. Definition of H-Index:  A scientist has an index ...

Read more

Question 4. High Five LeetCode Solution Problem Statement: The High Five LeetCode Solution – Given a list of scores of different students named “item”, where the “item” has two fields item[0] represents the student’s id, and item[1] represents the student’s score eg. item[i]=[IDi, SCOREi] Return the answer as an array of pairs result, where result[j] = ...

Read more

Question 5. Reveal Cards In Increasing Order Leetcode Solution Problem Statement The Reveal Cards In Increasing Order Leetcode Solution – Given an integer Array named “deck”. In this deck of cards, every card has a unique integer. The integer on the i card is deck[i].  Order the deck in any order and all the cards start face down (unrevealed) ...

Read more

Question 6. Maximum Side Length of a Square with Sum Less than or Equal to Threshold LeetCode Solution Problem Statement “Maximum Side Length of a Square with Sum Less than or Equal to Threshold,” says that  a m x n matrix mat and an integer threshold are given, return the maximum side-length of a square with a sum less than or equal to threshold or return 0 if there is no such square. Example 1: Input: ...

Read more

Question 7. Count Sub Islands LeetCode Solution Problem Statement Count Sub Islands LeetCode Solution says that grid1 and grid2 contain only 0‘s (representing water) and 1‘s (representing land). The island means the group of 1’s connected 4 directionally. An island in grid2 is considered a sub-island if there is an island in grid1 that contains all the cells that make ...

Read more

Question 8. Continuous Subarray Sum LeetCode Solution Problem Statement Continuous Subarray Sum LeetCode Solution – Given an integer array nums and an integer k, return true if nums has a continuous subarray of the size of at least two whose elements sum up to a multiple of k, or false otherwise. An integer x is a multiple of k if there exists an integer n such that x = n * k. 0 is always a ...

Read more

Question 9. Find the Winner of the Circular Game LeetCode Solution Problem Statement Find the Winner of the Circular Game LeetCode Solution – There are n friends that are playing a game. The friends are sitting in a circle and are numbered from 1 to n in clockwise order. More formally, moving clockwise from the ith friend brings you to the ...

Read more

Question 10. Top K Frequent Elements LeetCode Solution Problem Statement Top K Frequent Elements LeetCode Solution Says that – Given an integer array nums and an integer k, return the k most frequent elements. You may return the answer in any order. Example 1: Input: nums = [1,1,1,2,2,3], k = 2 Output: [1,2] Example 2: Input: nums = [1], k = 1 Output: [1] ...

Read more

Question 11. Shifting Letters LeetCode Solution Problem Statement Shifting Letters says that we have given a string s and an array shifts. Now for each shifts[i] = x, we want to shift the first i + 1 letters of s, x times. We have to return the final string after all shifts are applied. Example 1: Input: s = "abc", shifts ...

Read more

Question 12. Divide Chocolate LeetCode Solution Problem Statement The Divide Chocolate LeetCode solution says the chocolate bar is represented by a list of non-zero integers. The sum of a contiguous subarray stands for the sweetness of the chocolate piece represented by this subarray. Here the task is to find the maximum possible minimum sum of all ...

Read more

Question 13. Jump Game IV LeetCode Solution Problem Statement: Jump Game IV LeetCode Solution says – Given an array of integers arr, you are initially positioned at the first index of the array. In one step you can jump from the index i to index: i + 1 where: i + 1 < arr.length. i - 1 where: i - 1 >= ...

Read more

Question 14. Maximum Population Year LeetCode Solution Problem Statement Maximum Population Year LeetCode Solution says that – You are given a 2D integer array logs where each logs[i] = [birthi, deathi] indicates the birth and death years of the ith person. The population of some year x is the number of people alive during that year. The ith a person is counted ...

Read more

Question 15. Minimum Swaps to Group All 1’s Together Leetcode Solution Problem Statement Minimum Swaps to Group All 1’s Together Leetcode Solution – says that Given a binary array data, return the minimum number of swaps required to group all 1’s present in the array together in any place in the array. Input: data = [1,0,1,0,1] Output: 1 Explanation: There are 3 ways to group all ...

Read more

Question 16. Maximum Population Year LeetCode Solution Problem Statement: Maximum Population Year Leetcode Solution says that – You are given a 2D integer array logs where each logs[i] = [birthi, deathi] indicates the birth and death years of the ith person. The population of some year x is the number of people alive during that year? The ith person is counted in the year x‘s population if x is ...

Read more

Question 17. Best Meeting Point LeetCode Solution Problem Statement: Best Meeting Point Leetcode Solution says – Given a m x n binary grid grid where each 1 marks the home of one friend, return the minimal total travel distance. The total travel distance is the sum of the distances between the houses of the friends and the meeting point. The distance is calculated using Manhattan Distance, ...

Read more

Question 18. Minimum Path Sum Leetcode Solution Problem Statement The Minimum Path Sum LeetCode Solution – “Minimum Path Sum” says that given a n x m grid consisting of non-negative integers and we need to find a path from top-left to bottom right, which minimizes the sum of all numbers along the path. We can only move ...

Read more

Question 19. Min Cost Climbing Stairs LeetCode Solution Problem Statement Min Cost Climbing Stairs LeetCode Solution – An integer array cost  is given, where cost[i] is the cost of ith step on a staircase. Once you pay the cost, you can either climb one or two steps. You can either start from the step with index 0, or the step with ...

Read more

Question 20. Number of Subsequences That Satisfy the Given Sum Condition LeetCode solution Problem Statement Number of Subsequences That Satisfy the Given Sum Condition LeetCode solution – says that Given an array of integers nums and an integer target. Return the number of non-empty subsequences  nums such that the sum of the minimum and maximum element on it is less or equal to target. Since the answer may be too ...

Read more

Question 21. Find the Town Judge LeetCode Solution Problem Statement: Find the Town Judge LeetCode Solution – In a town, there are n people labeled from 1 to n. There is a rumor that one of these people is secretly the town judge and we need to find the town judge. If the town judge exists, then: The town judge trusts nobody. ...

Read more

Question 22. Insert Delete GetRandom O(1) Leetcode Solution Problem Statement The Insert Delete GetRandom O(1) LeetCode Solution – “Insert Delete GetRandom O(1)” asks you to implement these four functions in O(1) time complexity. insert(val): Insert the val into the randomized set and return true if the element is initially absent in the set. It returns false when the ...

Read more

Question 23. Daily Temperatures Leetcode Solution Problem Statement The Daily Temperatures Leetcode Solution: states that given an array of integers temperatures represents the daily temperatures, return an array answer such that answer[i] is the number of days you have to wait after the ith day to get a warmer temperature. If there is no future day for which this is possible, keep answer[i] == 0 instead. ...

Read more

Question 24. Bus Routes Leetcode Solution Problem Statement The Bus Routes LeetCode Solution – “Bus Routes” states that you’re given an array of routes where routes[i] is a bus route such that ith bus repeats the route forever. We’ll be given a bus stop source and we want to reach the bus stop target. We can ...

Read more

Question 25. Subarrays with K Different Integers Leetcode Solution Problem Statement The Subarrays with K Different Integers LeetCode Solution – “Subarrays with K Different Integers” states that you’re given an integer array nums and an integer k. We need to find a total number of good subarrays of nums. A good array is defined as an array with exactly ...

Read more

Question 26. Remove Duplicates from Sorted Array II Leetcode Solution Problem Statement : Given an integer array of nums sorted in non-decreasing order, remove some duplicates in place such that each unique element appears at most twice. The relative order of the elements should be kept the same. Since it is impossible to change the length of the array in some languages, you must instead have ...

Read more

Question 27. K Closest Points to Origin Leetcode Solution Problem Statement The K Closest Points to Origin LeetCode Solution – “K Closest Points to Origin” states that given an array of points, x coordinates and y coordinates represent the coordinates on XY Plane. We need to find k closest points to the origin. Note that the distance between two ...

Read more

Question 28. Next Permutation Leetcode Solution Problem Statement The Next Permutation LeetCode Solution – “Next Permutation” states that given an array of integers which is a permutation of first n natural numbers. We need to find the next lexicographically smallest permutation of the given array. The replacement must be in-place and use only constant extra space. ...

Read more

Question 29. Maximum Profit in Job Scheduling Leetcode Solution Problem Statement The Maximum Profit in Job Scheduling LeetCode Solution – “Maximum Profit in Job Scheduling” states that you’re given n jobs where each job starts from startTime[i] and ends at endTime[i] and obtaining the profit of profit[i]. We need to return the maximum profit that we can have such ...

Read more

Question 30. Trapping Rain Water Leetcode Solution Problem Statement The Trapping Rain Water LeetCode Solution – “Trapping Rain Water” states that given an array of heights which represents an elevation map where the width of each bar is 1. We need to find the amount of water trapped after rain. Example: Input: height = [0,1,0,2,1,0,1,3,2,1,2,1] Output: 6 Explanation: Check ...

Read more

Question 31. Sort Array by Increasing Frequency Leetcode Solution Problem Statement The Sort Array by Increasing Frequency LeetCode Solution – “Sort Array by Increasing Frequency” states that you’re given an array of integers, sort the array in increasing order based on the frequency of the values. Two or more values have the same frequency, we need to sort them ...

Read more

Question 32. Partition to K Equal Sum Subsets Leetcode Solution Problem Statement The Partition to K Equal Sum Subsets LeetCode Solution – “Partition to K Equal Sum Subsets” states that you’re given the integer array nums and an integer k, return true if it is possible to have k non-empty subsets whose sums are all equal. Example: Input: nums = [4,3,2,3,5,2,1], k = 4 Output: ...

Read more

Question 33. Coin Change 2 Leetcode Solution Problem Statement The Coin Change 2 LeetCode Solution – “Coin Change 2” states that given an array of distinct integers coins and an integer amount, representing a total amount of money. We need to return the count of the total number of different possible combinations that sum to the amount.  ...

Read more

Question 34. Frog Jump Leetcode Solution Problem Statement The Frog Jump LeetCode Solution – “Frog Jump” states that given the list of stones (positions) sorted in ascending order, determine if the frog can cross the river by landing on the last stone (last index of the array). Initially, the frog is on the first stone and ...

Read more

Question 35. Build Array From Permutation Leetcode Solution Problem Statement The Build Array From Permutation LeetCode Solution – “Build Array From Permutation” states that given zero-based permutation nums, we have to build an array of the same length where ans[i] = nums[nums[i]] for each i in range [0,nums.length-1]. A zero-based permutation nums is an array of distinct integers from 0 ...

Read more

Question 36. Number of Orders in the Backlog Leetcode Solution Problem Statement The Number of Orders in the Backlog LeetCode Solution – “Number of Orders in the Backlog” states that given the 2D integer array [price, amount, orderType] which denotes that amount orders have been placed of type order type. If the order type is : 0, denotes the current ...

Read more

Question 37. Minimum Cost For Tickets Leetcode Solution Problem Statement The Minimum Cost For Tickets LeetCode Solution – “Minimum Cost For Tickets” asks you to find the minimum number of dollars you need to travel every day in the given list of days. You will be given an integer array of days. Each day is an integer from ...

Read more

Question 38. Unique Paths II Leetcode Solution Problem Statement The Unique Paths II LeetCode Solution – “Unique Paths II” states that given the m x n grid where a robot starts from the top left corner of the grid. We need to find the total number of ways to reach the bottom right corner of the grid. ...

Read more

Question 39. Search a 2D Matrix II Leetcode Solution Problem Statement The Search a 2D Matrix II LeetCode Solution – “Search a 2D Matrix II”asks you to find an efficient algorithm that searches for a value target in an m x n integer matrix matrix. Integers in each row, as well as column, are sorted in ascending order. Example: Input: matrix = [[1,4,7,11,15],[2,5,8,12,19],[3,6,9,16,22],[10,13,14,17,24],[18,21,23,26,30]], target = 5 Output: true ...

Read more

Question 40. Maximum Length of a Concatenated String with Unique Characters Leetcode Solution Problem Statement The Maximum Length of a Concatenated String with Unique Characters LeetCode Solution – “Maximum Length of a Concatenated String with Unique Characters” says that you’re given an array of strings and you need to choose any subsequence of the given array and concatenate those strings to form the ...

Read more

Question 41. Shortest Word Distance Leetcode Solution Problem Statement The Shortest Word Distance LeetCode Solution – says that you’re given an array of strings and two different words. We need to return the shortest distance between these two words that appear in the input string. Example: Input: wordsDict = ["practice", "makes", "perfect", "coding", "makes"], word1 = "coding", word2 = "practice" Output: 3 Explanation: Word “coding” occurs at position 4. ...

Read more

Question 42. Moving Average from Data Stream Leetcode Solution Problem Statement The Moving Average from Data Stream LeetCode Solution – “Moving Average from Data Stream” states that given a stream of integers and a window size k. We need to calculate the moving average of all the integers in the sliding window. If the number of elements in the ...

Read more

Question 43. Set Matrix Zeroes Leetcode Solution Problem Statement The Set Matrix Zeroes LeetCode Solution – “Set Matrix Zeroes” states that you’re given an m x n integer matrix matrix.We need to modify the input matrix such that if any cell contains the element  0, then set its entire row and column to 0‘s. You must do it in ...

Read more

Question 44. Missing Number Leetcode Solution Problem Statement The Missing Number LeetCode Solution – “Missing Number” states that given an array of size n containing n distinct numbers between [0,n]. We need to return the number which is missing in the range. Example:   Input:  nums = [3,0,1] Output: 2 Explanation: We can easily observe that all the ...

Read more

Question 45. Design a Stack With Increment Operation Leetcode Solution Problem Statement The Design a Stack With Increment Operation Leetcode Solution –  states that we need to design a stack that supports the below operations efficiently. Assign the maximum capacity of the stack. Perform the push operation efficiently, if the size of the stack is strictly less than the maximum capacity of ...

Read more

Question 46. Slowest Key Leetcode Solution The problem Slowest Key Leetcode Solution provides us with a sequence of keys that have been pressed. We are also given an array or vector of times these keys have been released. The sequence of keys is given in the form of a string. So, the problem asked us to ...

Read more

Question 47. 3Sum Leetcode Solution Problem Statement Given an array of n integers, are there elements a, b, c in nums such that a + b + c = 0? Find all unique triplets in the array which gives the sum of zero. Notice: that the solution set must not contain duplicate triplets. Example #1 [-1,0,1,2,-1,4] ...

Read more

Question 48. Insert Interval Leetcode Solution The problem Insert Interval Leetcode Solution provides us with a list of some intervals and one separate interval. Then we are told to insert this new interval among the list of intervals. So, the new interval might be intersecting with intervals that are already in the list, or it might ...

Read more

Question 49. Combination Sum Leetcode Solution The problem Combination Sum Leetcode Solution provides us an array or list of integers and a target. We are told to find the combinations that can be made using these integers any number of times that add up to the given target. So more formally, we can use the given ...

Read more

Question 50. Island Perimeter Leetcode Solution Problem Statement In this problem, we are given a grid in form of a 2-D array. grid[i][j] = 0 represents there is water at that point and grid[i][j] = 1 represents land. Grid cells are connected vertically/horizontally but not diagonally. There is exactly one island (a connected component of land ...

Read more

Question 51. Maximum Subarray Leetcode Solution Problem Statement Given an integer array nums, find the contiguous subarray (containing at least one number) which has the largest sum and return its sum. Example nums = [-2,1,-3,4,-1,2,1,-5,4] 6 Explanation: [4,-1,2,1] has the largest sum = 6. nums = [-1] -1 Approach 1 (Divide and Conquer) In this approach ...

Read more

Question 52. Rank Transform of an Array Leetcode Solution The problem Rank Transform of an Array Leetcode Solution provided us with an array of integers. The array or the given sequence is unsorted. We need to assign ranks to each integer in the given sequence. There are some restriction s for assigning the ranks. The ranks must start with ...

Read more

Question 53. Decompress Run-Length Encoded List Leetcode Solution The problem Decompress Run-Length Encoded List Leetcode Solution states that you are given an array or vector containing a sequence. The sequence has some specific representation. The input sequence is formed from another sequence. We will call that another sequence as the original sequence. As per which the input sequence ...

Read more

Question 54. Replace Elements with Greatest Element on Right Side Leetcode Solution The problem Replace Elements with Greatest Element on Right Side Leetcode Solution provides us with an array or vector of integers. The problem asked us to replace all the elements with the element that is greatest among all the elements on the right side. So consider if we had an ...

Read more

Question 55. Find Winner on a Tic Tac Toe Game Leetcode Solution The problem Find Winner on a Tic Tac Toe Game Leetcode Solution asks us to find out the winner of a tic tac toe game. The problem provides us with an array or vector of moves made by the players. We need to go through the moves and judge who ...

Read more

Question 56. Find Common Characters Leetcode Solution Problem Statement In this problem, we are given a list of string. We have to find out the characters that are common in all the strings. If a character is present in all strings in multiple times, then we have to output the character multiple times. Suppose, we have array ...

Read more

Question 57. Minimum Time Visiting All Points Leetcode Solution The problem Minimum Time Visiting All Points Leetcode Solution provides us with an array or vector of points on coordinate axes. The problem after providing us with the input asks us to find the minimum time to visit all the points given in the input. When you move one unit ...

Read more

Question 58. Find N Unique Integers Sum up to Zero Leetcode Solution The problem Find N Unique Integers Sum up to Zero Leetcode Solution, provides us with an integer. It asks us to return n unique integers that sum up to 0. So, the question is pretty simple to understand. So, before diving into the solution. Let us take a look at ...

Read more

Question 59. Partition Array Into Three Parts With Equal Sum Leetcode Solution The problem Partition Array Into Three Parts With Equal Sum Leetcode Solution provides us with an array or vector and asks if there are three partitions possible of the sequence. Here, by partition we mean that is there two indices i, j such that the sum of elements from start ...

Read more

Question 60. Find Common Characters Leetcode Solution Problem Statement In this problem, we are given an array of strings. We need to print a list of all characters that appear in every string in the array(duplicates included). That is if a character appears 2 times in every string, but not 3 times, we need to have it ...

Read more

Question 61. Find All Numbers Disappeared in an Array Leetcode Solution Problem Statement In this problem, we are given an array of integers. It contains elements ranging from 1 to N, where N = size of the array. However, there are some elements that have disappeared and some duplicates are present in their place. Our goal is to return an array ...

Read more

Question 62. Majority Element II Leetcode Solution In this problem, we are given an array of integers. The goal is to find all the elements which occur more than ⌊N / 3⌋ time in the array where N = size of the array and ⌊ ⌋ is the floor operator. We need to return an array of ...

Read more

Question 63. Contains Duplicate II Leetcode Solution Problem Statement In this problem we are given an array of integers and we have to check if there exists any duplicate element which are at a distance of at least k to each other. i.e. the difference between the indices of those two same element should be less than ...

Read more

Question 64. Relative Sort Array Leetcode Solution In this problem, we are given two arrays of positive integers. All elements of the second array are distinct and are present in the first array. However, the first array can contain duplicate elements or elements that are not in the second array. We need to sort the first array ...

Read more

Question 65. Find Words That Can Be Formed by Characters Leetcode Solution Problem statement In the problem ” Find Words That Can Be Formed by Characters” we are given an array of strings that consists of lower case English alphabets (words) and a string that consists of a set of characters (chars). Our task is to check for each string in the array ...

Read more

Question 66. Number of Equivalent Domino Pairs Leetcode Solution Problem statement In the problem ” Number of Equivalent Domino Pairs,”  we are given a list of dominoes where each domino consists of two values like dominoes[i]=[a,b]. Two dominoes, dominoes[i] =[a,b] and dominoes[j]=[c,d]  are equivalent if (a==c and b==d) or (a==d and c==d). Our task is to find out the ...

Read more

Question 67. Pascal’s Triangle II Leetcode Solution Problem Statement In this problem we have been given Row index(i) of the Pascal Triangle. We have to create a linear array containing the values of the ith row and return it. Row index starts from 0. We know that Pascal’s triangle is a triangle where each number is the ...

Read more

Question 68. Unique Paths Leetcode Solution The problem Unique Paths Leetcode Solution states that you are given two integers representing the size of a grid. Using the size of the grid, the length, and breadth of the grid. We need to find the number of unique paths from the top left corner of the grid to ...

Read more

Question 69. Number of Good Pairs Leetcode Solution Problem Statement In this problem an array of integers is given and we have to find out the count of total number of good pairs (a[i], a[j]) where a[i]=a[j]. Example nums = [1,2,3,1,1,3] 4 Explanation:   There are 4 good pairs at indices (0,3), (0,4), (3,4), (2,5) . [1,1,1,1] 6 Explanation:  ...

Read more

Question 70. Third Maximum Number Leetcode Solution As the title says, the goal is to find the third maximum integer in a given array of integers. Note that we need to find the distinct third maximum integer in the array. We return the maximum integer in the array when it has no distinct third maximum integer. Example ...

Read more

Question 71. Balanced Binary Tree Leetcode Solution A binary tree is Height-balanced if the difference of heights of left and right subtree of every node in the tree is at most 1. In this problem, we are going to check for a balanced binary tree. Example 2 / 1 / 4 Not balanced 1 / \ 2 ...

Read more

Question 72. How Many Numbers Are Smaller Than the Current Number Leetcode Solution Problem Statement In this problem, we are given an array. For each element of this array, we have to find out the number of elements smaller than that element. i.e. for each i (0<=i<arr.length) we have to find out count of elements less than the number arr[i]. For that we ...

Read more

Question 73. Merge Sorted Arrays Leetcode Solution In the problem “Merge Sorted Arrays”, we are given two arrays sorted in non-descending order. The first array is not fully filled and has enough space to accommodate all elements of the second array as well. We have to merge the two arrays, such that the first array contains elements ...

Read more

Question 74. Search in Rotated Sorted Array Leetcode Solution Consider a sorted array but one index was picked and the array was rotated at that point. Now, once the array has been rotated you are required to find a particular target element and return its index. In case, the element is not present, return -1. The problem is generally ...

Read more

Question 75. Search Insert Position Leetcode Solution In this problem, we are given a sorted array and a target integer. We have to find its Search Insert Position. If the target value is present in the array, return its index. Return the index at which the target should be inserted so as to keep the order sorted(in ...

Read more

Question 76. Kids With the Greatest Number of Candies Leetcode Solution In the problem “Kids With the Greatest Number of Candies”, we are given an array of integers that represents the number of chocolates some children have got and some extra candies that can be distributed in any manner. Now, we need to find: Can every child have the greatest number ...

Read more

Question 77. Running Sum of 1d Array Leetcode Solution Problem Statement In running sum of 1d array problem we have been given an array nums for which we have to return an array where for each index i in the result array  arr[i] = sum( nums[0] … nums[i] ). Example  nums = [1,2,3,4] [1,3,6,10] Explanation: Running sum is :  ...

Read more

Question 78. Plus One Leetcode Solution Problem statement In the problem ” Plus One”  we are given an array where each element in the array represents a digit of a number. The complete array represents a number. The zeroth index represents the MSB of the number.  We can assume that there is no leading zero in ...

Read more

Question 79. Kth largest element in an Array Leetcode Solutions In this problem, we have to return the kth largest element in an unsorted array. Note that the array can have duplicates. So, we have to find the Kth largest element in the sorted order, not the distinct Kth largest element. Example A = {4 , 2 , 5 , 3 ...

Read more

Question 80. Max Consecutive Ones Leetcode Solution Problem Statement In Max Consecutive Ones problem a binary array is given. We have to find the maximum number of consecutive ones present in the given array. The input array will only contain 0 and 1. Example [1,1,0,1,1,1] 3 Explanation: The first two digits or the last three digits are ...

Read more

Question 81. Rearrange Array such that arr[i] >= arr[j] if i is even and arr[i] <= arr[j] if i is odd and j < i Suppose you have an integer array. The problem statement asks to rearrange the array in such a way that the elements at even position in an array should be greater than all elements before it and the elements at odd positions should be less than the elements before it. Example ...

Read more

Question 82. Sort Array By Parity II Leetcode Solution Problem statement In the problem ” Sort Array By Parity II,” we are given a parity array where all the elements are positive integers. The array contains an even number of elements. The array contains an equal number of even and odd elements. Our task is to rearrange the elements ...

Read more

Question 83. Count pair with Given Sum In problem “count pair with given sum” we have given an integer array[] and another number say ‘sum’, you have to determine whether any of the two elements in a given array has a sum equal to “sum”. Example Input: arr []={1,3,4,6,7} and sum = 9. Output: “ Elements found ...

Read more

Question 84. Group Multiple Occurrence of Array Elements Ordered by first Occurrence You are given a question in which you have given an unsorted array with multiple occurrences of numbers. The task is to group all the multiple occurrences of array elements ordered by first occurrence. Meanwhile, the order should be the same as the number comes. Example Input: [ 2, 3,4,3,1,3,2,4] ...

Read more

Question 85. Maximum difference between frequency of two elements such that element having greater frequency is also greater Suppose, you have an integer array. The problem statement asks to find out the maximum difference between the frequency of any two distinct elements of a given array, but the element with the greater frequency should also be greater in value than the other integer. Example Input: arr[] = {2,4,4,4,3,2} ...

Read more

Question 86. Maximize Sum of Array after K Negations Leetcode Solution This post is on Maximize Sum Of Array After K Negations Leetcode Solution Problem statement In the problem ” Maximize Sum Of Array After K Negations” we are given an array arr and a value K. The array consists of integer values. We can change the value of arr[i] to ...

Read more

Question 87. Smallest Subarray with k Distinct Numbers Suppose, you have an integer array and a number k. The problem statement asks to find out the smallest sub-array of range (l, r) inclusively, in such a way there are exactly k distinct numbers present in that smallest sub-array. Example Input: {1, 2, 2, 3, 4, 5, 5} k=3 ...

Read more

Question 88. All Unique Triplets that Sum up to a Given Value We have given an array of integers and a given number called ‘sum’. The problem statement asks to find out the triplet that adds up to the given number ‘sum’. Example Input: arr[] = {3,5,7,5,6,1} sum=16 Output: (3, 7, 6), (5, 5, 6) Explanation: Triplet which equals to the given ...

Read more

Question 89. Longest Subarray Having Count of 1s One More than Count of 0s We have given an array of integers. An array contains 1’s and 0’s only. The problem statement asks to find out the length of the longest Sub-Array which having the quantity of 1’s digit is just one more than the count of 0’s in a sub-array. Example Input: arr[] = ...

Read more

Question 90. Maximum Array from Two given Arrays Keeping Order Same Suppose we have two integers array of same size n. Both of the arrays can contain common numbers as well. The problem statement asks to form the resultant array that contains the ‘n’ maximum values from both of the arrays. The first array should be prioritized (elements of the first ...

Read more

Question 91. Guess Number Higher or Lower II Problem Statement “Guess Number Higher or Lower II” states that we are going to play a game that is called Guess Game. The game says that I pick a number from 1 to n. Whenever you guess the number which I have not picked, I m going to say you ...

Read more

Question 92. Rearrange an Array Such that arr[i] is equal to i “Rearrange an array such that arr[i]=i”  problem states that you are given an array of integers ranging from 0 to n-1. Since all the elements may not be present in the array, then in place of them -1 is there. The problem statement asks to rearrange the array in such ...

Read more

Question 93. Segregate 0s and 1s in an Array Problem Statement Suppose you have an integer array. The problem “Segregate 0s and 1s in an array” asks to segregate the array in two parts, in 0s and in 1s. The 0’s should be on the left side of the array and 1’s on the right side of the array. ...

Read more

Question 94. Find Largest d in Array such that a + b + c = d Problem Statement Suppose you have an array of integers. Input values are all distinct elements. The problem “Find largest d in array such that a + b + c = d” asks to find out the largest element ‘d’ in the set such that a + b + c = ...

Read more

Question 95. Maximum Number of Chocolates to be Distributed Equally Among k Students “The maximum number of chocolates to be distributed equally among k students” states that you are given n boxes that have some chocolates in it. Suppose there are k students. The task is to distribute the maximum number of chocolates among k students equally, by selecting consecutive boxes. We can ...

Read more

Question 96. Maximum Consecutive Numbers Present in an Array Problem Statement Suppose you have an array of integers of size N. The problem “Maximum consecutive numbers present in an array” asks to find out the maximum count of consecutive numbers that could be scattered in an array. Example arr[] = {2, 24, 30, 26, 99, 25} 3 Explanation: The ...

Read more

Question 97. Queries for Number of Distinct Elements in a Subarray We have given an array of integer and a number of queries and we have to find out the number of all the distinct elements we have within the given range, the query consists of two numbers left and right, this is the given range, with this given range we ...

Read more

Question 98. Range Minimum Query (Square Root Decomposition and Sparse Table) In the range minimum query problem we have given a query and an integer array. Each query contains the range as left and right indexes for each range. The given task is to determine the minimum of all number that lies within the range. Example Input: arr[] = {2, 5, ...

Read more

Question 99. Range Sum Query using Sparse Table In the range sum query using sparse table problem we have a range query and given an integer array. The given task is to find out the sum of all integers that comes in the range. Example Input: arr[] = {1,4,6,8,2,5} Query: {(0, 3), (2, 4), (1, 5)} Output: 19 16 25 ...

Read more

Question 100. Count and Toggle Queries on a Binary Array An array of size n has been given as an input value. The problem “Count and Toggle Queries on a Binary Array” asks to perform some of the queries which are given below, queries can vary in a random manner. The queries are ⇒ Toggle query ⇒ toggle(starting, ending), this ...

Read more

Question 101. Queries for Decimal Values of Subarrays of a Binary Array Write Queries for decimal values of subarrays of a binary array in a given binary array. The problem statement asks to find out the decimal number so formed with the help of range in a binary array. Example Input: arr[] = {1, 0, 1, 1, 0, 0, 1, 1} Query(1, ...

Read more

Question 102. Maximize Elements Using Another Array Suppose, we have given two integers array of same size n. Both of the arrays contain positive numbers. The problem statement asks to maximize the first array by using the second array element keeping the second array as a priority (elements of the second array should appear first in output). ...

Read more

Question 103. Minimum swaps required to bring all elements less than or equal to k together The problem “Minimum swaps required to bring all elements less than or equal to k together” states that you have an integer array. The problem statement asks to find out the smallest count of swaps that will be required to get the elements together which are less than or equal ...

Read more

Question 104. Find First and Last Position of Element in Sorted Array Leetcode Solution Problem statement In this article titled “Find First and Last Position of Element in Sorted Array Leetcode Solution,” we will discuss the solution to a leetcode problem. In the given problem we are given an array. We are also given a target element. Elements in the array are sequenced in ...

Read more

Question 105. Monotonic Array LeetCode Solution Problem statement In the problem “Monotonic Array” we are given an array. Our task is to check if the array is a monotonic array or not. A monotonic array is an array where elements are either sorted in increasing order or in decreasing order. If the array is sorted in ...

Read more

Question 106. Maximum subsequence sum such that no three are consecutive The problem “Maximum subsequence sum such that no three are consecutive ” states that you are given an array of integers. Now you need to find a subsequence that has the maximum sum given that you cannot consider three consecutive elements. To recall, a subsequence is nothing but an array ...

Read more

Question 107. Find duplicates in a given array when elements are not limited to a range The problem “Find duplicates in a given array when elements are not limited to a range” states that you have an array consisting of n integers. The problem statement it to find out the duplicate elements if present in the array. If no such element exists return -1. Example [ ...

Read more

Question 108. Check if Array Contains Contiguous Integers With Duplicates Allowed You are given an array of integers which can contain duplicate elements as well. The problem statement asks to find out if it is a set of contiguous integers, print “Yes” if it is, print “No” if it is not. Example Sample Input: [2, 3, 4, 1, 7, 9] Sample ...

Read more

Question 109. The K Weakest Rows in a Matrix Leetcode Solution Problem statement In the problem ” The K Weakest Rows in a Matrix” we are given a matrix of n rows and m columns. matrix is filled with 0 or 1. The special thing about this matrix is that all the ones are towards the left-hand side of each row ...

Read more

Question 110. Capacity To Ship Packages Within D Days Leetcode Solution Problem statement In the problem ” Capacity To Ship Packages Within D Days,” we have packets in port A that must be transferred to port B in D days. we are given a weights array that contains the weight of each packet and the number of days in which we ...

Read more

Question 111. Can Make Arithmetic Progression From Sequence Leetcode Solution Problem statement In the problem ” Can Make Arithmetic Progression From Sequence” we are given an array, now we need to answer if it is possible to generate an Arithmetic Progression by rearranging the sequence. Example arr = [3,1,5] true Explanation: We can rearrange the array as{1,3,5} which forms an ...

Read more

Question 112. Best Time to Buy and Sell Stock III Leetcode Solution Problem statement In the problem “Best Time to Buy and Sell Stock  III,” we are given an array where each element in the array contains the price of the given stock on that day. The definition of the transaction is buying one share of stock and selling that one share ...

Read more

Question 113. Best Time to Buy and Sell Stock  II Leetcode Solution Problem statement In the problem “Best Time to Buy and Sell Stock  II,” we are given an array where each element in the array contains the price of the given stock on that day. The definition of the transaction is buying one share of stock and selling that one share ...

Read more

Question 114. Best Time to Buy and Sell Stock with Transaction Fee Leetcode Solution Problem statement In the problem “Best Time to Buy and Sell Stock with Transaction Fee,” we are given an array where each element in the array contains the price of the given stock on that day. The definition of the transaction is buying one share of stock and selling that ...

Read more

Question 115. Count of index pairs with equal elements in an array Suppose, we have given an integer array. The problem “Count of index pairs with equal elements in an array” asks to find out the no of pair of indices (i,j) in such a way that arr[i]=arr[j] and i is not equal to j. Example arr[] = {2,3,1,2,3,1,4} 3 Explanation Pairs ...

Read more

Question 116. Find Sum of all unique sub-array sum for a given array Suppose you have an array of integers. The problem “Find Sum of all unique sub-array sum for a given array” asks to find out the sum of all unique sub-arrays (Sub-array sum is the sum of each sub-array’s elements). By unique sub-array sum, we meant to say that no sub-array ...

Read more

Question 117. Minimum Sum Path in a Triangle Problem Statement The problem “Minimum Sum Path in a Triangle” states that you are given a sequence in the form of a triangle of integers. Now starting from the top row what is the minimum sum you can achieve when you reach the bottom row? Example 1 2 3 5 ...

Read more

Question 118. Longest subarray not having more than K distinct elements The problem “Longest subarray not having more than K distinct elements” states that suppose you have an array of integers, the problem statement asks to find out the longest sub-array that having not greater than k different elements. Example arr[] = {4, 3, 5, 2, 1, 2, 0, 4, 5} ...

Read more

Question 119. Given an Array of Pairs Find all Symmetric Pairs in it Find all symmetric pairs – You are given some pairs of an array. You have to find out the symmetric pairs in it. The symmetric pair is said to be symmetric when in pairs say (a, b) and (c, d) in which ‘b’ is equal to ‘c’ and ‘a’ is ...

Read more

Question 120. Minimum operation to make all elements equal in array The problem “Minimum operation to make all elements equal in array” states that you are given an array with some integers in it. You have to find out the minimum operations that can be done to make an array equal. Example [ 1,3,2,4,1] 3 Explanation Either 3 subtractions can be ...

Read more

Question 121. Construct Binary Tree from given Parent Array representation The problem “Construct Binary Tree from given Parent Array representation” states that you are given an array. This input array represents a binary tree. Now you need to construct a binary tree on the basis of this input array. The array stores the index of parent node at each index. ...

Read more

Question 122. Find subarray with given sum (Handles Negative Numbers) The problem “Find subarray with given sum (Handles Negative Numbers)” states that you are given an integer array, containing negative integers as well and a number called “sum”. The problem statement asks to print the sub-array, which sums up to a given number called “sum”.  If more than one sub-array ...

Read more

Question 123. Length of the largest subarray with contiguous elements The problem “Length of the largest subarray with contiguous elements” states that you are given an integer array. The problem statement asks to find out the length of the longest contiguous sub-array of which elements can be arranged in a sequence (continuous, either ascending or descending). The numbers in the ...

Read more

Question 124. Count number of triplets with product equal to given number The problem “Count number of triplets with product equal to given number” states that we are given an integer array and a number m. The problem statement asks to find out the total number of triplets of with product equals to m. Example arr[] = {1,5,2,6,10,3} m=30 3 Explanation Triplets ...

Read more

Question 125. Maximum difference between first and last indexes of an element in array Suppose, you have an array of integers. The problem “Maximum difference between first and last indexes of an element in array” asks to find out the difference between the first and last index of each number present in an array such that the difference is being maximum of all. Example ...

Read more

Question 126. Find four elements that sum to a given value (Hashmap) The problem “Find four elements that sum to a given value (Hashmap)” states that suppose, you have an integer array and a number called sum. The problem statement asks to determine if four elements present in the array which sums up to the given value “sum”. If true, then function ...

Read more

Question 127. Longest subsequence such that difference between adjacents is one The problem “Longest subsequence such that difference between adjacents is one” states that you are given an integer array. Now you need to find the length of longest subsequence such that the difference of adjacent elements is 1. Example 1 2 3 4 7 5 9 4 6 Explanation As ...

Read more

Question 128. Find all triplets with zero sum The problem “Find all triplets with zero sum” states that you are given an array containing positive and negative number both. The problem statement asks to find out the triplet with the sum equal to 0. Example arr[] = {0,-2,1,3,2,-1} (-2 -1  3) (-2 0  2) (-1 0  1) Explanation ...

Read more

Question 129. Check if a given array contains duplicate elements within k distance from each other The problem “Check if a given array contains duplicate elements within k distance from each other” states that we have to check for duplicates in given unordered array within the range of k. Here the value of k is smaller than the given array. Examples K = 3   arr[] = ...

Read more

Question 130. Pair with given product The problem “Pair with given product” states that you are given an integer array and a number “x”. Determine, whether an array consists of a pair of which product equals ‘x’ exist in the given input array. Example [2,30,12,5] x = 10 Yes, it has Product Pair Explanation Here 2 ...

Read more

Question 131. Maximum Distance in Array The problem “Maximum Distance in Array” states that you are given “n” no. of arrays and all the arrays are given in ascending order. Your task is to find the maximum difference/absolute difference of two numbers in an array and we can define the maximum distance between two numbers as ...

Read more

Question 132. First element occurring k times in an array We have given a number ‘k’ and an integer array. The problem “First element occurring k times in an array” says to find out the first element in the array which occurs exactly k times in an array. If there is no element in the array which occurs k times ...

Read more

Question 133. Print all subarrays with 0 sum You are given an integer array, your task is to print all the possible sub-arrays with sum is equal to 0. So we need to Print all subarrays with 0 sum. Example arr[] = {-2, 4, -2, -1, 1, -3, 1, 5, 7, -11, -6} Sub-Array found from 0 index ...

Read more

Question 134. Contains Duplicate We are given an array and it may be containing duplicates elements or maybe not. So we need to check if it contains duplicate. Examples [1, 3, 5, 1] true [“apple”, “mango”, “orange”, “mango”] true [22.0, 4.5, 3.98, 45.6, 13.54] false Approach We can check an array in several ways ...

Read more

Question 135. Form minimum number from given sequence The problem “Form minimum number from given sequence” states that you are given some pattern of I’s and D’s only. The meaning of I stands for increasing and for decreasing we are provided with D. The problem statement asks to print the minimum number which satisfies the given pattern. We have ...

Read more

Question 136. Range Queries for Longest Correct Bracket Subsequence You are given a sequence of some brackets subsequence, in other words, you are given brackets like ‘(’ and ‘)’ and you are given a query range as a starting point and ending point. The problem “Range Queries for Longest Correct Bracket Subsequence” asks to find out the maximum length ...

Read more

Question 137. Largest subarray with equal number of 0s and 1s You are given an array of integers. The integers are only 0 and 1 in the input array. The problem statement asks to find out the largest sub-array that can have equal count of 0s and 1s. Example arr[]={0,1,0,1,0,1,1,1} 0 to 5 (total 6 elements) Explanation From the array position ...

Read more

Question 138. Binary array after M range toggle operations You are given a binary array, which consists of 0 initially and Q number of queries. The problem statement asks to toggle the values (converting 0s into 1s and 1s into 0s). After the Q queries performed, print the resultant array. Example arr[] = {0, 0, 0, 0, 0} Toggle(2,4) ...

Read more

Question 139. Non-overlapping sum of two sets Problem Statement The problem “Non-overlapping sum of two sets” states that you are given two arrays as input values as arrA[] and arrB[] of the same size n. Also, both of the arrays have distinct elements individually and some common elements. Your task is to find out the total sum ...

Read more

Question 140. Find all pairs (a, b) in an array such that a % b = k Problem Statement The problem “Find all pairs (a, b) in an array such that a % b = k” states that you are given an array of integers and an integer value called k. The problem statement asks to find out the pair in such a way that that x ...

Read more

Question 141. Range LCM Queries Problem Statement The problem “Range LCM Queries” states that you have an integer array and q number of queries. Each query contains the (left, right) as a range. The given task is to find out the LCM(left, right), i.e, LCM of all the number that comes in the range of ...

Read more

Question 142. Queries for GCD of all numbers of an array except elements in a given range Problem Statement The “Queries for GCD of all numbers of an array except elements in a given range” problem states that you will be given an integer array and a q number of queries. Each query contains the number left and right. The problem statement asks to find out the ...

Read more

Question 143. Find whether a subarray is in form of a mountain or not Problem Statement The problem “Find whether a subarray is in form of a mountain or not” states that you are given an integer array and a range. The problem statement asks to find out whether the sub-array formed between the given range is in form of a mountain form or ...

Read more

Question 144. Subset Sum Problem in O(sum) space Problem Statement The “Subset sum in O(sum) space” problem states that you are given an array of some non-negative integers and a specific value. Now find out if there is a subset whose sum is equal to that of the given input value. Example Array = {1, 2, 3, 4} ...

Read more

Question 145. Find Index of Closing Bracket for a Given Opening Bracket in an Expression Problem Statement Given a string s of length/size n and an integer value representing the index of an opening square bracket. Find index of closing bracket for a given opening bracket in an expression. Example s = "[ABC[23]][89]" index = 0 8 s = "[C-[D]]" index = 3 5 s ...

Read more

Question 146. Gold Mine Problem Problem Statement The “Gold Mine problem” states that you are given a 2D grid having some non-negative coins placed in each cell of the given grid. Initially, the miner is standing at the first column but there is no restriction on the row. He can start in any row. The ...

Read more

Question 147. Longest Increasing Consecutive Subsequence Subsequences are another topic loved by interviewers. Tweaking them around can always give them new opportunities for testing candidates. It can check the candidate’s ability to think and analyze things and come up with the best and optimal solutions. Today we are solving a subsequence problem that will be doing ...

Read more

Question 148. Best Time to Buy and Sell Stock Problem Statement The problem “Best Time to Buy and Sell Stock” states that you are given an array of prices of length n, where the ith element stores the price of stock on ith day. If we can make only one transaction, that is, to buy on one day and ...

Read more

Question 149. Top K Frequent Elements Problem Statement In top K frequent elements we have given an array nums[], find the k most frequently occurring elements. Examples nums[] = {1, 1, 1, 2, 2, 3} k = 2 1 2   nums[] = {1} k = 1 1 Naive Approach for Top K Frequent Elements Build ...

Read more

Question 150. Bubble sort using two Stacks Problem Statement The problem “Bubble sort using two Stacks” states that you are given an array a[ ] of size n. Create a function to sort the given array a[ ] using a bubble sort paradigm with two stack data structures. Example a[ ] = {15, 12, 44, 2, 5, ...

Read more

Question 151. Sort an array according to the order defined by another array Problem Statement You are given two arrays of integers arr1[] and arr2[]. The problem “Sort an array according to the order defined by another array” asks to sort the first array according to the second array so that the numbers in first array will be relatively sorted off all the ...

Read more

Question 152. Construction of Longest Increasing Subsequence (N log N) Problem Statement You are given an array of integers. The problem “Construction of Longest Increasing Subsequence (N log N)” asks to construct the longest increasing subsequence. Example arr[]={1, 4, 7, 2, 9, 6, 12, 3 } 12, 9, 7, 4, 1 and the size of this longest increasing subsequence is ...

Read more

Question 153. Minimum time required to rot all oranges Problem Statement The problem “Minimum time required to rot all oranges” states that you are given a 2D array, every cell has one of the three possible values 0, 1 or 2. 0 means an empty cell. 1 means a fresh orange. 2 means a rotten orange. If a rotten ...

Read more

Question 154. Rearrange an array such that ‘arr[j]’ becomes ‘i’ if ‘arr[i]’ is ‘j’ Problem Statement The problem ” Rearrange an array such that ‘arr[j]’ becomes ‘i’ if ‘arr[i]’ is ‘j’ ” states that you have an “n” sized array containing integers. The numbers in the array are in a range of 0 to n-1. The problem statement asks to rearrange the array in ...

Read more

Question 155. Maximum Product Subarray Problem Statement The problem “Maximum Product Subarray” states that you are given an array of integer containing both positive and negative numbers. The problem statement asks to find out the maximum product of the sub-array. Example arr[] = { 2, -2, 3, 5} 15 Explanation The elements in the sub-array ...

Read more

Question 156. Convert array into Zig-Zag fashion Problem Statement The problem “Convert array into Zig-Zag fashion” states that you are given an – of integers. The problem statement asks to sort the array in a zig-zag manner such that the elements in the array will look like à  a < b > c < d > e ...

Read more

Question 157. First negative integer in every window of size k Problem Statement The problem “First negative integer in every window of size k” states that you are given an array containing positive and negative integers, for every window of size k print the first negative integer in that window. If there is no negative integer in any window then output ...

Read more

Question 158. Distance of nearest cell having 1 in a binary matrix Problem Statement The problem “Distance of nearest cell having 1 in a binary matrix” states that you are given a binary matrix(containing only 0s and 1s) with at least one 1. Find the distance of the nearest cell having 1 in the binary matrix for all the elements of the ...

Read more

Question 159. Form Minimum Number From Given Sequence Problem Statement The problem “Form Minimum Number From Given Sequence states that you are given a string s of length/size n representing a pattern of characters ‘I’ i.e. increasing and ‘D’ i.e. decreasing only. Print the minimum number for the given pattern with unique digits from 1-9. For instance – ...

Read more

Question 160. Number Of Longest Increasing Subsequence Problem Statement The problem “Number Of Longest Increasing Subsequence” states that you are given an array a[ ] of size n. Print the number of longest increasing subsequences in it. Example a[ ] = {1, 2, 5, 4, 7} 2 Explanation: The longest increasing subsequences can be seen in the ...

Read more

Question 161. Find Minimum In Rotated Sorted Array Problem Statement “Find Minimum In Rotated Sorted Array” states that you are given a sorted array of size n which is rotated at some index. Find the minimum element in the array. Example a[ ] = {5, 1, 2, 3, 4} 1 Explanation: If we arrange the array in sorted ...

Read more

Question 162. Implementation of Deque using circular array Problem Statement “Implementation of Deque using circular array” asks to implement the following functions of a Deque(Doubly Ended Queue) using circular array, insertFront(x) : insert an element x at the front of Deque insertRear(x) : insert an element x at the rear of Deque deleteFront() : delete an element from ...

Read more

Question 163. Rearrange an array in order – smallest, largest, 2nd smallest, 2nd largest Problem Statement Suppose you have an integer array. The problem “Rearrange an array in order – smallest, largest, 2nd smallest, 2nd largest, ..” asks to rearrange the array in such a way that the smallest number comes first and then the largest number, then second smallest and then the second ...

Read more

Question 164. Rearrange array such that even positioned are greater than odd Problem Statement Suppose you have an integer array. The problem “Rearrange array such that even positioned are greater than odd” asks to rearrange the array such the elements at even position in an array should be greater than the element just before it. Arr[i-1] < = Arr[i], if position ‘i’ ...

Read more

Question 165. Arrange given numbers to form the biggest number Problem Statement Suppose you have an array of integers. The problem “Arrange given numbers to form the biggest number”  asks to rearrange the array in such a manner that the output should be the maximum value which can be made with those numbers of an array. Example [34, 86, 87, ...

Read more

Question 166. Remove duplicates from sorted array Problem Statement “Remove duplicates from sorted array” states that you are given a sorted array of size N. You need to remove the duplicate elements from the array. Print the array containing unique elements after the removal of duplicate elements. Example a [] = {1, 1, 1, 1} {1} Explanation: ...

Read more

Question 167. Count subarrays having total distinct elements same as original array Problem Statement “Count subarrays having total distinct elements same as original array” states that you are given an integer array. The problem statement asks to find out the total number of sub-arrays that contain all distinct elements as present in an original array. Example arr[] = {2, 1, 3, 2, ...

Read more

Question 168. Product of array except self Problem Statement “Product of array except self” problem, states that you are given an array a [ ]. Print another array p [ ] of the same size such that value at i’th index of array p is equal to the product of all the elements of the original array ...

Read more

Question 169. First missing positive Problem Statement “First missing positive” problem states that you are given an array a[ ] (sorted or unsorted) of size n. Find the first positive number that is missing in this array. Example a[ ] = {1, 3, -1, 8}  2 Explanation: If we sort the array we get {-1, ...

Read more

Question 170. Contiguous Array Leetcode Problem Statement “Contiguous Array Leetcode” problem states that you are given an array a[ ] of size n consists of 1’s and 0’s only. Find the longest subarray in which the number of 1’s is equal to the number of 0’s. Example a[ ] = {1, 0, 1, 1, 1, ...

Read more

Question 171. Numbers with prime frequencies greater than or equal to k Problem Statement Problem “Numbers with prime frequencies greater than or equal to k” states that you are given an array of integers size n and an integer value k. All the numbers inside it are prime numbers. The problem statement asks to find out the numbers which appear in the ...

Read more

Question 172. Find pairs with given sum such that elements of pair are in different rows Problem Statement “Find pairs with given sum such that elements of pair are in different rows” problem states that you are given a matrix of integers and a value called “sum”. The problem statement asks to find out all the pairs in a matrix that sums up to a given ...

Read more

Question 173. Common elements in all rows of a given matrix Problem Statement “Common elements in all rows of a given matrix” problem state that, you are given a matrix of M*N. The problem statement asks to find out all the common elements in a given matrix in each row of the matrix in O(M*N) time. Example arr[]={{12, 1, 4, 5, ...

Read more

Question 174. Collect maximum points in a grid using two traversals Problem Statement We are given a matrix of size “n x m”, and we need to collect maximum points in a grid using two traversals. If we are standing at cell i,j then we have three options to go to cell i+1, j or i+1, j-1or i+1, j+1. That is ...

Read more

Question 175. Given two unsorted arrays find all pairs whose sum is x Problem Statement Given two unsorted arrays, find all pairs whose sum is x problem states that you are given two arrays of integers that are unsorted and a value called sum. The problem statement asks to find out the total number of pairs and print all those pairs that add ...

Read more

Question 176. Sort elements by frequency Problem Statement You are given an array of integers, some numbers are repeated in it. The problem statement asks to print the number in the array in decreasing order according to their frequency that is to sort elements by frequency. Example arr[]={3,4,3,1,2,9,2,9,2,5 } 2 2 2 3 3 9 9 ...

Read more

Question 177. Find the first repeating element in an array of integers Problem Statement Find the first repeating element in an array of integers problem states that you are given an array of integer. It asks to find out the first repeating element from the array and print that number. Example arr[] = {2,6,9,3,1,9,1} 9 Explanation: In the given array there are ...

Read more

Question 178. Find the subarray with least average Problem Statement You have given an integer array and a number k. The problem statement asks to find the subarray with least average, which is to find out the sub-array of k elements, which has the minimum average. Example arr[] = {12, 34, 20, 30, 24, 45} k = 3 Sub-Array of [0, 2] has a minimum average. Explanation: ...

Read more

Question 179. Find minimum number of merge operations to make an array palindrome Problem Statement You are given an array of integers. The problem statement asks to find minimum number of merge operations to make an array palindrome, i.e. find out the minimum number of merging operations to be done on the array to make it a palindrome. Merging operation simply means that ...

Read more

Question 180. Check given array of size n can represent BST of n levels or not Problem Statement Given an array with n elements, check given array of size n can represent BST of n levels or not. That is to check whether the binary search tree constructed using these n elements can represent a BST of n levels. Examples arr[] = {10, 8, 6, 9, ...

Read more

Question 181. Find maximum average subarray of k length Problem Statement You are given an array of integers and a number k. The problem statement asks to find maximum average subarray of k length. Subarray is nothing but an array composed from a contiguous block of the original array’s elements Example arr[] = {1,3,12,34,76,10} [2, 4] Explanation: Array starting ...

Read more

Question 182. Printing brackets in Matrix Chain Multiplication Problem Problem Statement We need to find the order of multiplication of matrices such that the number of operations involved in the multiplication of all the matrices is minimized. Then we need to print this order i.e. printing brackets in matrix chain multiplication problem. Consider you have 3 matrices A, B, ...

Read more

Question 183. Find minimum difference between any two elements Problem Statement You are given an array of integers. The problem statement asks to find minimum difference between any two elements given in the array. Example arr[] = {11,1,6,8,20,13} 2 Explanation: Minimum difference between 11 and 13 is 2. arr[] = {19,14,80,200,32,29} 3 Explanation: Minimum difference between 32 and 29 ...

Read more

Question 184. Largest rectangular sub-matrix whose sum is 0 Problem Statement Find the maximum size sub-matrix in a 2D array whose sum is zero. A sub-matrix is nothing but a 2D array inside of the given 2D array. So, you have a matrix of signed integers, you need to calculate the sum of sub-matrices and find the matrix with ...

Read more

Question 185. Maximum sum rectangle in a 2D matrix Problem Statement Find the maximum sum rectangle in a 2D matrix i.e. to find a sub-matrix with maximum sum. A sub-matrix is nothing but a 2D array inside of the given 2D array. So, you have a matrix of signed integers, you need to calculate the sum of sub-matrices and ...

Read more

Question 186. Maximum Sum Increasing Subsequence Problem Statement You are given an array of integers. Your task is to find out the maximum sum subsequence within the array in such a way that the numbers in subsequence should be ordered in a sorted manner in increasing order. A subsequence is nothing but a sequence that we ...

Read more

Question 187. Largest Sum Contiguous Subarray Problem Statement You are given an array of integers. The problem statement asks to find out the largest sum contiguous subarray. This means nothing but to find a subarray (continuous elements) which has the largest sum among all other subarrays in the given array. Example arr[] = {1, -3, 4, ...

Read more

Question 188. Matrix Chain Multiplication In the matrix chain multiplication II problem, we have given the dimensions of matrices, find the order of their multiplication such that the number of operations involved in multiplication of all the matrices is minimized. Consider you have 3 matrices A, B, C of sizes a x b, b x ...

Read more

Question 189. Sorted Array to Balanced BST In sorted array to balanced BST problem, we have given an array in sorted order, construct a Balanced Binary Search Tree from the sorted array. Examples Input arr[] = {1, 2, 3, 4, 5} Output Pre-order : 3 2 1 5 4 Input arr[] = {7, 11, 13, 20, 22, ...

Read more

Question 190. Single Number Given an array a[ ] of size n. All the elements in the array are present twice except for 1. Find the element which appears only once or in other words we say that find the single number. Example Input : a[ ] = {1, 3, 5, 5, 2, 1, 3} ...

Read more

Question 191. Subset Leetcode In Subset Leetcode problem we have given a set of distinct integers, nums, print all subsets (the power set). Note: The solution set must not contain duplicate subsets. An array A is a subset of an array B if a can be obtained from B by deleting some (possibly, zero ...

Read more

Question 192. Shuffle an Array Given an array or set which contains n elements. Here the elements are unique or there is no repetition. Shuffle an array(or a set) of numbers without duplicates. Example // Init an array with set 2, 4, 3 and 1. int[] nums = {2, 4, 3, 1}; Shuffle object = ...

Read more

Question 193. Maximal Square In the maximal square problem we have given a 2D binary matrix filled with 0’s and 1’s, find the largest square containing only 1’s, and return its area. Example Input: 1 0 1 0 0 0 0 1 1 1 1 1 1 1 1 0 0 0 1 0 ...

Read more

Question 194. Dividing Array into Pairs With Sum Divisible by K The dividing array into pairs with sum divisible by K is a problem which is asked in interviews with various tweaks now and then. Those who know me know my habit of converting these problems into stories. In this article let us look into this problem. Situation To Understand The ...

Read more

Question 195. Count Distinct Elements in Every Window of Size K Subsets are something which we have been dealing with for some time now. In the last episode, we covered the number of subsets we could make with distinct even numbers. This time we count distinct elements in every window of size K. Section-1 About the problem. Given an unsorted array ...

Read more

Question 196. Find Three Element From Different Three Arrays Such That a + b + c = sum Three Sum is a problem loved by interviewers. It is a problem I was personally asked during the Amazon interview. So, without wasting any more time let us get to the problem. An array that has both positive and negative numbers. Three numbers that sum up to zero/can be modified, ...

Read more

Question 197. Word Search Word search is something like the word-finding puzzles at some time in our life. Today I bring to the table a modified crossword. My readers must be a bit perplexed as to what I am talking about. Without wasting any more time let us get to the problem statement Can ...

Read more

Question 198. K Empty Slots K empty slots correctly present a gardener’s dilemma, trying to pick flowers that suit our condition. Our gardener has a field of N-slots. Mr gardener has planted a flower in each one of the slots. Each flower will bloom on a certain unique day. Also, we have planted evergreen flowers. ...

Read more

Question 199. Count Pairs Whose Products Exist in Array In count pairs whose products exist in array problem we have given an array, count all the distinct pairs whose product value is present in the array. Example Input A[]={2, 5, 6, 3, 15} Output Number of distinct pairs whose product exists in the array is: 2 Pairs are: (2, ...

Read more

Question 200. Print All Distinct Elements of a Given Integer Array Given an integer array, print all distinct elements in the array. The given array may contain duplicates and the output should print every element only once. The given array is not sorted. Example Input: nums[]= {12, 10, 9, 45, 2, 10, 10, 45} Output: 12, 10, 9, 45, 2 Approach ...

Read more

Question 201. Pair of Positive Negative Values in an Array In pair of positive negative values in an array problem we have given an array A of distinct integers, print all the pairs having positive value and negative value of a number that exists in the array. We need to print pairs in order of their occurrences. A pair whose ...

Read more

Question 202. Count Pairs With Given Sum Given an integer array of size n, and an integer  ‘K’, you need to count the number of pairs(need not to be unique) present in the array whose sum is equal to ‘K’. Example Input: Arr={1,  5,  7, 1} K=6 Output: 2 Brute force solution for Count Pairs With Given Sum Main idea ...

Read more

Question 203. Insert Delete GetRandom In Insert Delete GetRandom problem we need to design a data structure that supports all following operations in average O(1) time. insert(val): Inserts an item val to the set if not already present. remove(val): Removes an item val from the set if present. getRandom: Returns a random element from the current set ...

Read more

Question 204. Merge Overlapping Intervals In merge overlapping intervals problem we have given a collection of intervals, merge and return all overlapping intervals. Example Input : [[2, 3], [3, 4], [5, 7]] Output: [[2, 4], [5, 7]] Explanation: We can merge [2, 3] and [3, 4] together to form [2, 4] Approach for finding Merge ...

Read more

Question 205. Median of Two Sorted Arrays Given two sorted arrays A and B of size n and m respectively. Find the median of the final sorted array obtained after merging the given two arrays or in other words, we say that find median of two sorted arrays. ( Expected time complexity: O(log(n)) ) Approach 1 for ...

Read more

Question 206. Maximum Product Subarray In the maximum product subarray problem, we have given an array of integers, find the contiguous sub-array with atleast one element which has the largest product. Example Arr=[ 0, -1, 0 ,1 ,2, -3] Maximum product = 2 Arr=[-1, -1, -1] Maximum product = -1 Arr=[0, -1, 0, -2, 0] ...

Read more

Question 207. Find Maximum of Minimum for Every Window Size in a Given Array Given an array a[ ] of size n. For every window size that varies from 1 to n in array print or find maximum of minimum for every window size in a given array. Example Input : a[ ] = {10, 20, 30, 50, 10, 70, 30} Output : 70 30 20 ...

Read more

Question 208. Minimum Size Subarray Sum Given an array nums of a positive integer and a sum s, find the minimum size of a contiguous subarray of nums such that whose sum equals to or greater than s(given value). Example Input: nums[] = {2, 3, 1, 2, 4, 3} s = 7 Output: 2   {Subarray [4, ...

Read more

Question 209. Search an Element in Sorted Rotated Array In search in sorted rotated array problem we have given a sorted and rotated array and an element, check if the given element is present in the array or not. Examples Input nums[] = {2, 5, 6, 0, 0, 1, 2} target = 0 Output true Input nums[] = {2, ...

Read more

Question 210. Maximum Product Subarray Given an array of n integers, find the maximum product obtained from a contiguous subarray of the given array. Examples Input arr[] = {-2, -3, 0, -2, -40} Output 80 Input arr[] = {5, 10, 6, -2, 1} Output 300 Input arr[] = {-1, -4, -10, 0, 70} Output 70 ...

Read more

Question 211. Set Matrix Zeroes In the set matrix zeroes problem, we have given a (n X m) matrix, if an element is 0, set its entire row and column 0. Examples Input: { [1, 1, 1] [1, 0, 1] [1, 1, 1] } Output: { [1, 0, 1] [0, 0, 0] [1, 0, 1] ...

Read more

Question 212. 3 Sum In 3 Sum problem, we have given an array nums of n integers, find all the unique triplets that sum up to 0. Example Input: nums = {-1, 0, 1, 2, -1, -4} Output: {-1, 0, 1}, {-1, 2, -1} Naive Approach for 3 Sum problem The Brute force approach ...

Read more

Question 213. Find The Duplicate Number Given an array nums containing (n + 1) elements and every element is between 1 to n. If there is only one duplicate element, find the duplicate number. Examples Input: nums = {1, 3, 4, 2, 2} Output: 2 Input: nums = {3, 1, 3, 4, 2} Output: 3 Naive ...

Read more

Question 214. Reservoir Sampling Reservoir Sampling is a technique of selecting k reservoir items randomly from a given list of n items, where n is very large. For example, search lists in Google, YouTube etc. Naive Approach for Reservoir Sampling Build a reservoir array of size k, randomly select items from the given list. ...

Read more

Question 215. Most Frequent Element in an Array You are given an array of integers. The problem statement says that you have to find out the most frequent element present in an array. If there are multiple values that occurs the maximum number of times, then we have to print any of them. Example Input [1, 4,5,3,1,4,16] Output ...

Read more

Question 216. Minimum Path Sum In the minimum path sum problem, we have given “a × b” matrix consisting of non-negative numbers. Your task is to find the path from top left to right bottom which minimizes the sum consisting of all the numbers which come in a path you found. Note: You can only move ...

Read more

Question 217. How to Efficiently Implement k Stacks in a Single Array? Design and implement a new data structure that Implement k Stacks in a Single Array. The new data structure must support these two operations – push (element, stack_number): that pushes the element in a given number of the stack. pop (stack_number): that pop out the top element from a given ...

Read more

Question 218. Print Next Greater Number of Q queries In Print Next Greater Number of Q queries problem we have given an array a[ ] of size n containing numbers and another array q[ ] of size m representing queries. Each query represents the index in array a[ ]. For each query, i print the number from the array ...

Read more

Question 219. Check if an Array is Stack Sortable In check if an array is stack sortable problem we have given an array a[ ] of size n containing elements from 1 to n in random order. Sort the array in ascending order using a temporary stack following only these two operations – Remove the element at the starting ...

Read more

Question 220. Find Top K (or Most Frequent) Numbers in a Stream In find top k (or most frequent) numbers in a stream problem, we have given an integer array consisting of some numbers. The problem statement says that you have to take an element from the array, and you can only have at most k numbers at the top. We need ...

Read more

Question 221. K Empty Slots LeetCode K Empty Slots is a very famous problem on LeetCode. The problem statement is like that- A garden is consists of n slots containing a flower each. All the flowers are unbloomed initially. Given an array a[ ] of flowers and an integer k. Considering i stating from 0, i+1’th ...

Read more

Question 222. Trapping Rain Water LeetCode Solution In the Trapping Rain Water LeetCode problem, we have given N non-negative integers representing an elevation map and the width of each bar is 1. We have to find the amount of water that can be trapped in the above structure. Example Let’s understand that by an example For the ...

Read more

Question 223. Sliding Window Technique Before getting on and along with what is the sliding window technique? What it does and how it does what it does let us get the hang of this concept by a small problem Given an array of integers, we have the task of finding the minimum sum from all ...

Read more

Question 224. Finding K closest element In Finding K closest element problem we have given a sorted array and a value x. The problem is to find the K number of elements closest to x in the given array. Given an array arr[] ={12, 16, 22, 30, 35, 39, 42,45, 48, 50, 53, 55, 56} and x ...

Read more

Question 225. Jump Game In jump game we have given an array of non-negative integers, you are initially positioned at the first index of the array. Each element in the array represents your maximum jump length at that position. Determine if you are able to reach the last index. Example Input: arr = [2,3,1,1,4] ...

Read more

Question 226. Postfix to Prefix Conversion In this problem, we have given a string that denotes the postfix expression. We have to do postfix to prefix conversion. Prefix Notation In this notation, we write the operands after the operator. It is also known as Polish Notation. For instance: +AB is a prefix expression. Postfix Notation In ...

Read more

Question 227. Combination Sum In combination sum problem we have given an array of positive integers arr[] and a sum s, find all unique combinations of elements in arr[] where the sum of those elements is equal to s. The same repeated number may be chosen from arr[] an unlimited number of times. Elements ...

Read more

Question 228. Max Area of Island Problem Description: Given a 2D matrix, the matrix has only 0(representing water)  and 1(representing land) as entries. An island in the matrix is formed by grouping all the adjacent 1’s connected 4-directionally(horizontal and vertical). Find the maximum area of the island in the matrix. Assume that all four edges of ...

Read more

Question 229. Search in Sorted Rotated Array An element search in sorted rotated array can be found using binary search in O(logn) time. The objective of this post is to find a given element in a sorted rotated array in O(logn) time. Some example of a sorted rotated array is given. Example Input : arr[] = {7,8,9,10,1,2,3,5,6}; ...

Read more

Question 230. Unique Paths A m x n 2D  grid is given and you are standing at the topmost and leftmost cell in the grid. i.e. the cell located at (1,1). Find the number of unique paths that can be taken to reach a cell located at (m,n) from the cell located at (1,1) ...

Read more

Question 231. Maximum Subarray In the Maximum Subarray problem we have given an integer array nums, find the contiguous sub array which has the largest sum and print the maximum sum subarray value. Example Input nums[] = {-2, 1, -3, 4, -1, 2, 1, -5, 4} Output 6 Algorithm The goal is to find ...

Read more

Question 232. Length of Longest Fibonacci Subsequence Given a strictly increasing array of positive integers, find the length of the longest fibonacci subsequence. A sequence of n elements is fibonacci like if, n >= 3 xi = x(i – 2) + x(i -1), where xi is the ith term of the sequence and i >= 2 Examples Input arr[] ...

Read more

Question 233. Merging Intervals In merging intervals problem we have given a set of intervals of the form [l, r], merge the overlapping intervals. Examples Input {[1, 3], [2, 6], [8, 10], [15, 18]} Output {[1, 6], [8, 10], [15, 18]} Input {[1, 4], [1, 5]} Output {[1, 5]} Naive Approach for merging intervals ...

Read more

Question 234. 4Sum In the 4Sum problem, we have given an integer x and an array a[ ] of size n. Find all the unique set of 4 elements in array such that sum of those 4 elements is equal to the given integer x. Example Input  a[ ] = {1, 0, -1, ...

Read more

Question 235. Find Peak Element Let’s understand Find Peak Element problem. Today we have with us an array that needs its peak element. Now, you must be wondering as to what do I mean by the peak element? The peak element is one which is greater than all its neighbours. Example: Given an array of ...

Read more

Question 236. K-th Smallest Element in a Sorted Matrix In K-th Smallest Element in a Sorted Matrix problem, we have given an n x n matrix, where every row and column is sorted in non-decreasing order. Find the kth smallest element in the given 2D array. Example Input 1: k = 3 and matrix = 11, 21, 31, 41 ...

Read more

Question 237. Pascal Triangle Leetcode The Pascal Triangle is a very good Leetcode problem that is asked so many times in Amazon, Microsoft, and other companies. we have given non-negative integer rows, print first rows rows of the pascal triangle. Example rows = 5 rows = 6 Types of solution for Pascal Triangle Leetcode Dynamic Programming ...

Read more

Question 238. Missing Number In Missing Number problem we have given an array of size N containing a number from 0 to N. All the values in the array are unique. We need to find the missing number which is not present in the array and that number lies between 0 to N. Here ...

Read more

Question 239. Merge Sorted Array In merge sorted array problem we have given two sorted arrays in increasing order. In input first, we have given the number initialized to array1 and array2. These two-number are N and M. The size of array1 is equal to the sum of N and M. In array 1 first ...

Read more

Question 240. Partition Equal Subset Sum Partition Equal Subset Sum is a problem in which we have given an array of positive numbers. We have to find out that can we divide it into two subsets such that the sum of elements in both sets is the same. Here it’s not necessary that the number of ...

Read more

Question 241. Sort Colors Sort colors is a problem in which we have to given an array containing N objects. Each box is painted with a single color which can be red, blue, and white. We have N objects which are already painted. We have to sort the array such that the same color ...

Read more

Question 242. Rotate Array Rotate array is a problem in which we have given an array of size N. We have to rotate the array in the right direction. Each element shift by one position right and last element of the array come to the first position. So, we have given a value K ...

Read more

Question 243. Container with Most Water Problem description : you are given n integers (y0, y1, y2 … yn-1) at n indices (i = 0,1,2 … n-1). Integer at i-th index is yi. Now, you draw n lines on a cartesian plane each connecting points (i, yi) and (i, 0). Find the maximum volume of water ...

Read more

Question 244. Matrix Chain Multiplication using Dynamic Programming Matrix Chain Multiplication is a method in which we find out the best way to multiply the given matrices. We all know that matrix multiplication is associative(A*B = B*A) in nature. So, we have a lot of orders in which we want to perform the multiplication. Actually, in this algorithm, ...

Read more

Question 245. Subarray Sum Equals k Given an integer array and an integer k. Find total number of contiguous subarrays of given array whose sum of elements is equal to k. Example Input 1: arr[] = {5,0,5,10,3,2,-15,4} k = 5 Output: 7 Input 2: arr[] = {1,1,1,2,4,-2} k = 2 Output: 4 Explanation : consider example-1 ...

Read more

Question 246. Subset sum problem In the subset sum problem, we are given a list of all positive numbers and a Sum. We need to check if there is a subset whose sum is equal to the given sum. Example Input List of numbers: 1 2 3 10 5 sum: 9 Output  true Explanation  for ...

Read more

Question 247. Heap Sort Heap sort is a comparison based sorting technique that is based on a Binary Heap data structure. HeapSort is similar to a selection sort where we find the maximum element and then place that element at the end. We repeat this same process for the remaining elements. Given an unsorted ...

Read more

Question 248. Coin Change Problem Coin Change Problem – Given some coins of different values c1, c2, … , cs (For instance: 1,4,7….). We need an amount n. Use these given coins to form the amount n. You can use a coin as many times as required. Find the total number of ways in which ...

Read more

Question 249. Multiplication of Two Matrices Problem Statement In the “Multiplication of Two Matrices” problem we have given two matrices. We have to multiply these matrices and print the result or final matrix. Here, the necessary and sufficient condition is the number of columns in A should be equal to the number of rows in matrix ...

Read more

Question 250. Minimum number of Merge Operations to make an Array Palindrome Problem Statement In the “Minimum number of Merge Operations to make an Array Palindrome” problem we have given an array “a[]”. Find the minimum number of merge_operations are required to make an array palindrome. Note, A palindrome is a word, phrase, or sequence that reads the same backward as forwards. ...

Read more

Question 251. Form Minimum Number from Given Sequence of D’s and I’s Problem Statement In the “Form Minimum Number from Given Sequence of D’s and I’s” problem, we have given a pattern containing only I’s and D’s. I for increasing and D for decreasing. Write a program to print the minimum number following that pattern. Digits from 1-9 and digits can’t repeat. Input Format ...

Read more

Question 252. Find the Subarray of given length with Least Average Problem Statement In the “Find the Subarray of given length with Least Average” problem we have given an array and an input integer X. Write a program to find the subarray of length X with least/minimum average. Prints the starting and ending indexes of the subarray which has the least ...

Read more

Question 253. Find Zeros to be Flipped so that Number of Consecutive 1’s is Maximized Problem Statement In the “Find Zeros to be Flipped so that Number of Consecutive 1’s is Maximized” problem we have given a binary array and a number x which denotes the no. of zeros to be flipped. Write a program to find the zeros that need to be flipped so ...

Read more

Question 254. Merge K Sorted Arrays and Print Sorted Output Problem Statement In the “Merge K Sorted Arrays and Print Sorted Output” problem we have given k sorted arrays of different size. Write a program to merge those arrays and prints the final sorted array as output. Input Format The first line containing an integer n. Next n lines containing ...

Read more

Question 255. Find the Minimum Element in a Sorted and Rotated Array Problem Statement In the “Find the Minimum Element in a Sorted and Rotated Array” problem we have given a sorted array a[]. This array is rotated at some unknown point, find the minimum element in this array. Input Format The first and only one line containing an integer value n. ...

Read more

Question 256. Sort Elements by Frequency II Problem Statement In the “Sort Elements by Frequency II” problem we have given an array a[]. Sort the array according to the frequency of the elements where the higher frequency element comes first then others. Input Format The first and only one line containing an integer n. Second-line containing n ...

Read more

Question 257. Stock Buy Sell to Maximize Profit Problem Statement In the “Stock Buy Sell to Maximize Profit” problem we have given an array that contains stock price on each day, find the maximum profit that you can make by buying and selling in those days. Here, we can buy and sell multiple times but only after selling ...

Read more

Question 258. Merge Overlapping Intervals II Problem Statement In the “Merge Overlapping Intervals II” problem we have given a set of intervals. Write a program that will merge the overlapping intervals into one and print all the non-overlapping intervals. Input Format The first line containing an integer n. Second-line containing n pairs where each pair is ...

Read more

Question 259. Maximum Subarray Sum using Divide and Conquer Problem Statement In the “Maximum Subarray Sum using Divide and Conquer” problem we have given an array of both positive and negative integers. Write a program that will find the largest sum of the contiguous subarray. Input Format The first line containing an integer N. Second-line containing an array of ...

Read more

Question 260. Pancake Sorting Problem Problem Statement “Pancake Sorting Problem” is based on pancake sorting. Given an unsorted array, we need to write a program that uses only flip operation to sort the array. Flip is the operation that reverses the array. Input Format The first line containing an integer N. Second-line containing N space-separated ...

Read more

Question 261. Pancake Sorting Problem Statement In the “Pancake Sorting” problem we have given an array of integers A[]. Sort the array by performing a series of pancake flips. In one pancake flip we do the following steps: Choose an integer k where 1 <= k <= arr.length. Reverse the sub-array arr[0…k-1] (0-indexed). Input ...

Read more

Question 262. Arrange given Numbers to Form the Biggest Number II Problem Statement In the “Arrange given Numbers to Form the Biggest Number II” problem, we have given an array of positive integers.  Arrange them in such a way that the arrangement will form the largest value. Input Format The first and only one line containing an integer n. Second-line containing ...

Read more

Question 263. Iterative Implementation of Quick Sort Problem Statement In the “Iterative Implementation of Quick Sort” problem, we have given an array a[]. We have to sort the array using quick sort. Here, quick sort is not implemented recursively, it is implemented in an iterative manner. Input Format The first line containing an integer n. Second-line containing ...

Read more

Question 264. Shuffle a given Array Problem Statement In the “Shuffle a given Array” problem we have given an array of integers. Write a program that shuffles the given array. That is, it will shuffle the elements in the array randomly. Input Format The first line containing an integer n. Second-line containing n space-separated integer Output ...

Read more

Question 265. Find the Row with Maximum Number of 1’s Problem Statement In the “Find the Row with Maximum Number of 1’s” problem we have given a matrix(2D array) containing binary digits with each row sorted. Find the row which has the maximum number of 1’s. Input Format The first line containing two integers values n, m. Next, n lines ...

Read more

Question 266. Sorting a K Sorted Array Problem Statement In the “Sorting a K Sorted Array” problem we have given an array of n elements, where each element is at most k away from its target position. Devise an algorithm that sorts in O(n log k) time. Input Format The first line containing two integer values N ...

Read more

Question 267. Maximum Product Subarray II Problem Statement In the “Maximum Product Subarray II” problem we have given an array consisting of positive, negative integers, and also zeroes. We need to find the maximum product of the subarray. Input Format The first line containing an integer N. Second-line containing N space-separated integers. Output Format The only ...

Read more

Question 268. Largest Subarray with Equal Number of 0’s and 1’s Problem Statement In the “Largest Subarray with Equal Number of 0’s and 1’s” problem, we have given an array a[] containing only 0 and 1. Find the largest subarray with an equal number of 0’s and 1’s and will print the start index and end index of the largest subarray. ...

Read more

Question 269. Maximum Sum Increasing Subsequence Problem Statement In the “Maximum Sum Increasing Subsequence” problem we have given an array. Find the sum of the maximum subsequence of the given array, that is the integers in the subsequence are in sorted order. A subsequence is a part of an array which is a sequence that is ...

Read more

Question 270. Number of Smaller Elements on Right Side Problem Statement In the “Number of Smaller Elements on Right Side” problem, we have given an array a[]. Find the number of smaller elements that are on the right_side of each element. Input Format The first and only one line containing an integer N. Second-line containing N space-separated integers. Output ...

Read more

Question 271. Increasing Subsequence of Length three with Maximum Product Problem Statement In the “Increasing Subsequence of Length three with Maximum Product” problem, we have given an array of positive integers. Find the subsequence of length 3 with the maximum product. Subsequence should be increasing. Input Format The first and only one line containing an integer N denoting the size ...

Read more

Question 272. Elements Appear more than N/K times in Array Problem Statement In the “Elements Appear more than N/K times in Array” problem we have given an integer array of size n. Find the elements which appear more than n/k times. Where k is the input value. Input Format The first and only one line containing two integers N and ...

Read more

Question 273. Find the Peak Element from an Array Problem Statement In the “Find the Peak Element from an Array” problem we have given an input array of integers. Find a peak element. In an array, an element is a peak element, if the element is greater than both the neighbours. For corner elements, we can consider the only ...

Read more

Question 274. Rearrange Positive and Negative Numbers Alternatively in Array Problem Statement In the “Rearrange Positive and Negative Numbers Alternatively in Array” problem we have given an array a[]. This array contains positive and negative integers. Rearrange the array in such a way that positive and negative are placed alternatively. Here, the number of positive and negative elements need not ...

Read more

Question 275. Find the Maximum Repeating Number in Array Problem Statement In the “Find the Maximum Repeating Number in Array” problem we have given an unsorted array of size N. Given array contains numbers in range {0, k} where k <= N. Find the number that is coming the maximum number of times in the array. Input Format The ...

Read more

Question 276. Tug of War Problem Statement In tug of war problem, we have given an array of integers, divide the array into two subsets of size n/2 size each so that the difference of the sum of two subsets is as minimum as possible. If n is even each subset size is n/2. If ...

Read more

Question 277. First Circular Tour to Visit all the Petrol Bunks In the first circular tour to visit all the petrol bunks problem the statement is such that there is a circle with n petrol pumps on the circle. Every petrol pump has a pair of data. The first value is the amount of petrol pump has and the second is ...

Read more

Question 278. Count Possible Triangles Problem Statement In count possible triangles problem we have given an array of n positive integers. Find the number of triangles that can be formed using three different elements of the array as the sides of a triangle. Note: The condition of the triangle is the sum of two sides ...

Read more

Question 279. Maximum Circular Subarray Sum Problem Statement In the maximum circular subarray sum problem, we have given an array of integers arranged in a circle, find the maximum sum of consecutive numbers in the circular array. Example Input arr[] =  {13, -17, 11, 9, -4, 12, -1} Output 40 Explanation Here, sum = 11 + ...

Read more

Question 280. Four Elements that Sum to Given Problem Statement In four elements that sum to a given problem, we have given an array containing N elements that may be positive or negative. Find the set of four elements whose sum is equal to given value k. Input Format First-line containing an integer N. Second-line containing an array ...

Read more

Question 281. Partition Problem Problem Statement In the Partition problem, we have given a set that contains n elements. Find whether the given set can be divided into two sets whose sum of elements in the subsets is equal. Example Input arr[] = {4, 5, 11, 9, 8, 3} Output Yes Explanation The array ...

Read more

Question 282. The Celebrity Problem Problem Statement In the celebrity problem there is a room of N people, Find the celebrity. Conditions for Celebrity is- If A is Celebrity then Everyone else in the room should know A. A shouldn’t know anyone in the room. We need to find the person who satisfies these conditions. ...

Read more

Question 283. Find a Sorted Subsequence of size 3 Problem Statement In the given unsorted array of integers. We need to find a sorted subsequence of size 3. Let three elements be array[i], array[j], array[k] then, array[i] < array[j] < array[k] for i< j < k. If there are multiple triplets found in the array then print any one ...

Read more

Question 284. Subarray with Given Sum Problem Statement In the subarray with the given sum problem, we have given an array containing n positive elements. We have to find the subarray in which the sum of all the elements of the subarray equal to a given_sum. Subarray is obtained from the original array by deleting some ...

Read more

Question 285. Maximum Element in an Array which is Increasing and then Decreasing Problem Statement In the given array which contains n elements. Elements are stored in such a way that first k elements are in increasing order and then n-k elements in decreasing from there, we need to find the maximum element in the array. Example a)    Input array : [15, 25, ...

Read more

Question 286. Count Minimum Steps to Get the given Array Problem Statement In count minimum steps to get the given array problem, we have given an input array target[] containing n elements, we need to compute the minimum number of operations from converting array[] of size n with all zeros to target[]. Operations a)    Increment an element by 1 is ...

Read more

Question 287. Find the Lost Element From a Duplicated Array Problem Statement Given two arrays A and B, one array is a duplicate of the other except one element. The one element is missing from either A or B. we need to find the lost element from a duplicated array. Example 5 1 6 4 8 9 6 4 8 ...

Read more

Question 288. Rearrange given Array in Maximum Minimum Form Problem Statement In the “Rearrange given Array in Maximum Minimum Form” problem, we have given a sorted array containing N elements. Rearrange the given sorted array of positive integers, such that alternative elements are ith max and ith min. See below for a better understanding of rearrangement of elements- Array[0] ...

Read more

Question 289. Subarray and Subsequence Problem Statement In the subarray and subsequence problem, we have to print all the subarrays and subsequences for a given array. Generate all possible non-empty subarrays. A subarray is commonly defined as a part or section of an array in which the contiguousness is based on the index. The subarray ...

Read more

Question 290. Merge Two Sorted Arrays Problem Statement In merge two sorted arrays problem, we have given two input sorted arrays, we need to merge these two arrays such that the initial numbers after complete sorting should be in the first array and remaining in the second array. Example Input A[] = {1, 3, 5, 7, ...

Read more

Question 291. Count of Triplets With Sum Less than Given Value Problem Statement We have given an array containing N number of elements. In the given array, Count the number of triplets with a sum less than the given value. Example Input a[] = {1, 2, 3, 4, 5, 6, 7, 8} Sum = 10 Output 7 Possible triplets are : ...

Read more

Question 292. Next Greater Element in an Array Problem Statement Given an array, we will find the next greater element of each element in the array. If there is no next greater element for that element then we will print -1, else we will print that element. Note: Next greater element is the element that is greater and ...

Read more

Question 293. Merging Two Sorted Arrays Problem Statement In merging two sorted arrays problem we have given two sorted arrays, one array with size m+n and the other array with size n. We will merge the n sized array into m+n sized array and print the m+n sized merged array. Example Input 6 3 M[] = ...

Read more

Question 294. Find a Fixed Point in a Given Array Problem Statement Given an array of n distinct elements, find a fixed point in a given array, where a fixed point means the element value is the same as the index. Example Input 5 arr[] = {0,4,8,2,9} Output 0 is a fixed point in this array because value and index ...

Read more

Question 295. Find Element Using Binary Search in Sorted Array Problem Statement Given a sorted array, Find element using binary search in the sorted array. If present, print the index of that element else print -1. Example Input arr[] =  {1, 6, 7, 8, 9, 12, 14, 16, 26, 29, 36, 37, 156} X = 6 //element to be searched ...

Read more

Question 296. Find Triplet in Array With a Given Sum Problem Statement Given an array of integers, find the combination of three elements in the array whose sum is equal to a given value X. Here we will print the first combination that we get. If there is no such combination then print -1. Example Input N=5, X=15 arr[] = ...

Read more

Question 297. Find Duplicates in an Array in Most Efficient Way Problem Statement Display all the elements which are duplicates in the most efficient way in O(n) and O(1) space. Given an array of size n which contains numbers from range 0 to n-1, these numbers can occur any number of times. Find duplicates in an array in the most efficient ...

Read more

Question 298. Sort 0s 1s and 2s in an Array Problem Statement Given an array containing N elements where elements of the array are 0,1 or 2. Sort or Segregate 0s 1s and 2s in an array. Arrange all zeros in the first half, all ones in the second half and all twos in the third half. Example Input 22 ...

Read more

Question 299. Find Leaders in an Array Problem Statement Given an array containing N elements. Find the leaders in an array. Leaders are the element that have no element larger than themselves on the right of them in the array. Example Input 7 1 95 4 46 8 12 21 Output 95 46 21 Explanation Here no ...

Read more

Question 300. Smallest Positive Number Missing in an Unsorted Array Problem Statement In the given unsorted array find the smallest positive number missing in an unsorted array. A positive integer doesn’t include 0. We can modify the original array if needed. The array may contain positive and negative numbers. Example a. Input array : [3, 4, -1, 0, -2, 2, 1, ...

Read more

Question 301. Find K Length Subarray of Maximum Average Problem Statement In find K length subarray of maximum average problem, we have given an array of size N. Finding the start position of a subarray in the given array of size k with a maximum average. The array may contain positive and negative numbers. (Average = sum of elements/number ...

Read more

Question 302. Find Pythagorean Triplets from Array Problem Statement We have given an array that contains n integers. We need to find the set of Pythagorean triples from the given array. Note: Pythagorean triplets condition: a^2 + b^2 = c^2. Example Input 6 [3, 4, 6, 5, 7, 8] Output Pythagorean triplets: 3, 4, 5 Approach 1 ...

Read more

Question 303. Move All the Zeros to the End of the Given Array Problem Statement In the given array move all the zeros which are present in the array to the end of the array. Here there is always a way exist to insert all the number of zeroes to the end of the array. Example Input 9 9 17 0 14 0 ...

Read more

Question 304. Find Minimum Distance Between Two Numbers in an Array Problem Statement In the given unsorted array, which may also contain duplicates, find the minimum distance between two different numbers in an array. Distance between 2 numbers in an array: the absolute difference between the indices +1. Example Input 12 3 5 4 2 6 5 6 6 5 4 ...

Read more

Question 305. Count Number of Occurrences in a Sorted Array Problem Statement In the “Count Number of Occurrences in a Sorted Array” problem, we have given a sorted array. Count the number of occurrences or frequency in a sorted array of X where X is an integer. Example Input 13 1 2 2 2 2 3 3 3 4 4 ...

Read more

Question 306. Maximum Sum of Non Consecutive Elements Problem Statement In the “Maximum Sum of Non Consecutive Elements” given array, you need to find the maximum sum of non-consecutive elements. You can not add immediate neighbor numbers. For example [1,3,5,6,7,8,] here 1, 3 are adjacent so we can’t add them, and 6, 8 are not adjacent so we ...

Read more

Question 307. Find Smallest Missing Number in a Sorted Array Problem Statement In the “Find Smallest Missing Number in a Sorted Array” problem we have given an integer array. Find the smallest missing number in N sized sorted array having unique elements in the range of 0 to M-1, where M>N. Example Input [0, 1, 2, 3, 4, 6, 7, ...

Read more

Question 308. First Repeating Element Problem Statement We have given an array that contains n integers. We have to find the first repeating element in the given array. If there is no repeated element then print “No repeating integer found”. Note: Repeating elements are those elements that come more than once. (Array may contain duplicates) ...

Read more

Question 309. A Product Array Puzzle Problem Statement In a product array puzzle problem we need to construct an array where the ith element will be the product of all the elements in the given array except element at the ith position. Example Input  5 10 3 5 6 2 Output 180 600 360 300 900 ...

Read more

Question 310. Find All Pairs With a Given Difference Problem Statement We have given an array of containing different elements or no repeated elements present in the array. Find all pairs with a given difference. If there is no any pair with given different then print “No pair with given different”. Example Input 10 20 90 70 20 80 ...

Read more

Question 311. Find the first Repeating Number in a Given Array Problem Statement There can be multiple repeating numbers in an array but you have to find the first repeating number in a given array (occurring the second time). Example Input 12 5 4 2 8 9 7 12 5 6 12 4 7 Output 5 is the first repeating element ...

Read more

Question 312. Maximum difference between two elements such as larger element comes after smaller Problem Statement We have given an array of n integers in which we have to find the maximum difference between two elements such as larger element comes after smaller. Example Input 4  7  2  18  3  6  8  11  21 Output 19 Approach 1 for Maximum difference between two elements  ...

Read more

Question 313. Majority Element Problem Statement Given a sorted array, we need to find the majority element from the sorted array. Majority element: Number occurring more than half the size of the array. Here we have given a number x we have to check it is the majority_element or not. Example Input 5 2 ...

Read more

Question 314. Find the First and Second Smallest Elements Problem Statement In find the first and second smallest elements problem we have given an array of integers. Find the first and second smallest integers from an array or find two smallest numbers from an array. Example Input 7, 6, 8, 10, 11, 5, 13, 99 Output First Smallest is ...

Read more

Question 315. Find the Number Occurring Odd Number of Times in an Array Problem Statement Given an array of positive integers. All numbers occur even a number of times except one number which occurs an odd number of times. We have to find the number occurring an odd number of times in an array. Example Input 1, 1, 1, 1, 2, 2, 3, ...

Read more

Question 316. Sort Elements by Frequency of Occurrences Problem Statement In sort elements by frequency of occurrences problem, we have given an array a[]. Sort array elements in such a way that the element with the highest number of occurrences comes first. If the number of occurrences is equal then the print the number which appeared first in ...

Read more

Question 317. Find the Missing Number Problem Statement In finding the missing number from an array of 1 to N numbers we have given an array that contains N-1 numbers. One number is missing from an array of numbers from 1 to N. We have to find the missing number. Input Format First-line containing an integer ...

Read more

Amazon String Questions
Question 318. Camelcase Matching Leetcode Solution Problem Statement: Camelcase Matching Leetcode Solution says that – Given an array of string “queries” and string “pattern”, return boolean array result where result[i] is true where “queries[i]” matches with “pattern”, false otherwise. A query word “queries[i]” matches with “pattern” if you can insert some lowercase English letters in “pattern” so ...

Read more

Question 319. Step-By-Step Directions From a Binary Tree Node to Another LeetCode Solution Problem Statement: Step-By-Step Directions From a Binary Tree Node to Another LeetCode Solution – You are given the root of a binary tree with n nodes. Each node is uniquely assigned a value from 1 to n. You are also given an integer startValue representing the value of the start node s, and a different integer destValue representing the value of the destination ...

Read more

Question 320. Rotate String LeetCode Solution Problem Statement Rotate String LeetCode Solution – Given two strings s and goal, return true if and only if s can become goal after some number of shifts on s. A shift on s consists of moving the leftmost character of s to the rightmost position. For example, if s = “abcde”, then it will ...

Read more

Question 321. Shifting Letters LeetCode Solution Problem Statement Shifting Letters says that we have given a string s and an array shifts. Now for each shifts[i] = x, we want to shift the first i + 1 letters of s, x times. We have to return the final string after all shifts are applied. Example 1: Input: s = "abc", shifts ...

Read more

Question 322. Score of Parenthesis LeetCode Solution Problem Statement The score of Parenthesis LeetCode Solution says – Given a balanced parentheses string s and return the maximum score. The score of a balanced parenthesis string is based on the following rules: "()" has score 1. AB has score A + B, where A and B are balanced parenthesis strings. (A) has score 2 * A, where A is a ...

Read more

Question 323. Design Add and Search Words Data Structure LeetCode Solution Problem Statement: Design Add and Search Words Data Structure LeetCode Solution says – Design a data structure that supports adding new words and finding if a string matches any previously added string. Implement the WordDictionary class: WordDictionary() Initializes the object. void addWord(word) Adds word to the data structure, it can be matched later. bool search(word) Returns true if there ...

Read more

Question 324. Detect Capital Leetcode Solution Problem Statement: Detect Capital Leetcode Solution says that – Given a string, return true if the usage of capitals in it is right. The conditions for the right words are : All letters in this word are capitals, like "UK". All letters in this word are not capitals, like "going". Only ...

Read more

Question 325. Decode String Leetcode Solution Problem Statement The Decode String LeetCode Solution – “Decode String” asks you to convert the encoded string into a decoded string. The encoding rule is k[encoded_string], where the encoded_string inside the square brackets is being repeated exactly k times where k is a positive integer. Example: Input: s = "3[a]2[bc]" Output: "aaabcbc" ...

Read more

Question 326. Substring with Concatenation of All Words Leetcode Solution Problem Statement The Substring with Concatenation of All Words LeetCode Solution – “Substring with Concatenation of All Words” states that given a string s and an array of string words where each word is of the same length. We need to return all starting indices of the substring that is ...

Read more

Question 327. Different Ways to Add Parentheses Leetcode Solution Problem Statement The Different Ways to Add Parentheses LeetCode Solution – “Different Ways to Add Parentheses” states that given a string expression of numbers and operators. We need to return all possible results from computing all different possible ways to group numbers and operators. Return the answer in any order. ...

Read more

Question 328. Generate Parentheses Leetcode Solution Problem Statement The Generate Parentheses LeetCode Solution – “Generate Parentheses” states that given the value of n. We need to generate all combinations of n pairs of parentheses. Return the answer in the form of a vector of strings of well-formed parentheses. Example: Input: n = 3 Output: ["((()))","(()())","(())()","()(())","()()()"] Explanation: ...

Read more

Question 329. Minimum Remove to Make Valid Parentheses LeetCode Solution Problem Statement The Minimum Remove to Make Valid Parentheses LeetCode Solution – You are given a string s of ‘(‘, ‘)’ and lowercase English characters. Your task is to remove the minimum number of parentheses ( ‘(‘ or ‘)’, in any positions ) so that the resulting parentheses string is ...

Read more

Question 330. Longest Substring Without Repeating Characters Leetcode Solution Problem Statement The Longest Substring Without Repeating Characters LeetCode Solution –  states that given the string s. We need to find the longest substring without repeating characters. Example: Input: s = "abcabcbb" Output: 3 Explanation: The longest substring with no characters being repeated is of length 3. The string is: “abc”. Input: s = "bbbbb" ...

Read more

Question 331. Design Underground System Leetcode Solution Problem Statement The Design Underground System LeetCode Solution – “Design Underground System” asks you to design a railway system to keep track of customer travel times between two stations. It is needed to calculate the average time it takes to travel from one station to another. We need to implement ...

Read more

Question 332. Longest Common Prefix Leetcode Solution Problem Statement The Longest Common Prefix LeetCode Solution – “Longest Common Prefix” states that given an array of strings. We need to find the longest common prefix among these strings. If there doesn’t exist any prefix, return an empty string. Example: Input: strs = ["flower","flow","flight"] Output: "fl" Explanation: “fl” is the longest ...

Read more

Question 333. Valid Palindrome II Leetcode Solution Problem Statement The Valid Palindrome II LeetCode Solution – “Valid Palindrome II” states that given the string s, we need to return true if s can be a palindrome string after deleting at most one character. Example: Input: s = "aba" Output: true Explanation: The input string is already palindrome, so there’s ...

Read more

Question 334. Valid Parentheses Leetcode Solution Problem Statement The Valid Parentheses LeetCode Solution – “Valid Parentheses” states that you’re given a string containing just the characters '(', ')', '{', '}', '[' and ']'. We need to determine whether the input string is a valid string or not. A string is said to be a valid string if open brackets must be closed ...

Read more

Question 335. Largest Number Leetcode Solution Problem Statement The Largest Number LeetCode Solution – “Largest Number” states that given a list of non-negative integers nums, we need to arrange the numbers in such a way that they form the largest number and return it. Since the result may be very large, so you need to return ...

Read more

Question 336. Implement Trie (Prefix Tree) Leetcode Solution Problem Statement The Implement Trie (Prefix Tree) LeetCode Solution – “Implement Trie (Prefix Tree)” asks you to implement the Trie Data Structure that performs inserting, searching and prefix searching efficiently. Example: Input: ["Trie", "insert", "search", "search", "startsWith", "insert", "search"] [[], ["apple"], ["apple"], ["app"], ["app"], ["app"], ["app"]] Output: [null, null, true, false, true, null, true] Explanation: After inserting all the strings, trie looks like this. Word apple is searched which ...

Read more

Question 337. Palindrome Partitioning Leetcode Solution Problem Statement The Palindrome Partitioning LeetCode Solution – “Palindrome Partitioning” states that you’re given a string, partition the input string such that every substring of the partition is a palindrome. Return all possible palindrome partitioning of the input string. Example: Input: s = "aab" Output: [["a","a","b"],["aa","b"]] Explanation: There exist exactly 2 valid ...

Read more

Question 338. Count and Say Leetcode Solution Problem Statement The Count and Say LeetCode Solution – “Count and Say” asks you to find the nth term of the count-and-say sequence. The count-and-say sequence is a sequence of digit strings defined by the recursive formula: countAndSay(1) = "1" countAndSay(n) is the way you would “say” the digit string from countAndSay(n-1), which is then converted ...

Read more

Question 339. Palindromic Substrings Leetcode Solution Problem Statement The Palindromic Substrings LeetCode Solution – “Palindromic Substrings” asks you to find a total number of palindromic substrings in the input string. A string is a palindrome when it reads the same backward as forward. A substring is a contiguous sequence of characters within the string. Example: Input: s = "aaa" Output: ...

Read more

Question 340. Maximum Length of a Concatenated String with Unique Characters Leetcode Solution Problem Statement The Maximum Length of a Concatenated String with Unique Characters LeetCode Solution – “Maximum Length of a Concatenated String with Unique Characters” says that you’re given an array of strings and you need to choose any subsequence of the given array and concatenate those strings to form the ...

Read more

Question 341. Shortest Word Distance Leetcode Solution Problem Statement The Shortest Word Distance LeetCode Solution – says that you’re given an array of strings and two different words. We need to return the shortest distance between these two words that appear in the input string. Example: Input: wordsDict = ["practice", "makes", "perfect", "coding", "makes"], word1 = "coding", word2 = "practice" Output: 3 Explanation: Word “coding” occurs at position 4. ...

Read more

Question 342. Remove Invalid Parentheses Leetcode Solution Problem Statement The Remove Invalid Parentheses Leetcode Solution –  states that you’re given a string s that contains parenthesis and lowercase letters. We need to remove the minimum number of invalid parentheses to make the input string valid. We need to return all possible results in any order. A string is ...

Read more

Question 343. Minimum Number of Steps to Make Two Strings Anagram Leetcode Solutions Problem Statement In this problem, we are given two strings ‘s’ & ‘t’ consisting of lower-case English characters. In one operation, we can choose any character in string ‘t’ and change it to some other character. We need to find the minimum number of such operations to make ‘t’ an ...

Read more

Question 344. Isomorphic Strings Leetcode Solution Problem Statement In this problem, we are given two strings, a and b. Our goal is to tell whether the two strings are isomorphic or not. Two strings are called isomorphic if and only if the characters in the first string can be replaced by any character(including itself) at all ...

Read more

Question 345. Minimum Swaps to Make Strings Equal Leetcode Solution Problem Statement You are given two strings s1 and s2 of equal length consisting of letters “x” and “y” only. you can swap any two characters belong to different strings, your task is to make both the string equal. return minimum number of swaps required to make both strings equal ...

Read more

Question 346. Remove Palindromic Subsequences Leetcode Solution The problem Remove Palindromic Subsequences Leetcode Solution states that you are given a string. The string consists of only two characters ‘a’ or ‘b’. You are required to erase the whole string. There is a restriction that you can delete only a palindromic subsequence in one move. Find the minimum ...

Read more

Question 347. Defanging an IP Address Leetcode Solution Problem Statement In this problem, we are given an IP Address. We just have to convert it into a Defanged IP Address i.e. in our output string, all the “.” are converted to “[.]”. Example #1: address = "1.1.1.1" "1[.]1[.]1[.]1" #2: address = "255.100.50.0" "255[.]100[.]50[.]0" Approach 1 (Using String Stream/Builder) ...

Read more

Question 348. String Matching in an Array Leetcode Solution The problem String Matching in an Array Leetcode Solution provides us with an array of strings. The problem asks us to find the strings that are substrings of some other string from the input. Just a quick reminder, a substring is nothing but a part of the string remaining after ...

Read more

Question 349. Is Subsequence Leetcode Solution Problem Statement In this problem, we are given two different strings. The goal is to find out whether the first string is a subsequence of the second. Examples first string = "abc" second string = "mnagbcd" true first string = "burger" second string = "dominos" false Approach(Recursive) This is easy ...

Read more

Question 350. Find the Difference Leetcode Solution In this problem, we are given two strings. The second string is generated by shuffling the characters of the first string randomly and then adding an extra character at any random position. We need to return the extra character that was added to the second string. The characters will always ...

Read more

Question 351. Add Binary Leetcode Solution Problem Statement Given two binary strings a and b, we have to add these two strings and then return the result as a binary string. Binary string are the strings that contains only 0s and 1s. Example a = "11", b = "1" "100" a = "1010", b = "1011" "10101" Approach For adding two ...

Read more

Question 352. Valid Palindrome Leetcode Solution Problem Statement Given a string, we have to determine if it is a palindrome, considering only alphanumeric characters i.e. numbers and alphabets only. We also have to ignore cases for alphabet characters. Example "A man, a plan, a canal: Panama" true Explanation: “AmanaplanacanalPanama”  is a valid palindrome. "race a car" ...

Read more

Question 353. Reverse Vowels of a String Leetcode Solution Problem Statement In this problem a string is given and we have to reverse only the vowels of this string. Example "hello" "holle" Explanation: before reversing :  “hello” after reversing    :  “holle” "leetcode" "leotcede" Explanation: Approach 1 (Using Stack) We just have to reverse the vowels present in input ...

Read more

Question 354. Roman to Integer Leetcode Solution In the problem “Roman to Integer”, we are given a string representing some positive integer in its Roman numeral form. Roman numerals are represented by 7 characters that can be converted to integers using the following table: Note: The integer value of the given roman numeral will not exceed or ...

Read more

Question 355. Path Crossing Leetcode Solution Problem Statement In path crossing problem a_string is given in which there are only four different characters ‘N’, ‘S’, ‘E’ or ‘W’ showing the movement of an object in one direction at a time by 1 unit. Object is initially at origin (0,0). We have to find out if the ...

Read more

Question 356. Multiply Strings Leetcode Solution The problem Multiply Strings Leetcode solution asks us to multiply two strings which are given to us as input. We are required to print or return this result of multiplying to the caller function. So to put it more formally given two strings, find the product of the given strings. ...

Read more

Question 357. Integer to Roman Leetcode Solution In this problem, we are given an integer and are required to convert into roman numeral. Thus the problem is generally referred to as “Integer to Roman” and this is Integer to Roman Leetcode Solution. If someone does not know about Roman numerals. In the old times, people did not ...

Read more

Question 358. Scramble String Problem Statement “Scramble String” problem states that you are given two strings. Check if the second string is a scrambled string of first one or not? Explanation Let string s = “great” Representation of s as binary tree by recursively dividing it into two non-empty sub-strings. This string can be ...

Read more

Question 359. Group Anagrams We have to find out the group anagrams of the given words. This means for each word we are going to sort it and store it as a key and original input which is not sorted as a value and if any other input has the same value as a ...

Read more

Question 360. Integer to English words In problem “Integer to English words” we have given a non-negative integer and the tasks to convert that integer into its numerical words or we get an input of a number, any number, and our task is to represent that number in a string form. Let’s see one example, the ...

Read more

Question 361. Find Smallest Range Containing Elements from k Lists In the problem “Find the smallest range containing elements from k lists” we have given K lists which are sorted and of the same size N. It asks to determine the smallest range that contains at least element(s) from each of the K lists. If there is more than one ...

Read more

Question 362. Minimum insertions to form a palindrome with permutations allowed The problem “Minimum insertions to form a palindrome with permutations allowed” states that you are given a String with all letters in lowercase. The problem statement asks to find out the minimum insertion of a character to a string that it can become Palindrome. The position of characters can be ...

Read more

Question 363. LCS (Longest Common Subsequence) of three strings The problem “LCS (Longest Common Subsequence) of three strings” states that you are given 3 strings. Find out the longest common subsequence of these 3 strings. LCS is the string that is common among the 3 strings and is made of characters having the same order in all of the ...

Read more

Question 364. Check if Array Contains Contiguous Integers With Duplicates Allowed You are given an array of integers which can contain duplicate elements as well. The problem statement asks to find out if it is a set of contiguous integers, print “Yes” if it is, print “No” if it is not. Example Sample Input: [2, 3, 4, 1, 7, 9] Sample ...

Read more

Question 365. Longest Repeated Subsequence The problem “Longest Repeated Subsequence” states that you are given a string as an input. Find out the longest repeated subsequence, that is the subsequence that exists twice in the string. Example aeafbdfdg 3 (afd) Approach The problem asks us to find out the longest repeated subsequence in the string. ...

Read more

Question 366. Check for Palindrome after every character replacement Query The problem “Check for Palindrome after every character replacement Query” states that suppose you are given a String and no. of Queries, each query has two integer input values as i1 and i2 and one character input called ‘ch’. The problem statement asks to change the values at i1 and ...

Read more

Question 367. Letter Combinations of a Phone Number In letter combinations of a phone number problem, we have given a string containing numbers from 2 to 9. The problem is to find all the possible combinations that could be represented by that number if every number has some letters assigned to it. The assignment of the number is ...

Read more

Question 368. Longest Substring Without Repeating Characters LeetCode Solution Longest Substring Without Repeating Characters LeetCode Solution – Given a string, we have to find the length of the longest substring without repeating characters. Let’s look into a few examples: Example pwwkew 3 Explanation: Answer is “wke” with length 3 aav 2 Explanation: Answer is “av” with length 2 Approach-1 ...

Read more

Question 369. Form minimum number from given sequence The problem “Form minimum number from given sequence” states that you are given some pattern of I’s and D’s only. The meaning of I stands for increasing and for decreasing we are provided with D. The problem statement asks to print the minimum number which satisfies the given pattern. We have ...

Read more

Question 370. Find Index of Closing Bracket for a Given Opening Bracket in an Expression Problem Statement Given a string s of length/size n and an integer value representing the index of an opening square bracket. Find index of closing bracket for a given opening bracket in an expression. Example s = "[ABC[23]][89]" index = 0 8 s = "[C-[D]]" index = 3 5 s ...

Read more

Question 371. Text Justification LeetCode Solution We will discuss Text Justification LeetCode Solution today Problem Statement The problem “Text Justification” states that you are given a list s[ ] of type string of size n and an integer size. Justify the text such that each line of text consists of size number of characters. You can ...

Read more

Question 372. Reverse individual words Problem Statement The problem “Reverse individual words” states that you are given a string s. Now, print the reverse of all the individual words in the string. Example s = "TutorialCup - changing the way of learning" puClairotuT - gnignahc eht yaw fo gninrael  s = "Reverse individual words" esreveR ...

Read more

Question 373. Remove brackets from an algebraic string containing + and – operators Problem Statement You are given a string s of size n representing an arithmetic expression with parenthesis. The problem “Remove brackets from an algebraic string containing + and – operators” asks us to create a function that can simplify the given expression. Example s = "a-(b+c)" a-b-c  s = a-(b-c-(d+e))-f a-b+c+d+e-f ...

Read more

Question 374. Minimum sum of squares of character counts in a given string after removing k characters Problem Statement The problem “Minimum sum of squares of character counts in a given string after removing k characters” states that you are given a string containing lower case characters only. You are allowed to remove k characters from the string such that in the remaining string the sum of ...

Read more

Question 375. Queue based approach for first non-repeating character in a stream Problem Statement The problem “Queue based approach for first non-repeating character in a stream” states that you are given a stream containing lower case characters, find the first non-repeating character whenever a new character is added to the stream, and if there is no non-repeating character return -1. Examples aabcddbe ...

Read more

Question 376. Form Minimum Number From Given Sequence Problem Statement The problem “Form Minimum Number From Given Sequence states that you are given a string s of length/size n representing a pattern of characters ‘I’ i.e. increasing and ‘D’ i.e. decreasing only. Print the minimum number for the given pattern with unique digits from 1-9. For instance – ...

Read more

Question 377. Palindrome Substring Queries Problem Statement The problem “Palindrome Substring Queries” states that you are given a String and some queries. With those queries, you have to determine if the formed substring from that query is a palindrome or not. Example String str = "aaabbabbaaa" Queries q[] = { {2, 3}, {2, 8},{5, 7}, ...

Read more

Question 378. Arrange given numbers to form the biggest number Problem Statement Suppose you have an array of integers. The problem “Arrange given numbers to form the biggest number”  asks to rearrange the array in such a manner that the output should be the maximum value which can be made with those numbers of an array. Example [34, 86, 87, ...

Read more

Question 379. Palindrome Partitioning Problem Statement Given a string, find the minimum number of cuts required such that all the substrings of partitions are palindromes. Since we are cutting our original string into different partitions such that all the substrings are palindromes, we call this problem the Palindrome Partition Problem. Example  asaaaassss 2 Explanation: ...

Read more

Question 380. Reverse words in a string Problem Statement “Reverse words in a string” states that you are given a string s of size n. Print the string in reverse order such that the last word becomes the first, second last becomes the second, and so on. Hereby string we refer to a sentence containing words instead ...

Read more

Question 381. Maximum weight transformation of a given string Problem Statement The maximum weight transformation of a given string problem states that given a string consisting only of two characters ‘A’ and ‘B’. We have an operation where we can transform string to another string by toggling any character. Thus many transformations are possible. Out of all the possible ...

Read more

Question 382. Mobile Numeric Keypad Problem Problem Statement In the mobile numeric keypad problem, we consider a numeric keypad.  We need to find all number of possible numeric sequences of given length such that you are only allowed to press buttons which are top, down, left, and right of the current button. You are not allowed ...

Read more

Question 383. Shortest Palindrome In the shortest palindrome problem, we have given a string s of length l. Add characters in front of it to make it palindrome if it’s not. Print the smallest count of characters used to make the given string a palindrome. Example Input : s = abc Output: 2  (by ...

Read more

Question 384. Second Most Repeated Word in a Sequence Given a sequence of strings, the task is to find out the second most repeated (or frequent) word or string in a sequence. (Considering no two words are the second most repeated, there will be always a single word). Example Input: {“aaa”, ”bb”, ”bb”, ”aaa”, ”aaa”, c”} Output: String with ...

Read more

Question 385. Maximum occurring character in a string Given a string of size n containing lower case letters. We need to find the maximum occurring character in a string. If there is more than one character with a maximum occurrence then print any of them. Example Input: String s=”test” Output: Maximum occurring character is ‘t’. Approach 1: Using ...

Read more

Question 386. Decode Ways In Decode Ways problem we have given a non-empty string containing only digits, determine the total number of ways to decode it using the following mapping: 'A' -> 1 'B' -> 2 ... 'Z' -> 26 Example S = “123” Number of ways to decode this string is 3 If we ...

Read more

Question 387. Edit Distance In the edit distance problem we have to find the minimum number of operations required to convert a string X of length n to another string Y of length m. Operations allowed: Insertion Deletion Substitution Example Input: String1 = “abcd” String2 = “abe” Output: Minimum operations required is 2 ( ...

Read more

Question 388. Substring With Concatenation Of All Words In substring with the concatenation of all words problem, we have given a string s and a list consist of many words each of the same length. Print the starting index of the substring which can be the result of the concatenation of all the words in the list in ...

Read more

Question 389. Minimum Bracket Reversals In minimum bracket reversals problem, we have given a string s containing an expression of characters ‘{‘ and ‘}’ only. Find the minimum number of bracket reversals needed to make an expression balanced. Example Input : s = “}{” Output: 2 Input : s = “{{{” Output: The given expression can not ...

Read more

Question 390. Expression Contains Redundant Bracket or Not Given a string s containing an expression of operators, operands, and parenthesis. Find if the given string contains any unnecessary parenthesis without which the expression will still give the same result. In other words, we have to find that expression contains a redundant bracket or not. Redundant Bracket If an ...

Read more

Question 391. Check if Two Expressions With Brackets are Same Given two strings s1 and s2 representing expressions containing addition operator, subtraction operator, lowercase alphabets, and parenthesis. Check if two expressions with brackets are the same. Example Input  s1 = “-(a+b+c)” s2 = “-a-b-c” Output  Yes Input  s1 = “a-b-(c-d)” s2 = “a-b-c-d” Output No Algorithm to Check if Two ...

Read more

Question 392. Valid Parenthesis String In the valid parenthesis string problem we have given a string containing ‘(‘, ‘)‘ and ‘*‘, check if the string is balanced if ‘*‘ can be replaced with ‘(‘, ‘)‘ or an empty string. Examples Input “()” Output true Input “*)” Output true Input “(*))” Output true Naive Approach for ...

Read more

Question 393. Longest Palindromic Subsequence In the longest palindromic subsequence problem we have given a string, find the length of the longest palindromic subsequence. Examples Input: TUTORIALCUP Output: 3 Input: DYNAMICPROGRAMMING Output: 7 Naive Approach for Longest Palindromic Subsequence The naive approach to solve the above problem is to generate all the subsequences of the ...

Read more

Question 394. KMP Algorithm KMP(Knuth-Morris-Pratt) algorithm is used for pattern searching in a given string. We are given a string S and a pattern p, our goal is to determine whether or not the given pattern is present in the string. Example Input: S = “aaaab” p = “aab” Output: true Naive Approach The ...

Read more

Question 395. Check for Balanced Parentheses in an Expression Given a string s of length n. Check whether there is a closing parenthesis for every opening parentheses i.e. if all the parentheses are balanced. In other words, we can also say that, if we have a ‘}’, ‘)’ and ‘]’ for every ‘{‘, ‘(‘ and ‘[‘ respectively, the expression ...

Read more

Question 396. Find if an Expression has Duplicate Parenthesis or Not Given a string containing balanced parenthesis. Find if the expression/string contains duplicate parenthesis or not. Duplicate Parenthesis When an expression is in the middle of or surrounded by the same type of balanced parenthesis i.e. enclosed between the same type of opening and closing parenthesis more than once it is ...

Read more

Question 397. Find Maximum Depth of Nested Parenthesis in a String Given a string s. Write the code to print the maximum depth of nested parenthesis in the given string. Example Input : s = “( a(b) (c) (d(e(f)g)h) I (j(k)l)m)” Output : 4 Input : s = “( p((q)) ((s)t) )” Output : 3 Using Stack Algorithm Initialize a string s of length ...

Read more

Question 398. Balanced Expression with Replacement In Balanced Expression with Replacement problem we have given a string s containing parenthesis i.e. ‘(‘, ‘)’, ‘[‘, ‘]’, ‘{‘, ‘}’. The string also contains x at some places as a replacement of parenthesis. Check if the string can be converted into an expression with valid parenthesis after replacing all ...

Read more

Question 399. Decode String Suppose, you are given an encoded string. A string is encoded in some kind of pattern, your task is to decode the string. Let us say, < no of times string occurs > [string ] Example Input 3[b]2[bc] Output bbbcaca Explanation Here “b” occurs 3times and “ca” occur 2 times. ...

Read more

Question 400. Prefix to Infix Conversion In prefix to infix conversion problem, we have given expression in prefix notation. Write a program to convert it into an infix expression. Prefix Notation In this notation the operands are written after the operator. It is also known as Polish Notation. For instance : +AB is an prefix expression. ...

Read more

Question 401. Postfix to Infix Conversion In postfix to infix conversion problem, we have given expression in postfix notation. Write a program to convert the given notation in infix notation. Infix Notation In this notation, the operators are written between the operands. It is similar to how we generally write an expression. For instance: A + ...

Read more

Question 402. Prefix to Postfix Conversion In prefix to postfix conversion problem, we have given expression in prefix notation in string format. Write a program to convert the given notation in postfix notation. Prefix Notation In this notation, we write the operands after the operator. It is also known as Polish Notation. For instance: +AB is ...

Read more

Question 403. Next Permutation In the next permutation problem we have given a word, find the lexicographically greater_permutation of it. Example input : str = "tutorialcup" output : tutorialpcu input : str = "nmhdgfecba" output : nmheabcdfg input : str = "algorithms" output : algorithsm input : str = "spoonfeed" output : Next Permutation ...

Read more

Question 404. Longest Common Subsequence You are given two strings str1 and str2, find out the length of the longest common subsequence. Subsequence: a subsequence is a sequence that can be derived from another sequence by deleting some or no elements without changing the order of the remaining elements. For ex ‘tticp‘ is the subsequence ...

Read more

Question 405. Repeated Substring Pattern In repeated substring patterns we have given a string check if it can be constructed by taking a substring of itself and appending multiple copies of the substring together. Example Input 1: str = “abcabcabc” Output: True Explanation: “abcabcabc” can be formed by repeatedly appending “abc” to an empty string. ...

Read more

Question 406. Letter Case Permutation In letter case permutation we have given a string consisting of alphabets and numbers only, each character in the string can be converted into lowercase and uppercase, find out all different strings which can be obtained from different combinations of lowercase and uppercase of each character in the string. Example ...

Read more

Question 407. Longest Common Prefix using Sorting In the Longest Common Prefix using Sorting problem we have given a set of strings, find the longest common prefix. i.e. find the prefix part that is common to all the strings. Example Input1: {“tutorialcup”, “tutorial”, “tussle”, “tumble”} Output: "tu" Input2: {"baggage", "banana", "batsmen"} Output: "ba" Input3: {"abcd"} Output: "abcd" ...

Read more

Question 408. Backspace String Compare In the backspace string compare problem we have given two Strings S and T, check if they are equal or not. Note that the strings contain ‘#’ which means backspace character. Examples Input S = “ab#c” T = “ad#c” Output true (as both S and T converts to “ac”) Input ...

Read more

Question 409. Word Pattern We have all come across word patterns like “ABBA”, “AABB” and so on. We always wonder what this babble could relate to. Today we will try to solve a problem where we try to make use of the babble. A plethora of string problems does not help the case. Given ...

Read more

Question 410. Regular Expression Matching In the Regular Expression Matching problem we have given two strings one (let’s assume it x) consists of only lower case alphabets and second (let’s assume it y) consists of lower case alphabets with two special characters i.e, “.” and “*”. The task is to find whether the second string ...

Read more

Question 411. Reorganize String In Reorganize String problem we have given a string containing some characters “a-z” only. Our task is to rearrange those characters such that no two same characters are adjacent to each other. Example Input apple Output pelpa Input book Output obko Input aa Output not possible Input aaab Output not ...

Read more

Question 412. String Compression In the String Compression problem, we have given an array a[ ] of type char. Compress it as the character and count of a particular character (if the count of character is 1 then the only character is stored in a compressed array). The length of the compressed array should ...

Read more

Question 413. Valid Parentheses LeetCode Solution In Valid Parentheses LeetCode problem we have given a string containing just the characters ‘(‘, ‘)’, ‘{‘, ‘}’, ‘[‘ and ‘]’, determine if the input string is valid. Here we will provide a Valid Parentheses LeetCode Solution to you. An input string is valid if: Open brackets must be closed ...

Read more

Question 414. Longest Common Prefix using Trie In the Longest Common Prefix using Trie problem we have given a set of strings, find the longest common prefix. i.e. find the prefix part that is common to all the strings. Example Input1: {“tutorialcup”, “tutorial”, “tussle”, “tumble”} Output: "tu" Input2: {"baggage", "banana", "batsmen"} Output: "ba" Input3: {"abcd"} Output: "abcd" ...

Read more

Question 415. Valid Number In the Valid Number problem we have given a string, check if it can be interpreted into a valid decimal number. It is to be noted that, for a given string to be interpreted as a valid decimal number. It should contain the following characters: Numbers 0-9 Exponent – “e” ...

Read more

Question 416. Find the Closest Palindrome number Problem In Find the Closest Palindrome number problem we have given a number n. Find a number which is a palindrome and the absolute difference between the palindromic number and n is as minimum as possible except zero. If there is more than one number satisfying this condition then print ...

Read more

Question 417. Count and Say Count and Say in which we have given a number N and we need to find the Nth term of the count and say sequence. Firstly we need to understand what is count and say sequence. Firstly see some terms of the sequence: 1st term is “1”. 2nd term is ...

Read more

Question 418. Find unique character in a string In Find unique character in a string problem, we have given a string containing only lower case alphabets(a-z). We need to find the first non-repeating character in it and print the index. if no such character exists print -1. Input Format Only a single line containing string. Output Format Print ...

Read more

Question 419. Integer to Roman Integer to Roman conversion. We have given a number N and we need to print the Roman number of N. Roman numbers are represented by the use of {I, V, X, L, C, D, M} values. Let’s see some examples for good understanding. Input Format Only a single line containing ...

Read more

Question 420. Rabin Karp Algorithm Rabin Karp Algorithm used to find the pattern string in the given text string. There are so many types of algorithms or methods used to find the pattern string. In this algorithm, we use Hashing for finding the pattern matching. If we got the same hash code for the substring ...

Read more

Question 421. Guess The Word Guess The Word is an interactive problem. An interactive problem means the data which is given to us is not predetermined. We can print values or call the specific function to interact or get more information regarding the solution. After each step, we also need to FLUSH the buffer to ...

Read more

Question 422. Distinct Subsequences Given two strings S and P1, we have to count all the number of distinct subsequences of S which equals P1. Note: A subsequence of a given string is a string that we archive by deleting some characters or possible zero characters also from the original string. We can’t change ...

Read more

Question 423. Isomorphic Strings Isomorphic Strings – Given two strings we need to check if for every occurrence of a character in string1 there is a unique mapping with characters in string2. In short, check, if there is one to one mapping or not. Example Input str1 = “aab” str2 = “xxy” Output True ...

Read more

Question 424. Perform String Shifts Leetcode A shift is a process in which alphabets are incremented by 1 in their ASCII value. For the last alphabet z it starts again i.e. shift of z will be a. In perform string shifts leetcode problem we have Given a string s (lowercase characters only) and an array a[ ...

Read more

Question 425. String comparison containing wildcards In String comparison containing wildcards problem, we have given two strings second string contains small alphabets and the first contains small alphabets and some wildcard patterns.  Wildcard patterns are: ?: we can replace this wildcard with any small alphabet. *: we can replace this wildcard with any string. An empty ...

Read more

Question 426. Check whether Strings are K Distance Apart or Not Problem Statement Given two strings and an integer k, write a program to check whether the given strings are k distance apart or not. That is if any character is mismatched or any character is to be removed then it is known as k distance apart. Input Format The first ...

Read more

Question 427. Generate all Binary Strings Without Consecutive 1’s Problem Statement In the “Generate all binary strings without consecutive 1’s” problem we have given an integer k, write a program to print all binary strings of size k with no consecutive 1’s. Input Format The first and only one line containing an integer N. Output Format Print all possible ...

Read more

Question 428. Sort a String According to Another String Problem Statement Given two input strings, a pattern and a string. We need to sort the string according to the order defined by the pattern. Pattern string has no duplicates and it has all characters of the string. Input Format The first line containing a string s which we need ...

Read more

Question 429. Check if String Follows Order of Characters by a Pattern or not Problem Statement In the “Check if String Follows Order of Characters by a Pattern or not” problem we have to check if characters in the given input string follow the same order as determined by characters present in the given input pattern then print “Yes” else print “No”. Input Format ...

Read more

Question 430. Reverse String Without Temporary Variable Problem Statement In the “Reverse String Without Temporary Variable” problem we have given a string “s”. Write a program to reverse this string without using any extra variable or space. Input Format The first line containing the given string “s”. Output Format Print the string which is reverse of the ...

Read more

Question 431. Print all Palindromic Partitions of a String Problem Statement In the “Print all Palindromic Partitions of a String” problem we have given a string “s”. Write a program to print all possible palindromic partitioning of s. A palindrome is a word, number, phrase, or another sequence of characters that reads the same backward as forward, such as ...

Read more

Question 432. Count the Pairs at Same Distance as in English Alphabets Problem Statement In the “Count of Pairs at Same Distance as in English Alphabets” problem we have given a string “s”. Write a program that will print the number of pairs whose elements are at the same distance as in English alphabets. Input Format The first line containing the given ...

Read more

Question 433. Minimum Characters to be Added at Front to Make String Palindrome Problem Statement In the “Minimum Characters to be Added at Front to Make String Palindrome” problem we have given a string “s”. Write a program to find the minimum characters to be added at the front to make a string palindrome. Input Format The first and only one line containing ...

Read more

Question 434. Kth Non-repeating Character Problem Statement In the “Kth Non-repeating Character” we have given a string “s”. Write a program to find out the kth non-repeating_character. If there are less than k character which is non-repeating in the string then print “-1”. Input Format The first and only one line containing a string “s”. ...

Read more

Question 435. Remove Minimum Characters so that Two Strings Become Anagrams Problem Statement In the “Remove Minimum Characters so that Two Strings Become Anagrams” problem we have given two input strings. Find the minimum number of_characters to be removed from these two strings such that, they become anagrams. Input Format The first line containing a string “s”. The second line containing ...

Read more

Question 436. Generate all Binary Strings from Given Pattern Problem Statement In the “Generate all Binary Strings from Given Pattern” problem we have given input string “s” consists of 0, 1, and ? (wildcard char). We need to generate all possible binary strings by replacing ? with ‘0’ and ‘1’. Input Format The first and only one line containing ...

Read more

Question 437. Print all Possible Ways to Break a String in Bracket Form Problem Statement In the “Print all Possible Ways to Break a String in Bracket Form” problem, we have given a string “s”. Find all possible ways to break the given string in bracket form. Enclose all substrings within brackets (). Input Format The first and only one line containing a ...

Read more

Question 438. Caesar Cipher Description The Caesar Cipher technique is one of the earliest techniques of encryption. Here, for each letter in the given text, it is replaced by a letter some fixed number of positions down the alphabet. If n = 1, replace A with by B, B would become C, and so ...

Read more

Question 439. Longest Palindrome can be Formed by Removing or Rearranging Characters Problem Statement In the “Longest Palindrome can be Formed by Removing or Rearranging Characters” problem we have given a string “s”. Find the longest palindrome that can be constructed by removing or rearranging some characters or possibly zero characters from the string. There may be multiple solutions possible, you can ...

Read more

Question 440. Longest Common Prefix Word by Word Matching Problem Statement In the “Longest Common Prefix using Word by Word Matching” problem, we have given N strings.  Write a program to find the longest common prefix of the given strings. Input Format The first line containing an integer value N which denotes the number of strings. Next N lines ...

Read more

Question 441. Longest Common Prefix using Character by Character Matching Problem Statement In the “Longest Common Prefix using Character by Character Matching” problem we have given an integer value N and N strings. Write a program to find the longest common prefix of the given strings. Input Format The first line containing an integer value N which denotes the number ...

Read more

Question 442. Permutations of a Given String Using STL Problem Statement In the “Permutations of a Given String Using STL” problem, we have given a string “s”. Print all the permutations of the input string using STL functions. Input Format The first and only one line containing a string “s”. Output Format Print all the permutation of the given ...

Read more

Question 443. Longest Common Prefix using Divide and Conquer Problem Statement In the “Longest Common Prefix using Divide and Conquer ” problem, we have given an integer n and n strings. Write a program that will print the longest common prefix. If there is no common prefix then print “-1”. Input Format The first line contains an integer n. ...

Read more

Question 444. Longest Common Prefix Using Binary Search II Problem Statement In the “Longest Common Prefix Using Binary Search II” problem we have given an integer value N and N strings. Write a program that will print the longest common prefix of given strings. If there is no common prefix then print “-1”. Input Format The first line containing ...

Read more

Question 445. Palindrome Permutations of a String Problem Statement In the “Palindrome Permutations of a String” problem, we have given an input string “s”. Print all the possible palindromes that can be generated using the characters of the string. Input Format The first and only one line containing a string “s”. Output Format Print all the possible ...

Read more

Question 446. Check if Two given Strings are Isomorphic to each other Problem Statement In the “Check if Two given Strings are Isomorphic to each other” problem we have given two strings s1 and s2. Write a program that says whether the given strings are isomorphic or not. Note: Two strings are said to be isomorphic if there is a one to ...

Read more

Question 447. Length of Longest valid Substring Problem Statement In the “Length of Longest valid Substring” we have given a string that contains the opening and closing parenthesis only. Write a program that will find the longest valid parenthesis substring. Input Format The first and only one line containing a string s. Output Format The first and ...

Read more

Question 448. Smallest window in a string containing all characters of another string Find the shortest substring in a given string that contains all the characters of a given word or Find the Smallest window in a string containing all characters of another string Given two strings s and t, write a function that will find the minimum window in s which will ...

Read more

Question 449. Form Minimum Number from Given Sequence of D’s and I’s Problem Statement In the “Form Minimum Number from Given Sequence of D’s and I’s” problem, we have given a pattern containing only I’s and D’s. I for increasing and D for decreasing. Write a program to print the minimum number following that pattern. Digits from 1-9 and digits can’t repeat. Input Format ...

Read more

Question 450. Arrange given Numbers to Form the Biggest Number II Problem Statement In the “Arrange given Numbers to Form the Biggest Number II” problem, we have given an array of positive integers.  Arrange them in such a way that the arrangement will form the largest value. Input Format The first and only one line containing an integer n. Second-line containing ...

Read more

Question 451. Check if a Linked list of Strings form a Palindrome Problem Statement In the “Check if a Linked list of Strings form a Palindrome” problem we have given a linked list handling string data. Write a program to check whether the data forms a palindrom or not. Example ba->c->d->ca->b 1 Explanation: In the above example we can see that the ...

Read more

Amazon Tree Questions
Question 452. Lowest Common Ancestor of a Binary Search Tree Leetcode Solution Problem Statement: Lowest Common Ancestor of a Binary Search Tree Leetcode Solution – Given a binary search tree (BST), find the lowest common ancestor (LCA) node of two given nodes in the BST. Note: “The lowest common ancestor is defined between two nodes p and q as the lowest node in T that has both p and q as ...

Read more

Question 453. Step-By-Step Directions From a Binary Tree Node to Another LeetCode Solution Problem Statement: Step-By-Step Directions From a Binary Tree Node to Another LeetCode Solution – You are given the root of a binary tree with n nodes. Each node is uniquely assigned a value from 1 to n. You are also given an integer startValue representing the value of the start node s, and a different integer destValue representing the value of the destination ...

Read more

Question 454. Vertical Order Traversal of Binary Tree LeetCode Solution Problem Statement Vertical Order Traversal of Binary Tree LeetCode Solution says – Given the root of a binary tree, calculate the vertical order traversal of the binary tree. For each node at position (row, col), its left and right children will be at positions (row + 1, col - 1) and (row + 1, col + 1) respectively. ...

Read more

Question 455. Sum Root to Leaf Numbers LeetCode Solution Problem Statement Sum Root to Leaf Numbers LeetCode Solution says – You are given the root of a binary tree containing digits from 0 to 9 only. Each root-to-leaf path in the tree represents a number. For example, the root-to-leaf path 1 -> 2 -> 3 represents the number 123. Return the total sum of all root-to-leaf numbers. Test ...

Read more

Question 456. Binary Tree Inorder Traversal LeetCode Solution Problem Statement: Binary Tree Inorder Traversal LeetCode solution Given the root of a binary tree, return the inorder traversal of its nodes’ values. Example 1: Input: root = [1,null,2,3] Output: [1,3,2] Example 2: Input: root = [] Output: [] Example 3: Input: root = [1] Output: [1] Constraints: The number of nodes in ...

Read more

Question 457. Flatten Binary Tree to Linked List LeetCode Solution Flatten Binary Tree to Linked List LeetCode Solution says that – Given the root of a binary tree, flatten the tree into a “linked list”: The “linked list” should use the same TreeNode class where the right child pointer points to the next node in the list and the left child pointer is always null. The “linked list” ...

Read more

Question 458. Lowest Common Ancestor of a Binary Tree Leetcode Solution Problem Statement The Lowest Common Ancestor of a Binary Tree LeetCode Solution – “Lowest Common Ancestor of a Binary Tree” states that given the root of the binary tree and two nodes of the tree. We need to find the lowest common ancestor of these two nodes. The Lowest Common ...

Read more

Question 459. Populating Next Right Pointers in Each Node Leetcode Solution Problem Statement The Populating Next Right Pointers in Each Node LeetCode Solution – “Populating Next Right Pointers in Each Node” states that given the root of the perfect binary tree and we need to populate each next pointer of the node to its next right node. If there is no next ...

Read more

Question 460. Delete Nodes and Return Forest Leetcode Solution Problem Statement The Delete Nodes and Return Forest LeetCode Solution – “Delete Nodes and Return Forest” states that given the root of the binary tree where each node has a distinct value. We’re also given an array,  to_delete, where we need to delete all the nodes with values contained in ...

Read more

Question 461. Recover Binary Search Tree Leetcode Solution Problem Statement The Recover Binary Search Tree LeetCode Solution – “Recover Binary Search Tree” states that given the root of the binary search tree, where the values of exactly two nodes are swapped by mistake. We need to recover the tree without changing its structure. Example: Input: root = [1,3,null,null,2] Output: [3,1,null,null,2] ...

Read more

Question 462. Symmetric Tree Leetcode Solution Problem Statement The Symmetric Tree LeetCode Solution – “Symmetric Tree” states that given the root of the binary tree and we need to check if the given binary tree is a mirror of itself (symmetric around its center) or not? If Yes, we need to return true otherwise, false. Example: ...

Read more

Question 463. Root to Leaf path with target sum Leetcode Solutions A binary tree and an integer K are given. Our goal is to return whether there is a root-to-leaf path in the tree such that it’s sum is equal to the target-K. The sum of a path is the sum of all nodes that lie on it. 2 / \ ...

Read more

Question 464. Scramble String Problem Statement “Scramble String” problem states that you are given two strings. Check if the second string is a scrambled string of first one or not? Explanation Let string s = “great” Representation of s as binary tree by recursively dividing it into two non-empty sub-strings. This string can be ...

Read more

Question 465. Queries for Number of Distinct Elements in a Subarray We have given an array of integer and a number of queries and we have to find out the number of all the distinct elements we have within the given range, the query consists of two numbers left and right, this is the given range, with this given range we ...

Read more

Question 466. Morris Traversal Morris traversal is a method to traverse the nodes in a binary tree without using stack and recursion. Thus reducing the space complexity to linear. Inorder Traversal Example 9 7 1 6 4 5 3 1           /    \         2    ...

Read more

Question 467. Kth ancestor of a node in binary tree Problem Statement The problem “Kth ancestor of a node in binary tree” states that you are given a binary tree and a node. Now we need to find the kth ancestor of this node. An ancestor of any node is the nodes that lie on the path from the root ...

Read more

Question 468. Inorder Successor of a node in Binary Tree Problem Statement The problem asks to find “Inorder Successor of a node in Binary Tree”. An inorder successor of a node is a node in the binary tree that comes after the given node in the inorder traversal of the given binary tree. Example Inorder successor of 6 is 4 ...

Read more

Question 469. Check if a given array can represent Preorder Traversal of Binary Search Tree The problem “Check if a given array can represent Preorder Traversal of Binary Search Tree” states that you are given a preorder traversal sequence. Now consider this sequence and find out if this sequence can represent a binary search tree or not? The expected time complexity for the solution is ...

Read more

Question 470. Construct Binary Tree from given Parent Array representation The problem “Construct Binary Tree from given Parent Array representation” states that you are given an array. This input array represents a binary tree. Now you need to construct a binary tree on the basis of this input array. The array stores the index of parent node at each index. ...

Read more

Question 471. Given a binary tree, how do you remove all the half nodes? The problem “Given a binary tree, how do you remove all the half nodes?” states that you are given a binary tree. Now you need to remove the half nodes. A half node is defined as a node in the tree that has only a single child. Either it is ...

Read more

Question 472. Iterative Preorder Traversal The problem “Iterative Preorder Traversal” states that you are given a binary tree and now you need to find the preorder traversal of the tree. We are required to find the preorder traversal using iterative method and not the recursive approach. Example   5 7 9 6 1 4 3 ...

Read more

Question 473. Find distance between two nodes of a Binary Tree Problem Statement The problem “Find distance between two nodes of a Binary Tree” states that you are given a binary tree and you are given two nodes. Now you need to find the minimum distance between these two nodes. Example // Tree is shown using the image above node 1 ...

Read more

Question 474. Write Code to Determine if Two Trees are Identical The problem “Write Code to Determine if Two Trees are Identical” states that you are given two binary trees. find out if they are identical or not? Here, identical tree means that both the binary trees have the same node value with the same arrangement of nodes. Example Both trees ...

Read more

Question 475. Boundary Traversal of binary tree Problem Statement The problem “Boundary Traversal of binary tree” states that you are given a binary tree. Now you need to print the boundary view of a binary tree. Here boundary traversal means that all the nodes are shown as the boundary of the tree. The nodes are seen from ...

Read more

Question 476. Diagonal Traversal of Binary Tree Problem Statement The problem “Diagonal Traversal of Binary Tree” states that you are given a binary tree and now you need to find the diagonal view for the given tree. When we see a tree from the top-right direction. The nodes which are visible to us is the diagonal view ...

Read more

Question 477. Bottom View of a Binary Tree Problem Statement The problem “Bottom View of a Binary Tree” states that you are given a binary tree and now you need to find the bottom view for the given tree. When we see a tree from the downward direction. The nodes which are visible to us is the bottom ...

Read more

Question 478. Print Right View of a Binary Tree Problem Statement The problem “Print Right View of a Binary Tree” states that you are given a binary tree. Now you need to find the right view of this tree. Here, right view of the binary tree means to print the sequence as the tree looks when looked from the ...

Read more

Question 479. Range LCM Queries Problem Statement The problem “Range LCM Queries” states that you have an integer array and q number of queries. Each query contains the (left, right) as a range. The given task is to find out the LCM(left, right), i.e, LCM of all the number that comes in the range of ...

Read more

Question 480. Find Maximum Level sum in Binary Tree Problem Statement The problem “Find Maximum Level sum in Binary Tree” states that you are given a binary tree with positive and negative nodes, find the maximum sum of a level in the binary tree. Example Input 7 Explanation First Level : Sum = 5 Second Level : Sum = ...

Read more

Question 481. Red-Black Tree Introduction Red Black Tree is a self-balancing binary tree. In this tree, every node is either a red node or a black node. In this Red-black Tree Introduction, we will try to cover all of its basic properties. Properties of Red-Black Tree Every node is represented as either red or black. ...

Read more

Question 482. Binary Search Tree Delete Operation Problem Statement The problem “Binary Search Tree Delete Operation” asks us to implement the delete operation for binary search tree. Delete function refers to the functionality to delete a node with a given key/data. Example Input Node to be deleted = 5 Output Approach for Binary Search Tree Delete Operation So ...

Read more

Question 483. Iterative Method to find Height of Binary Tree Problem Statement The problem “Iterative Method to find Height of Binary Tree” states that you are given a binary tree, find the height of the tree using the iterative method. Examples Input 3 Input 4 Algorithm for Iterative Method to find Height of Binary Tree The height of a tree ...

Read more

Question 484. Clone a Binary Tree with Random Pointers Problem Statement You are given a complete binary tree with some random pointers. Random pointers are referred to nodes which every node points to other than its left and right child. So, this also changes the standard structure of a node in a simple binary tree. Now the node of ...

Read more

Question 485. Level order traversal using two Queues Problem Statement The problem “Level order traversal using two Queues” states that you are given a binary tree, print its level order traversal line by line. Examples Input 5 11 42 7 9 8 12 23 52 3 Input 1 2 3 4 5 6 Algorithm for Level Order Traversal ...

Read more

Question 486. Check if all levels of two Binary Tree are anagrams or not Problem Statement The problem “Check if all levels of two Binary Tree are anagrams or not” says that you are given two Binary Trees, check if all the levels of the two trees are anagrams or not. Examples Input true Input false Algorithm to Check if all levels of two ...

Read more

Question 487. Check if the given array can represent Level Order Traversal of Binary Search Tree Problem Statement The problem “Check if the given array can represent Level Order Traversal of Binary Search Tree” states that you are given a level order traversal of the binary search tree. And using the level order traversal of the tree. We need to efficiently find if the level order ...

Read more

Question 488. Number of siblings of a given Node in n-ary Tree Problem Statement The problem “Number of siblings of a given Node in n-ary Tree” states that you are given an n-ary Tree and a target node. Find the number of siblings of the target node. Assume that node is always present in the tree and the first node is the ...

Read more

Question 489. Convert BST into a Min-Heap without using array Problem Statement “Convert BST into a Min-Heap without using array” problem states that you are given a BST (binary search tree) and you need to convert it into a min-heap. The min-heap should contain all the elements in the binary search tree. The algorithm should run in linear time complexity. ...

Read more

Question 490. Merge two BSTs with limited extra space Problem Statement The problem “Merge two BSTs with limited extra space” states that you are given two binary search tree(BST) and you need to print the elements from both the trees in sorted order. That is in such an order that it seems that elements are from a single BST. ...

Read more

Question 491. Iterative Postorder Traversal Using Two Stacks Problem Statement The problem “Iterative Postorder Traversal Using Two Stacks” states that you are given a binary tree with n nodes. Write the program for it’s iterative postorder traversal using two stacks. Example Input   4 5 2 6 7 3 1 Input   4 2 3 1 Algorithm Create ...

Read more

Question 492. Binary Tree to Binary Search Tree Conversion using STL set Problem Statement We are given a binary tree and we need to convert it into a binary search tree. The problem “Binary Tree to Binary Search Tree Conversion using STL set” asks to do conversion using STL set. We have already discussed converting the binary tree into BST but we ...

Read more

Question 493. K’th Largest element in BST using constant extra space Problem Statement “K’th Largest element in BST using constant extra space” states that you are given a binary search tree and you need to find the kth largest element in it. So if we arrange the elements of the binary search tree in descending order then we need to return ...

Read more

Question 494. K’th Largest Element in BST when modification to BST is not allowed Problem Statement “K’th Largest Element in BST when modification to BST is not allowed” states that you are given a binary search tree and you need to find the kth largest element. This means that when all the elements of the binary search tree are arranged in descending order. Then ...

Read more

Question 495. Iterative method to find ancestors of a given binary tree Problem Statement “Iterative method to find ancestors of a given binary tree” problem states that you are given a binary tree and an integer representing a key. Create a function to print all the ancestors of the given key using iteration. Example Input  key = 6 5 2 1 Explanation: ...

Read more

Question 496. Check if each internal node of a BST has exactly one child Problem Statement “Check if each internal node of a BST has exactly one child” problem states that you are given a preorder traversal of a binary search tree. And you need to find if all the non-leaf nodes contain only a single child. Here we also consider that all the ...

Read more

Question 497. Find k-th smallest element in BST (Order Statistics in BST) Problem Statement “Find k-th smallest element in BST (Order Statistics in BST)” problem states that you are given a binary search tree and you need to find the k-th smallest number in the BST. This means if we do an in-order traversal of the binary search tree and store the ...

Read more

Question 498. Vertical sum in a given binary tree Problem Statement “Vertical sum in a given binary tree” problem states that you are given a binary tree and we need to find the sum of each vertical level. By vertical level, we mean if we draw vertical lines at a distance of 1 unit in the left and right ...

Read more

Question 499. A program to check if a binary tree is BST or not Problem Statement “A program to check if a binary tree is BST or not” states that you are given a binary tree and you need to check if the binary tree satisfies the properties of the binary search tree. So, the binary tree has the following properties:  The left subtree ...

Read more

Question 500. Maximum Depth Of Binary Tree Problem Statement “Maximum depth of binary tree” problem states that you are given a binary tree data structure. Print the maximum depth of the given binary tree. Example Input 2 Explanation: Maximum depth for the given tree is 2. Because there is only a single element below the root (i.e. ...

Read more

Question 501. Convert BST to Min Heap Problem Statement Given a complete Binary Search Tree, write an algorithm to convert it into a Min Heap, which is to convert BST to Min Heap. The Min Heap should be such that the values on the left of a node must be less than the values on the right ...

Read more

Question 502. Merge Two Balanced Binary Search Trees Problem Statement Given Two Balanced Binary Search Trees, there are n elements in the first BST and m elements in the second BST. Write an algorithm to merge two balanced binary search trees to form a third balanced Binary Search Tree with (n + m) elements. Example Input Output Pre-order ...

Read more

Question 503. Binary Search Tree Search and Insertion Problem Statement Write an algorithm to perform searching and insertion in Binary Search Tree. So what we are going to do is insert some of the elements from input into a binary search tree. Whenever asked to search a particular element, we’ll be searching it among the elements in BST(short ...

Read more

Question 504. Check given array of size n can represent BST of n levels or not Problem Statement Given an array with n elements, check given array of size n can represent BST of n levels or not. That is to check whether the binary search tree constructed using these n elements can represent a BST of n levels. Examples arr[] = {10, 8, 6, 9, ...

Read more

Question 505. Binary Tree to Binary Search Tree Conversion In binary tree to binary search tree conversion problem, we have given a binary tree convert it to Binary Search Tree without changing the structure of the tree. Example Input Output pre-order : 13 8 6 47 25 51 Algorithm We do not have to change the structure of the ...

Read more

Question 506. Sorted Linked List to Balanced BST In sorted linked list to balanced BST problem, we have given a singly Linked list in sorted order, construct a Balanced Binary Tree from the singly Linked List. Examples Input 1 -> 2 -> 3 -> 4 -> 5 Output Pre-order : 3 2 1 5 4 Input 7 -> ...

Read more

Question 507. Sorted Array to Balanced BST In sorted array to balanced BST problem, we have given an array in sorted order, construct a Balanced Binary Search Tree from the sorted array. Examples Input arr[] = {1, 2, 3, 4, 5} Output Pre-order : 3 2 1 5 4 Input arr[] = {7, 11, 13, 20, 22, ...

Read more

Question 508. Transform a BST to Greater sum Tree In transform a BST to greater sum tree Given a Binary Search Tree write an algorithm to convert it to a greater sum tree, that is, transform each node to contain the sum of all the elements greater than it. Example Input Output Pre-order : 69 81 87 34 54 ...

Read more

Question 509. Advantages of BST over Hash Table The most commonly used operations on any data structure are insertion, deletion, and searching. Hash Table is able to perform these three operations with the average time complexity of O(1), while self-balancing Binary Search Trees take O(log n) time complexity. At first, it seems as Hash Tables are better than ...

Read more

Question 510. Construct BST from its given Level Order Traversal Given the level order traversal of a Binary Search Tree, write an algorithm to construct the Binary Search Tree or BST from ITS given level order traversal. Example Input levelOrder[] = {18, 12, 20, 8, 15, 25, 5, 9, 22, 31} Output In-order : 5 8 9 12 15 18 ...

Read more

Question 511. Construct BST from given Preorder Traversal Given a pre-order traversal of a Binary Search Tree(BST), write an algorithm to construct the BST from given preorder traversal. Examples Input   preOrder[] = {7, 5, 3, 6, 9} Output Inorder : 3 5 6 7 9 Input preOrder[] = {12, 6, 1, 35, 20} Output Inorder : 1 6 ...

Read more

Question 512. Find the node with minimum value in a Binary Search Tree Given a Binary Search Tree, write an algorithm to find the node with the minimum value in a given binary search tree. Example Input Output 5 Naive Approach A simple approach is to do a tree traversal and find the node with the minimum value among all the nodes. This ...

Read more

Question 513. Construct Binary Tree from Given Inorder and Preorder Traversals In this problem, we have inorder and preorder of the binary tree. We need to construct a binary tree from the given Inorder and Preorder traversals. Example Input: Inorder= [D, B, E, A, F, C] Preorder= [A, B, D, E, C, F] Output: Pre-order traversal of the tree formed by ...

Read more

Question 514. Print Ancestors of a Given Binary Tree Node Without Recursion Given a binary tree and a specific node or key. Print ancestors of a given binary tree node without recursion. Example Input : key = 7 Output : 3 1 Input : key = 4 Output : 2 1 Algorithm for Ancestors of a Given Binary Tree Node Create a class Node ...

Read more

Question 515. Level order Traversal in Spiral Form In this problem we have given a binary tree,  print its level order traversal in a spiral form. Examples Input Output 10 30 20 40 50 80 70 60 Naive Approach for Level order Traversal in Spiral Form The idea is to do a normal level order traversal using a ...

Read more

Question 516. Kth Smallest Element in a BST In this problem, we have given a BST and a number k, find the kth smallest element in a BST. Examples Input tree[] = {5, 3, 6, 2, 4, null, null, 1} k = 3 Output 3 Input tree[] = {3, 1, 4, null, 2} k = 1 Output 1 ...

Read more

Question 517. Balanced Binary Tree In the balanced binary tree problem, we have given the root of a binary tree. We have to determine whether or not it is height balance. Examples Input Output true Input Output: false Balanced Binary Tree Every node in a balanced binary tree has a difference of 1 or less ...

Read more

Question 518. Interval Tree In the interval tree problem, we have given a set of intervals and three types of queries addInterval(x,y): Add an interval (x,y) to the set removeInterval(x,y): Remove an interval (x,y) from the set checkInterval(x,y): Check if interval (x,y) overlaps with some existing interval Design a data structure( Interval Tree ) ...

Read more

Question 519. Construct Complete Binary Tree from its Linked List Representation Given the linked list representation of a complete binary tree. The linked list is in the order of level order traversal of the tree. Write an algorithm to construct the complete binary tree back from its linked list representation. Example Input 1 -> 2 -> 3 -> 4 -> 5 ...

Read more

Question 520. Lowest Common Ancestor Given the root of a binary tree and two nodes n1 and n2, find the LCA(Lowest Common Ancestor) of the nodes. Example What is Lowest Common Ancestor(LCA)? The ancestors of a node n are the nodes present in the path between root and node. Consider the binary tree shown in ...

Read more

Question 521. Lowest Common Ancestor in Binary Search Tree Given the root of a binary search tree and two nodes n1 and n2, find the LCA(Lowest Common Ancestor) of the nodes in a given binary search tree. Example Naive Approach for Lowest Common Ancestor in Binary Search Tree Find the LCA(n1, n2) using the optimal approach to find LCA ...

Read more

Question 522. Segment Tree If we have performing addition on a given range of array whose element values updated any time. Then in that type of problem, we handle using a segment tree structure. Given an array a[] with n elements and you have to answer multiple queries, each of the queries is one ...

Read more

Question 523. Print a Binary Tree in Vertical Order In this problem, we have given a pointer denoting the root of the binary tree and your task is to print the binary tree in the vertical order. Example Input 1 / \ 2 3 / \ / \ 4 5 6 7 \ \ 8 9 Output 4 2 ...

Read more

Question 524. Binary Search Tree A binary search tree is a Binary tree with some rules that allows us to maintain the data in a sorted fashion. As it is a binary tree hence, a node can have at max 2 children. Structure of a Binary Search Tree node   Rules for Binary tree to ...

Read more

Question 525. Maximum Binary Tree In this problem, we have given an array a[ ] of size n. Create the maximum binary tree from the array and return its root node. It is made from the array using the following steps : The root node of the tree should be the maximum value in the given ...

Read more

Question 526. Binary Tree zigzag level order Traversal Given a binary tree, print the zigzag level order traversal of its node values. (ie, from left to right, then right to left for the next level and alternate between). Example consider the binary tree given below Below is the zigzag level order traversal of the above binary tree Types ...

Read more

Question 527. Recover Binary Search Tree Consider a binary search tree, two nodes of the tree have been swapped, design an algorithm to recover the binary search Tree. Example Consider the binary search tree given below whose two nodes have been swapped as input. Incorrect nodes on the BST are detected(highlighted) and then swapped to obtain ...

Read more

Question 528. Populating Next Right Pointers in Each Node Given a Binary Tree, connect nodes that are at the same level from left to right. Structure of the Tree Node: A node of the tree contains 4 components which are data(integer value), pointers(next, left and right) of the tree node type. next pointer of a node point towards its ...

Read more

Question 529. Top View of Binary Tree The top view of a binary tree is the set of nodes visible when the tree is viewed from the top. Given a binary tree, the Output top view of the binary tree from the left-most horizontal level to the rightmost horizontal level. Example Example 1 Example 2 Types of ...

Read more

Question 530. Level of Each node in a Tree from source node Given a tree (an acyclic fully connected graph where constituent nodes are connected by bidirectional edges) and a source node. find the level of each node in a tree form source node. It is given that level of a node v with respect to the source is the distance between ...

Read more

Question 531. Find Duplicate Subtrees Duplicate Subtrees  Subtrees are said to be duplicate if they have the same node values and structure. Given a binary tree with n nodes. Find all the duplicate subtrees and return their root node. Example Here, the subtrees 4 and 2->4 appear more than once therefore we will return root ...

Read more

Question 532. Symmetric Tree In Symmetric Tree problem we have given a binary tree, check whether it is a mirror of itself. A tree is said to be a mirror image of itself if there exists an axis of symmetry through a root node that divides the tree into two same halves. Example Types ...

Read more

Question 533. Longest Common Prefix using Trie In the Longest Common Prefix using Trie problem we have given a set of strings, find the longest common prefix. i.e. find the prefix part that is common to all the strings. Example Input1: {“tutorialcup”, “tutorial”, “tussle”, “tumble”} Output: "tu" Input2: {"baggage", "banana", "batsmen"} Output: "ba" Input3: {"abcd"} Output: "abcd" ...

Read more

Question 534. Convert Sorted List to Binary Search Tree Problem Given a linked list. The elements of the linked list are in increasing order. Convert the given linked list into a highly balanced binary search tree. A highly balanced binary search tree is a binary search tree in which the difference between the depth of two subtrees of any ...

Read more

Question 535. Validate Binary Search Tree Problem In Validate Binary Search Tree problem we have given the root of a tree, we have to check if it is a binary search tree or not. Example : Output: true Explanation: The given tree is a binary search tree because all elements which are left to each subtree ...

Read more

Question 536. Path Sum What is Path Sum Problem? In the Path Sum problem, we have given a binary tree and an integer SUM. We have to find if any path from the root to leaf has a sum equal to the SUM. Path sum is defined as the sum of all the nodes ...

Read more

Question 537. Level Order Traversal of Binary Tree Level Order Traversal of a given binary tree is the same as the BFS of the binary tree. Do we already know about what actually BFS is? if not then don’t need to feel bad just read the whole article and visit our previous articles for better understanding. BFS is a ...

Read more

Question 538. Tree Traversal (Preorder, Inorder & Postorder) First, we need to know about what is Traversal in Binary Tree. Traversal is a type of method in which we visit all the nodes exactly once in some specific manner/order. Basically there are two types of traversal in Binary Tree: Breadth-First Traversal Depth  First Traversal We already know about ...

Read more

Question 539. Deletion in a Binary Tree Do we already know about what actually Binary Tree is? Now in this post, we are focusing on how to delete a node whose value is given. We are sure that the value of the node which we want to delete is always present before deletion in BT. In Binary ...

Read more

Question 540. Unique Binary Search Trees Firstly we have to find the total number of counts to form a unique binary search tree. After it, we construct all possible unique BST. First of all, we have to know the construction of BST. In a Binary Search Tree, the nodes present in the left subtree wrt. any ...

Read more

Question 541. BFS vs DFS for Binary Tree Breadth First Search (BFS) Do we already know about what actually BFS is? if not then don’t need to feel bad just read the whole article and visit our previous article on Breadth First Search for better understanding. BFS is a level order traversal in which we visit the nodes of ...

Read more

Amazon Graph Questions
Question 542. Most Stones Removed with Same Row or Column LeetCode Solution Problem Statement Most Stones Removed with Same Row or Column LeetCode Solution says that On a 2D plane we place n stones at some integer coordinate points. Each coordinate point may have at most one stone. A stone can be removed if it shares either the same row or the same ...

Read more

Question 543. Is Graph Bipartite? LeetCode Solution Problem Statement Is Graph Bipartite LeetCode Solution- There is an undirected graph with n nodes, where each node is numbered between 0 and n - 1. You are given a 2D array graph, where graph[u] is an array of nodes that node u is adjacent to. More formally, for each v in graph[u], there is an undirected edge between node u and node v. The graph has ...

Read more

Question 544. Find the Town Judge LeetCode Solution Problem Statement: Find the Town Judge LeetCode Solution – In a town, there are n people labeled from 1 to n. There is a rumor that one of these people is secretly the town judge and we need to find the town judge. If the town judge exists, then: The town judge trusts nobody. ...

Read more

Question 545. Find the Town Judge Leetcode Solution Problem Statement In this problem, we are given n people labelled from 1 to n. We are also given a 2d array trust[][] shows that trust[i][0]th people trusts trust[i][1]th people for each 0 <= i < trust.length. We have to find a person “town judge” who does not trust any ...

Read more

Question 546. Find the smallest binary digit multiple of given number Problem Statement The problem “Find the smallest binary digit multiple of given number” states that you are given a decimal number N. So find the smallest multiple of N that contains only the binary digits ‘0’ and ‘1’. Example 37 111 A detailed explanation can be found below in the ...

Read more

Question 547. Minimum Operations to convert X to Y Problem Statement The problem “Minimum Operations to convert X to Y” states that you are given two numbers X and Y, it is needed to convert X into Y using following operations: Starting number is X. Following operations can be performed on X and on the numbers that are generated ...

Read more

Question 548. Check if two nodes are on the same path in a Tree Problem Statement The problem “Check if two nodes are on the same path in a Tree” states that you are given a n-ary tree (directed acyclic graph) rooted at root node with uni-directional edges between it’s vertices. You are also given a list of queries q. Each query in list ...

Read more

Question 549. Distance of nearest cell having 1 in a binary matrix Problem Statement The problem “Distance of nearest cell having 1 in a binary matrix” states that you are given a binary matrix(containing only 0s and 1s) with at least one 1. Find the distance of the nearest cell having 1 in the binary matrix for all the elements of the ...

Read more

Question 550. Transpose Graph Problem Statement The problem “Transpose graph” states that you are given a graph and you need to find the transpose of the given graph. Transpose: Transpose of a directed graph produces another graph with same edge & node configurations but the direction of all the edges have been reversed. Example ...

Read more

Question 551. BFS for Disconnected Graph Problem Statement The problem “BFS for Disconnected Graph” states that you are given a disconnected directed graph, print the BFS traversal of the graph. Example The BFS traversal of the graph above gives: 0 1 2 5 3 4 6 Approach Breadth first Search (BFS) traversal for Disconnected Directed Graph ...

Read more

Question 552. Minimum Steps to reach target by a Knight Description The problem “Minimum Steps to reach target by a Knight” states that you are given a square chess board of N x N dimensions, co-ordinates of the Knight piece, and the target cell. Find out the minimum number of steps taken by the Knight piece to reach the target ...

Read more

Question 553. Iterative Depth First Traversal of Graph In iterative depth first traversal of graph problem, we have given a graph data structure. Write the program to print the depth first traversal of the given graph using the iterative method. Example Input : 0 -> 1, 0 -> 2, 1 -> 2, 2 -> 0, 2 -> 3, 3 ...

Read more

Question 554. Evaluate Division In evaluate division problem we have given some equations, in the form, A/B = k, where A and B are strings and k is a real number. Answer some queries, if the answer does not exist return -1. Example Input: equations: a/b = 2.0 and b/c = 3.0 queries: a/c ...

Read more

Question 555. Prim’s Algorithm Prim’s algorithm is used to find the Minimum Spanning Tree(MST) of a connected or undirected graph. Spanning Tree of a graph is a subgraph that is also a tree and includes all the vertices. Minimum Spanning Tree is the spanning tree with a minimum edge weight sum. Example Graph Minimum ...

Read more

Question 556. Max Area of Island Problem Description: Given a 2D matrix, the matrix has only 0(representing water)  and 1(representing land) as entries. An island in the matrix is formed by grouping all the adjacent 1’s connected 4-directionally(horizontal and vertical). Find the maximum area of the island in the matrix. Assume that all four edges of ...

Read more

Question 557. Graph Cloning What is Graph Cloning? Today we have with us a reference to an undirected graph. What do we have to do? Returning a deep copy of the provided graph. Let us look at the structure: The Class Node: It consists of the data value and the neighbors associated with each ...

Read more

Question 558. Topological Sorting Given a directed acyclic graph, topologically sort the graph nodes. Topological Sorting Example Topological sorting of above graph is -> {1,2,3,0,5,4} Theory Topological Sorting is done for a Directed Acyclic Graph (DAG). A DAG has no cycles in it. ie, there is no such path starting from any node of ...

Read more

Question 559. Breadth First Search (BFS) for a Graph Breadth First Search (BFS) for a graph is a traversing or searching algorithm in tree/graph data structure. It starts at a given vertex(any arbitrary vertex) and explores all the connected vertex and after that moves to the nearest vertex and explores all the unexplored nodes and takes care that no ...

Read more

Question 560. Dijkstra Algorithm Dijkstra is the shortest path algorithm. Dijkstra algorithm is used to find the shortest distance of all nodes from the given start node. It logically creates the shortest path tree from a single source node, by keep adding the nodes greedily such that at every point each node in the ...

Read more

Amazon Stack Questions
Question 561. Score of Parenthesis LeetCode Solution Problem Statement The score of Parenthesis LeetCode Solution says – Given a balanced parentheses string s and return the maximum score. The score of a balanced parenthesis string is based on the following rules: "()" has score 1. AB has score A + B, where A and B are balanced parenthesis strings. (A) has score 2 * A, where A is a ...

Read more

Question 562. Binary Tree Inorder Traversal LeetCode Solution Problem Statement: Binary Tree Inorder Traversal LeetCode solution Given the root of a binary tree, return the inorder traversal of its nodes’ values. Example 1: Input: root = [1,null,2,3] Output: [1,3,2] Example 2: Input: root = [] Output: [] Example 3: Input: root = [1] Output: [1] Constraints: The number of nodes in ...

Read more

Question 563. Decode String Leetcode Solution Problem Statement The Decode String LeetCode Solution – “Decode String” asks you to convert the encoded string into a decoded string. The encoding rule is k[encoded_string], where the encoded_string inside the square brackets is being repeated exactly k times where k is a positive integer. Example: Input: s = "3[a]2[bc]" Output: "aaabcbc" ...

Read more

Question 564. Flatten Binary Tree to Linked List LeetCode Solution Flatten Binary Tree to Linked List LeetCode Solution says that – Given the root of a binary tree, flatten the tree into a “linked list”: The “linked list” should use the same TreeNode class where the right child pointer points to the next node in the list and the left child pointer is always null. The “linked list” ...

Read more

Question 565. Add Two Numbers II Leetcode Solution Problem Statement The Add Two Numbers II LeetCode Solution – “Add Two Numbers II” states that two non-empty linked lists represent two non-negative integers where the most significant digit comes first and each node contains exactly one digit. We need to add the two numbers and return the sum as ...

Read more

Question 566. Daily Temperatures Leetcode Solution Problem Statement The Daily Temperatures Leetcode Solution: states that given an array of integers temperatures represents the daily temperatures, return an array answer such that answer[i] is the number of days you have to wait after the ith day to get a warmer temperature. If there is no future day for which this is possible, keep answer[i] == 0 instead. ...

Read more

Question 567. Minimum Remove to Make Valid Parentheses LeetCode Solution Problem Statement The Minimum Remove to Make Valid Parentheses LeetCode Solution – You are given a string s of ‘(‘, ‘)’ and lowercase English characters. Your task is to remove the minimum number of parentheses ( ‘(‘ or ‘)’, in any positions ) so that the resulting parentheses string is ...

Read more

Question 568. Trapping Rain Water Leetcode Solution Problem Statement The Trapping Rain Water LeetCode Solution – “Trapping Rain Water” states that given an array of heights which represents an elevation map where the width of each bar is 1. We need to find the amount of water trapped after rain. Example: Input: height = [0,1,0,2,1,0,1,3,2,1,2,1] Output: 6 Explanation: Check ...

Read more

Question 569. Valid Parentheses Leetcode Solution Problem Statement The Valid Parentheses LeetCode Solution – “Valid Parentheses” states that you’re given a string containing just the characters '(', ')', '{', '}', '[' and ']'. We need to determine whether the input string is a valid string or not. A string is said to be a valid string if open brackets must be closed ...

Read more

Question 570. Maximum Frequency Stack Leetcode Solution Problem Statement The Maximum Frequency Stack LeetCode Solution – “Maximum Frequency Stack” asks you to design a frequency stack in which whenever we pop an element from the stack, it should return the most frequent element present in the stack. Implement the FreqStack class: FreqStack() constructs an empty frequency stack. void push(int val) pushes ...

Read more

Question 571. Design a Stack With Increment Operation Leetcode Solution Problem Statement The Design a Stack With Increment Operation Leetcode Solution –  states that we need to design a stack that supports the below operations efficiently. Assign the maximum capacity of the stack. Perform the push operation efficiently, if the size of the stack is strictly less than the maximum capacity of ...

Read more

Question 572. Min Stack Leetcode Solution Problem Statement Design a stack that supports push, pop, top, and retrieving the minimum element in constant time. push(x) — Push element x onto stack. pop() — Removes the element on top of the stack. top() — Get the top element. getMin() — Retrieve the minimum element in the stack. ...

Read more

Question 573. Next Greater Element I Leetcode Solution Problem Statement In this problem, we are given two lists in which first list is subset of second list. For each element of first list, we have to find out next greater element in the second list. Example nums1 = [4,1,2], nums2 = [1,3,4,2] [-1,3,-1] Explanation: for first element of list1 i.e. for 4 there ...

Read more

Question 574. Check if a given array can represent Preorder Traversal of Binary Search Tree The problem “Check if a given array can represent Preorder Traversal of Binary Search Tree” states that you are given a preorder traversal sequence. Now consider this sequence and find out if this sequence can represent a binary search tree or not? The expected time complexity for the solution is ...

Read more

Question 575. Form minimum number from given sequence The problem “Form minimum number from given sequence” states that you are given some pattern of I’s and D’s only. The meaning of I stands for increasing and for decreasing we are provided with D. The problem statement asks to print the minimum number which satisfies the given pattern. We have ...

Read more

Question 576. Range Queries for Longest Correct Bracket Subsequence You are given a sequence of some brackets subsequence, in other words, you are given brackets like ‘(’ and ‘)’ and you are given a query range as a starting point and ending point. The problem “Range Queries for Longest Correct Bracket Subsequence” asks to find out the maximum length ...

Read more

Question 577. Find Index of Closing Bracket for a Given Opening Bracket in an Expression Problem Statement Given a string s of length/size n and an integer value representing the index of an opening square bracket. Find index of closing bracket for a given opening bracket in an expression. Example s = "[ABC[23]][89]" index = 0 8 s = "[C-[D]]" index = 3 5 s ...

Read more

Question 578. Design a stack that supports getMin() in O(1) time and O(1) extra space Design a stack that supports getMin() in O(1) time and O(1) extra space. Thus the special stack data structure must support all the operations of the stack like – void push() int pop() bool isFull() bool isEmpty() in constant time. Add an additional operation getMin() to return the minimum value ...

Read more

Question 579. Sort a stack using recursion Problem Statement The problem “Sort a stack using recursion” states that you are given a stack data structure. Sort its elements using recursion. Only the below-listed functions of the stack can be used – push(element) – to insert the element in the stack. pop() – pop() – to remove/delete the ...

Read more

Question 580. Delete middle element of a stack Problem Statement Given a data structure (stack). Write a program to delete the middle element of the given stack using the basic functions of the stack – push() – to insert an element in the stack. pop() – to remove/delete the top element from the stack. empty() – to check ...

Read more

Question 581. Sorting array using Stacks Problem statement The problem “Sorting array using Stacks” states that you are given a data structure array a[ ] of size n. Sort the elements of the given array using stack data structure. Example 2 30 -5 43 100 -5 2 30 43 100 Explanation: The elements are sorted in ...

Read more

Question 582. Sort a stack using a temporary stack Problem Statement The problem “Sort a stack using a temporary stack” states that you are given a stack data structure. Sort the elements of the given stack using a temporary stack. Example 9 4 2 -1 6 20 20 9 6 4 2 -1 2 1 4 3 6 5 ...

Read more

Question 583. Reverse individual words Problem Statement The problem “Reverse individual words” states that you are given a string s. Now, print the reverse of all the individual words in the string. Example s = "TutorialCup - changing the way of learning" puClairotuT - gnignahc eht yaw fo gninrael  s = "Reverse individual words" esreveR ...

Read more

Question 584. Remove brackets from an algebraic string containing + and – operators Problem Statement You are given a string s of size n representing an arithmetic expression with parenthesis. The problem “Remove brackets from an algebraic string containing + and – operators” asks us to create a function that can simplify the given expression. Example s = "a-(b+c)" a-b-c  s = a-(b-c-(d+e))-f a-b+c+d+e-f ...

Read more

Question 585. Implement a stack using single queue Problem Statement The problem “Implement a stack using single queue” asks us to implement a stack (LIFO) data structure using a queue (FIFO) data structure. Here LIFO means Last In First Out while FIFO means First In First Out. Example push(10) push(20) top() pop() push(30) pop() top() Top : 20 ...

Read more

Question 586. Check if a queue can be sorted into another queue using a stack Problem Statement The problem “Check if a queue can be sorted into another queue using a stack” states that you are given a queue containing n elements, the elements in the queue are a permutation of numbers 1 to n. Check if this queue can be arranged in increasing order ...

Read more

Question 587. Form Minimum Number From Given Sequence Problem Statement The problem “Form Minimum Number From Given Sequence states that you are given a string s of length/size n representing a pattern of characters ‘I’ i.e. increasing and ‘D’ i.e. decreasing only. Print the minimum number for the given pattern with unique digits from 1-9. For instance – ...

Read more

Question 588. Iterative Postorder Traversal Using Two Stacks Problem Statement The problem “Iterative Postorder Traversal Using Two Stacks” states that you are given a binary tree with n nodes. Write the program for it’s iterative postorder traversal using two stacks. Example Input   4 5 2 6 7 3 1 Input   4 2 3 1 Algorithm Create ...

Read more

Question 589. Stack Permutations (Check if an array is stack permutation of other) Problem Statement The problem “Stack Permutations (Check if an array is stack permutation of other)” states that you are given two arrays a[ ] and b[ ] of size n. All the elements of the array are unique. Create a function to check if the given array b[ ] is ...

Read more

Question 590. Iterative method to find ancestors of a given binary tree Problem Statement “Iterative method to find ancestors of a given binary tree” problem states that you are given a binary tree and an integer representing a key. Create a function to print all the ancestors of the given key using iteration. Example Input  key = 6 5 2 1 Explanation: ...

Read more

Question 591. Construct BST from given Preorder Traversal Given a pre-order traversal of a Binary Search Tree(BST), write an algorithm to construct the BST from given preorder traversal. Examples Input   preOrder[] = {7, 5, 3, 6, 9} Output Inorder : 3 5 6 7 9 Input preOrder[] = {12, 6, 1, 35, 20} Output Inorder : 1 6 ...

Read more

Question 592. Print Ancestors of a Given Binary Tree Node Without Recursion Given a binary tree and a specific node or key. Print ancestors of a given binary tree node without recursion. Example Input : key = 7 Output : 3 1 Input : key = 4 Output : 2 1 Algorithm for Ancestors of a Given Binary Tree Node Create a class Node ...

Read more

Question 593. Find Maximum of Minimum for Every Window Size in a Given Array Given an array a[ ] of size n. For every window size that varies from 1 to n in array print or find maximum of minimum for every window size in a given array. Example Input : a[ ] = {10, 20, 30, 50, 10, 70, 30} Output : 70 30 20 ...

Read more

Question 594. Iterative Depth First Traversal of Graph In iterative depth first traversal of graph problem, we have given a graph data structure. Write the program to print the depth first traversal of the given graph using the iterative method. Example Input : 0 -> 1, 0 -> 2, 1 -> 2, 2 -> 0, 2 -> 3, 3 ...

Read more

Question 595. Minimum Bracket Reversals In minimum bracket reversals problem, we have given a string s containing an expression of characters ‘{‘ and ‘}’ only. Find the minimum number of bracket reversals needed to make an expression balanced. Example Input : s = “}{” Output: 2 Input : s = “{{{” Output: The given expression can not ...

Read more

Question 596. Expression Contains Redundant Bracket or Not Given a string s containing an expression of operators, operands, and parenthesis. Find if the given string contains any unnecessary parenthesis without which the expression will still give the same result. In other words, we have to find that expression contains a redundant bracket or not. Redundant Bracket If an ...

Read more

Question 597. Check if Two Expressions With Brackets are Same Given two strings s1 and s2 representing expressions containing addition operator, subtraction operator, lowercase alphabets, and parenthesis. Check if two expressions with brackets are the same. Example Input  s1 = “-(a+b+c)” s2 = “-a-b-c” Output  Yes Input  s1 = “a-b-(c-d)” s2 = “a-b-c-d” Output No Algorithm to Check if Two ...

Read more

Question 598. Level order Traversal in Spiral Form In this problem we have given a binary tree,  print its level order traversal in a spiral form. Examples Input Output 10 30 20 40 50 80 70 60 Naive Approach for Level order Traversal in Spiral Form The idea is to do a normal level order traversal using a ...

Read more

Question 599. Min Stack In min stack problem we have to design a stack to implement the following functions efficiently, push(x) –> Push an element x to the stack pop() –> Removes the item on top of stack top() –> Return the element at top of stack getMin() –> Return the minimum element present ...

Read more

Question 600. Queue using Stacks In queue using a stack problem, we have to implement the following functions of a queue using the standard functions of stack data structure, Enqueue: Add an element to the end of the queue Dequeue: Remove an element from the start of the queue Example Input: Enqueue(5) Enqueue(11) Enqueue(39) Dequeue()  ...

Read more

Question 601. Arithmetic Expression Evaluation We write Arithmetic expressions in following three notations – Prefix Notation In this notation, the operands are written after the operator. It is also known as Polish Notation. For instance: +AB is a prefix expression. Infix Notation In this notation, the operators are written between the operands. It is similar ...

Read more

Question 602. Check for Balanced Parentheses in an Expression Given a string s of length n. Check whether there is a closing parenthesis for every opening parentheses i.e. if all the parentheses are balanced. In other words, we can also say that, if we have a ‘}’, ‘)’ and ‘]’ for every ‘{‘, ‘(‘ and ‘[‘ respectively, the expression ...

Read more

Question 603. Evaluation of Postfix Expression In the Evaluation of the postfix expression problem, we have given a string s containing a postfix expression. Evaluate the given expression. Example Input : s = “231*+9-” Output : -4 Input : s = “100 200 + 2 / 5 * 7 +” Output : 757 For Operands Having Single Digits Algorithm ...

Read more

Question 604. Find if an Expression has Duplicate Parenthesis or Not Given a string containing balanced parenthesis. Find if the expression/string contains duplicate parenthesis or not. Duplicate Parenthesis When an expression is in the middle of or surrounded by the same type of balanced parenthesis i.e. enclosed between the same type of opening and closing parenthesis more than once it is ...

Read more

Question 605. How to Implement Stack Using Priority Queue or Heap? Implement a stack with the help of a priority queue or a heap. Priority Queue : Priority queue data structure is similar to the queue or stack data structure with an addition of priority. Every element is given a priority number. In conclusion, the elements with high priority are prefered ...

Read more

Question 606. How to Efficiently Implement k Stacks in a Single Array? Design and implement a new data structure that Implement k Stacks in a Single Array. The new data structure must support these two operations – push (element, stack_number): that pushes the element in a given number of the stack. pop (stack_number): that pop out the top element from a given ...

Read more

Question 607. Find Maximum Depth of Nested Parenthesis in a String Given a string s. Write the code to print the maximum depth of nested parenthesis in the given string. Example Input : s = “( a(b) (c) (d(e(f)g)h) I (j(k)l)m)” Output : 4 Input : s = “( p((q)) ((s)t) )” Output : 3 Using Stack Algorithm Initialize a string s of length ...

Read more

Question 608. Expression Evaluation In expression evaluation problem, we have given a string s of length n representing an expression that may consist of integers, balanced parentheses, and binary operations ( +, -, *, / ). Evaluate the expression. An expression can be in any one of prefix, infix, or postfix notation. Example See ...

Read more

Question 609. How to Create Mergable Stack? We have to design and create a stack that performs the operations in constant time. Here we have one problem which is how to create mergable stack? Here we perform the below operation for merge two stacks. push(element): Insert the element in the stack. pop(): Remove the top element in ...

Read more

Question 610. The Stock Span Problem This problem “The Stock Span Problem” comes under the financial aspect. In this problem, we find the stock span for the stock price of each day. The maximum number of consecutive days just before any particular day for which the price of the stock of the days before it is ...

Read more

Question 611. Find Maximum Sum Possible Equal Sum of Three Stacks Given 3 arrays stack1[ ], stack2[ ] and stack3[ ] representing stacks and the starting index of these arrays are treated as their top. Find the common maximum sum possible in all the three stacks i.e. the sum of elements of stack1, stack2 and stack3 are equal. Removal of the ...

Read more

Question 612. Print Next Greater Number of Q queries In Print Next Greater Number of Q queries problem we have given an array a[ ] of size n containing numbers and another array q[ ] of size m representing queries. Each query represents the index in array a[ ]. For each query, i print the number from the array ...

Read more

Question 613. Check if an Array is Stack Sortable In check if an array is stack sortable problem we have given an array a[ ] of size n containing elements from 1 to n in random order. Sort the array in ascending order using a temporary stack following only these two operations – Remove the element at the starting ...

Read more

Question 614. Balanced Expression with Replacement In Balanced Expression with Replacement problem we have given a string s containing parenthesis i.e. ‘(‘, ‘)’, ‘[‘, ‘]’, ‘{‘, ‘}’. The string also contains x at some places as a replacement of parenthesis. Check if the string can be converted into an expression with valid parenthesis after replacing all ...

Read more

Question 615. Trapping Rain Water LeetCode Solution In the Trapping Rain Water LeetCode problem, we have given N non-negative integers representing an elevation map and the width of each bar is 1. We have to find the amount of water that can be trapped in the above structure. Example Let’s understand that by an example For the ...

Read more

Question 616. Decode String Suppose, you are given an encoded string. A string is encoded in some kind of pattern, your task is to decode the string. Let us say, < no of times string occurs > [string ] Example Input 3[b]2[bc] Output bbbcaca Explanation Here “b” occurs 3times and “ca” occur 2 times. ...

Read more

Question 617. Recursion What is Recursion? Recursion is simply defined as a function calling itself. It uses its previously solved sub-problems to compute a bigger problem. It is one of the most important and tricky concepts in programming but we can understand it easily if we try to relate recursion with some real ...

Read more

Question 618. Prefix to Infix Conversion In prefix to infix conversion problem, we have given expression in prefix notation. Write a program to convert it into an infix expression. Prefix Notation In this notation the operands are written after the operator. It is also known as Polish Notation. For instance : +AB is an prefix expression. ...

Read more

Question 619. Postfix to Infix Conversion In postfix to infix conversion problem, we have given expression in postfix notation. Write a program to convert the given notation in infix notation. Infix Notation In this notation, the operators are written between the operands. It is similar to how we generally write an expression. For instance: A + ...

Read more

Question 620. Prefix to Postfix Conversion In prefix to postfix conversion problem, we have given expression in prefix notation in string format. Write a program to convert the given notation in postfix notation. Prefix Notation In this notation, we write the operands after the operator. It is also known as Polish Notation. For instance: +AB is ...

Read more

Question 621. Postfix to Prefix Conversion In this problem, we have given a string that denotes the postfix expression. We have to do postfix to prefix conversion. Prefix Notation In this notation, we write the operands after the operator. It is also known as Polish Notation. For instance: +AB is a prefix expression. Postfix Notation In ...

Read more

Question 622. Binary Tree zigzag level order Traversal Given a binary tree, print the zigzag level order traversal of its node values. (ie, from left to right, then right to left for the next level and alternate between). Example consider the binary tree given below Below is the zigzag level order traversal of the above binary tree Types ...

Read more

Question 623. Backspace String Compare In the backspace string compare problem we have given two Strings S and T, check if they are equal or not. Note that the strings contain ‘#’ which means backspace character. Examples Input S = “ab#c” T = “ad#c” Output true (as both S and T converts to “ac”) Input ...

Read more

Question 624. Next greater element The next greater element is a problem in which we have given an array. This array containing N values(may be positive or negative). We need to find the first greater_element in the given array on its right side. If there is no greater_element then take -1. Input Format First-line containing ...

Read more

Question 625. Infix to Postfix What is an infix expression? Expression in the form of ‘operand’ ‘operator’ ‘operand’ is called infix expression. Example:  a+b What is postfix expression? Expression in the form of ‘operand’ ‘operand’ ‘operator’ is called postfix expression. Example:  ab+ What is the need of infix to postfix conversion? Infix expression is easy ...

Read more

Question 626. Form Minimum Number from Given Sequence of D’s and I’s Problem Statement In the “Form Minimum Number from Given Sequence of D’s and I’s” problem, we have given a pattern containing only I’s and D’s. I for increasing and D for decreasing. Write a program to print the minimum number following that pattern. Digits from 1-9 and digits can’t repeat. Input Format ...

Read more

Question 627. The Celebrity Problem Problem Statement In the celebrity problem there is a room of N people, Find the celebrity. Conditions for Celebrity is- If A is Celebrity then Everyone else in the room should know A. A shouldn’t know anyone in the room. We need to find the person who satisfies these conditions. ...

Read more

Question 628. Next Greater Element in an Array Problem Statement Given an array, we will find the next greater element of each element in the array. If there is no next greater element for that element then we will print -1, else we will print that element. Note: Next greater element is the element that is greater and ...

Read more

Amazon Queue Questions
Question 629. Find the Winner of the Circular Game LeetCode Solution Problem Statement Find the Winner of the Circular Game LeetCode Solution – There are n friends that are playing a game. The friends are sitting in a circle and are numbered from 1 to n in clockwise order. More formally, moving clockwise from the ith friend brings you to the ...

Read more

Question 630. Moving Average from Data Stream Leetcode Solution Problem Statement The Moving Average from Data Stream LeetCode Solution – “Moving Average from Data Stream” states that given a stream of integers and a window size k. We need to calculate the moving average of all the integers in the sliding window. If the number of elements in the ...

Read more

Question 631. Find Maximum Level sum in Binary Tree Problem Statement The problem “Find Maximum Level sum in Binary Tree” states that you are given a binary tree with positive and negative nodes, find the maximum sum of a level in the binary tree. Example Input 7 Explanation First Level : Sum = 5 Second Level : Sum = ...

Read more

Question 632. Implementation of Deque using Doubly Linked List Problem Statement The problem “Implementation of Deque using Doubly Linked List” states that you need to implement the following functions of Deque or Doubly Ended Queue using a doubly linked list, insertFront(x) : Add element x at the starting of Deque insertEnd(x) : Add element x at the end of ...

Read more

Question 633. Iterative Method to find Height of Binary Tree Problem Statement The problem “Iterative Method to find Height of Binary Tree” states that you are given a binary tree, find the height of the tree using the iterative method. Examples Input 3 Input 4 Algorithm for Iterative Method to find Height of Binary Tree The height of a tree ...

Read more

Question 634. Level order traversal using two Queues Problem Statement The problem “Level order traversal using two Queues” states that you are given a binary tree, print its level order traversal line by line. Examples Input 5 11 42 7 9 8 12 23 52 3 Input 1 2 3 4 5 6 Algorithm for Level Order Traversal ...

Read more

Question 635. Implement a stack using single queue Problem Statement The problem “Implement a stack using single queue” asks us to implement a stack (LIFO) data structure using a queue (FIFO) data structure. Here LIFO means Last In First Out while FIFO means First In First Out. Example push(10) push(20) top() pop() push(30) pop() top() Top : 20 ...

Read more

Question 636. Find the First Circular Tour that visits all the Petrol Pumps Problem Statement The problem “Find the First Circular Tour that visits all the Petrol Pumps” states that there are N petrol pumps on a circular road. Given the petrol that every petrol pump has and the amount of petrol required to cover the distance between two petrol pumps. So you ...

Read more

Question 637. Check if X can give change to every person in the Queue Problem Statement X is an ice cream seller and there are n people waiting in a queue to buy an ice cream. Arr[i] denotes the denomination ith person in the queue has, the possible values of denominations are 5, 10 and 20. If the initial balance of X is 0 ...

Read more

Question 638. Check if all levels of two Binary Tree are anagrams or not Problem Statement The problem “Check if all levels of two Binary Tree are anagrams or not” says that you are given two Binary Trees, check if all the levels of the two trees are anagrams or not. Examples Input true Input false Algorithm to Check if all levels of two ...

Read more

Question 639. Minimum sum of squares of character counts in a given string after removing k characters Problem Statement The problem “Minimum sum of squares of character counts in a given string after removing k characters” states that you are given a string containing lower case characters only. You are allowed to remove k characters from the string such that in the remaining string the sum of ...

Read more

Question 640. First negative integer in every window of size k Problem Statement The problem “First negative integer in every window of size k” states that you are given an array containing positive and negative integers, for every window of size k print the first negative integer in that window. If there is no negative integer in any window then output ...

Read more

Question 641. Queue based approach for first non-repeating character in a stream Problem Statement The problem “Queue based approach for first non-repeating character in a stream” states that you are given a stream containing lower case characters, find the first non-repeating character whenever a new character is added to the stream, and if there is no non-repeating character return -1. Examples aabcddbe ...

Read more

Question 642. Distance of nearest cell having 1 in a binary matrix Problem Statement The problem “Distance of nearest cell having 1 in a binary matrix” states that you are given a binary matrix(containing only 0s and 1s) with at least one 1. Find the distance of the nearest cell having 1 in the binary matrix for all the elements of the ...

Read more

Question 643. An Interesting Method to generate Binary Numbers from 1 to n Problem Statement The problem “An Interesting Method to generate Binary Numbers from 1 to n” states that you are given a number n, print all the numbers from 1 to n in binary form. Examples 3 1 10 11   6 1 10 11 100 101 110 Algorithm The generation ...

Read more

Question 644. Find the largest multiple of 3 Problem Statement The problem “Find the largest multiple of 3” states that you are given an array of positive integers(0 to 9). Find the maximum multiple of 3 that can be formed by rearranging the elements of the array. Examples arr[] = {5, 2, 1, 0, 9, 3} 9 5 ...

Read more

Question 645. Check if the given array can represent Level Order Traversal of Binary Search Tree Problem Statement The problem “Check if the given array can represent Level Order Traversal of Binary Search Tree” states that you are given a level order traversal of the binary search tree. And using the level order traversal of the tree. We need to efficiently find if the level order ...

Read more

Question 646. Number of siblings of a given Node in n-ary Tree Problem Statement The problem “Number of siblings of a given Node in n-ary Tree” states that you are given an n-ary Tree and a target node. Find the number of siblings of the target node. Assume that node is always present in the tree and the first node is the ...

Read more

Question 647. Check if a queue can be sorted into another queue using a stack Problem Statement The problem “Check if a queue can be sorted into another queue using a stack” states that you are given a queue containing n elements, the elements in the queue are a permutation of numbers 1 to n. Check if this queue can be arranged in increasing order ...

Read more

Question 648. Priority Queue using doubly linked list Problem Statement The problem “Priority Queue using doubly linked list” asks to implement the following functions of priority queue using doubly linked list. push(x, p) : Enqueue an element x with priority p in the priority queue at appropriate position. pop() : Remove and return the element with highest priority ...

Read more

Question 649. Stack Permutations (Check if an array is stack permutation of other) Problem Statement The problem “Stack Permutations (Check if an array is stack permutation of other)” states that you are given two arrays a[ ] and b[ ] of size n. All the elements of the array are unique. Create a function to check if the given array b[ ] is ...

Read more

Question 650. Minimum Steps to reach target by a Knight Description The problem “Minimum Steps to reach target by a Knight” states that you are given a square chess board of N x N dimensions, co-ordinates of the Knight piece, and the target cell. Find out the minimum number of steps taken by the Knight piece to reach the target ...

Read more

Question 651. Implementation of Deque using circular array Problem Statement “Implementation of Deque using circular array” asks to implement the following functions of a Deque(Doubly Ended Queue) using circular array, insertFront(x) : insert an element x at the front of Deque insertRear(x) : insert an element x at the rear of Deque deleteFront() : delete an element from ...

Read more

Question 652. Find the node with minimum value in a Binary Search Tree Given a Binary Search Tree, write an algorithm to find the node with the minimum value in a given binary search tree. Example Input Output 5 Naive Approach A simple approach is to do a tree traversal and find the node with the minimum value among all the nodes. This ...

Read more

Question 653. Minimum Bracket Reversals In minimum bracket reversals problem, we have given a string s containing an expression of characters ‘{‘ and ‘}’ only. Find the minimum number of bracket reversals needed to make an expression balanced. Example Input : s = “}{” Output: 2 Input : s = “{{{” Output: The given expression can not ...

Read more

Question 654. Construct Complete Binary Tree from its Linked List Representation Given the linked list representation of a complete binary tree. The linked list is in the order of level order traversal of the tree. Write an algorithm to construct the complete binary tree back from its linked list representation. Example Input 1 -> 2 -> 3 -> 4 -> 5 ...

Read more

Question 655. Queue using Stacks In queue using a stack problem, we have to implement the following functions of a queue using the standard functions of stack data structure, Enqueue: Add an element to the end of the queue Dequeue: Remove an element from the start of the queue Example Input: Enqueue(5) Enqueue(11) Enqueue(39) Dequeue()  ...

Read more

Question 656. How to Implement Stack Using Priority Queue or Heap? Implement a stack with the help of a priority queue or a heap. Priority Queue : Priority queue data structure is similar to the queue or stack data structure with an addition of priority. Every element is given a priority number. In conclusion, the elements with high priority are prefered ...

Read more

Question 657. Priority Queue in C++ FIFO manner is used to implement a queue. In a queue, insertions are done at one end (rear) and deletion takes place at another end (front). Basically, the element enters first is deleted first. We implement a priority queue using c++ inbuilt functions. Characteristics of Priority Queue A priority queue ...

Read more

Question 658. Priority Queue A priority queue is a type of data structure which is similar to a regular queue but has a priority associated with each of its element. Higher the priority earlier the element will be served. In some cases, there are two elements with the same priority then, the element enqueued ...

Read more

Question 659. Binary Tree zigzag level order Traversal Given a binary tree, print the zigzag level order traversal of its node values. (ie, from left to right, then right to left for the next level and alternate between). Example consider the binary tree given below Below is the zigzag level order traversal of the above binary tree Types ...

Read more

Question 660. Queue Reconstruction by Height Problem Description of Queue Reconstruction by Height Suppose you have a random list of people standing in a queue. Each person is described by a pair of integers (h, k), where h is the height of the person and k is the number of people in front of this person ...

Read more

Question 661. Level Order Traversal of Binary Tree Level Order Traversal of a given binary tree is the same as the BFS of the binary tree. Do we already know about what actually BFS is? if not then don’t need to feel bad just read the whole article and visit our previous articles for better understanding. BFS is a ...

Read more

Question 662. Breadth First Search (BFS) for a Graph Breadth First Search (BFS) for a graph is a traversing or searching algorithm in tree/graph data structure. It starts at a given vertex(any arbitrary vertex) and explores all the connected vertex and after that moves to the nearest vertex and explores all the unexplored nodes and takes care that no ...

Read more

Amazon Matrix Questions
Question 663. Count Sub Islands LeetCode Solution Problem Statement Count Sub Islands LeetCode Solution says that grid1 and grid2 contain only 0‘s (representing water) and 1‘s (representing land). The island means the group of 1’s connected 4 directionally. An island in grid2 is considered a sub-island if there is an island in grid1 that contains all the cells that make ...

Read more

Question 664. Best Meeting Point LeetCode Solution Problem Statement: Best Meeting Point Leetcode Solution says – Given a m x n binary grid grid where each 1 marks the home of one friend, return the minimal total travel distance. The total travel distance is the sum of the distances between the houses of the friends and the meeting point. The distance is calculated using Manhattan Distance, ...

Read more

Question 665. Minimum Path Sum Leetcode Solution Problem Statement The Minimum Path Sum LeetCode Solution – “Minimum Path Sum” says that given a n x m grid consisting of non-negative integers and we need to find a path from top-left to bottom right, which minimizes the sum of all numbers along the path. We can only move ...

Read more

Question 666. Unique Paths II Leetcode Solution Problem Statement The Unique Paths II LeetCode Solution – “Unique Paths II” states that given the m x n grid where a robot starts from the top left corner of the grid. We need to find the total number of ways to reach the bottom right corner of the grid. ...

Read more

Question 667. Search a 2D Matrix II Leetcode Solution Problem Statement The Search a 2D Matrix II LeetCode Solution – “Search a 2D Matrix II”asks you to find an efficient algorithm that searches for a value target in an m x n integer matrix matrix. Integers in each row, as well as column, are sorted in ascending order. Example: Input: matrix = [[1,4,7,11,15],[2,5,8,12,19],[3,6,9,16,22],[10,13,14,17,24],[18,21,23,26,30]], target = 5 Output: true ...

Read more

Question 668. Set Matrix Zeroes Leetcode Solution Problem Statement The Set Matrix Zeroes LeetCode Solution – “Set Matrix Zeroes” states that you’re given an m x n integer matrix matrix.We need to modify the input matrix such that if any cell contains the element  0, then set its entire row and column to 0‘s. You must do it in ...

Read more

Question 669. Word Search Leetcode Solution Problem Statement Given an m x n board and a word, find if the word exists in the grid. The word can be constructed from letters of sequentially adjacent cells, where “adjacent” cells are horizontally or vertically neighbouring. The same letter cell may not be used more than once. Example ...

Read more

Question 670. Unique Paths II Suppose a man standing in the first cell or the top left corner of “a × b” matrix. A man can move only either up or down. That person wants to reach his destination and that destination for him is the last cell of the matrix or bottom right corner. ...

Read more

Question 671. Find maximum length Snake sequence The problem “Find maximum length Snake sequence” states that we are provided with a grid containing integers. The task is to find a snake sequence with the maximum length. A sequence having adjacent numbers in the grid with an absolute difference of 1, is known as a Snake sequence. Adjacent ...

Read more

Question 672. Gold Mine Problem Problem Statement The “Gold Mine problem” states that you are given a 2D grid having some non-negative coins placed in each cell of the given grid. Initially, the miner is standing at the first column but there is no restriction on the row. He can start in any row. The ...

Read more

Question 673. Minimum time required to rot all oranges Problem Statement The problem “Minimum time required to rot all oranges” states that you are given a 2D array, every cell has one of the three possible values 0, 1 or 2. 0 means an empty cell. 1 means a fresh orange. 2 means a rotten orange. If a rotten ...

Read more

Question 674. Distance of nearest cell having 1 in a binary matrix Problem Statement The problem “Distance of nearest cell having 1 in a binary matrix” states that you are given a binary matrix(containing only 0s and 1s) with at least one 1. Find the distance of the nearest cell having 1 in the binary matrix for all the elements of the ...

Read more

Question 675. Find pairs with given sum such that elements of pair are in different rows Problem Statement “Find pairs with given sum such that elements of pair are in different rows” problem states that you are given a matrix of integers and a value called “sum”. The problem statement asks to find out all the pairs in a matrix that sums up to a given ...

Read more

Question 676. Common elements in all rows of a given matrix Problem Statement “Common elements in all rows of a given matrix” problem state that, you are given a matrix of M*N. The problem statement asks to find out all the common elements in a given matrix in each row of the matrix in O(M*N) time. Example arr[]={{12, 1, 4, 5, ...

Read more

Question 677. Collect maximum points in a grid using two traversals Problem Statement We are given a matrix of size “n x m”, and we need to collect maximum points in a grid using two traversals. If we are standing at cell i,j then we have three options to go to cell i+1, j or i+1, j-1or i+1, j+1. That is ...

Read more

Question 678. Mobile Numeric Keypad Problem Problem Statement In the mobile numeric keypad problem, we consider a numeric keypad.  We need to find all number of possible numeric sequences of given length such that you are only allowed to press buttons which are top, down, left, and right of the current button. You are not allowed ...

Read more

Question 679. Printing brackets in Matrix Chain Multiplication Problem Problem Statement We need to find the order of multiplication of matrices such that the number of operations involved in the multiplication of all the matrices is minimized. Then we need to print this order i.e. printing brackets in matrix chain multiplication problem. Consider you have 3 matrices A, B, ...

Read more

Question 680. Largest rectangular sub-matrix whose sum is 0 Problem Statement Find the maximum size sub-matrix in a 2D array whose sum is zero. A sub-matrix is nothing but a 2D array inside of the given 2D array. So, you have a matrix of signed integers, you need to calculate the sum of sub-matrices and find the matrix with ...

Read more

Question 681. Maximum sum rectangle in a 2D matrix Problem Statement Find the maximum sum rectangle in a 2D matrix i.e. to find a sub-matrix with maximum sum. A sub-matrix is nothing but a 2D array inside of the given 2D array. So, you have a matrix of signed integers, you need to calculate the sum of sub-matrices and ...

Read more

Question 682. Matrix Chain Multiplication In the matrix chain multiplication II problem, we have given the dimensions of matrices, find the order of their multiplication such that the number of operations involved in multiplication of all the matrices is minimized. Consider you have 3 matrices A, B, C of sizes a x b, b x ...

Read more

Question 683. Maximal Square In the maximal square problem we have given a 2D binary matrix filled with 0’s and 1’s, find the largest square containing only 1’s, and return its area. Example Input: 1 0 1 0 0 0 0 1 1 1 1 1 1 1 1 0 0 0 1 0 ...

Read more

Question 684. Set Matrix Zeroes In the set matrix zeroes problem, we have given a (n X m) matrix, if an element is 0, set its entire row and column 0. Examples Input: { [1, 1, 1] [1, 0, 1] [1, 1, 1] } Output: { [1, 0, 1] [0, 0, 0] [1, 0, 1] ...

Read more

Question 685. Flood Fill LeetCode In Flood Fill problem we have given a 2D array a[ ][ ] representing an image of size mxn with each value representing the color of the pixel at that co-ordinate. Also given the location or coordinates of a pixel and a color. Replace the color at a given location ...

Read more

Question 686. Max Area of Island Problem Description: Given a 2D matrix, the matrix has only 0(representing water)  and 1(representing land) as entries. An island in the matrix is formed by grouping all the adjacent 1’s connected 4-directionally(horizontal and vertical). Find the maximum area of the island in the matrix. Assume that all four edges of ...

Read more

Question 687. Unique Paths A m x n 2D  grid is given and you are standing at the topmost and leftmost cell in the grid. i.e. the cell located at (1,1). Find the number of unique paths that can be taken to reach a cell located at (m,n) from the cell located at (1,1) ...

Read more

Question 688. K-th Smallest Element in a Sorted Matrix In K-th Smallest Element in a Sorted Matrix problem, we have given an n x n matrix, where every row and column is sorted in non-decreasing order. Find the kth smallest element in the given 2D array. Example Input 1: k = 3 and matrix = 11, 21, 31, 41 ...

Read more

Question 689. Matrix Chain Multiplication using Dynamic Programming Matrix Chain Multiplication is a method in which we find out the best way to multiply the given matrices. We all know that matrix multiplication is associative(A*B = B*A) in nature. So, we have a lot of orders in which we want to perform the multiplication. Actually, in this algorithm, ...

Read more

Question 690. Multiplication of Two Matrices Problem Statement In the “Multiplication of Two Matrices” problem we have given two matrices. We have to multiply these matrices and print the result or final matrix. Here, the necessary and sufficient condition is the number of columns in A should be equal to the number of rows in matrix ...

Read more

Question 691. Check whether Strings are K Distance Apart or Not Problem Statement Given two strings and an integer k, write a program to check whether the given strings are k distance apart or not. That is if any character is mismatched or any character is to be removed then it is known as k distance apart. Input Format The first ...

Read more

Question 692. Find the Row with Maximum Number of 1’s Problem Statement In the “Find the Row with Maximum Number of 1’s” problem we have given a matrix(2D array) containing binary digits with each row sorted. Find the row which has the maximum number of 1’s. Input Format The first line containing two integers values n, m. Next, n lines ...

Read more

Question 693. The Celebrity Problem Problem Statement In the celebrity problem there is a room of N people, Find the celebrity. Conditions for Celebrity is- If A is Celebrity then Everyone else in the room should know A. A shouldn’t know anyone in the room. We need to find the person who satisfies these conditions. ...

Read more

Amazon Other Questions
Question 694. Validate Stack Sequences LeetCode Solution Problem Statement Validate Stack Sequences LeetCode Solution – Given two integer arrays pushed and popped each with distinct values, return true if this could have been the result of a sequence of push and pop operations on an initially empty stack, or false otherwise. Example 1: Input: pushed = [1,2,3,4,5], popped = [4,5,3,2,1] Output: true Explanation: We ...

Read more

Question 695. Implement strStr() LeetCode Solution Problem Statement: Implement strStr() LeetCode Solution – Implement strStr(). Given two strings needle and haystack, return the index of the first occurrence of needle in haystack, or -1 if needle is not part of haystack. Clarification: What should we return when needle is an empty string? This is a great question to ask during an interview. For the purpose of this problem, we ...

Read more

Question 696. Count Good Nodes in Binary Tree LeetCode Solution Problem Statement: Count Good Nodes in Binary Tree LeetCode Solution: Given a binary tree root, a node X in the tree is named good if in the path from the root to X there are no nodes with a value greater than X. Return the number of good nodes in the binary tree.   Example 1: Input: root = [3,1,4,3,null,1,5] ...

Read more

Question 697. Break a Palindrome LeetCode Solution Problem Statement: Break a Palindrome LeetCode Solution: Given a palindromic string of lowercase English letters palindrome, replace exactly one character with any lowercase English letter so that the resulting string is not a palindrome and that it is the lexicographically smallest one possible. Return the resulting string. If there is no way to replace a character to make ...

Read more

Question 698. Contains Duplicate LeetCode Solution Problem Statement: Contains Duplicate LeetCode Solution says that- Given an integer array nums, return true if any value appears at least twice in the array, and return false if every element is distinct. Example 1: Input: nums = [1,2,3,1] Output: true Example 2: Input: nums = [1,2,3,4] Output: false Example 3: Input: nums = [1,1,1,3,3,4,3,2,4,2] Output: ...

Read more

Question 699. Best Time to Buy and Sell Stock IV LeetCode Solution Problem Statement: Best Time to Buy and Sell Stock IV LeetCode Solution: You are given an integer array prices where prices[i] is the price of a given stock on the ith day, and an integer k. Find the maximum profit you can achieve. You may complete at most k transactions. Note: You may not engage in multiple transactions simultaneously ...

Read more

Question 700. Reverse Nodes in k-Group LeetCode Solution Problem Statement: Reverse Nodes in k-Group LeetCode Solution – Given the head of a linked list, reverse the nodes of the list k at a time, and return the modified list. k is a positive integer and is less than or equal to the length of the linked list. If the number of nodes is ...

Read more

Question 701. Split Linked List in Parts Leetcode Solution Problem Statement: Split Linked List in Parts Leetcode Solution – Given the head of a singly linked list and an integer k, split the linked list into k consecutive linked list parts. The length of each part should be as equal as possible: no two elements should have a size ...

Read more

Question 702. Single Element in a Sorted Array LeetCode Solution Problem Statement: Single Element in a Sorted Array LeetCode Solution says that –  You are given a sorted array consisting of only integers where every element appears exactly twice, except for one element which appears exactly once. Return the single element that appears only once. Your solution must run in O(log n) time ...

Read more

Question 703. Find First and Last Position of Element in Sorted Array LeetCode Solution Problem Statement: Find First and Last Position of Element in Sorted Array LeetCode Solution says that – given an array of integers nums sorted in non-decreasing order, find the starting and ending position of a given target value. If target is not found in the array, return [-1, -1]. You must write an algorithm with O(log n) runtime complexity. ...

Read more

Question 704. Fibonacci Number LeetCode Solution Problem Statement: Fibonacci Number LeetCode Solution says that – The Fibonacci numbers, commonly denoted F(n) form a sequence, called the Fibonacci sequence, such that each number is the sum of the two preceding ones, starting from 0 and 1. That is F(0) = 0, F(1) = 1 F(n) = F(n - 1) + F(n - 2), ...

Read more

Question 705. All Possible Full Binary Trees LeetCode Solution Problem Statement: All Possible Full Binary Trees LeetCode Solution : Given an integer n, return a list of all possible full binary trees with n nodes. Each node of each tree in the answer must have Node.val == 0. Each element of the answer is the root node of one possible tree. You may return the final ...

Read more

Question 706. Trapping Rain Water II LeetCode Solution Problem Statement: Trapping Rain Water II LeetCode Solution : Given an m x n integer matrix heightMap representing the height of each unit cell in a 2D elevation map, return the volume of water it can trap after raining. Examples: Input: heightMap = [[1,4,3,1,3,2],[3,2,1,3,2,4],[2,3,3,2,3,1]] Output: 4 Explanation: After the rain, water is trapped between the ...

Read more

Question 707. Group Anagrams LeetCode Solution Problem Statement Group Anagrams LeetCode Solution Says that – Given an array of strings strs, group the anagrams together. You can return the answer in any order. An Anagram is a word or phrase formed by rearranging the letters of a different word or phrase, typically using all the original letters exactly once. Example 1: ...

Read more

Question 708. Sliding Window Maximum LeetCode Solution Problem Statement Sliding Window Maximum LeetCode Solution Says that – You are given an array of integers nums, and there is a sliding window of size k which is moving from the very left of the array to the very right. You can only see the k numbers in the window. Each time ...

Read more

Question 709. Binary Search LeetCode Solution Problem Statement Binary Search LeetCode Solution says that – Given an array of integers nums which is sorted in ascending order, and an integer target, write a function to search target in nums. If target exists, then return its index. Otherwise, return -1. You must write an algorithm with O(log n) runtime complexity. Example 1: Input: nums = [-1,0,3,5,9,12], target ...

Read more

Question 710. Container With Most Water LeetCode Solution Problem Statement Container With Most Water LeetCode Solution says that – You are given an integer array height of length n. There are n vertical lines are drawn such that the two endpoints of the ith line are (i, 0) and (i, height[i]). Find two lines that together with the x-axis form a container, such that the container ...

Read more

Question 711. Pairs of Songs With Total Durations Divisible by 60 LeetCode Solution Problem Statement Pairs of Songs With Total Durations Divisible by 60 LeetCode Solution – Pairs of Songs With Total Durations Divisible by 60 LeetCode Solution says that – You are given a list of songs where the ith song has a duration of time[i] seconds. Return the number of pairs of songs for which ...

Read more

Question 712. Valid Anagram Leetcode Solution Problem Statement Valid Anagram Leetcode Solution – Given two strings s and t, return true if t is an anagram of s, and false otherwise. An Anagram is a word or phrase formed by rearranging the letters of a different word or phrase, typically using all the original letters exactly once. Example 1: Input: s = "anagram", t = "nagaram" Output: ...

Read more

Question 713. Next Permutation LeetCode Solution Problem Statement Next Permutation LeetCode Solution – A permutation of an array of integers is an arrangement of its members into a sequence or linear order. For example, for arr = [1,2,3], the following are considered permutations of arr: [1,2,3], [1,3,2], [3,1,2], [2,3,1]. The next permutation of an array of integers is the next lexicographically greater permutation of ...

Read more

Question 714. Paint House LeetCode Solution Problem Statement Paint House LeetCode Solution – There is a row of n houses, where each house can be painted one of three colors: red, blue, or green. The cost of painting each house with a certain color is different. You have to paint all the houses such that no ...

Read more

Question 715. Closest Binary Search Tree Value II LeetCode Solution Problem Statement: Closest Binary Search Tree Value II LeetCode Solution: Given the root of a binary search tree, a target value, and an integer k, return the k values in the BST that are closest to the target. You may return the answer in any order. You are guaranteed to have only one unique set of k values in the BST that are closest ...

Read more

Question 716. Minimum Number of Arrows to Burst Balloons LeetCode Solution Problem Statement: Minimum Number of Arrows to Burst Balloons LeetCode Solution: There are some spherical balloons taped onto a flat wall that represents the XY-plane. The balloons are represented as a 2D integer array points where points[i] = [xstart, xend] denotes a balloon whose horizontal diameter stretches between xstart and xend. You do not know the exact y-coordinates of ...

Read more

Question 717. Flatten Binary Tree to Linked List LeetCode Solution Problem Statement: Flatten Binary Tree to Linked List LeetCode Solution: Given the root of a binary tree, flatten the tree into a “linked list”: The “linked list” should use the same TreeNode class where the right child pointer points to the next node in the list and the left child pointer is always null. The “linked list” should be ...

Read more

Question 718. Next Greater Element I Leetcode Solution Problem Statement Next Greater Element I Leetcode Solution – The next greater element of some element x in an array is the first greater element that is to the right of x in the same array. You are given two distinct 0-indexed integer arrays nums1 and nums2, where nums1 is a subset of nums2. For each 0 <= i < nums1.length, find the index j such that nums1[i] == nums2[j] and determine ...

Read more

Question 719. Next Greater Element II LeetCode Solution Problem Statement Next Greater Element II LeetCode Solution – Given a circular integer array nums (i.e., the next element of nums[nums.length - 1] is nums[0]), return the next greater number for every element in nums. The next greater number of a number x is the first greater number to its traversing order next in the array, which means you could search ...

Read more

Question 720. Group Shifted Strings Leetcode Solution Problem Statement Group Shifted Strings Leetcode Solution – We can shift a string by shifting each of its letters to its successive letter. For example, "abc" can be shifted to be "bcd". We can keep shifting the string to form a sequence. For example, we can keep shifting "abc" to form the sequence: "abc" -> "bcd" ...

Read more

Question 721. Isomorphic Strings LeetCode Solution Problem Statement Isomorphic Strings LeetCode Solution – Given two strings s and t, determine if they are isomorphic. Two strings s and t are isomorphic if the characters in s can be replaced to get t. All occurrences of a character must be replaced with another character while preserving the order of characters. No two characters may map to the ...

Read more

Question 722. Peak Index in a Mountain Array LeetCode Solution Problem Statement Peak Index in a Mountain Array LeetCode Solution – An array arr a mountain if the following properties hold: arr.length >= 3 There exists some i with 0 < i < arr.length - 1 such that: arr[0] < arr[1] < ... < arr[i - 1] < arr[i] arr[i] > arr[i + 1] > ... > ...

Read more

Question 723. Valid Triangle Number LeetCode Solution Problem Statement Valid Triangle Number LeetCode Solution – Given an integer array nums, return the number of triplets chosen from the array that can make triangles if we take them as side lengths of a triangle. Input: nums = [2,2,3,4] Output: 3 Explanation: Valid combinations are: 2,3,4 (using the first 2) ...

Read more

Question 724. Swim in Rising Water LeetCode Solution Problem Statement: Swim in Rising Water LeetCode Solution : You are given an n x n integer matrix grid where each value grid[i][j] represents the elevation at that point (i, j). The rain starts to fall. At time t, the depth of the water everywhere is t. You can swim from a square to another 4-directionally adjacent square if ...

Read more

Question 725. Unique Binary Search Trees LeetCode Solution Unique Binary Search Trees LeetCode Solution says that – Given an integer n, return the number of structurally unique BST’s (binary search trees) which has exactly n nodes of unique values from 1 to n. Example 1: Input: n = 3 Output: 5 Example 2: Input: n = 1 Output: 1 Constraints: 1 <= n <= 19 ...

Read more

Question 726. Insert Delete GetRandom O(1) – Duplicates allowed LeetCode Solution Problem Statement: Insert Delete GetRandom O(1) – Duplicates allowed LeetCode Solution: RandomizedCollection is a data structure that contains a collection of numbers, possibly duplicates (i.e., a multiset). It should support inserting and removing specific elements and also removing a random element. Implement the RandomizedCollection class: RandomizedCollection() Initializes the empty RandomizedCollection object. bool insert(int val) Inserts an item val into ...

Read more

Question 727. Range Sum of BST LeetCode Solution Range Sum of BST LeetCode Solution says that – Given the root the node of a binary search tree and two integers low and high, return the sum of values of all nodes with a value in the inclusive range [low, high].   Example 1: Input: root = [10,5,15,3,7,null,18], low = 7, high = 15 Output: 32 Explanation: ...

Read more

Question 728. Reverse Integer Leetcode Solution Problem Statement Reverse Integer LeetCode Solution says that – Given a signed 32-bit integer x, return x with its digits reversed. If reversing x causes the value to go outside the signed 32-bit integer range [-231, 231 - 1], then return 0. Assume the environment does not allow you to store 64-bit integers (signed or unsigned). Example 1: ...

Read more

Question 729. Find K Closest Elements LeetCode Solution Problem Statement Find K Closest Elements LeetCode Solution – Given a sorted integer array arr, two integers k and x, return the k closest integers to x in the array. The result should also be sorted in ascending order. An integer a is closer to x than an integer b if: |a - x| < |b - x|, or |a - x| == |b - ...

Read more

Question 730. Sort Colors LeetCode Solution Problem Statement Sort Colors LeetCode Solution – Given an array nums with n objects colored red, white, or blue, sort them in-place so that objects of the same color are adjacent, with the colors in the order red, white, and blue. We will use the integers 0, 1, and 2 to represent the color red, white, and blue, respectively. ...

Read more

Question 731. Excel Sheet Column Number LeetCode Solution Problem Statement Excel Sheet Column Number LeetCode Solution says that Given a string columnTitle that represents the column title as appears in an Excel sheet, return its corresponding column number. For example: A -> 1 B -> 2 C -> 3 ... Z -> 26 AA -> 27 AB -> 28 ...   ...

Read more

Question 732. Longest Common Subsequence LeetCode Solution Problem Statement Longest Common Subsequence LeetCode Solution – Given two strings text1 and text2, return the length of their longest common subsequence. If there is no common subsequence, return 0. A subsequence of a string is a new string generated from the original string with some characters (can be none) deleted without changing the relative order of the remaining ...

Read more

Question 733. Range Sum Query 2D – Immutable LeetCode Solution Problem Statement Range Sum Query 2D – Immutable LeetCode Solution – Given a 2D matrix, handle multiple queries of the following type: Calculate the sum of the elements of the matrix inside the rectangle defined by its upper left corner (row1, col1) and lower right corner (row2, col2). Implement the NumMatrix class: NumMatrix(int[][] ...

Read more

Question 734. Palindrome Number LeetCode Solution Problem Statement Palindrome Number LeetCode Solution says that – Given an integer x, return true if x is palindrome integer. An integer is a palindrome when it reads the same backward as forward. For example, 121 is a palindrome while 123 is not.   Example 1: Input: x = 121 Output: true Explanation: 121 reads as 121 from left to right ...

Read more

Question 735. Find the Town Judge LeetCode Solution Problem Statement: Find the Town Judge Leetcode Solution: In a town, there are n people labeled from 1 to n. There is a rumor that one of these people is secretly the town judge. If the town judge exists, then: The town judge trusts nobody. Everybody (except for the town judge) trusts the town judge. ...

Read more

Question 736. Total Hamming Distance LeetCode Solution Problem Statement: Total Hamming Distance LeetCode Solution: Given an integer array nums, return the sum of Hamming distances between all the pairs of the integers in nums. The Hamming distance between two integers is the number of positions at which the corresponding bits are different. Example 1: Input: nums = [4,14,2] Output: 6 Explanation: In binary representation, ...

Read more

Question 737. Minimum Number of Operations to Move All Balls to Each Box LeetCode Solution Problem Statement: Minimum Number of Operations to Move All Balls to Each Box LeetCode Solution: You have n boxes. You are given a binary string boxes of length n, where boxes[i] is '0' if the ith box is empty, and '1' if it contains one ball. In one operation, you can move one ball from a box to an adjacent box. Box i is adjacent to box j if abs(i - j) == ...

Read more

Question 738. Valid Triangle Number LeetCode Solution Problem Statement: Valid Triangle Number LeetCode Solution says – Given an integer array nums, return the number of triplets chosen from the array that can make triangles if we take them as side lengths of a triangle. Example 1: Input: nums = [2,2,3,4] Output: 3 Explanation: Valid combinations are: 2,3,4 (using ...

Read more

Question 739. Reach a Number LeetCode Solution Problem statement: Reach a Number LeetCode Solution says – You are standing at a position 0 on an infinite number line. There is a destination at the position target. You can make a number of moves numMoves so that: On each move, you can either go left or right. During the ith move (starting ...

Read more

Question 740. Shortest Unsorted Continuous Subarray LeetCode Solution Problem Statement Shortest Unsorted Continuous Subarray LeetCode Solution says that – Given an integer array nums, you have to find one continuous subarray that if you only sort this subarray in ascending order, then the whole array will be sorted in ascending order. Return the length of the shortest subarray. Example 1: ...

Read more

Question 741. Rectangle Overlap LeetCode Solution Problem Statement: Rectangle Overlap LeetCode Solution – says that An axis-aligned rectangle is represented as a list, [x1, y1, x2, y2], where (x1, y1) is the coordinate of its bottom-left corner, and (x2, y2) is the coordinate of its top-right corner. Its top and bottom edges are parallel to the X-axis, and its left ...

Read more

Question 742. Greatest Sum Divisible by Three LeetCode Solution Problem Statement: Greatest Sum Divisible by Three LeetCode Solution:  Array nums of integers are given, we need to find the maximum possible sum of elements of the array such that it is divisible by three. Example 1: Input: nums = [3,6,5,1,8] Output: 18 Explanation: Pick numbers 3, 6, 1 and ...

Read more

Question 743. Insert into a Sorted Circular Linked List LeetCode Solution Problem Statement: Insert into a Sorted Circular Linked List LeetCode Solution – says that Given a Circular Linked List node, which is sorted in ascending order, write a function to insert a value insertVal into the list such that it remains a sorted circular list. The given node can be a ...

Read more

Question 744. Arranging Coins Leetcode Solution Problem Statement The Arranging Coins LeetCode Solution – “Arranging Coins” asks you to build a staircase with these coins. The staircase consists of k rows, where ith row consists of exactly i coins. The last row of the staircase may not be complete. For the given amount of coins, return ...

Read more

Question 745. Odd Even Linked List Leetcode Solution Problem Statement The Odd-Even Linked List LeetCode Solution – “Odd-Even Linked List” states that given a non-empty singly linked list. We need to group all nodes with odd indices together followed by the nodes with even indices, and return the reordered list. Note that the relative order inside both the ...

Read more

Question 746. Design A Leaderboard Leetcode Solution Problem Statement The Design A Leaderboard LeetCode Solution – “Design A Leaderboard” asks you to complete 3 functions: addScore(playerId, score): Update the leaderboard by adding a score to the given player’s score. If there doesn’t exist any player, add such id on the leaderboard. top(K): Return the top sum of ...

Read more

Question 747. Divide Two Integers Leetcode Solution Problem Statement The Divide Two Integers LeetCode Solution – “Divide Two Integers” states that you’re given two integers dividend and divisor. Return the quotient after dividing the dividend by the divisor. Note that we’re assuming that we’re dealing with an environment that could store integers within a 32-bit signed integer ...

Read more

Question 748. Robot Room Cleaner Leetcode Solution Problem Statement The Robot Room Cleaner LeetCode Solution – “Robot Room Cleaner” states that given the robot in a m x n a binary grid where 0 represents a wall and 1 represents an empty slot. The initial position of the robot is guaranteed to be empty and the robot moves inside the ...

Read more

Question 749. The kth Factor of n Leetcode Solution Problem Statement The kth Factor of n Leetcode Solution: states that you are given two positive integers n and k. A factor of an integer n is defined as an integer i where n % i == 0. Consider a list of all factors of n sorted in ascending order, return the kth factor in this list or return -1 if n has less than k factors. Example 1: Input: ...

Read more

Question 750. LRU Cache Leetcode Solution Problem Statement The LRU Cache LeetCode Solution – “LRU Cache” asks you to design a data structure that follows Least Recently Used (LRU) Cache We need to implement LRUCache class that has the following functions: LRUCache(int capacity): Initializes the LRU cache with positive size capacity. int get(int key): Return the value ...

Read more

Question 751. Merge k Sorted Lists Leetcode Solution Problem Statement The Merge k Sorted Lists LeetCode Solution – “Merge k Sorted Lists” states that given the array of k linked lists, where each linked list has its values sorted in ascending order. We need to merge all the k-linked lists into one single linked list and return the ...

Read more

Question 752. Range Sum Query 2D – Immutable Leetcode Solution Problem Statement Range Sum Query 2D – Immutable Leetcode Solution – Given a 2D matrix matrix, handle multiple queries of the following type: Calculate the sum of the elements of matrix inside the rectangle defined by its upper left corner (row1, col1) and lower right corner (row2, col2). Implement the NumMatrix class: NumMatrix(int[][] matrix) Initializes the object with the integer ...

Read more

Question 753. Partition Labels LeetCode Solution Problem Statement Partition Labels LeetCode Solution – You are given a string s. We want to partition the string into as many parts as possible so that each letter appears in at most one part. Note that the partition is done so that after concatenating all the parts in order, the ...

Read more

Question 754. Fibonacci Number LeetCode Solution Problem Statement Fibonacci Number LeetCode Solution – “Fibonacci Number” states that The Fibonacci numbers, commonly denoted F(n) form a sequence, called the Fibonacci sequence, such that each number is the sum of the two preceding ones, starting from 0 and 1. That is, F(0) = 0, F(1) = 1 F(n) = F(n - 1) + F(n ...

Read more

Question 755. Diagonal Traversal LeetCode Solution Problem Statement Diagonal Traversal LeetCode Solution – Given a 2D integer array nums, return all elements of nums in diagonal order as shown in the below images. Input: nums = [[1,2,3],[4,5,6],[7,8,9]] Output: [1,4,2,7,5,3,8,6,9] Explanation for Diagonal Traversal LeetCode Solution Key Idea The first row and the last column in this problem would serve ...

Read more

Question 756. Nearest Exit from Entrance in Maze LeetCode Solution Problem Statement Nearest Exit from Entrance in Maze LeetCode Solution – We are given an m x n matrix “maze” (0-indexed) with empty cells represented as ‘.’ and walls as ‘+’. You are also given the entrance of the maze, where entrance = [entrance_row, entrance_col] denotes the row and column ...

Read more

Question 757. Valid Tic-Tac-Toe State LeetCode Solution Problem Statement Valid Tic-Tac-Toe State LeetCode Solution – We are given a Tic-Tac-Toe board as a string array board & are asked to return true iff it is possible to reach this board position during the course of a valid tic-tac-toe game. The board is a 3 x 3 array ...

Read more

Question 758. Reverse Words in a String III LeetCode Solution Problem Statement Reverse Words in a String III LeetCode Solution – We are given a string and are asked to reverse the order of characters in each word within a sentence while still preserving whitespace and initial word order. Examples & Explanations Example 1: Input: s = "Let's take LeetCode ...

Read more

Question 759. Filter Restaurants by Vegan-Friendly, Price and Distance Leetcode Solution Problem Statement Filter Restaurants by Vegan-Friendly, Price, and Distance Leetcode Solution – Given the array restaurants where  restaurants[i] = [idi, ratingi, veganFriendlyi, pricei, distancei]. You have to filter the restaurants using three filters. The veganFriendly filter will be either true (meaning you should only include restaurants with veganFriendlyi set it to true) or false (meaning you can include any ...

Read more

Question 760. Brightest Position on Street LeetCode Solution Problem Statement Brightest Position on Street LeetCode Solution – We are asked to assume a number line representing a street. This street contains lamp(s) on it. We are given a 2D integer array “lights”. Each lights[i] = [position_i, range_i] indicates that there is a street lamp on position_i which can ...

Read more

Question 761. Remove Duplicates from Sorted List LeetCode Solution Problem Statement Remove Duplicates from Sorted List LeetCode Solution – We are given the head of a sorted linked list. We are asked to delete all the duplicates such that each element appears only once and return the linked list sorted as well. Examples & Explanations Example 1: Input: head ...

Read more

Question 762. Clone Graph LeetCode Solution Problem Statement Clone Graph LeetCode Solution – We are given a reference of a node in a connected undirected graph and are asked to return a deep copy of the graph. A deep copy is basically a clone where no node present in the deep copy should have the reference ...

Read more

Question 763. Minimum Height Trees LeetCode Solution Problem Statement Minimum Height Trees LeetCode Solution – We are given a tree of n nodes labelled from 0 to n-1 as a 2D array “edges” where edge[i] = [a_i, b_i] indicates that there is an undirected edge between the two nodes a_i and b_i in the tree. We have ...

Read more

Question 764. Kth Smallest Element in a Sorted Matrix LeetCode Solution Problem Statement Kth Smallest Element in a Sorted Matrix LeetCode Solution – We are given a matrix of size n where each of the rows and columns is sorted in ascending order. We are asked to return the kth smallest element in the matrix. Note that it is the kth ...

Read more

Question 765. Number of Islands II LeetCode Solution Problem Statement Number of Islands II LeetCode Solution – You are given an empty 2D binary grid grid of size m x n. The grid represents a map where 0‘s represent water and 1‘s represent land. Initially, all the cells  grid are water cells (i.e., all the cells are 0‘s). We may perform an add land ...

Read more

Question 766. Construct Binary Tree from Preorder and Postorder Traversal LeetCode Solution Problem Statement Construct Binary Tree from Preorder and Postorder Traversal LeetCode Solution – Given two integer arrays, preorder and postorder where preorder is the preorder traversal of a binary tree of distinct values and postorder is the postorder traversal of the same tree, reconstruct and return the binary tree. If there exist multiple answers, you can return any of them. Input: preorder ...

Read more

Question 767. Number of Dice Rolls With Target Sum LeetCode Solution Problem Statement Number of Dice Rolls With Target Sum LeetCode Solution – You have n dice and each die has k faces numbered from 1 to k. Given three integers n, k, and target, return the number of possible ways (out of the kn total ways) to roll the dice so the sum of the face-up numbers equals target. Since the answer may be ...

Read more

Question 768. Remove Duplicates from Sorted List II LeetCode Solution Problem Statement Remove Duplicates from Sorted List II LeetCode Solution – Given the head of a sorted linked list, delete all nodes that have duplicate numbers, leaving only distinct numbers from the original list. Return the linked list sorted as well. Input: head = [1,2,3,3,4,4,5] Output: [1,2,5] Explanation The idea here is to traverse ...

Read more

Question 769. Shortest Path in a Grid with Obstacles Elimination LeetCode Solution Problem Statement Shortest Path in a Grid with Obstacles Elimination LeetCode Solution – You are given an m x n integer matrix grid where each cell is either 0 (empty) or 1 (obstacle). You can move up, down, left, or right from and to an empty cell in one step. Return the minimum number of steps to walk from the upper left ...

Read more

Question 770. Can Place Flowers LeetCode Solution Problem Statement Can Place Flowers LeetCode Solution – You have a long flowerbed in which some of the plots are planted, and some are not. However, flowers cannot be planted in adjacent plots. Given an integer array flowerbed containing 0‘s and 1‘s, where 0 means empty and 1 means not empty, and an integer n, return if n new flowers can be planted in ...

Read more

Question 771. First Unique Character in a String LeetCode Solution Problem Statement First Unique Character in a String LeetCode Solution – Given a string s, find the first non-repeating character in it and return its index. If it does not exist, return -1. Example Test Case 1: Input: s = “leetcode” Output: 0 Test Case 2: Input: s = “aabb” Output: -1 Explanation ...

Read more

Question 772. Analyze User Website Visit Pattern LeetCode Solution Problem Statement Analyze User Website Visit Pattern LeetCode Solution – You are given two string arrays username and website and an integer array timestamp. All the given arrays are of the same length and the tuple [username[i], website[i], timestamp[i]] indicates that the user username[i] visited the website website[i] at time timestamp[i]. A pattern is a list of three websites (not necessarily distinct). For example, ["home", ...

Read more

Question 773. Invert Binary Tree LeetCode Solution Problem Statement: Invert Binary Tree LeetCode Solution – In this question, Given a root of any binary tree, the solution is required to invert the binary tree meaning the left tree should become the right tree and vice versa.   Explanation We can ask ourselves which tree traversal would be ...

Read more

Question 774. Closest Binary Search Tree Value Leetcode Solution Problem Statement : Closest Binary Search Tree Value Leetcode Solution – Given the root of a binary search tree and a target value, return the value in the BST that is closest to the target. Example : Example 1 Input: root = [4,2,5,1,3], target = 3.714286 Output: 4 Example 2 Input: root = [1], target ...

Read more

Question 775. Partition List Leetcode Solution Problem Statement : Partition List Leetcode Solution – Given the head of a linked list and a value x, partition it such that all nodes less than x come before nodes greater than or equal to x. You should preserve the original relative order of the nodes in each of the two partitions. Example : Example 1  Input: head = ...

Read more

Question 776. Design Browser History LeetCode Solution Problem Statement Design Browser History LeetCode Solution – You have a browser with one tab where you start on the homepage and you can visit another url, get back in the history number of steps or move forward in the history number of steps. Implement the BrowserHistory class: BrowserHistory(string homepage) Initializes the object with the homepage of the ...

Read more

Question 777. Evaluate Reverse Polish Notation LeetCode Solution Problem Statement Evaluate Reverse Polish Notation LeetCode Solution – Evaluate the value of an arithmetic expression in Reverse Polish Notation. Valid operators are +, -, *, and /. Each operand may be an integer or another expression. Note that the division between two integers should truncate toward zero. It is guaranteed that the given ...

Read more

Question 778. 3Sum Closest LeetCode Solution Problem Statement 3Sum Closest LeetCode Solution – Given an integer array nums of length n and an integer target, find three integers in nums such that the sum is closest to target. Return the sum of the three integers. You may assume that each input would have exactly one solution. Input: nums = [-1,2,1,-4], target = 1 Output: ...

Read more

Question 779. Contiguous Array LeetCode Solution Problem Statement Contiguous Array LeetCode Solution – Given a binary array nums, return the maximum length of a contiguous subarray with an equal number of 0 and 1. Input: nums = [0,1] Output: 2 Explanation: [0, 1] is the longest contiguous subarray with an equal number of 0 and 1. Explanation Now what we ...

Read more

Question 780. Maximum Number of Occurrences of a Substring Leetcode Solution Problem Statement : Maximum Number of Occurrences of a Substring Leetcode Solution – Given a string s, return the maximum number of occurrences of any substring under the following rules: The number of unique characters in the substring must be less than or equal to maxLetters. The substring size must be between minSize and maxSize inclusive. Example ...

Read more

Question 781. N-Queens LeetCode Solution Problem Statement N-Queens LeetCode Solution – The n-queens puzzle is the problem of placing n queens on a n x n chessboard such that no two queens attack each other. Given an integer n, return all distinct solutions to the n-queens puzzle. You may return the answer in any order. Each solution contains a distinct board configuration of the ...

Read more

Question 782. Largest Rectangle in Histogram LeetCode Solution Problem Statement Largest Rectangle in Histogram LeetCode Solution – Given an array of integers heights representing the histogram’s bar height where the width of each bar is 1, return the area of the largest rectangle in the histogram. Example Test Case 1: Input: heights = [2, 1, 5, 6, 2, 3] Output: 10 Explanation: ...

Read more

Question 783. Regular Expression Matching Regular Expression Matching LeetCode Solution Problem Statement Regular Expression Matching Regular Expression Matching LeetCode Solution – Given an input string s and a pattern p, implement regular expression matching with support for '.' and '*' where: '.' Matches any single character.​​​​ '*' Matches zero or more of the preceding element. The matching should cover the entire input string (not partial). Example Test Case 1: Input: ...

Read more

Question 784. Binary Tree Right Side View LeetCode Solution Problem Statement Binary Tree Right Side View LeetCode Solution – Given the root of a binary tree, imagine yourself standing on the right side of it, and return the values of the nodes you can see ordered from top to bottom. Example Test Case 1: Input: root = [1, 2, 3, null, 5, null, ...

Read more

Question 785. Zigzag Conversion LeetCode Solution Problem Statement Zigzag Conversion LeetCode Solution – The string "PAYPALISHIRING" is written in a zigzag pattern on a given number of rows like this: (you may want to display this pattern in a fixed font for better legibility) P A H N A P L S I I G Y I ...

Read more

Question 786. Maximize Distance to Closest Person LeetCode Solution Problem Statement Maximize Distance to Closest Person LeetCode Solution – You are given an array representing a row of seats where seats[i] = 1 represents a person sitting in the ith seat, and seats[i] = 0 represents that the ith seat is empty (0-indexed). There is at least one empty seat, and at least one person sitting. Alex wants to ...

Read more

Question 787. Third Maximum Number Leetcode Solution Problem Statement Third Maximum Number Leetcode Solution – Given an integer array nums, return the third distinct maximum number in this array. If the third maximum does not exist, return the maximum number. Example Input: nums = [3,2,1] Output: 1 Explanation: The first distinct maximum is 3. The second distinct maximum is 2. The third ...

Read more

Question 788. Minesweeper LeetCode Solution Problem Statement Minesweeper LeetCode Solution – Let’s play the minesweeper game (Wikipedia, online game)! You are given an m x n char matrix board representing the game board where: 'M' represents an unrevealed mine, 'E' represents an unrevealed empty square, 'B' represents a revealed blank square that has no adjacent mines (i.e., above, below, left, right, and all ...

Read more

Question 789. Koko Eating Bananas LeetCode Solution Problem Statement Koko Eating Bananas LeetCode Solution – Koko loves to eat bananas. There are n piles of bananas, the ith pile has piles[i] bananas. The guards have gone and will come back in h hours. Koko can decide her bananas-per-hour eating speed of k. Each hour, she chooses some pile of bananas and eats k bananas from that pile. If ...

Read more

Question 790. Time Based Key-Value Store LeetCode Solution Problem Statement Time Based Key-Value Store LeetCode Solution – Design a time-based key-value data structure that can store multiple values for the same key at different time stamps and retrieve the key’s value at a certain timestamp. Implement the TimeMap class: TimeMap() Initializes the object of the data structure. void set(String key, String ...

Read more

Question 791. Find Median from Data Stream LeetCode Solution Problem Statement Find Median from Data Stream LeetCode Solution – The median is the middle value in an ordered integer list. If the size of the list is even, there is no middle value and the median is the mean of the two middle values. For example, for arr = [2,3,4], the median ...

Read more

Question 792. Permutation in String Leetcode Solution Problem Statement : Permutation in String Leetcode Solution – Given two strings s1 and s2, return true if s2 contains a permutation of s1, or false otherwise. In other words, return true if one of s1‘s permutations is the substring of s2. Example : Example 1  Input: s1 = "ab", s2 = "eidbaooo" Output: true Explanation: s2 contains one permutation of s1 ("ba"). ...

Read more

Question 793. Determine Whether Matrix Can Be Obtained By Rotation LeetCode Solution Problem Statement Determine Whether Matrix Can Be Obtained By Rotation LeetCode Solution – Given two n x n binary matrices mat and target, return true if it is possible to make mat equal to target by rotating mat in 90-degree increments, or false otherwise. Examples Input: mat = [[0,1],[1,0]], target = [[1,0],[0,1]] Output: true Explanation: We can rotate mat 90 degrees clockwise to make mat equal ...

Read more

Question 794. Asteroid Collision LeetCode Solution Problem Statement Asteroid Collision LeetCode Solution – We are given an array asteroids of integers representing asteroids in a row. For each asteroid, the absolute value represents its size, and the sign represents its direction (positive meaning right, negative meaning left). Each asteroid moves at the same speed. Find out the state ...

Read more

Question 795. Reorder Data in Log Files LeetCode Solution Problem Statement Reorder Data in Log Files LeetCode Solution – You are given an array of logs. Each log is a space-delimited string of words, where the first word is the identifier. There are two types of logs: Letter-logs: All words (except the identifier) consist of lowercase English letters. Digit-logs: All words ...

Read more

Question 796. Longest Increasing Path in a Matrix LeetCode Solution Problem Statement Longest Increasing Path in a Matrix LeetCode Solution – Given an m x n integers matrix, return the length of the longest increasing path in matrix. From each cell, you can either move in four directions: left, right, up, or down. You may not move diagonally or move outside the boundary (i.e., wrap-around is not allowed). Input: ...

Read more

Question 797. Optimal Account Balancing LeetCode Solution Problem Statement Optimal Account Balancing LeetCode Solution – You are given an array of transactions transactions where transactions[i] = [fromi, toi, amounti] indicates that the person with ID = fromi gave amounti $ to the person with ID = toi. Return the minimum number of transactions required to settle the debt. Input: transactions = [[0,1,10],[2,0,5]] Output: 2 Explanation: Person #0 ...

Read more

Question 798. Number of Closed Islands Leetcode Solution Problem Statement : Number of Closed Islands Leetcode Solution – Given a 2D grid consisting of 0s (land) and 1s (water).  An island is a maximal 4-directionally connected group of 0s and a closed island is an island totally (all left, top, right, bottom) surrounded by 1s. Return the number of closed islands. Example : Example 1  Input: grid = [[1,1,1,1,1,1,1,0],[1,0,0,0,0,1,1,0],[1,0,1,0,1,1,1,0],[1,0,0,0,0,1,0,1],[1,1,1,1,1,1,1,0]] Output: 2 Explanation: Islands in gray ...

Read more

Question 799. Serialize and Deserialize Binary Tree LeetCode Solution Problem Statement Serialize and Deserialize Binary Tree LeetCode Solution – Serialization is the process of converting a data structure or object into a sequence of bits so that it can be stored in a file or memory buffer, or transmitted across a network connection link to be reconstructed later in ...

Read more

Question 800. Binary Tree Maximum Path Sum LeetCode Solution Problem Statement Binary Tree Maximum Path Sum LeetCode Solution – A path in a binary tree is a sequence of nodes where each pair of adjacent nodes in the sequence has an edge connecting them. A node can only appear in the sequence at most once. Note that the path does not need ...

Read more

Question 801. Robot Bounded In Circle LeetCode Solution Problem Statement Robot Bounded In Circle LeetCode Solution – On an infinite plane, a robot initially stands at (0, 0) and faces north. Note that: The north direction is the positive direction of the y-axis. The south direction is the negative direction of the y-axis. The east direction is the positive direction of the x-axis. The west direction is the ...

Read more

Question 802. Minimum Knight Moves LeetCode Solution Problem Statement Minimum Knight Moves LeetCode Solution – In an infinite chessboard with coordinates from -infinity to +infinity, you have a knight at square [0, 0]. A knight has 8 possible moves it can make, as illustrated below. Each move is two squares in a cardinal direction, then one square in an orthogonal direction. Return the minimum number ...

Read more

Question 803. Minimum Number of Taps to Open to Water a Garden LeetCode Solution Problem Statement Minimum Number of Taps to Open to Water a Garden LeetCode Solution – There is a one-dimensional garden on the x-axis. The garden starts at the point 0 and ends at the point n. (i.e The length of the garden is n). There are n + 1 taps located at points [0, 1, ..., n] in ...

Read more

Question 804. Binary Tree Zigzag Level Order Traversal LeetCode Solution Problem Statement Binary Tree Zigzag Level Order Traversal LeetCode Solution – Given the root of a binary tree, return the zigzag level order traversal of its nodes’ values. (i.e., from left to right, then right to left for the next level and alternate between). Input: root = [3,9,20,null,null,15,7] Output: [[3],[20,9],[15,7]] Explanation We ...

Read more

Question 805. Find the Duplicate Number LeetCode Solution Problem Statement Find the Duplicate Number LeetCode Solution – Given an array of integers nums containing n + 1 integers where each integer is in the range [1, n] inclusive. There is only one repeated number in nums, return this repeated number. You must solve the problem without modifying the array nums and uses only constant extra space. Input: nums = [1,3,4,2,2] Output: 2 Explanation ...

Read more

Question 806. Snakes and Ladders LeetCode Solution Problem Statement Snakes and Ladders LeetCode Solution – You are given an n x n integer matrix board where the cells are labeled from 1 to n2 in a Boustrophedon style starting from the bottom left of the board (i.e. board[n - 1][0]) and alternating directions in each row. You start on the square 1 of the board. In each move, ...

Read more

Question 807. Missing Element in Sorted Array LeetCode Solution Problem Statement: Missing Element in Sorted Array LeetCode Solution – Given an integer array nums which are sorted in ascending order and all of its elements are unique and given also an integer k, return the kth missing number starting from the leftmost number of the array. Example: Example 1 Input: nums = [4,7,9,10], k = ...

Read more

Question 808. Path Sum II LeetCode Solution Problem Statement : Path Sum II LeetCode Solution – Given the root of a binary tree and an integer targetSum, return all root-to-leaf paths where the sum of the node values in the path equals targetSum. Each path should be returned as a list of the node values, not node references. A root-to-leaf path is a path starting from ...

Read more

Question 809. Alien Dictionary LeetCode Solution Problem Statement Alien Dictionary LeetCode Solution – There is a new alien language that uses the English alphabet. However, the order among the letters is unknown to you. You are given a list of strings words from the alien language’s dictionary, where the strings in words are sorted lexicographically by the rules of this new language. ...

Read more

Question 810. Product of Array Except Self LeetCode Solution Problem Statement Product of Array Except Self LeetCode Solution – Given an integer array nums, return an array answer such that answer[i] is equal to the product of all the elements of nums except nums[i]. The product of any prefix or suffix of nums is guaranteed to fit in a 32-bit integer. You must write an algorithm that runs in O(n) time and without using the division ...

Read more

Question 811. Scramble String LeetCode Solution Problem Statement Scramble String LeetCode Solution – We can scramble a string s to get a string t using the following algorithm: If the length of the string is 1, stop. If the length of the string is > 1, do the following: Split the string into two non-empty substrings ...

Read more

Question 812. Sum of Left Leaves LeetCode Solution Problem Statement: Sum of Left Leaves LeetCode Solution – Given the root of a binary tree, return the sum of all left leaves. A leaf is a node with no children. A left leaf is a leaf that is the left child of another node. Example & Explanation: Input: root = [3,9,20,null,null,15,7] Output: 24 Explanation: There ...

Read more

Question 813. Intersection of Two Linked Lists LeetCode Solution Problem Statement Intersection of Two Linked Lists LeetCode Solution – We are given the heads of two strongly linked-lists headA and headB. It is also given that the two linked lists may intersect at some point. We are asked to return the node at which they intersect or null if ...

Read more

Question 814. Permutation Sequence LeetCode Solution Problem Statement Permutation Sequence LeetCode Solution – The set [1, 2, 3, ..., n] contains a total of n! unique permutations. By listing and labeling all of the permutations in order, we get the following sequence for n = 3: "123" "132" "213" "231" "312" "321" Given n and k, return the kth permutation sequence. Example Test Case 1: Input: n ...

Read more

Question 815. Find Largest Value in Each Tree Row LeetCode Solution Problem Statement Find Largest Value in Each Tree Row LeetCode Solution – Given the root of a binary tree, return an array of the largest value in each row of the tree (0-indexed). Example Test Case 1: Input: root = [1, 3, 4, 5, 3, null, 9] Output: [1, 3, 9] Explanation 1, 3, and ...

Read more

Question 816. Search Suggestions System LeetCode Solution Problem Statement Search Suggestions System LeetCode Solution – You are given an array of strings products and a string searchWord. Design a system that suggests at most three product names from products after each character of searchWord is typed. Suggested products should have a common prefix with searchWord. If there are more than three products with a ...

Read more

Question 817. Rotate Image LeetCode Solution Problem Statement Rotate Image LeetCode Solution – You are given an n x n 2D matrix representing an image, rotate the image by 90 degrees (clockwise). You have to rotate the image in-place, which means you have to modify the input 2D matrix directly. DO NOT allocate another 2D matrix and do the rotation. Example Test Case 1: Input: ...

Read more

Question 818. Peeking Iterator LeetCode Solution Problem Statement Peeking Iterator LeetCode Solution – Design an iterator that supports the peek operation on an existing iterator in addition to the hasNext and the next operations. Implement the PeekingIterator class: PeekingIterator(Iterator<int> nums) Initializes the object with the given integer iterator iterator. int next() Returns the next element in the array and moves the pointer to the next element. boolean ...

Read more

Question 819. Orderly Queue LeetCode Solution Problem Statement Orderly Queue LeetCode Solution – You are given a string s and an integer k. You can choose one of the first k letters of s and append it at the end of the string. Return the lexicographically smallest string you could have after applying the mentioned step any number of moves. Input: s ...

Read more

Question 820. Defanging an IP Address LeetCode Solution Problem Statement Defanging an IP Address LeetCode Solution – Given a valid (IPv4) IP address, return a defanged version of that IP address. A defanged IP address replaces every period "." with "[.]". Input: address = "1.1.1.1" Output: "1[.]1[.]1[.]1" Explanation The intuition is very simple. 1. create a Stringbuilder str 2. loop through the address string ...

Read more

Question 821. Kth Smallest Element in a BST Leetcode Solution Problem Statement Kth Smallest Element in a BST Leetcode Solution – Given the root of a binary search tree, and an integer k, return the kth smallest value (1-indexed) of all the values of the nodes in the tree. Examples: Input: root = [3,1,4,null,2], k = 1 Output: 1   Input: root = [5,3,6,2,4,null,null,1], k ...

Read more

Question 822. Find Leaves of Binary Tree LeetCode Solution Problem Statement Find Leaves of Binary Tree LeetCode Solution – Given the root of a binary tree, collect a tree’s nodes as if you were doing this: Collect all the leaf nodes. Remove all the leaf nodes. Repeat until the tree is empty. Example Test Case 1: Input: root = [1, 2, 3, ...

Read more

Question 823. Top K Frequent Words LeetCode Solution Problem Statement Top K Frequent Words LeetCode Solution – Given an array of strings words and an integer k, return the k most frequent strings. Return the answer sorted by the frequency from highest to lowest. Sort the words with the same frequency by their lexicographical order. Example Test Case 1: Input: words = [“i”,”love”,”leetcode”,”i”,”love”,”coding”] k = 2 Output: [“i”,”love”] Explanation ...

Read more

Question 824. Increasing Triplet Subsequence LeetCode Solution Problem Statement : Increasing Triplet Subsequence LeetCode Solution – Given an integer array nums, return true if there exists a triple of indices (i, j, k) such that i < j < k and nums[i] < nums[j] < nums[k]. If no such indices exists, return false. Example : Example 1: Input: nums = [2,1,5,0,4,6] Output: true Explanation: The ...

Read more

Question 825. Merge Sorted Array LeetCode Solution Problem Statement Merge Sorted Array LeetCode Solution – You are given two integer arrays nums1 and nums2, sorted in non-decreasing order, and two integers m and n, representing the number of elements in nums1 and nums2 respectively. Merge nums1 and nums2 into a single array sorted in non-decreasing order. The final sorted array should not be returned by the function, but instead be stored inside the array nums1. ...

Read more

Question 826. Employee Free Time LeetCode Solution Problem Statement Employee Free Time LeetCode Solution – We are given a list schedule of employees, which represents the working time for each employee. Each employee has a list of non-overlapping Intervals, and these intervals are in sorted order. Return the list of finite intervals representing the common, positive-length free time for all employees, also in ...

Read more

Question 827. Minimum Possible Integer After at Most K Adjacent Swaps On Digits LeetCode Solution Problem Statement Minimum Possible Integer After at Most K Adjacent Swaps On Digits LeetCode Solution – You are given a string num representing the digits of a very large integer and an integer k. You are allowed to swap any two adjacent digits of the integer at most k times. Return the minimum integer you can obtain also ...

Read more

Question 828. Swapping Nodes in a Linked List Leetcode Solution Problem Statement Swapping Nodes in a Linked List Leetcode Solution – You are given the head of a linked list, and an integer k.Return the head of the linked list after swapping the values of the kth node from the beginning and the kth node from the end (the list is 1-indexed). Example: Input: head = [1,2,3,4,5], k = 2 ...

Read more

Question 829. Find Minimum in Rotated Sorted Array II LeetCode Solution Problem Statement Find Minimum in Rotated Sorted Array II LeetCode Solution – Suppose an array of length n sorted in ascending order is rotated between 1 and n times. For example, the array nums = [0,1,4,4,5,6,7] might become: [4,5,6,7,0,1,4] if it was rotated 4 times. [0,1,4,4,5,6,7] if it was rotated 7 times. Notice that rotating an array [a[0], a[1], a[2], ..., a[n-1]] 1 time results in the array [a[n-1], a[0], a[1], a[2], ...

Read more

Question 830. Delete Node in a Linked List Leetcode Solution Problem Statement : Delete Node in a Linked List Leetcode Solution – Write a function to delete a node in a singly-linked list. You will not be given access to the head of the list, instead, you will be given access to the node to be deleted directly. It is guaranteed that the node to be deleted is not ...

Read more

Question 831. Number of Distinct Islands Leetcode Solution Problem Statement The Number of Distinct Islands LeetCode Solution – “Number of Distinct Islands” states that given a n x m binary matrix. An island is a group of 1‘s (representing land) connected 4-directionally (horizontal or vertical). An island is considered to be the same as another if and only if one island ...

Read more

Question 832. Find if Path Exists in Graph Leetcode Solution Problem Statement Find if Path Exists in Graph Leetcode Solution – There is a bi-directional graph with n vertices, where each vertex is labeled from 0 to n - 1 (inclusive). The edges in the graph are represented as a 2D integer array edges, where each edges[i] = [ui, vi] denotes a bi-directional edge between vertex ui and vertex vi. Every vertex pair ...

Read more

Question 833. Closest Leaf in a Binary Tree LeetCode Solution Problem Statement Closest Leaf in a Binary Tree LeetCode Solution – Given the root of a binary tree where every node has a unique value and a target integer k, return the value of the nearest leaf node to the target k in the tree. Nearest to a leaf means the least number of edges traveled on the binary tree to ...

Read more

Question 834. Ugly Number II LeetCode Solution Problem Statement Ugly Number II LeetCode Solution – An ugly number is a positive integer whose prime factors are limited to 2, 3, and 5. Given an integer n, return the nth ugly number. Input: n = 10 Output: 12 Explanation: [1, 2, 3, 4, 5, 6, 8, 9, 10, 12] is the sequence of the first 10 ...

Read more

Question 835. Invalid Transactions LeetCode Solution Problem Statement Invalid Transactions LeetCode Solution – A transaction is possibly invalid if: the amount exceeds $1000, or; if it occurs within (and including) 60 minutes of another transaction with the same name in a different city. You are given an array of strings transaction where transactions[i] consists of comma-separated values representing the name, time (in minutes), amount, and city ...

Read more

Question 836. Combination Sum IV LeetCode Solution Problem Statement Combination Sum IV LeetCode Solution – Given an array of distinct integers nums and a target integer target, return the number of possible combinations that add up to target. The test cases are generated so that the answer can fit in a 32-bit integer. Input: nums = [1,2,3], target = 4 Output: 7 Explanation: The possible ...

Read more

Question 837. String to Integer (atoi) LeetCode Solution Problem Statement The String to Integer (atoi) Leetcode Solution -“String to Integer (atoi)” states that Implementing the myAtoi(string s) function, which converts a string to a 32-bit signed integer (similar to C/C++’s atoi function). The algorithm for myAtoi(string s) is as follows: Read in and ignore any leading whitespace. Check if the next character (if ...

Read more

Question 838. Restore IP Addresses Leetcode Solution Problem Statement The Restore IP Addresses LeetCode Solution – “Restore IP Addresses” states that given the string which contains only digits, we need to return all possible valid IP Addresses in any order that can be formed by inserting dots into the string. Note that we’re not allowed to return ...

Read more

Question 839. String Compression LeetCode Solution Problem Statement String Compression LeetCode Solution – Given an array of characters chars, compress it using the following algorithm: Begin with an empty string s. For each group of consecutive repeating characters in chars: If the group’s length is 1, append the character to s. Otherwise, append the character followed by the group’s length. The compressed string ...

Read more

Question 840. Minimum Swaps To Make Sequences Increasing LeetCode Solution Problem Statement Minimum Swaps To Make Sequences Increasing LeetCode Solution – You are given two integer arrays of the same length nums1 and nums2. In one operation, you are allowed to swap nums1[i] with nums2[i]. For example, if nums1 = [1,2,3,8], and nums2 = [5,6,7,4], you can swap the element at i = 3 to obtain nums1 = [1,2,3,4] and nums2 = [5,6,7,8]. ...

Read more

Question 841. Check Completeness of a Binary Tree LeetCode Solution Problem Statement Check Completeness of a Binary Tree LeetCode Solution – Given the root of a binary tree, determine if it is a complete binary tree. In a complete binary tree, every level, except possibly the last, is completely filled, and all nodes in the last level are as far left as possible. ...

Read more

Question 842. Graph Valid Tree LeetCode Solution Problem Statement Graph Valid Tree LeetCode Solution – Given the edges of a graph, check if the edges make up a valid tree. If yes, return true and false otherwise. The edges are given as a 2D array of size n*2 Examples & Explanations Example 1: Input: n = 5, ...

Read more

Question 843. Spiral Matrix II Leetcode Solution Problem Statement This question Spiral Matrix II is very similar to  Spiral Matrix  Please try to attempt the above question to get a better idea before solving this problem. In this question, we are asked to generate a matrix of size n*n having elements in spiral order, and only n ...

Read more

Question 844. Web Crawler LeetCode Solution Problem Statement Web Crawler LeetCode Solution – Given a URL startUrl and an interface HtmlParser, implement a web crawler to crawl all links that are under the same hostname as startUrl. Return all URLs obtained by your web crawler in any order. Your crawler should: Start from the page: startUrl Call HtmlParser.getUrls(url) to get all URLs from a webpage of ...

Read more

Question 845. One Edit Distance LeetCode Solution Problem Statement One Edit Distance LeetCode Solution – Given two strings s and t, return true if they are both one edit distance apart, otherwise return false. A string s is said to be one distance apart from a string t if you can: Insert exactly one character into s to get t. Delete exactly one character from s to get t. Replace exactly one character of s with a different character to get t. Input: ...

Read more

Question 846. Possible Bipartition LeetCode Solution Problem Statement Possible Bipartition LeetCode Solution – We want to split a group of n people (labeled from 1 to n) into two groups of any size. Each person may dislike some other people, and they should not go into the same group. Given the integer n and the array dislikes where dislikes[i] = [ai, bi] indicates that the person labeled ai does ...

Read more

Question 847. Employee Importance LeetCode Solution Problem Statement Employee Importance LeetCode Solution – You have a data structure of employee information, including the employee’s unique ID, importance value, and direct subordinates’ IDs. You are given an array of employees employees where: employees[i].id is the ID of the ith employee. employees[i].importance is the important value of the ith employee. employees[i].subordinates is a list of the ...

Read more

Question 848. Integer Break LeetCode Solution Problem Statement Integer Break LeetCode Solution – Given an integer n, break it into the sum of k positive integers, where k >= 2, and maximize the product of those integers. We need to Return the maximum product we can get. Input: n = 2 Output: 1 Explanation: 2 = 1 + 1, ...

Read more

Question 849. Kth Smallest Product of Two Sorted Arrays LeetCode Solution Problem Statement Kth Smallest Product of Two Sorted Arrays LeetCode Solution – Given two sorted 0-indexed integer arrays nums1 and nums2 as well as an integer k, return the kth (1-based) smallest product of nums1[i] * nums2[j] where 0 <= i < nums1.length and 0 <= j < nums2.length. Input: nums1 = [2,5], nums2 = [3,4], k = 2 Output: 8 Explanation: The 2 ...

Read more

Question 850. Kill Process LeetCode Solution Problem Statement Kill Process LeetCode Solution – You have n processes forming a rooted tree structure. You are given two integer arrays pid and ppid, where pid[i] is the ID of the ith process and ppid[i] is the ID of the ith process’s parent process. Each process has only one parent process but may have multiple children processes. Only one process has ppid[i] = 0, ...

Read more

Question 851. Path With Maximum Minimum Value LeetCode Solution Problem Statement Path With Maximum Minimum Value LeetCode Solution – Given an m x n integer matrix grid, return the maximum score of a path starting at (0, 0) and ending at (m - 1, n - 1) moving in the 4 cardinal directions. The score of a path is the minimum value in that path. For example, the score of ...

Read more

Question 852. Maximum Product of Splitted Binary Tree LeetCode Solution Problem Statement Maximum Product of Splitted Binary Tree LeetCode Solution – Given the root of a binary tree, split the binary tree into two subtrees by removing one edge such that the product of the sums of the subtrees is maximized. Return the maximum product of the sums of the two subtrees. ...

Read more

Question 853. Symmetric Tree LeetCode Solution Leetcode Solution Problem Statement The Symmetric Tree LeetCode Solution – “Symmetric Tree” states that given the root of the binary tree and we need to check if the given binary tree is a mirror of itself(symmetric around its center) or not? If Yes, we need to return true otherwise, false. Example:   ...

Read more

Question 854. Design Hit Counter LeetCode Solution Problem Statement Design Hit Counter LeetCode Solution – Design a hit counter which counts the number of hits received in the past 5 minutes (i.e., the past 300 seconds). Your system should accept a timestamp parameter (in seconds granularity), and you may assume that calls are being made to the system in chronological order (i.e., timestamp is monotonically increasing). ...

Read more

Question 855. Minimum Moves to Equal Array Elements LeetCode Solution Problem Statement Minimum Moves to Equal Array Elements LeetCode Solution – Given an integer array nums of size n, return the minimum number of moves required to make all array elements equal. In one move, you can increment n - 1 elements of the array by 1. Example 1: Input  1: nums = [1, 2, 3] Output: ...

Read more

Question 856. Jump Game Leetcode Solution Problem Statement Jump Game Leetcode Solution – You are given an integer array nums. You are initially positioned at the array’s first index, and each element in the array represents your maximum jump length at that position. Return true if you can reach the last index, or false otherwise. Example: Input 1: nums = [2, ...

Read more

Question 857. Linked List Cycle II LeetCode Solution Problem Statement Linked List Cycle II LeetCode Solution – Given the head of a linked list, return the node where the cycle begins. If there is no cycle, return null. There is a cycle in a linked list if there is some node in the list that can be reached again by continuously ...

Read more

Question 858. Champagne Tower LeetCode Solution Problem Statement Champagne Tower LeetCode Solution – We stack glasses in a pyramid, where the first row has 1 glass, the second row has 2 glasses, and so on until the 100th row.  Each glass holds one cup of champagne. Then, some champagne is poured into the first glass at the top.  When the topmost glass is full, any ...

Read more

Question 859. Bitwise AND of Numbers Range LeetCode Solution Problem Statement Bitwise AND of Numbers Range LeetCode Solution – Given 2 numbers left and right that represent the range [left, right], we have to find bitwise AND of all the numbers from left to right (both inclusive) Examples & Explanation Example 1: Input: left = 5, right = 7 ...

Read more

Question 860. Word Pattern LeetCode Solution Problem Statement Word Pattern LeetCode Solution – We are given 2 strings – “s” and “pattern”, we need to find if the pattern follows s. Follows here means full match. More formally, we can for every pattern[i] there should only be one s[i] and vice versa i.e. there is a ...

Read more

Question 861. Maximum Product of Three Numbers LeetCode Solution Problem Statement Maximum Product of Three Numbers LeetCode Solution – We are given an array, the question asks us to calculate the maximum product of any 3 numbers. Examples Example 1: Input: nums = [1,2,3] Output: 6 Example 2: Input: nums = [1,2,3,4] Output: 24 Example 3: Input: nums = ...

Read more

Question 862. Excel Sheet Column Title LeetCode Solution Problem Statement Excel Sheet Column Title LeetCode Solution – We are given a column number (let’s call it colNum) and need to return its corresponding column title as it appears in an excel sheet For example A -> 1 B -> 2 C -> 3 … Z -> 26 AA ...

Read more

Question 863. Valid Perfect Square LeetCode Solution Problem Statement Valid Perfect Square LeetCode Solution – Given a positive integer num, write a function that returns True if num is a perfect square else False. Follow up: Do not use any built-in library function such as sqrt. Input: num = 16 Output: true Explanation A boundary for our solution is fixed. for any number ...

Read more

Question 864. Random Pick Index LeetCode Solution Problem Statement Random Pick Index LeetCode Solution- We are given a constructor of class “Solution” and a function “pick” of type int. We are required to implement the “Solution” class as Solution(int[] nums) Initializes the object with the array nums. int pick(int target) Picks a random index i from nums where nums[i] == target. If there are multiple ...

Read more

Question 865. Merge Two Binary Trees LeetCode Solution Problem Statement Merge Two Binary Trees LeetCode Solution – You are given two binary trees root1 and root2. Imagine that when you put one of them to cover the other, some nodes of the two trees are overlapped while the others are not. You need to merge the two trees into ...

Read more

Question 866. Subarray Product Less Than K LeetCode Solution Problem Statement Subarray Product Less Than K LeetCode Solution – Given an array of integers nums and an integer k, return the number of contiguous subarrays where the product of all the elements in the subarray is strictly less than k. Example Test Case 1: Input: inputArr = [10, 5, 2, 6] k = 100 ...

Read more

Question 867. Reverse Only Letters LeetCode Solution Problem Statement Reverse Only Letters LeetCode Solution – Given a string s, reverse the string according to the following rules: All the characters that are not English letters remain in the same position. All the English letters (lowercase or uppercase) should be reversed. Return s after reversing it. Input: s = "ab-cd" ...

Read more

Question 868. Repeated Substring Pattern LeetCode Solution Problem Statement Repeated Substring Pattern LeetCode Solution – Given a string s, check if it can be constructed by taking a substring of it and appending multiple copies of the substring together. Input: s = "abab" Output: true Explanation: It is the substring "ab" twice. Explanation The first char of ...

Read more

Question 869. Number of Days Between Two Dates LeetCode Solution Problem Statement The question Number of Days Between Two Dates LeetCode Solution asks us to calculate the exact number of days between 2 given dates including leap years. The dates are given as strings in the format YYYY-MM-DD. It is also given that the input dates are valid dates between ...

Read more

Question 870. Encoded String With Shortest Length LeetCode Solution Problem Statement Encoded String With Shortest Length LeetCode Solution – Given a string s, encode the string such that its encoded length is the shortest. The encoding rule is: k[encoded_string], where the encoded_string inside the square brackets is being repeated exactly k times. k should be a positive integer. If an encoding process does not make the ...

Read more

Question 871. Next Greater Element III LeetCode Solution Problem Statement The problem, Next Greater Element III LeetCode Solution states that you are given a positive integer n and you need to find the next greatest integer using the digits present in n only. If there does not exist any such integer, you need to print -1. Moreover, the new ...

Read more

Question 872. Binary Tree Longest Consecutive Sequence LeetCode Solution Problem Statement Binary Tree Longest Consecutive Sequence LeetCode Solution – Given the root of a binary tree, return the length of the longest consecutive sequence path. The path refers to any sequence of nodes from some starting node to any node in the tree along with the parent-child connections. The longest consecutive ...

Read more

Question 873. Perfect Squares LeetCode Solution Problem Statement The Perfect Squares LeetCode Solution – “Perfect Squares” states that given an integer n and you need to return the minimum number of perfect squares whose sum equals to n. Note that the same perfect square can be used multiple times. Example: Input: n = 12 Output: 3 Explanation: ...

Read more

Question 874. Edit Distance LeetCode Solution Problem Statement The problem Edit Distance LeetCode Solution states that you are given two strings word1 and word2 and you need to convert word1 into word2 in minimum operations. The operations that can be performed on the string are – Insert a character Delete a character Replace a character Examples Test Case ...

Read more

Question 875. Custom Sort String Leetcode Solution Problem Statement The Custom Sort String LeetCode Solution – “Custom Sort String” states that you’re given two strings order and s. All characters of string order are unique and they are sorted in the custom order. We need to permute the characters of s and such that the characters follow ...

Read more

Question 876. Minimum Cost to Move Chips to The Same Position LeetCode Solution Problem Statement The Minimum Cost to Move Chips to The Same Position LeetCode Solution – “Minimum Cost to Move Chips to The Same Position” states that you have n chips, where the position of the ith chip is position[i]. You need to move all the chips to the same position. In one step, we ...

Read more

Question 877. Least Number of Unique Integers after K Removals Leetcode Solution Problem Statement The Least Number of Unique Integers after K Removals LeetCode Solution – “Least Number of Unique Integers after K removals” states that you’re given an array of integers and an integer k. Find the least number of unique integers after removing exactly k elements. Example:   Input: arr = [5,5,4], k = 1 Output: 1 Explanation: Since k ...

Read more

Question 878. Remove All Occurrences of a Substring LeetCode Solution Problem Statement The Remove All Occurrences of a Substring LeetCode Solution –“Remove All Occurrences of a Substring” states that remove ALL the occurrences of the substring part from the given input string s. Note: Substring is a contiguous sequence of characters in an input string. Example        Explanation Let’s ...

Read more

Question 879. Find All Duplicates in an Array LeetCode Solution Problem Statement The problem, Find All Duplicates in an Array LeetCode Solution states that you are given an array of size n containing elements in the range [1,n]. Each integer can appear either once or twice and you need to find all the elements that appear twice in the array. Examples ...

Read more

Question 880. Move Zeroes LeetCode Solution Problem Statement The problem, Move Zeroes LeetCode Solution states that you are given an array containing zero and non-zero elements and you need to move all the zeroes to the end of the array, maintaining the relative order of non-zero elements in the array. You also need to implement an in-place ...

Read more

Question 881. Single Number Leetcode Solution Problem Statement Single Number Leetcode Solution – We are given a non-empty array of integers and need to find an element that appears exactly once. It is given in the question that every element appears twice except for one. Example 1: Input: nums = [2,2,1] Output: 1 Example 2: Input: ...

Read more

Question 882. Number of Provinces Leetcode Solution Problem Statement Number of Provinces Leetcode Solution – We are given an adjacency matrix representation of a graph and need to find the number of provinces. Here province is a group of directly or indirectly connected cities and no other cities outside of the group. Example Example 1: Input: isConnected ...

Read more

Question 883. 01 Matrix LeetCode Solution Problem Statement In this problem 01 Matrix LeetCode Solution, we need to find the distance of the nearest 0 for each cell of the given matrix. The matrix consists only of 0’s and 1’s and the distance of any two adjacent cells is 1. Examples Example 1: Input: mat = ...

Read more

Question 884. Check If Array Pairs Are Divisible by k LeetCode Solution Problem Statement Check If Array Pairs Are Divisible by k LeetCode Solution – Given an array of integers of even length n and an integer k. We want to divide the array into exactly n/2 pairs such that the sum of each pair is divisible by k. Return true  If ...

Read more

Question 885. Sort Characters By Frequency LeetCode Solution Problem Statement Sort Characters By Frequency LeetCode Solution – Given a string S, sort it in decreasing order based on the frequency of the characters. The frequency of a character is the number of times it appears in the string. Return the sorted string. If there are multiple answers, return any of them. Example for Sort Characters By ...

Read more

Question 886. Non-decreasing Array LeetCode Solution Problem Statement Non-decreasing Array LeetCode Solution – given array nums with n integers, your task is to check if it could become non-decreasing by modifying at most one element. We define an array is non-decreasing if nums[index ] <= nums[index +1] holds for every index (0-based) such that (0 <= index <= n-2). ...

Read more

Question 887. Longest Substring with At Most K Distinct Characters LeetCode Solution Problem Statement Longest Substring with At Most K Distinct Characters LeetCode Solution – Given a string S and an integer K, return the length of the longest substring of S that contains at most K distinct characters. Example: Test Case 1: Input: S = “bacc” K = 2 Output: 3 Test Case 2: Input: S = “ab” ...

Read more

Question 888. Factorial Trailing Zeroes LeetCode Solution Problem Statement Factorial Trailing Zeroes LeetCode Solution – Given an integer n, return the number of trailing zeroes in n!. Note that n! = n * (n - 1) * (n - 2) * ... * 3 * 2 * 1. Input: n = 3 Output: 0 Explanation: 3! = 6, no trailing ...

Read more

Question 889. Guess Number Higher or Lower LeetCode Solution Problem Statement Guess Number Higher or Lower LeetCode Solution – We are playing the Guess Game. The game is as follows: I pick a number from 1 to n. You have to guess which number I picked. Every time you guess wrong, I will tell you whether the number I ...

Read more

Question 890. Convert Sorted Array to Binary Search Tree LeetCode Solutions Problem Statement Convert Sorted Array to Binary Search Tree LeetCode Solutions says given an integer array nums where the elements are sorted in ascending order, convert it to a height-balanced binary search tree. A height-balanced binary tree is a binary tree in which the depth of the two subtrees of every node never differs by more ...

Read more

Question 891. Minimum Jumps to Reach Home LeetCode Solution Problem Statement Minimum Jumps to Reach Home LeetCode Solution says – A certain bug’s home is on the x-axis at position x. Help them get there from position 0. The bug jumps according to the following rules: It can jump exactly a positions forward (to the right). It can jump exactly b positions backward (to the ...

Read more

Question 892. Word Ladder LeetCode Solution Problem Statement The Word Ladder LeetCode Solution – “Word Ladder” states that you are given a string beginWord, string endWord, and a wordList. We need to find the shortest transformation sequence length (if no path exists, print 0) from beginWord to endWord following the given conditions: All the Intermediate Words should ...

Read more

Question 893. Best Meeting Point LeetCode Solution Problem Statement The Best Meeting Point LeetCode Solution says Given a binary grid grid of size m x n where each 1 determines the home of one friend, we want to return the minimal total travel distance where the total travel distance is the sum of the distances between the houses of ...

Read more

Question 894. Longest Substring with At Least K Repeating Characters LeetCode Solution Problem Statement The problem Longest Substring with At Least K Repeating Characters LeetCode Solution says given a string S and an integer k, return the length of the longest substring of S such that the frequency of each character in this substring is greater than or equal to k. Example for Longest Substring with At Least ...

Read more

Question 895. Same Tree LeetCode Solution Problem Statement The problem Same Tree says Given the roots of two binary trees p and q, write a function to check if they are the same or not. Two binary trees are considered the same if they are structurally identical, and the nodes have the same value. Example: Test Case ...

Read more

Question 896. Kth Smallest Number in Multiplication Table Leetcode Solution Problem Statement The Kth Smallest Number in Multiplication Table Solution – states that you are given the multiplication table matrix of size m x n, where matrix[i][j] = i*j (1 indexed). For the given three integers m,n and k, we need to find the kth smallest element in the m ...

Read more

Question 897. Last Stone Weight II LeetCode Solution Problem Statement The problem Last Stone Weight II  says you are given an array of integers stones where stones[i] is the weight of the ith stone. We are playing a game with the stones. On each turn, we choose any two stones and smash them together. Suppose the stones have weights x and y ...

Read more

Question 898. Spiral Matrix LeetCode Solution Problem Statement Spiral Matrix Problem says In Spiral Matrix we want to print all the elements of a matrix in a spiral form in the clockwise direction.   Approach for Spiral Matrix: Idea The problem can be implemented by dividing the matrix into loops and printing all the elements in each ...

Read more

Question 899. Sum of Subarray Ranges Leetcode Solution Problem Statement The Sum of Subarray Ranges Leetcode Solution – says that you’re given an integer array nums of max size 10^3. We need to return the sum of all subarray ranges of the given array. The range of a subarray is defined as the difference between the largest and smallest ...

Read more

Question 900. Remove Duplicates from Sorted Array Leetcode Solution Problem Statement The Remove Duplicates from Sorted Array Leetcode Solution – says that you’re given an integer array sorted in non-decreasing order. We need to remove all duplicate elements and modify the original array such that the relative order of distinct elements remains the same and, report the value of ...

Read more

Question 901. Largest BST Subtree LeetCode Solution Problem Statement The Largest BST Subtree LeetCode Solution problem says given the root of a binary tree, find the largest subtree, which is also a Binary Search Tree (BST), where the largest means subtree having the largest number of nodes. Note: A subtree must include all of its descendants. In a Binary ...

Read more

Question 902. My Calendar I LeetCode Solution Problem Statement My Calendar I LeetCode Solution –  We need to write a program that can be used as a Calendar. We can add a new event if adding the event will not cause a double booking. A double booking happens when two events have some non-empty intersection (i.e., some moment is ...

Read more

Question 903. Sort Array By Parity LeetCode Solution Problem Statement The Sort Array By Parity LeetCode Solution – “Sort Array By Parity” states that you are given an integer array nums, move all the even integers at the beginning of the array followed by all the odd integers. Note: Return any array that satisfies this condition. Example: Input: Output: ...

Read more

Question 904. Remove Nth Node From End of List Leetcode Solution Problem Statement The Remove Nth Node From End of List Leetcode Solution – states that you are given the head of a linked list and you need to remove the nth node from the end of this list. After deleting this node, return the head of the modified list. Example: Input: ...

Read more

Question 905. Meeting Rooms II LeetCode Solution Problem Statement The Meeting Rooms II LeetCode Solution – “Meeting Rooms II” states that you are given an array of meeting time intervals “intervals” where “intervals[i] = [ start[i], end[i] ]”, return the minimum number of conference rooms required. Example: intervals = [[0,30],[5,10],[15,20]] 2 Explanation: Meeting one can be done ...

Read more

Question 906. Subarray Sum Equals K LeetCode Solution Problem Statement The Subarray Sum Equals K LeetCode Solution – “Subarray Sum Equals K” states that you are given an array of integers “nums” and an integer ‘k’, return the total number of continuous subarrays whose sum equals to ‘k’. Example: nums = [1, 2, 3], k=3 2 Explanation: There ...

Read more

Question 907. Longest Palindromic Substring LeetCode Solution Problem Statement The Longest Palindromic Substring LeetCode Solution – “Longest Palindromic Substring” states that You are Given a string s, return the longest palindromic substring in s. Note: A palindrome is a word that reads the same backward as forwards, e.g. madam. Example:   s = "babad" "bab" Explanation: All ...

Read more

Question 908. Best Time to Buy and Sell Stock LeetCode Solution Problem Statement The Best Time to Buy and Sell Stock LeetCode Solution – “Best Time to Buy and Sell Stock” states that You are given an array of prices where prices[i] is the price of a given stock on an ith day. You want to maximize your profit by choosing ...

Read more

Question 909. Median of Two Sorted Arrays LeetCode Solution Problem statement Median of Two Sorted Arrays LeetCode solution – In the problem “Median of Two Sorted Arrays”, we are given two sorted arrays nums1 and nums2 of size m and n respectively, and we have to return the median of the two sorted arrays. The overall run time complexity should be O(log (m+n)). Example nums1 = [1,3], ...

Read more

Question 910. Number of Islands LeetCode Solution Problem Statement The number of Islands LeetCode Solution – “Number of Islands” states that you are given an m x n 2D binary grid which represents a map of ‘1’s (land) and ‘0’s (water), you have to return the number of islands. An island is surrounded by water and is ...

Read more

Question 911. LRU Cache LeetCode Solution Question Design a data structure that follows the constraints of a Least Recently Used (LRU) cache. Implement the LRUCache class: LRUCache(int capacity) Initialize the LRU cache with positive size capacity. int get(int key) Return the value of the key if the key exists, otherwise return -1. void put(int key, int value) Update the value of the key if the key exists. Otherwise, add the key-value pair to ...

Read more

Question 912. Kth Largest Element in a Stream Leetcode Solution Problem Statement In this problem, we have to design a class KthLargest() that initially has an integer k and an array of integers. We need to write a parameterized constructor for it when an integer k and array nums are passed as arguments. The class also has a function add(val) that adds ...

Read more

Question 913. Remove Linked List Elements Leetcode Solution Problem Statement In this problem, we are given a linked list with its nodes having integer values. We need to delete some nodes from the list which have value equal to val. The problem does not require to be solved in-place but we will discuss one such approach. Example List = ...

Read more

Question 914. Minimum Moves to Equal Array Elements Leetcode Solution Problem Statement In this problem, we are given an array of integers. Also, we are allowed to perform a certain set of operations on this array. In one operation, we can increment ” n – 1″ (all elements except any one) elements in the array by 1. We need to ...

Read more

Question 915. Hamming Distance Leetcode Solution Problem Statement In this problem, we are given two integers, A and B, and the goal is to find the hamming distance between the given integers. The integers are greater that/equal to 0 and less than 231    Example First Integer = 5 , Second Integer = 2 3 First Integer ...

Read more

Question 916. Count Good Nodes in Binary Tree Leetcode Solution Problem Statement In this problem a binary tree is given with its root. A node X in the tree is named good if in the path from root to X there are no nodes with a value greater than X. We have to return the number of good nodes in ...

Read more

Question 917. Number of Steps to Reduce a Number to Zero Leetcode Solution The problem Number of Steps to Reduce a Number to Zero Leetcode Solution states that given an integer. Find the minimum number of steps to convert the given integer to 0. You can perform either of the two steps, either subtract 1 or divide the integer by 2. The problem ...

Read more

Question 918. Design Parking System Leetcode Solution Problem Statement In this problem, we have to design a parking lot. We have 3 kinds of parking spaces (big, medium and small). All these parking spaces has some fixed number of empty slots initially. Like, in big type of space, we can place at most b cars. In small ...

Read more

Question 919. Combinations Leetcode Solution The problem Combinations Leetcode Solution provides us with two integers, n, and k. We are told to generate all the sequences that have k elements picked out of n elements from 1 to n. We return these sequences as an array. Let us go through a few examples to get ...

Read more

Question 920. Intersection of Two Arrays II Leetcode Solution Problem Statement In this problem two arrays are given and we have to find out the intersection of this two arrays and return the resultant array. Each element in the result should appear as many times as it shows in both arrays. The result can be in any order. Example ...

Read more

Question 921. Jewels and Stones Leetcode Solution The problem Jewels and Stones Leetcode Solution states that you are given two strings. One of them represents jewels and one of them represents stones. The string that contains jewels represents the characters that are jewels. We need to find the number of characters in the stones string that are ...

Read more

Question 922. Assign Cookies Leetcode Solution The problem Assign cookies Leetcode Solution provides with two arrays. One of the arrays represents the size of the cookies and the other represents the greediness of the children. The problem states that you are the parent of children, and you want the maximum number of children to be content. ...

Read more

Question 923. Majority Element Leetcode Solution Problem Statement We are given an array of integers. We need to return the integer which occurs more than ⌊N / 2⌋ time in the array where ⌊ ⌋ is the floor operator. This element is called the majority element. Note that the input array always contains a majority element. ...

Read more

Question 924. Palindrome Linked List Leetcode Solution In the problem “Palindrome Linked List”, we have to check whether a given singly integer linked list is a palindrome or not. Example List = {1 -> 2 -> 3 -> 2 -> 1} true Explanation #1: The list is palindrome as all elements from the start and back are ...

Read more

Question 925. Maximum Depth of Binary Tree Leetcode Solution Problem Statement In the problem a binary tree is given and we have to find out the maximum depth of the given tree. A binary tree’s maximum depth is the number of nodes along the longest path from the root node down to the farthest leaf node. Example 3 / ...

Read more

Question 926. Maximum Depth of N-ary Tree Leetcode Solution In this problem, we are given an N-ary tree, that is, a tree that allows nodes to have more than 2 children. We need to find the depth of a leaf farthest from the root of the tree. This is called maximum depth. Note that the depth of a path ...

Read more

Question 927. Rotate List Leetcode Solution The problem Rotate List Leetcode Solution provides us a linked list and an integer. We are told to rotate the linked list to the right by k places. So if we rotate a linked list k places to the right, in each step we take the last element from the ...

Read more

Question 928. Pow(x, n) Leetcode Solution The problem “Pow(x, n) Leetcode Solution” states that you are given two numbers, one of which is a floating-point number and another an integer. The integer denotes the exponent and the base is the floating-point number. We are told to find the value after evaluating the exponent over the base. ...

Read more

Question 929. Find the Difference Leetcode Solution Problem statement In the problem “Find the Difference” we are given two strings s and t. String t is produced by randomly stuffing the characters of string s and adding one character at a random position. our task is to find out the character which was added in string t. ...

Read more

Question 930. Insert into a Binary Search Tree Leetcode Solution In this problem, we are given the root node of a Binary Search Tree containing integer values and an integer value of a node that we have to add in the Binary Search Tree and return its structure. After inserting the element into the BST, we have to print its ...

Read more

Question 931. Merge Two Sorted Lists Leetcode Solutions Linked lists are quite like arrays in their linear properties. We can merge two sorted arrays to form an overall sorted array. In this problem, we have to merge two sorted linked lists in place to return a new list which contains elements of both lists in a sorted fashion. Example ...

Read more

Question 932. Permutations Leetcode Solution The problem Permutations Leetcode Solution provides a simple sequence of integers and asks us to return a complete vector or array of all the permutations of the given sequence. So, before going into solving the problem. We should be familiar with permutations. So, a permutation is nothing but an arrangement ...

Read more

Question 933. Minimum Depth of Binary Tree Leetcode Solution In this problem, we need to find the length of the shortest path from the root to any leaf in a given binary tree. Note that the “length of the path” here means the number of nodes from the root node to the leaf node. This length is called Minimum ...

Read more

Question 934. Count Primes Leetcode Solutions In this problem, we are given an integer, N. The goal is to count how numbers less than N, are primes. The integer is constrained to be non-negative. Example 7 3 10 4 Explanation Primes less than 10 are 2, 3, 5 and 7. So, the count is 4. Approach(Brute ...

Read more

Question 935. House Robber II Leetcode Solution In the “House Robber II” problem, a robber wants to rob money from different houses. The amount of money in the houses is represented through an array. We need to find the maximum sum of money that can be made by adding the elements in a given array according to ...

Read more

Question 936. Sqrt(x) Leetcode Solution As the title says, we need to find the square root of a number. Let say the number is x, then Sqrt(x) is a number such that Sqrt(x) * Sqrt(x) = x. If the square root of a number is some decimal value, then we have to return the floor value of ...

Read more

Question 937. Convert Sorted Array to Binary Search Tree Leetcode Solution Consider we are given a sorted array of integers. The goal is to build a Binary Search Tree from this array such that the tree is height-balanced. Note that a tree is said to be height-balanced if the height difference of left and right subtrees of any node in the ...

Read more

Question 938. Swap Nodes in Pairs Leetcode Solutions The goal of this problem is to swap nodes of a given linked list in pairs, that is, swapping every two adjacent nodes. If we are allowed to swap just the value of the list nodes, the problem would be trivial. So, we are not allowed to modify the node ...

Read more

Question 939. House Robber Leetcode Solution Problem Statement In this problem there are houses in a street and House robber has to rob these houses. But the problem is that he can’t rob more than one house successively i.e which are adjacent to each other. Given a list of non-negative integers representing the amount of money ...

Read more

Question 940. Happy Number Leetcode Solution Problem Statement The problem is to check whether a number is happy number or not. A number is said to be happy number if replacing the number by the sum of the squares of its digits, and repeating the process makes the number equal to 1. if it does not ...

Read more

Question 941. Valid Anagrams In the problem “Valid Anagrams” we have given two strings str1 and str2. Find out that both the strings are anagrams or not. If they are anagrams return true else return false. Example Input: str1 = “abcbac” str2 = “aabbcc” Output: true Explanation: Since str2 can be formed by rearranging ...

Read more

Question 942. Contiguous Array Given an array consisting of number 0’s and 1’s only. We have to find the length of the longest contiguous sub-array consisting o’s and 1’s equally. Example Input arr = [0,1,0,1,0,0,1] Output 6 Explanation The longest contiguous sub-array is marked in red [0,1,0,1,0,0,1] and its length is 6. Algorithm Set ...

Read more

Question 943. Union and Intersection of two Linked Lists Given two linked lists, create another two linked lists to get union and intersection of the elements of existing lists. Example Input: List1: 5 → 9 → 10 → 12 → 14 List2: 3 → 5 → 9 → 14 → 21 Output: Intersection_list: 14 → 9 → 5 Union_list:   ...

Read more

Question 944. Lemonade Change Leetcode Solution This post is on Lemonade Change Leetcode Solution Problem statement In the problem ” Lemonade Change” there is a queue of customers. They want to buy lemonade from us which costs 5 rupees. The customers can give us 5 rupees, 10 rupees, or 20 rupees. We want to return the ...

Read more

Question 945. Valid Perfect Square Leetcode Solution This post is on Valid Perfect Square Leetcode Solution Problem statement In the problem “Valid Perfect Square” we are given a number “num” and we need to check if this number is a perfect square or not. We have to check this without using the built-in sqrt function. If the ...

Read more

Question 946. Round Robin Scheduling The Round Robin scheduling is very much similar to FCFS. The only difference between RR and FCFS scheduling is, RR is preemptive scheduling whereas FCFS is non-preemptive scheduling. Every process is allocated to CPU in the ready queue for a single time slice. Here, a ready queue is similar to ...

Read more

Question 947. Maximum number of segments of lengths a, b and c The problem “Maximum number of segments of lengths a, b and c” states that you are given a positive integer N, and you need to find the maximum number of segments of lengths a,b, and c that can be formed using N. Example N = 7 a = 5, b ...

Read more

Question 948. Best Time to Buy and Sell Stock with Cooldown Leetcode Solution Problem statement In the problem “Best Time to Buy and Sell Stock with Cooldown” we are given an array where each element in the array contains the price of the given stock on that day. There is no restriction on the number of transactions. The definition of the transaction is ...

Read more

Question 949. Sequences of given length where every element is more than or equal to twice of previous The problem “Sequences of given length where every element is more than or equal to twice of previous” provides us with two integers m and n. Here m is the largest number that can exist in the sequence and n is the number of elements that must be present in the ...

Read more

Question 950. Count ways to reach the nth stair using step 1, 2 or 3 The problem “Count ways to reach the nth stair using step 1, 2, or 3” states that you are standing on the ground. Now you need to reach the end of the staircase. So how many ways are there to reach the end if you can jump only 1, 2, ...

Read more

Question 951. Find postorder traversal of BST from preorder traversal Problem Statement The problem “Find postorder traversal of BST from preorder traversal” states that you are given preorder traversal of a binary search tree. Then using the given input find the postorder traversal. Example preorder traversal sequence: 5 2 1 3 4 7 6 8 9 1 4 3 2 ...

Read more

Question 952. Count even length binary sequences with same sum of first and second half bits The problem “Count even length binary sequences with same sum of first and second half bits” states that you are given an integer. Now find out the number of ways to construct a binary sequence of size 2*n such that the first half and second half have the same number ...

Read more

Question 953. Print Maximum Length Chain of Pairs Problem Statement The problem “Print Maximum Length Chain of Pairs” states that you are given some pairs of numbers. It is given that in each pair, the first number is smaller than the second number. Now you need to find the longest chain such that the second number of preceding ...

Read more

Question 954. Print n terms of Newman-Conway Sequence Problem Statement The problem “Print n terms of Newman-Conway Sequence” states that you are given an integer “n”. Find the first n terms of Newman-Conway Sequence then print them. Example n = 6 1 1 2 2 3 4 Explanation All the terms which are printed follow the Newman-Conway Sequence ...

Read more

Question 955. Remove Duplicates from Sorted List II The problem “Remove Duplicates from Sorted List II” states that you are given a linked list that may or may not have duplicate elements. If the list has duplicate elements then remove all of their instances from the list. After performing the following operations, print the linked list at the ...

Read more

Question 956. Write a function to get the intersection point of two Linked Lists Problem Statement The problem “Write a function to get the intersection point of two Linked Lists” states that you are given two linked lists. But they are not independent linked lists. They are connected at some point. Now you need to find this point of intersection of these two lists. ...

Read more

Question 957. Newman-Conway Sequence Problem Statement The problem “Newman-Conway Sequence” states that you are given an input integer “n”. Then you need to print first nth element of the Newman-Conway Sequence. Example n = 6 4 n = 10 6 Explanation Since the output elements represent the sixth and tenth element of the Newman-Conway ...

Read more

Question 958. Delete Nth node from the end of the given linked list Problem Statement The problem “Delete Nth node from the end of the given linked list”  states that you are given a linked list with some nodes. And now you need to remove nth node from the end of the linked list. Example 2->3->4->5->6->7 delete 3rd node from last 2->3->4->6->7 Explanation: ...

Read more

Question 959. Print Fibonacci sequence using 2 variables Problem Statement The problem “Print Fibonacci sequence using 2 variables” states that you need to print the Fibonacci sequence but there is a limitation of using only 2 variables. Example n = 5 0 1 1 2 3 5 Explanation The output sequence has the first five elements of the ...

Read more

Question 960. Cutting a Rod Problem Statement The problem “Cutting a Rod” states that you are given a rod of some particular length and prices for all sizes of rods which are smaller than or equal to the input length. That is we know the price for rods of length from 1 to n, considering ...

Read more

Question 961. Largest divisible pairs subset Problem Statement The problem “Largest divisible pairs subset” states that you are given an array of n distinct elements. Find the length of largest such that each pair of the subset has the larger element divisible by smaller elements. Example array = {1, 2, 4, 5, 8, 9, 16} 5 ...

Read more

Question 962. Check if any two intervals overlap among a given set of intervals Problem Statement The problem “Check if any two intervals overlap among a given set of intervals” states that you are given some set of intervals. Each interval consists of two values, one is starting time and the other is ending time. The problem statement asks to check if any of ...

Read more

Question 963. Friends Pairing Problem Problem Statement The “Friends Pairing Problem” states that there are N friends. And each them can remain single or be paired up with each other. But once a pair is made, those two friends can not take part in pairing. So, you need to find the total number of ways ...

Read more

Question 964. Happy Number Problem Statement What is a happy number? A number is a happy number if we can reduce a given number to 1 following this process: -> Find the sum of the square of the digits of the given number. Replace this sum with the old number. We will repeat this ...

Read more

Question 965. Palindrome Number Problem Statement the problem “Palindrome Number” states that you are given an integer number. Check if it is a palindrome or not. Solve this problem without converting the given number into a string. Example 12321 true Explanation 12321 is a palindrome number because when we reverse 12321 it gives 12321 ...

Read more

Question 966. Tiling Problem Problem Statement The “Tiling Problem” states that you have a grid of size 2 x N and a tile of size 2 x 1. So, find the number of ways to tile the given grid. Example 3 2 Explanation: Approach for Tiling Problem We can solve this problem by using recursion. ...

Read more

Question 967. Page Replacement Algorithms in Operating Systems What is Page Replacement? The modern operating systems use paging for memory management and many times there is a need for page replacement. Page replacement is the process of replacing a page that is currently present in the memory with a page that is needed but is not present in ...

Read more

Question 968. Linked List Cycle Problem Statement “Linked List Cycle” problem states that you are given a linked list. Find if it contains any loop or not?  Linked list with cycle Example 1->2->3 No Loop Explanation: The linked list does not contain any loop because if it did then there would’ve been two no des ...

Read more

Question 969. Boolean Parenthesization Problem Problem Statement “ Boolean Parenthesization Problem ” states that we are given a sequence of true and false, and some boolean operators( AND, OR, XOR) in between them. We need to find the number of ways to parenthesize the given sequence such that the entire sequence results in TRUE. In ...

Read more

Question 970. Count pairs from two linked lists whose sum is equal to a given value Problem Statement Problem “Count pairs from two linked lists whose sum is equal to a given value” state that you are given two linked lists and an integer value sum. The problem statement asked to find out how many total pair has a sum equal to the given value. Example ...

Read more

Question 971. How to print maximum number of A’s using given four keys Problem Statement How to print maximum number of A’s using given four keys, this problem states that you have the option to choose which key to press. The keys perform the following tasks: Key1 – Prints ‘A’ on screen Key2 – Select the whole screen. Key3 – Copy the selected ...

Read more

Question 972. Count items common to both the lists but with different prices Problem Statement You are given two lists. Each of which index contains the name of the item and its price. The problem statement asks to count items common to both the lists but with different prices, which is to find out how many numbers of items are common in both ...

Read more

Question 973. A Space Optimized DP solution for 0-1 Knapsack Problem Problem Statement We are given a knapsack which can hold some weight, we need to pick some of the items out of given items with some value. The items should be picked such that the value of the knapsack ( total value of picked up items ) should be maximized. ...

Read more

Question 974. Minimum number of jumps to reach end Problem Statement Suppose you have an array of integers and each element of an array indicates each number as maximum jumps that can be taken from that point. Your task is to find out the minimum number of jumps to reach end, i.e. minimum of jumps that can be taken ...

Read more

Question 975. Huffman Coding We have a message that we want to deliver. We want the message to be of least size possible so that the costs incurred in sending the message is low.  Here we use the Huffman Coding concept to reduce the size of the message. Let’s assume that we have the ...

Read more

Question 976. Data Structure Designing Listening to Data Structure Designing, A lot of people might want to run away looking at the title itself. Those who know me know that I am not leaving until I explain the concept entirely. Embark with me on a journey to learn a problem and a few ideas on ...

Read more

Question 977. Longest Increasing Subsequence We are provided with an array of integers that is unsorted and we have to find the longest increasing subsequence. The subsequence need not be consecutive The subsequence shall be increasing Let’s understand that better by a few examples. Example Input [9, 2, 5, 3, 7, 10, 8] Output 4 ...

Read more

Question 978. K-th Distinct Element in an Array You are given an integer array A, print k-th distinct element in an array. The given array may contain duplicates and the output should print k-th distinct element among all unique elements in an array. If k is more than a number of distinct elements, then report it. Example Input: ...

Read more

Question 979. Swap Nodes In Pairs In swap nodes in pairs problem, we have given a linked list consisting of n nodes. Swap every node at even index with it’s a right adjacent node at odd index() considering index starting from 0. Example Input : 1->2->3->4->NULL Output : 2->1->4->3->NULL Input : 1->2->3->4->5->6->7->NULL Output : 2->1->4->3->6->5->7->NULL Iterative Method Algorithm Create a ...

Read more

Question 980. Intersection of Two Arrays In intersection of two arrays problem, we have given two arrays, we need to print their intersection(common elements). Example Input arr1[] = {1, 2, 2, 1} arr2[] = {2, 2} Output {2, 2} Input arr1 = {4, 9, 5} arr2 = {9, 4, 9, 8, 4} Output {4, 9} Algorithm ...

Read more

Question 981. Leetcode Permutations In this leetcode problem premutation we have given an array of distinct integers, print all of its possible permutations. Examples Input arr[] = {1, 2, 3} Output 1 2 3 1 3 2 2 1 3 2 3 1 3 1 2 3 2 1 Input arr[] = {1, 2, ...

Read more

Question 982. Sudoku Solver In the sudoku solver problem we have given a partially filled (9 x 9) sudoku, write a program to complete the puzzle. Sudoku must satisfy the following properties, Every number(1-9) must appear exactly once in a row and once in a column. Every number(1-9) must appear exactly once in a ...

Read more

Question 983. MiniMax Algorithm Everyone might be wondering. Argh, another new MINIMAX ALGORITHM. Why do we need it? Let’s know to play a game of chess or tic-tac-toe we have often wondered if there was an algorithm to win the game. Explanation A lot of times we might have wondered if It was possible to ...

Read more

Question 984. Target Sum “Target Sum” is a special problem for all the DPHolics I have with me today. There ain’t no need to worry I am going to abandon the rest of my lovely readers. We all have gone through the classic KnapSack problem where we try to find the maximum number of ...

Read more

Question 985. Counting Bits All about Counting Bits! Humans have a problem communicating with the computers they made. Why? Humans speak and understand the language they have come to speak and listen to over the years but they taught the poor computer 0’s and 1’s. So today, Let’s teach our computer to count the ...

Read more

Question 986. Merge K Sorted Linked Lists Merge K sorted linked lists problem is so famous as per the interview point of view. This question asks so many times in big companies like Google, Microsoft, Amazon, etc.  As the name suggests we’ve been provided with k sorted linked lists. We have to merge them together into a ...

Read more

Question 987. OSI Model This model was developed in 1983 by the International Standards Organization (ISO). This was the first step taken to standardized the international protocols used in various layers. As it deals with connecting open systems, that is, systems that are open for communication with other systems, the model is called the ...

Read more

Question 988. Nth Catalan Number In the Nth Catalan number problem, we have given an integer n. Find the first n Catalan numbers. Catalan numbers are a series of positive integers which is seen in many counting problems. They are used to count – BSTs (Binary search trees) with n keys. Certain types of lattice ...

Read more

Question 989. Merge Two Sorted Linked Lists In merge two sorted linked lists we have given head pointer of two linked lists, merge them such that a single linked list is obtained which has nodes with values in sorted order. return the head pointer of the merged linked list. Note: merge the linked list in-place without using ...

Read more

Question 990. Find Median from data Stream In Find Median from the data Stream problem, we have given that integers are being read from a data stream. Find the median of all the elements read so far starting from the first integer till the last integer. Example Input 1: stream[ ] = {3,10,5,20,7,6} Output : 3 6.5 ...

Read more

Question 991. House Robber The House Robber Problem states that, in a neighborhood in a city, there is a single row of n houses. A thief is planning to carry a heist in this neighborhood. He knows how much gold is concealed in each of the houses. However, in order to avoid triggering an ...

Read more

Question 992. Sliding Window Maximum In Sliding Window Maximum problem we have given an array nums, for each contiguous window of size k, find the maximum element in the window. Example Input nums[] = {1,3,-1,-3,5,3,6,7} k = 3 Output {3,3,5,5,6,7} Explanation Naive Approach for Sliding Window Maximum For every contiguous window of size k, traverse ...

Read more

Question 993. Word Break Word Break is a problem that beautifully illustrates a whole new concept. We have all heard of compound words. Words made up of more than two words. Today we have a list of words and all we’ve got to do is check if all the words from the dictionary can ...

Read more

Question 994. Hamming Distance What is Hamming Distance? Hamming distance is Technically defined as the number of bits in the same position that differs in two numbers. Let us delve into a new way of finding the distance between two numbers. Example Input To find the hamming distance between 4 and 14 4 and ...

Read more

Question 995. First Bad Version We all have heard the saying “Bad Apple Ruins The Bunch”.First Bad Version is a problem that beautifully illustrates the same. Today we have a problem which is First Bad Version. One of the interns has made an nth bad commit due to which commits from n+1 have all been ...

Read more

Question 996. Kruskal Algorithm What is Kruskal Algorithm? Kruskal’s algorithm is used to find the minimum spanning tree(MST) of a connected and undirected graph. Example Graph Minimum Spanning Tree(MST) Algorithm Kruskal’s algorithm is a greedy algorithm to find the minimum spanning tree. Sort the edges in ascending order according to their weights. At every ...

Read more

Question 997. Merge Two Sorted Lists Leetcode What is merge two sorted lists problem on leetcode? This is so interesting question asked so many times in compnies like Amazon, Oracle, Microsoft, etc. In this problem(Merge Two Sorted Lists Leetcode), we have given two linked lists. Both linked lists are in increasing order. Merge both linked list in ...

Read more

Question 998. Reverse Nodes in K-Group Problem In Reverse Nodes in K-Group problem we have given a linked list, Reverse the linked list in a group of k and return the modified list. If the nodes are not multiple of k then reverse the remaining nodes. The value of k is always smaller or equal to ...

Read more

Question 999. LRU Cache Implementation Least Recently Used (LRU) Cache is a type of method which is used to maintain the data such that the time required to use the data is the minimum possible. LRU algorithm used when the cache is full. We remove the least recently used data from the cache memory of ...

Read more

Question 1000. Merge Sort What is merge sort? Merge Sort is a Recursive Procedure. It is also a divide and conquers algorithm. Now we need to know what divide and conquer algorithm is? It’s a type of procedure in which we divide the problem into subproblems and divide them until we find the shortest ...

Read more

Question 1001. Valid Sudoku Valid Sudoku is a problem in which we have given a 9*9  Sudoku board. We need to find the given Sudoku is valid or not on the basis of the following rules: Each row must contain the digits 1-9 without repetition. Each column must contain the digits 1-9 without repetition. Every of the 9 3x3 sub-boxes ...

Read more

Question 1002. Palindrome Partitioning Palindrome Partitioning is a DP problem. In this problem, Given a string S. Partition S such that every substring of the partition is a palindrome.  We need to print the minimum cuts needed for a palindrome partitioning of S. Input Format Only a single line containing string S. Output Format ...

Read more

Question 1003. Add two numbers Add two numbers is a problem in which we have given two non-empty linked list representing a non-negative integer. The digit are store in reverse order and every node must contain only a single digit. Add the two numbers and print the result by using a linked list. Input Format ...

Read more

Question 1004. Sieve of Eratosthenes Sieve of Eratosthenes is an algorithm in which we find out the prime numbers less than N. Here N is an integer value. This is an efficient method to find out the prime numbers to a limit. By using this we can find out the prime numbers till 10000000. Here ...

Read more

Question 1005. N queen problem N queen problem using the concept of Backtracking. Here we place queen such that no queen under attack condition. The attack condition of the queens is if two queens are on the same column, row, and diagonal then they are under attack. Let’s see this by the below figure. Here ...

Read more

Question 1006. Alien Dictionary Alien Dictionary is a type of problem in which we have N-words and they are sorted in alien dictionary order. We need to find the order of the characters. The alien language is also used the lowercase letters but the order of the letters is different. Let’s see how we ...

Read more

Question 1007. Last Stone Weight Last Stone Weight is a problem in which we have a set of stones having some positive weights. Now we perform a task on it till we left 1 stone or no stone. We always pick two stones having the highest weight_value and smash them together. Let’s suppose the weight ...

Read more

Question 1008. Climbing stairs Problem Statement The problem “Climbing stairs” states that you are given a staircase with n stairs. At a time you can either climb one stair or two stairs. How many numbers of ways to reach the top of the staircase? Example 3 3 Explanation There are three ways to climb ...

Read more

Question 1009. Serialize and Deserialize Binary Tree We have given a binary tree containing N number of nodes where each node has some value. We need to serialize and deserialize the binary tree. Serialize The process of storing a tree in a file without disturbing its structure is called serialization. DeserializeSerialize and Deserialize Binary Tree The process ...

Read more

Question 1010. Reverse a linked list Problem Statement The problem “reverse a linked list” states that we are given the head of the linked list. We have to reverse the linked list by changing the links between them and return the head of the reversed linked list. Example 10->20->30->40->NULL NULL<-10<-20<-30<-40 Explanation We have reversed the linked ...

Read more

Question 1011. Maximum Length of Chain Pairs Problem Statement In the maximum length of chain pairs problem we have given n pairs of numbers, find the longest chain in which (c, d) can follow (a, b) if b < c. In the given pairs the first element is always smaller than the second.  Example Input [{12, 14}, ...

Read more

Question 1012. Find Pair with Given Difference Problem Statement In the given unsorted array, find the pair of elements in the given array with given difference n. Example Input arr[] = {120, 30, 70, 20, 5, 6}, difference(n) = 40 Output [30, 70] Explanation Here the difference of 30 and 70 is equal to the value of ...

Read more

Question 1013. Detect a loop in the Linked List Problem Statement In the “Detect a loop in the Linked List” problem we have given a linked list. Find whether there is loop or not. If there is a loop in the linked list then some node in the linked list will be pointing to one of the previous nodes ...

Read more

Question 1014. Find Nth Node Problem Statement In the “Find Nth Node” problem we have given a linked list to find the nth node. The program should print the data value in the nth node. N is the input integer index. Example 3 1 2 3 4 5 6 3 Approach Given a linked list ...

Read more

Question 1015. Swap Kth Node from beginning with Kth Node from End Problem Statement In the “Swap Kth Node from beginning with Kth Node from End” problem, we have given a linked list. Swap kth node from beginning_with kth node from the end. We should not swap the values, we should swap pointers. Example 2 1 2 3 4 5 6 1 ...

## bmware

second round

#Decorator pattern in python
multi argument pass in function 
conditional increment of counter depending on parameterized function call
via using dictionary or HashMap.

Implement Stack O(1) operations of push pop, top and min.

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


## toracle

1. variation of meeting room ||
2. https://leetcode.com/problems/decode-string/
Given an encoded string, return its decoded string.

The encoding rule is: k[encoded_string], where the encoded_string inside the square brackets is being repeated exactly k times. Note that k is guaranteed to be a positive integer.

You may assume that the input string is always valid; there are no extra white spaces, square brackets are well-formed, etc. Furthermore, you may assume that the original data does not contain any digits and that digits are only for those repeat numbers, k. For example, there will not be input like 3a or 2[4].

The test cases are generated so that the length of the output will never exceed 105.

 

3. duplicate remove from array inplace
4. op:{"Friend", "Friend", "Friend","Total"}
arr1 {1,2,3, 1}
arr2 {2,3,4, 5}

result = 4+1 = 5




https://leetcode.com/discuss/interview-question/460599/Blind-75-LeetCode-Questions 
## Array

- [x] [Two Sum](https://leetcode.com/problems/two-sum/)
- [x] [Best Time to Buy and Sell Stock](https://leetcode.com/problems/best-time-to-buy-and-sell-stock/)
- [x] [Contains Duplicate](https://leetcode.com/problems/contains-duplicate/)
- [x] [Product of Array Except Self](https://leetcode.com/problems/product-of-array-except-self/)
- [x] [Maximum Subarray](https://leetcode.com/problems/maximum-subarray/)
- [x] [Maximum Product Subarray](https://leetcode.com/problems/maximum-product-subarray/)
- [x] [Find Minimum in Rotated Sorted Array](https://leetcode.com/problems/find-minimum-in-rotated-sorted-array/)
- [x] [Search in Rotated Sorted Array](https://leetcode.com/problems/search-in-rotated-sorted-array/)
- [x] [3Sum](https://leetcode.com/problems/3sum/)
- [x] [Container With Most Water](https://leetcode.com/problems/container-with-most-water/)

---

## Binary

- [ ] [Sum of Two Integers](https://leetcode.com/problems/sum-of-two-integers/)
- [ ] [Number of 1 Bits](https://leetcode.com/problems/number-of-1-bits/)
- [ ] [Counting Bits](https://leetcode.com/problems/counting-bits/)
- [ ] [Missing Number](https://leetcode.com/problems/missing-number/)
- [ ] [Reverse Bits](https://leetcode.com/problems/reverse-bits/)

---

## Dynamic Programming

- [ ] [Climbing Stairs](https://leetcode.com/problems/climbing-stairs/)
- [ ] [Coin Change](https://leetcode.com/problems/coin-change/)
- [ ] [Longest Increasing Subsequence](https://leetcode.com/problems/longest-increasing-subsequence/)
- [ ] [Longest Common Subsequence](https://leetcode.com/problems/longest-common-subsequence/)
- [ ] [Word Break Problem](https://leetcode.com/problems/word-break/)
- [ ] [Combination Sum](https://leetcode.com/problems/combination-sum-iv/)
- [ ] [House Robber](https://leetcode.com/problems/house-robber/)
- [ ] [House Robber II](https://leetcode.com/problems/house-robber-ii/)
- [ ] [Decode Ways](https://leetcode.com/problems/decode-ways/)
- [ ] [Unique Paths](https://leetcode.com/problems/unique-paths/)
- [ ] [Jump Game](https://leetcode.com/problems/jump-game/)

---

## Graph

- [ ] [Clone Graph](https://leetcode.com/problems/clone-graph/)
- [ ] [Course Schedule](https://leetcode.com/problems/course-schedule/)
- [ ] [Pacific Atlantic Water Flow](https://leetcode.com/problems/pacific-atlantic-water-flow/)
- [ ] [Number of Islands](https://leetcode.com/problems/number-of-islands/)
- [ ] [Longest Consecutive Sequence](https://leetcode.com/problems/longest-consecutive-sequence/)
- [ ] [Alien Dictionary (Leetcode Premium)](https://leetcode.com/problems/alien-dictionary/)
- [ ] [Graph Valid Tree (Leetcode Premium)](https://leetcode.com/problems/graph-valid-tree/)
- [ ] [Number of Connected Components in an Undirected Graph (Leetcode Premium)](https://leetcode.com/problems/number-of-connected-components-in-an-undirected-graph/)

---

## Interval

- [ ] [Insert Interval](https://leetcode.com/problems/insert-interval/)
- [ ] [Merge Intervals](https://leetcode.com/problems/merge-intervals/)
- [ ] [Non-overlapping Intervals](https://leetcode.com/problems/non-overlapping-intervals/)
- [ ] [Meeting Rooms (Leetcode Premium)](https://leetcode.com/problems/meeting-rooms/)
- [ ] [Meeting Rooms II (Leetcode Premium)](https://leetcode.com/problems/meeting-rooms-ii/)

---

## Linked List

- [x] [Reverse a Linked List](https://leetcode.com/problems/reverse-linked-list/)
- [x] [Detect Cycle in a Linked List](https://leetcode.com/problems/linked-list-cycle/)
- [x] [Merge Two Sorted Lists](https://leetcode.com/problems/merge-two-sorted-lists/)
- [x] [Merge K Sorted Lists](https://leetcode.com/problems/merge-k-sorted-lists/)
- [x] [Remove Nth Node From End Of List](https://leetcode.com/problems/remove-nth-node-from-end-of-list/)
- [x] [Reorder List](https://leetcode.com/problems/reorder-list/)

---

## Matrix

- [ ] [Set Matrix Zeroes](https://leetcode.com/problems/set-matrix-zeroes/)
- [ ] [Spiral Matrix](https://leetcode.com/problems/spiral-matrix/)
- [ ] [Rotate Image](https://leetcode.com/problems/rotate-image/)
- [ ] [Word Search](https://leetcode.com/problems/word-search/)

---

## String

- [ ] [Longest Substring Without Repeating Characters](https://leetcode.com/problems/longest-substring-without-repeating-characters/)
- [ ] [Longest Repeating Character Replacement](https://leetcode.com/problems/longest-repeating-character-replacement/)
- [ ] [Minimum Window Substring](https://leetcode.com/problems/minimum-window-substring/)
- [ ] [Valid Anagram](https://leetcode.com/problems/valid-anagram/)
- [ ] [Group Anagrams](https://leetcode.com/problems/group-anagrams/)
- [ ] [Valid Parentheses](https://leetcode.com/problems/valid-parentheses/)
- [ ] [Valid Palindrome](https://leetcode.com/problems/valid-palindrome/)
- [ ] [Longest Palindromic Substring](https://leetcode.com/problems/longest-palindromic-substring/)
- [ ] [Palindromic Substrings](https://leetcode.com/problems/palindromic-substrings/)
- [ ] [Encode and Decode Strings (Leetcode Premium)](https://leetcode.com/problems/encode-and-decode-strings/)

---

## Tree
- [x] [Maximum Depth of Binary Tree](https://leetcode.com/problems/maximum-depth-of-binary-tree/)
- [x] [Same Tree](https://leetcode.com/problems/same-tree/)
- [x] [Invert/Flip Binary Tree](https://leetcode.com/problems/invert-binary-tree/)
- [ ] [Binary Tree Maximum Path Sum](https://leetcode.com/problems/binary-tree-maximum-path-sum/)
- [x] [Binary Tree Level Order Traversal](https://leetcode.com/problems/binary-tree-level-order-traversal/)
- [ ] [Serialize and Deserialize Binary Tree](https://leetcode.com/problems/serialize-and-deserialize-binary-tree/)
- [x] [Subtree of Another Tree](https://leetcode.com/problems/subtree-of-another-tree/)
- [ ] [Construct Binary Tree from Preorder and Inorder Traversal](https://leetcode.com/problems/construct-binary-tree-from-preorder-and-inorder-traversal/)
- [ ] [Validate Binary Search Tree](https://leetcode.com/problems/validate-binary-search-tree/)
- [ ] [Kth Smallest Element in a BST](https://leetcode.com/problems/kth-smallest-element-in-a-bst/)
- [ ] [Lowest Common Ancestor of BST](https://leetcode.com/problems/lowest-common-ancestor-of-a-binary-search-tree/)
- [ ] [Implement Trie (Prefix Tree)](https://leetcode.com/problems/implement-trie-prefix-tree/)
- [ ] [Add and Search Word](https://leetcode.com/problems/add-and-search-word-data-structure-design/)
- [ ] [Word Search II](https://leetcode.com/problems/word-search-ii/)

---

## Heap

- [ ] [Merge K Sorted Lists](https://leetcode.com/problems/merge-k-sorted-lists/)
- [ ] [Top K Frequent Elements](https://leetcode.com/problems/top-k-frequent-elements/)
- [ ] [Find Median from Data Stream](https://leetcode.com/problems/find-median-from-data-stream/)

## Important Link:
[14 Patterns to Ace Any Coding Interview Question](https://hackernoon.com/14-patterns-to-ace-any-coding-interview-question-c5bb3357f6ed)
Facebook | System Design | A web crawler that will crawl Wikipedia

We need to deploy the same software on each node. We have 10,000 nodes, the software can know about all the nodes. We have to minimize communication and make sure each node does equal amount of work.

Encountered this question in facebook.

My solution:
Intial Proposal:
Start out with the root page, and based on a hash function decide if that page is for you (the node) or not.

What if one node fails or does not work?
When encountering a page, ping to see whether the node handling that page is online, if not use a secondary hash function to determine alternate handler. If you are the alternate handler, handle the page, if not ping to see if the alternate handler is online. Do this for al hash functions you decide to have, more hash functions means less impact by failure of one node.

How do you know when the crawler is done?
Pass around a timestamp of the last crawled page. If the timestamp gets back to you without changing, then you are done.


In a System design question, understand the scope of the problem and stay true to the original problem.
The scope was to design a web crawler using available distributed system constructs and NOT to design a distributed database or a distributed cache.

A Web crawler system design has 2 main components:

    The Crawler (Write path)
    The Indexer (Read path)

Make sure you ask about expected number of URLs to crawl (Write QPS) and expected number of Query API calls (Read QPS).
Make sure you ask about the SLA for the Query API. If its in tens of milliseconds at say 90 percentile, you'll probably need to cache the query results and can we use a messaging queue like SQS?

Begin with these high level components, then break them down into smaller sub-components, then connect these to form a coherent whole.

Crawler

    For crawling you need a "seed of URLs" to begin the crawling. You'd want to put the URLs in a queue.
    The queue workers would work on one URL at a time. Each queue worker, given a URL has to:
    **Extract text from the URL and send it to a Document Indexing Service .
    **Insert any links found in the page back into the queue. Before inserting, the links are looked up (and stored) in a Global NoSql store, to ensure they weren't already crawled. We use a NoSql store (and not a SQL Database) because we're doing lookup operations only and don't require expensive joins.

Eventually the queue will become empty. At this point, the "seeder" will reseed the queue with seed URLs and the whole process restarts.

Scaling up the crawler (only if the websites to crawl are in billions):

    Your queue could be a distributed message queue (such as SQS or Azure ServiceBus).
    Your NoSql store could be DynamoDB.

The interviewer would most likely know that both message queues and NoSql stores maintain replicas (typically master-slave replication) for fault tolerance and re-partition themselves via an algorithm like consistent hashing for scalability.
All distributed queues have a Visibility Timeout i.e. when an element is dequeued, it still remains in the queue but is made invisible to other dequeue requests till Visibility Timeout seconds have elapsed. A worker that is handling the dequeued element must explicitly delete it from the queue before Visibility Timeout seconds.

Challenges for Crawler:

    How would you handle throttling from your NoSql store (say because you have too many crawlers attempting to lookup and write URLS to it)? If you try an exponential retry algorithm in your worker, your message queue may release the URL being already crawled to another worker.
    How would you handle dead links? You'd probably want to maintain a blacklist of links that returned 404 so that your workers don't put these in crawler queue the next time around.
    How do you handle crawling of temporarily offline websites. Assume that your worker connected to the website but it took 40 seconds to respond with 503 but by that time, your message queue already released the same URL to another worker who'd attempt to reconnect to the same website and suffer from the same fate.
    How would you handle websites that failed to get crawled? You'd probably want to store them in a Dead Letter Queue to be inspected later.
    Would you respect Robots.txt files while crawling? Maybe you could store the domain name + /* of such sites in the Blacklist NoSql Store.
    How would you throttle requests from your crawlers running in parallel to different pages on a single website (like Wikipedia). Maybe a message queue is not a right fit in this design? You could probably use a Streaming queue (like Kafka/Kinesis Streams/ Azure EventHub) where the domain name of the URL is the partition key. This means that all sub-URLs within a domain will be handled by one worker only. But this leads to obvious load balancing issues. Alternatively, you could invest in a Rate Limiter that ensures that one worker does not open more than n connections to a single website. But what is a good value of n? Wikipedia can probably handle thousands of concurrent connections but a small company's website could cave in. So the value on n depends on the domain being crawled and will need tweaking via trial and error. Which means you'll need another NoSql store that stores domain names and n which the RateLimiter will need to cache when doing the rate limiting. Next question: what should the worker do if the Rate Limiter disallowed it from accessing the URL? Should it keep retrying? If yes, what if the message queue releases the same URL to another worker? It makes sense for the worker to drop it and go for the next URL in the queue. This will cause the message queue to release this current URL to another worker after Visibility Timeout seconds, and that worker might have a higher chance of succeeding. But what if the next URL is also of the same domain?

All in all, you should also discuss what logs/metrics you'd emit and how these are analyzed to make the crawling better. Some metrics to emit would be how many times a worker was rate limited, latency of every operation (such as reading entire contents a URL, time taken for ranking the text, indexing it etc.). For websites that caved in or were unresponsive etc, apart from the metrics, you'd also write them in special log files which are then machine learned to produce the Blacklist NoSql store or to recompute the number of connections for a domain to be used by the Rate Limiter.

Indexer

    You'll need a Document Indexing Service that does 2 things on its write path:
    ** Insert the URL and its text into another NoSql store. This will be used for showing cached copies in case the original URLis unavailable or is dead. But what if the text is huge? In that case, it makes sense to store the text instead in an Object/Blob Store like S3/Azure Blob Storage under a key which is the hash of the URL.
    ** Maintain a Reverse Index that maps keywords/phrases in the text back to the original URL. You can use a Reverse Index database like Elastic Search.

The Document Indexing Service also exposes a query API that takes as input, a phrase + number of results (i.e. page size) to return. It would then break the phrase into keywords, remove "Stop words" (words like the, a, an etc), correct spelling mistakes in the keywords, add synonyms of certain keywords and then call into Elastic Search to return the URLs that contain these keywords. Elastic Search has plugins which already do spelling corrections, stop word removal etc. The URLs could then be fed into a Ranking service that ranks the URL before returning. If your Read QPS is higher than Write QPS, a better approach would be to do the ranking via an hourly offline process and store the rank in Elastic Search. That would speed up the querying path as you'd skip ranking and instead ask Elastic Search to return URLs sorted by rank. This also makes it easy to paginate as the first page will contain the top n results, the next page will contain the next n results etc. The hourly offline ranker would need what are called as "Clickstream logs" to figure out which links are being clicked more often so as to rank them higher.

The query API must also return a pagination token to allow the caller to continue retrieving more pages

Challenges for Indexer:

    Can we speed up the read path by maintaining a cache for most commonly queried phrases? The 80/20 rule states that 80% of users query the same 20% phrases. If so, what caching strategy to use? LRU/TTL? Should we go with a write through cache so that the crawler directly updates the cache? Or a cache-aside strategy where the cache is bypassed by the crawlers when they write to the Document Service? In that case, what TTL value would be appropriate for the cache?
    What kind of distributed cache would we use? Redis/memcached? Only if asked, you can mention about consistent hashing here.

That's about it...No consistent hashing/zookeeper etc required.

--> This is decent design. But will only get you to E3 at FB. This question as asked at FB, is about bringing out your distributed systems knowledge. Interviewer will cut short this discussion with one question/requirement after the first 5 mins - By introducing many components into system such as sqs, dynamo, s3 you have to allocate capacity to each of these components. How would decide which component needs more capacity ? what if many nodes of one type(say sqs) go down ? Will you pull some dynamo nodes and install sqs on them ? Do you see the problem here ? Each set of nodes has some specialized function, which makes it difficult to scale. If the nodes are homogenous, you can scale very easily. Read the first line - "We need to deploy the same software on each node"


Alternative:

Based on just the description of problem, I would say we dont even have to distinguish between crawling and indexing - each node has to do both !
I would design the system as:

Hash out Nodes into 2000 groups of 5 nodes each. Assuming wikipedia has 100 million URLs that need to be traversed.
Each node needs to process - 10k URLs (100 mill/10k nodes).
Now seed each of the 2k groups using some hash API. Use a 2nd level hash to still assign seeds within groups.
Let each node crawl for (say) 100 URLs (just build a list of 100 URLs, no indexing yet).
To avoid duplication, there is a central authority - Master per group which determines if worker node should go ahead indexing the data or not (I know I am assigning more work for this node, but i expect master to be rotating role between 5 nodes within group).
Each node generates a 6 byte hash of URL , and send 1000*6 = 6KB worth of data to master.
Assuming it takes 1 second to build 100 URL list(10 ms to open 1 URL and process it, 100X10ms = 1sec), each node would be sending 6KB/second.
Every second master node would receive (4nodes *6KB)24KB worth of data.
Master would do comparison between the hashes and remove duplicates from these lists and send the result back to each nodes.
With the now confirmed unique URLs - each node would go ahead and index the data (in some central DB?? )

As each node is responsible for only 10k URLs, entire wikipedia would be indexed in roughly 100 seconds.

Update:
De-duplication of URLs need to be done between groups as well. Continuing the same patten - each group-master node would send group hashed URLs to a central server. This server again would be a floating role and can be taken by some other node in next iteration.
So the cluster master would require - 30KB*2K clusters = 60MBps bandwidth.
Typical home network provide speed at 20MBps. Thus master server would take 3(60/20) seconds to collect all data.
And this needs to be done 100 times.
Thus in-total 300 seconds for master level de-duplication.
Thus total time taken at high level 100+300 seconds = ~7 minutes.

I see that in current shape, my design has single point of failure at master node.
I would say that 2000 groups could be divided into smaller super-groups which perform de-dup before reaching out to master node.
This will remove single point of failure and provide redundancy to architecture at the cost of increasing total scanning time.
But I believe we could still do the scanning with multiple-hierarchies in roughly under 20 minutes (by extrapolating above calculations).

Even if we use consistent-hashing, the question is how would all servers know about the updated list of servers? In case for example services are failing or being added? This can be achieved by either updating the list manually and redeploying to each server or using a centralized piece, e.g. ZK.
Then, if we use a centralized service, such as ZK, we can leverage it to know when all are done. Same as all are periodically sending heartbeat to ZK, they will also update once they're done. Once all are done, we know we're done.
Another approach - is that we do not care about services that fail and that no new servers are added. We can then treat it naively and assume that client library will direct to the next server in the consistent hash ring. BUT this will not provide full balance between all AND we will not know when we're done.

're on the right track regarding "Clickstream" logs. Essentially search engines like Google log which links from the search page you clicked. There are techniques for them to find out the "dwell time" (i.e. how long you stayed on the link you clicked) as well. The "dwell time" allows Google to figure out how relevant the link is to the keywords that were searched. If the link was clicked by mistake or is irrelevant you're likely to close the web page quickly and return to the Search page. Otherwise you'll dwell on that page for quite some time.

This information (keywords you typed + links you clicked + dwell time) is then fed into the *Ranker *. If the Ranker notices that many users are clicking the third link in the Search Query result for a set of keywords, and the "dwell time" is high, it will rank it higher. Eventually the most "relevant" link would be on top. At least that's the hope. Of course, Google's ranking looks at various other signals (many of them are proprietary secrets) but that's the gist. I'm guessing they also use your Google user name (if you're logged in) or your IP address to make the search results more of your taste ("personalization"). Ranking + personalization is a phenomenally complex problem and apart from ML algorithms, requires a large amount of user clickstream data to constantly train the AI to keep making it better. This large amount of user data gives Google the edge over other search engines like Bing, specially for unusual queries.


https://boston.lti.cs.cmu.edu/callan/Workshops/dir03/PapersPublished/singh.pdf

https://github.com/donnemartin/system-design-primer/blob/master/solutions/system_design/web_crawler/README.md
Design a simple model of Facebook where people can add other people as friends. In addition, where people can post messages and that messages are visible on their friend's page. The design should be such that it can handle 10M of people. There may be, on an average 100 friends each person has. Every day each person posts around 10 messages on an average.

Use Case

    A user can create their own profile.
    A user can add other users to his friend list.
    Users can post messages to their timeline.
    The system should display posts of friends to the display board/timeline.
    People can like a post.
    People can share their friends post to their own display board/timeline.

Constraints

    Consider a whole network of people as represented by a graph. Each person is a node and each friend
    relationship is an edge of the graph.
    Total number of distinct users / nodes: 10 million
    Total number of distinct friend’s relationship / edges in the graph: 100 * 10 million
    Number of messages posted by a single user per day: 10
    Total number of messages posted by the whole network per day: 10 * 10 million

Basic Design

Our system architecture is divided into two parts:

    First, the web server that will handle all the incoming requests.
    The second database, which will store the entire person's profile, their friend relations and posts.

First, three requirements creating a profile, adding friends, posting messages are written some information
to the database. While the last operation is reading data from the database.

The system will look like this:

    Each user will have a profile.
    There will be a list of friends in each user profile.
    Each user will have their own homepage where his posts will be visible.
    A user can like any post of their friend and that likes will reflect on the actual message shared by his
    friend.

If a user shares some post, then this post will be added to the user home page and all the other friends of
the user will see this post as a new post.

Bottleneck

A number of requests posted per day is 100 million. Approximate some 1000 request are posted per
second. There will be an uneven distribution of load so the system that we will design should be able to
handle a few thousand requests per seconds.

Scalability

Since there is, a heavy load we need horizontal scaling many web servers will be handling the requests.
In doing this we need to have a load balancer, which will distribute the request among the servers.
This approach gives us a flexibility that when the load increases, we can add more web servers to handle
the increased load.
These web servers are responsible for handling new post added by the user. They are responsible for
generating various user homepage and timeline pages. In our case, the client is the web browser,
which is rendering the page for the user.

We need to store data about user profile, Users friend list, User-generated posts, User like statues to the
posts.
Let us find out how much storage we need to store all this data. The total number of users 10 million. Let
us suppose each user is using Facebook for 5 to 6 years, so the total number of posts that a user had
produced in this whole time is approximately 20,000 million or 20 billion. Let us suppose each message
consists of 100 words or 500 characters. Let us assume each character take 2 bytes.

Total memory required = 20 * 500 * 2 billion bytes.
= 20,000 billion bytes
= 20, 000 GB
= 20 TB
1 gigabyte (GB) = 1 billion bytes
1000 gigabytes (GB) = 1 Terabytes 

Most of the memory is taken from the posts and the user profile and friend list will take nominal as
compared with the posts. We can use a relational database like SQL to store this data. Facebook and
twitter are using a relational database to store their data.

Responsiveness is key for social networking site. Databases have their own cache to increase their
performance. Still database access is slow as databases are stored on hard drives and they are slower
than RAM. Database performance can be increased by replication of the database. Requests can be
distributed between the various copies of the databases.

Also, there will be more reads then writes in the database so there can be multiple slave DB which are
used for reading and there can be few master DB for writing. Still database access is slow to we will use
some caching mechanism like Memcached in between application server and database. Highly popular
users and their home page will always remain in the cache.

There may be the case when the replication no longer solves the performance problem. In addition, we
need to do some Geo-location based optimization in our solution.
Again, look for a complete diagram in the scalability theory section.
If it were asked in the interview how you would store the data in the database. The schema of the
database can look like:

Table Users:

1. User Id
2. First Name
3. Last Name
4. Email
5. Password
6. Gender
7. DOB
8. Relationship

Table Posts:

1. Post Id
2.  Author Id
3.  Date of Creation
4.  Content

Table Friends:

1. Relation Id
2. First Friend Id
3. Second Friend Id

Table Likes:

1. Id
2. Post Id
3. User Id


------------------------------------------------------------
------------------------------------------------------------

Design Facebook

Requirements:
Add Friend
Post messages and show on friends timeline
10M users
Avg 100 friends of each user
Avg 10 messages/day each user

Use Case:
1. create user profile - write to DB
2. add other users as friends - write to DB
3. post messages on my timeline - write to DB
4. on newsfeed show friends posts - read to DB
5. like post - write
6. Share post - write

Constraints:
nodes: 10M
edges: 100*10M
posts: 10*10M/day

Basic Design:
1. Web servers for handling incoming requests
2. DataBase to store profiles, friends-list, posts

Profile(friendsList, timeline)
Likes visible on post
Share post - show on friends timeline as new post

Bottleneck:(Read Heavy)
Write requests/day: 100M/day ==> 1000 req/sec
Read requests/day: 10*100*10 ==> 10000M/day

Scalability:
Horizontal Scaling
LoadBalancer

Databases:
Store: Profile, FriendsList, Posts, Likes
Time: 5-6 years of 
10M users     
Total Posts: 5*365=2000 days * 100M/day = 200B posts
Each message: 100 or 500 chars
Bytes/char = 2
Total Storage = 200*500*2 B bytes = 200000 BBytes
= 200000GB = 200TB for posts

SQL DB
DB caches, DB repication
Master DB - write
Slave DB - read
Memory Cache - Memcache b/w application and Database
(Memcache used for Popular/trending profiles/post)



how to present to users the timeline (newsfeed generation for your friends). If also this was a key point of the interview you should talk a little about it. It's obvious that you cannot generate news feed on the fly when users connect, it would be too slow.
One solution is to have some worker jobs which asynchronously generates the news feed for each user and cache them (scheduled once a day).
Then a new issue pop up: you would like to have a more responsive system instead of wait one day to have the updates. The solution is to have a queue (probably multiple of them) where you keep track of the news feed to be updated based on the friends list of the users which post messages: when you post a message you also trigger the generation of the news feed for your friends.
Then again a new issue pop up: what's about celebrities which has a lot of friends? One possible approach could be to rank their friends based on the frequency that they are accessing to Facebook home page and trigger only frequent users, updating the other users news feed using only the scheduled job.



trickiest parts of FB are how serve up the data at scale. For example, user A is very popular and is cached. They make updates to their account that they want someone to see asap, like a new profile pic. How does this work? Can we hit your target of ~1000 TPS with this in mind? Why or why not?

shard the mysql DB by last name, therefore giving you the perf you need, if needed.
You could also say you use write through caching, where writes populate the cache with updated information.

Another huge glaring issue is pagination and their "user feed" system. That home screen, where you load everyone's posts, pages and updates is a critical component of how FB is designed. Figuring that out, and designing something that feeds you almost endless amount of information is a big challenge.

 use a FanOut Service or an Aggregator which technically keeps records of all ur posts and based on ur number of friends add to their list based on timestamp. So every time , ur friend's list has all list of recent posts sorted in timestamp by the his friend circles. And for for a famous celebrity post always append it at top at last if they post anything.
Its just a simple vague idea so that you can search on it and read more.



Actually the core component in facebook design is handling the friends list and timeline generation I believe. How can we handle these efficiently is a plus point.

    Like what data structure can be used to save relationship and which kind of db is well suited(sql, nosql etc).
    Also for timeline generation , If asynchronous queue can be used for pushing post to friends list since user can see notification immediately about his post but it is okay if system takes time to propagate post to a friends list.
    Also the caching criteria like instead of caching highly popular user and its homepage(Which will be needed frequently only if user logins frequently), I would like to cache 10% of the popular posts since it will be seen by many users.(Using LRU policy for cache eviction).




1. Phone Screen:

    https://leetcode.com/problems/find-all-anagrams-in-a-string/
    A string / array problem involving distinct characters and window
    https://leetcode.com/problems/shortest-bridge/
    https://leetcode.com/problems/partition-equal-subset-sum/
    https://leetcode.com/problems/valid-palindrome-ii/
    https://leetcode.com/problems/kth-smallest-element-in-a-bst/
    You are given a mn grid. You are asked to generate k mines on this grid randomly. Each cell should have equal probability of k / mn of being chosen. Your algorithm should run in O(m) time.
    https://leetcode.com/problems/continuous-subarray-sum/
    (Given a list of positive numbers and a target integer k, write a function to check if the array has a continuous subarray which sums to k.)
    https://leetcode.com/problems/verifying-an-alien-dictionary/
    https://leetcode.com/problems/alien-dictionary/
    https://leetcode.com/problems/course-schedule/
    https://leetcode.com/problems/interval-list-intersections/
    https://leetcode.com/problems/minimum-remove-to-make-valid-parentheses/
    https://leetcode.com/problems/plus-one/
    https://www.***.org/find-index-maximum-occurring-element-equal-probability/***
    https://leetcode.com/problems/range-sum-of-bst/
    Similar strings ("face", "eacf") returns true if only 2 positions in the strings are swapped. Here 'f' and 'e' are swapped in the example.
    https://leetcode.com/problems/number-of-connected-components-in-an-undirected-graph
    https://leetcode.com/problems/add-binary/
    Given two binary search trees how do we merge everything so it prints inorder. The answer I gave was to run inorder on both trees and use "merge" from merge-sort.
    https://leetcode.com/problems/valid-palindrome
    https://leetcode.com/problems/add-strings
    https://leetcode.com/problems/serialize-and-deserialize-binary-tree/
    https://leetcode.com/problems/lowest-common-ancestor-of-a-binary-tree
    https://leetcode.com/problems/smallest-subtree-with-all-the-deepest-nodes/
    https://leetcode.com/problems/binary-tree-paths
    https://leetcode.com/problems/minimum-window-substring
    How to remove duplicates from a list
    https://leetcode.com/problems/maximum-subarray
    https://leetcode.com/problems/valid-parentheses
    https://leetcode.com/problems/merge-intervals
    https://leetcode.com/problems/task-scheduler/
    https://leetcode.com/problems/clone-graph/

2. Coding Round 1:

    https://leetcode.com/problems/insert-interval/
    https://leetcode.com/problems/convert-a-number-to-hexadecimal/
    https://leetcode.com/problems/rotate-array/
    https://leetcode.com/problems/k-closest-points-to-origin/
    https://leetcode.com/discuss/interview-question/124759/
    https://leetcode.com/problems/product-of-array-except-self
    https://leetcode.com/problems/find-all-anagrams-in-a-string/
    https://leetcode.com/problems/minimum-window-substring/
    https://leetcode.com/problems/closest-binary-search-tree-value/
    https://leetcode.com/problems/insert-delete-getrandom-o1/
    https://leetcode.com/problems/fraction-to-recurring-decimal/
    https://leetcode.com/problems/powx-n
    https://leetcode.com/problems/subarray-sum-equals-k
    https://leetcode.com/problems/best-time-to-buy-and-sell-stock
    https://leetcode.com/problems/best-time-to-buy-and-sell-stock-iii
    https://leetcode.com/problems/best-time-to-buy-and-sell-stock-iv
    https://leetcode.com/problems/add-and-search-word-data-structure-design
    https://leetcode.com/problems/sudoku-solver/
    https://leetcode.com/discuss/interview-question/338948/Facebook-or-Onsite-or-Schedule-of-Tasks
    https://leetcode.com/problems/binary-tree-maximum-path-sum
    https://leetcode.com/problems/maximum-subarray
    https://leetcode.com/problems/move-zeroes
    https://leetcode.com/problems/valid-number
    https://leetcode.com/problems/first-bad-version/

3. Coding Round 2:

    https://leetcode.com/problems/valid-number/
    You have an API to check if is it possible to move left, right, up, down and one more method to check if current position is the last one. Find the shortest way to the last position. You don't have any data structure - only API.
    https://leetcode.com/problems/serialize-and-deserialize-binary-tree/
    https://leetcode.com/problems/group-shifted-strings/
    https://leetcode.com/problems/task-scheduler/
    Calculate tax if Salary and Tax Brackets are given as list in the form
    [ [10000, 0.3],[20000, 0.2], [30000, 0.1], [null, .1]]
    null being rest of the salary
    Is there a way to reach (0,0) from a mXn matrix to (m-1,n-1) position and give the path.
    https://leetcode.com/problems/simplify-path/
    n-ary Tree with each node having a boolean flag. Traverse all the nodes with only boolean flag = True. Return the total distance traveled from root to all those nodes.
    https://leetcode.com/problems/product-of-array-except-self/
    https://leetcode.com/discuss/interview-question/432086/Facebook-or-Phone-Screen-or-Task-Scheduler/394783
    https://leetcode.com/problems/find-all-anagrams-in-a-string
    https://leetcode.com/problems/is-graph-bipartite
    https://leetcode.com/problems/merge-sorted-array
    https://leetcode.com/problems/maximum-subarray
    https://leetcode.com/problems/serialize-and-deserialize-binary-tree
    https://leetcode.com/problems/remove-invalid-parentheses/
    https://leetcode.com/problems/subarray-sum-equals-k/
    https://leetcode.com/problems/binary-tree-level-order-traversal/
    https://leetcode.com/problems/longest-increasing-path-in-a-matrix/
    https://leetcode.com/problems/custom-sort-string
    https://leetcode.com/problems/read-n-characters-given-read4
    https://leetcode.com/problems/remove-invalid-parentheses
    https://leetcode.com/problems/palindrome-permutation
    https://leetcode.com/problems/max-consecutive-ones-iii
    https://leetcode.com/problems/range-sum-of-bst
    https://leetcode.com/problems/exclusive-time-of-functions
    https://leetcode.com/problems/search-in-rotated-sorted-array/
    https://leetcode.com/problems/search-in-rotated-sorted-array-ii/

4. Design:

    Design Google search
    Some question related to caching and balancing. Not exactly the "design twitter" type of question, but expect to talk about different components, latency, throughput, consistency and availability.
    A remote server is not responding. Debug the issue. Needed to cover entire TCP/IP stack(fragmentation/icmp/etc) + machine metrics (vmstat,iostat,strace etc). Describe virtual memory in terms of demand paging.
    2 machines are connected, suddenly 1 machine is responding slowly. Why ?
    We had a good discussion in which we discussed everything under the sun, from NFS being bad to Networking being wrong to Kernel running out of resources(buffer-cache/inodes/virtual memory). Interviewer was interested to know the commands that i would use (strace, lsof, readlink, cat /proc/pid etc).
    Copy some resource from N sources to M sinks. where N could be < 10 and M could be 10k/Millions etc.
    Design File Storage System. Like Dropbox, Google Drive
    Not any fancy one like design Twitter or Uber. More on scheduling service side and i designed using SQL appraoch. Discussed concuurency issues, Table schemas, composite keys etc.
    Design recommendation of celebrities to user on Instagram
    Design search for Twitter
    Design a Content publishing site with privacy restrictions.
    System Design of Uber. He liked my design. He was really nice guy, i felt he was interested in my success.
    Design a type ahead features for a website. We discussed various data structures, advantage /disadvantages. Lot of different cases, scenario to handle etc.
    Design instagram client side.
    Design a leetcode contest, leadership board system
    Design Instagram
    Design keyword search in FB Posts
    There are music providers like spotify, apple music etc. Design a service for these providers to display top 10 songs played by each user. Was aked to write ER tables and API's.
    Design a system like Hacker Rank for a programming contest and their ranking.

5. Behavioral:

    Work experience, past projects, standard "tell me about a time" questions, hypothetical scenario questions
    Usual stuff around things that I am proud of/ projects that I regret etc
    Tell me about your current role
    Tell me about a projects you are proud of
    Tell Me About A Time When You Had To Give Someone Difficult Feedback. How Did You Handle It?(What kind of feedback you give ?)
    Tell me about a time when you had a conflict with a manage and how you resolved it
    What's the most difficult/challenging problem you have had to solve?
    Which environment is best to you to work ?
    Tell about best decision in your life from childhood ? Decision that changed your life
    On which topics you want improve? What are doing to impoving on that topics ? Did you try build project on that topics ?

I compiled a list of facebook phone interview questions from this discuss section. Hope it helps!!

https://leetcode.com/problems/product-of-array-except-self/

https://leetcode.com/problems/leftmost-column-with-at-least-a-one/

https://leetcode.com/problems/employee-free-time/

https://www.*.org/lowest-common-ancestor-in-a-binary-tree-set-2-using-parent-pointer/

https://leetcode.com/problems/subarray-sum-equals-k/

https://leetcode.com/problems/copy-list-with-random-pointer/

https://leetcode.com/problems/serialize-and-deserialize-binary-tree/

https://leetcode.com/problems/word-break-ii/

Validate Single Binary Tree

    https://leetcode.com/discuss/interview-question/347374/

Task Scheduler

    https://leetcode.com/discuss/interview-question/673575/Facebook-or-Phone-or-Task-Scheduler
    https://leetcode.com/problems/task-scheduler/

https://leetcode.com/problems/target-sum/

https://leetcode.com/problems/generate-parentheses/

https://leetcode.com/problems/nth-digit/

https://leetcode.com/problems/insert-delete-getrandom-o1/

https://leetcode.com/problems/insert-delete-getrandom-o1-duplicates-allowed/

https://leetcode.com/problems/accounts-merge/

https://leetcode.com/problems/valid-word-abbreviation/

https://leetcode.com/problems/candy-crush/

https://leetcode.com/problems/koko-eating-bananas/

https://leetcode.com/problems/binary-tree-right-side-view/

https://leetcode.com/problems/restore-ip-addresses/

https://leetcode.com/problems/powx-n/

https://leetcode.com/problems/russian-doll-envelopes/

https://leetcode.com/problems/walls-and-gates/

https://leetcode.com/problems/best-time-to-buy-and-sell-stock/

https://leetcode.com/problems/find-largest-value-in-each-tree-row/

https://leetcode.com/problems/add-strings/

https://leetcode.com/problems/combination-sum/

https://leetcode.com/problems/maximum-swap/

Dot Product of Sparse vectors
https://leetcode.com/discuss/interview-question/124823/

    Find an efficient way to represent a vector (1,1,1,1,1,1,22,2,2,2,2,2,2,2,3,4,4,5,6,6,7,7,7,8,8,8,9,9,9,99,9,,1,1,1,1,1,1,2,3,34,3,4,,3,3,3,3....)
    Use the representation you come up with to compute dot product of two vectors
        Ex: If you come up with MyDataStructure to represent a vector, then your function signature will be
        int dotProduct(MyDataStructure vector1, MyDataStructure vector2)
        // dot product of two vectors [1,2,3,4] and [5,6,7,8] is 1 * 5 + 2 * 6 + 3 * 7 + 4 * 8
        Take advantage of your "efficient" representation to compute the dot product faster.

https://leetcode.com/problems/random-pick-with-weight/

Some questions are the closest that it can get to the actual question. Like Russian Doll envelopes or Task Scheduler.
## PamazonInterview




A copy of my personal incomplete list of questions I found on Amazon's Interview process from end of 2020 - 2021.
Purposely very verbose so as to allow to find the original post (via google search).
Feel free to comment missing questions so that I add them to the list.

Onsite

All Combined 2021 | SDE & New Grad

Tips

    I feel like to pass the onsite interview, you must demonstrate stong leadership principles and communication skills. The problems weren't too hard so I'm guessing they're looking to see if you can clearly explain your thought process.

    I personally think I will not get the offer because from my experience you either have to get everything perfect or you will fail. For me I can only say 2/4 interviews went perfectly thus I probably will get rejected. Alas, I do have another final round interview this August so I have another chance.

    One Leetcode Medium Question. Rather than the actual code, they were mostly interested in how I approach the problem and I had to speak aloud about my thought process in solving the problem. Heard back within 3 business days that they would like to extend the offer. If you practice Leetcode with full concentration then there is no reason not to clear the interviews at big companies. With regards to LP, if you have 2 scenarios which you can explain in detail for each of the LP principles, you are golden. All the best for everyone who is preparing.

    Finally, one last piece of advice. Please, PLEASE, avoid remembering the exact questions, but rather focus on learning the actual patterns, data structures, and logic behind each exercise.

    Experience -

        Initial 20 minutes they will ask you LP questions only. Its not like they will ask just one or two questions on LP.

        Next 20 minutes will be dedicated to coding. Links to coding platform will be shared. They wont be able to compile the code, but will see the way you are coding. One thing common in all rounds were they wanted me to write the code in OOD format. It was not like i just wrote the method and its done. They wanted me to write the object creation, function calls etc. I was not done with full implementation in round 1 and round 3, they stopped me like 2 minutes before 20 minutes are completed and asked me to write the OOD format for whole code.

        NOTE - I was not able to complete full implementation but i explained the approach very well, step by step. Its okay to go back and forth sometimes, just tell them i am thinking out loud, i am making connections to find optimal way :)

        3 Last five minutes were just if i have any questions for them.

    Finally I would suggest anyone who is appearing for the Amazon technical interview to focus on proper naming of variables and code readability and reusabality aspects as well.

Questions

Old https://leetcode.com/discuss/interview-question/488887/amazon-final-interview-questions-sde1 Amazon Final Interview Questions | SDE1 - Google Docs

    Number of Islands,

    Level Order (and Zigzag) Tree Traversal,

    Word Series (Word Ladder 1 & 2, Word Break 1 & 2, Word Search 1 & 2).

    "parking lot" OOD question

    Bloomberg | Software Engineering Intern | London | January 2020 [Offer] - LeetCode Discuss

    Amazon Dublin Ireland | Onsite - SDE New Grad 2021 | Income Calculator - LeetCode Discuss

    What are Design patterns? example and explanation? https://leetcode.com/discuss/interview-experience/1060893/amazon-sde-new-grad-2021-dublin-experience-offer

    Round2 Onsite: This was a class design. In the beginning, there were 2 LP questions then he asked how a hash table is implemented as a starter and then asked to design a file system and implement search on the filesystem based on certain parameters (like file size creation date etc)

    https://leetcode.com/discuss/interview-question/609070/Amazon-OOD-Design-Unix-File-Search-API

    Round 3: Bar raiser Basically asked LP questions and asked to Design a task scheduler (in memory) and then implement a function that finds the time a certain task takes to complete (given that there exist tasks that have to be executed before it )

    Round 4: Simple Number of islands question along with LP questions

    1 OOP questions variant of UNIX command, Game of Life Question and Iterator Question.

    Remove all duplicate numbers from a list.

    https://leetcode.com/problems/min-stack/ However, it came with the constraint that we would be needing extra O(n) space. I was also asked to implement exception handling to deal with situations when you call pop() or getMin() on an empty stack.

    First round: 2-3 behavioral questions followed by a coding question. The question was given a binary tree find a subtree within the binary tree that adds up to a certain target sum.

    Second round: 2-3 behavoral questions followed by an OOD question. The question was a bit vague and I had a hard time understanding their english but essentially it was to design a wharehouse class that had certain constraints such that the particular wharehouse could only store certain products.

    Fourth round: 2-3 behavioral questions. This was another coding round, which involved taking a string that say said "This sweater cost $40 dollars." The objective was to take that number and apply a 20% discount and return the string back with the updated price, i.e., "This sweater cost $32 dollars.".

    This round was interesting since it was not any of the Leetcode questions. I was given certain conditions for a valid transaction and I had to write a function that will determine if the transaction is valid or not. The goal of this round was to see how I can write a maintainable and scalable code. For example, how can we add more conditions for a valid transaction and still not alter the main function very much. I had LP questions as part of this round also.

    Find the count of a given sequence that appears in an array. There can be any amount of characters between the numbers of the sequence. ex 4,5,6,2 would have a count of 1.

    sequence 4,6,2

    array [ 3, 4, 4, 6, 7, 8 , 2, 6, 9, 2]

    count of sequences: 6
    https://leetcode.com/discuss/interview-question/437362/amazon-sde-count-of-sequences-within-an-array

    2 LP´s and Medium exercise on Trie Structure (make sure you know how to use a Trie, the Explore section here has a really good card on it). Really similar to an Amazon tagged exercise.

    2 LP´s, then started with an extremely simple exercise, and afterwards, the interviewer started adding complexity, to see how I adapted my solution so that it scaled. The interviewer was testing my knowledge on Object Oriented Design, which I use in my everyday work, but had not prepared for the interview. This was almost a disaster, my solution was far from good.

    Course Schedule II -

    Given huge database of sentences, write a class to find most frequently used words

    Questions on data structures like array list, linked list, hash table, binary search tree. Differences between these data structures and when would you use which one. Inheritance and Composition.

    Coding: Design a Tic Tac Toe Game

    Given a graph and destination D, find shortest path between all nodes. Not given any graph implementation, and input is a list of edges ([1,2,3] = Node 1 to Node 2, distance 3). Had to implement my own adjacency list and "nodes" (Dijkstra's Algorithm)

    Similar to this question, but exclude the combined word (ex. instead of [['car','super', 'supercar'], the answer is [['car','super'],)https://leetcode.com/discuss/interview-question/314550/amazon-onsite-interview-concatenated-words

    https://leetcode.com/problems/copy-list-with-random-pointer/

    https://leetcode.com/problems/longest-happy-prefix/

    https://leetcode.com/problems/insert-interval/

    Design a system to generate and apply coupons for e-commerce site based on product and its category.

    https://leetcode.com/problems/lfu-cache/

    Find the next value from the target node using BST

    https://leetcode.com/problems/string-to-integer-atoi/

    Longest common prefix among an array of strings - but the longest between any two (instead of the longest in all)

    https://leetcode.com/problems/boundary-of-binary-tree/

    https://leetcode.com/problems/integer-to-roman/

    K most frequent items(item_id) in a stream. Input is a stream of (item_id,timestamp).

    This I was able to easily solve using hashmap and min-heap

    Then, Interviewer asked me to find frequent items in last hour given a timestamp.

    For example, Given time 6:07 PM, Return k most frequent items from 5:07 PM to 6:07 PM.

    Gave an answer using queue, hashmap and min-heap, Not an optimal answer, But it worked.

    Three sum

    Round 1 - 2 interviewers https://leetcode.com/discuss/interview-experience/1060893/Amazon-SDE-new-grad-2021-Dublin-Experience-or-Offer/854173

        Implement queue using stack
        Find loop in single linkedlist
        find missing element in an array
        Explain any sorting algorithm
        Time and space complexity for the above problems
        Difference similarity between list, linkedlist and array
        Implementation of Hashmap
        Difference between set, hashmap, list

    Round 2 - 1 inerviewer

        2 LP questions
        What are Design patterns? example and explanation?
        Best coding practices
        https://leetcode.com/problems/integer-to-english-words/
        Time complexity for the above problem

    Round 3 - 1 interviewer

        Print matrix spirally. Time and space complexity for the above problem

    Given an array of large numbers and a number K, give an algorithm to search for a triplet whose sum is K. You can modify the array. You can print any triplet whose sum is K.

    After basic introduction, the interviewer asked me questions about Hashmaps. such as time complexity and how to handle collisions. And he asked me how would I implement a structure to store contact informations(phones numbers, names and area codes). I think I did ok in this part, and the interviewer agreed with me on how I would use a hashmap to do so.

    https://leetcode.com/problems/valid-parentheses/

    Merge List + find Top K Elements , I solved this using a Heap to merge the Lists, and a later variation involved using BFS, basically the question was , Recommend a user features that are used by friends and friends of friends N - level deep. Given an api which can give you user's friends and friends most used features.

    https://leetcode.com/problems/number-of-islands/

    https://leetcode.com/problems/knight-probability-in-chessboard/

    Given a positive integer N, and a starting point 1 one can perform any of the following 2 operations in one step: https://leetcode.com/discuss/interview-experience/906535/amazon-sde-i-bangalore-october-2020-offer

        Add 1 to the number
        Double the number

    The task is to find the minimum number of steps to reach N (desired complexity O(log n)).

    Given a set of N numbers (both positive and negative) sorted in increasing order with A[i] < A[j] for all i<j, find whether there exists an index i (i = 1 .. N) such that A[i] = i. If multiple answers are present return any one of them. (desired complexity O(log n)).

    Give the design of an automated valet parking system with the following specifications:

        There are 3 parking areas (each of different sizes) for 3 different vehicle sizes - small, medium and large.
        Small one can accommodate only small vehicles, medium can accommodate small and medium vehicles and similarly for the large one.
        Design a system which issues a parking ticket to a vehicle entering the lot with the optimal parking space allotted to it. For eg., if a medium vehicle arrives and both medium and large parking areas have vacant spaces, the vehicle should be allotted the medium slot.
        Also design a syntax for the token ID which is generated when each vehicle enters the lot. The ID should be uniquely able to determine the details of the slot where the vehicle is parked for smooth parking and un-parking.
        Provide the class design of the same.

    Virtual Onsite Round 3 (Bar Raiser, Coding + CS Fundamentals)

        Given a set of N integers find the kth largest contiguous subarray sum.
        Questions on OS like describe the boot up process of OS.
        Difference between caching, paging and buffering.
        Difference between stack and heap memory, calloc and malloc, etc.
        Things to keep in mind while designing a software product (scalability, memory leaks, deadlocks).

    Design a restaurant table booking system with the following specifications:

        The restaurant has X tables of size 2, Y tables of size 3 and Z tables of size 4.
        There are 3 slots from 6:30 pm to 11 pm, each of 1.5 hrs.
        Restaurant can take bookings upto 7 days in advance.
        No two parties will share a table.
        A pack of size N should always be assigned the largest table available.
        Wastage of seats should be minimised.
        Provide the database structure to support the above constraints (space should be optimised).
        Provide an algorithm to allot table to an incoming reservation with the following specs:
            Allot table(s) to a group of N people for the ith day and the jth slot.
        Provide pseudo code for the algorithm stated above.

    Search for smallest element in sorted rotated list

    Tell me about a situation when you had a tight deadline and what are the sacrifices you made to achieve the deadline.

    TTL LRU Cache.
    https://leetcode.com/discuss/interview-question/284925/ttl-lru-cache

    Tell me about a time you couldn't finish your task within the given deadline.

    flatten a hierarchical linked list.

    A variant of topological sort in a graph.

    Find smallest +ve missing integer from given array without extra space.

    (follow up : Array can contain both positive and negative numbers).

    Ex : ar [1,9,8] output :2

    You have locking suitcase system (the one in which there will be number codes). Find the minimum number of steps to reach from given number to target number. You can move any place digit at a time. (for n-digit codes, discuss complexity). Ex : start : 0-0-1Target : 1-0-0 min steps = 2 …..changing an xth place digit by b will be counted as b steps. follow -up...what if you are not allowed to use certain numbers(not digits but whole number )(given as array)Ex: [100,234,115]

    Implement a custom collection class with add, remove and getRandomOperations in O(1) time

    https://leetcode.com/discuss/interview-question/1586723/amazon-sde-3-interview-question

    https://leetcode.com/discuss/interview-question/system-design/685338/microsoft-onsite-design-the-t9-predictive-text-algorithm-and-system (not sure)

    https://kobejean.github.io/algorithms/2020/03/08/the-award-budget-cuts-problem/

    Poker Cards Game

    As we all know that poker cards have four suites: Spades, Hearts, Clubs and Diamonds with figures from 1 to 13.

    Now you are given a set of poker cards, you can pick any one card as the first card. And except for the first card, you can only pick the card that has the same suit or figure with the previous one.

    Return the max number of cards you can.

    For example: [(H, 3), (H, 4), (S, 4), (D, 5), (D, 1)], it returns 3 as follows: (H,3)-->(H,4)-->(S,4)

    https://leetcode.com/discuss/interview-question/1030942/Amazon-Onsite-Inteview-Poker-Cards-Game

    Given a game board| B ||A | C | D||E | F | G ||H | I | J|Rules of movinga. you can not move to same row.b. you can not move in same column.Given a starting point and number of moves tell the number of possible options https://leetcode.com/discuss/interview-question/1170079/amazon-onsite-imdb-team

    Given an array of integers(pos/neg) in sorted order, return an array of elements square in sorted order.

    Given an array of wine prices, any given year you can sell a bottle of wine only from either of the ends. Bottle of wine increases every year. Find max profit after selling all.

    Given a uni-directed graph with numbers find maximum root to leaf sum with using only internal data structure.

    https://leetcode.com/problems/binary-tree-maximum-path-sum/

    https://leetcode.com/problems/word-break/

    Given a dictionary of words and a string, state if the string if broken into multiple words consists of dictionary words.

    I explained him the standard solution using BFS which is O(n) time ans O(n) space.However, the interviewer was deeply interested with me solving the question via making a Graph and then solving it.

    https://leetcode.com/discuss/interview-question/600412/Amazon-onsite

    A very similar question to this , same concept of BFS will applyGiven a 2D grid, each cell is either a zombie 1 or a human 0. Zombies can turn adjacent (up/down/left/right) human beings into zombies every hour. Find out how many hours does it take to infect all humans?https://leetcode.com/discuss/interview-question/411357/ Amazon | OA 2019 | 🧟‍♀️ Zombie in Matrix - LeetCode Discuss

    given a list of unique strings, if the last char at string A match first char at string B then you can append them together: good+dog -> goodog . Now return the longest possible string (length of concatenated String, not the string number). https://leetcode.com/discuss/interview-question/250623/Onsite-question-for-Amazon-String-concatenation(Updated)/246655

    Convert BST to Doubly Linked List without deforming tree and without using extra space except used for creating List. So this shouldn’t be done inplace.Time and Space Complexity of my solutions -: O(n) & O(1) respectively

    You are given a subarray which has only 0’s and 1’s , Maximise the subarray containing 1’s and in this you can only flip one 0 , tell the index of that 0Similar to thisfind-zeroes-to-be-flipped-so-that-number-of-consecutive-1s-is-maximizedon GFGTime and Space Complexity of my solutions -: O(n) & O(1) respectively

    Given 2 large files say file1, file2 consisting of strings of customerid - find the unique customers present in those files. Basically unique words (ex. customer1, customer 3, customer5 and so on)!

    My approach - Solved using HashSet but interviewer told it won't work as input is very large and Set would exceed Memory limit. I told maybe something like divide and conquer but wasn't able to come up with the actual solution.

    For SDE I found Amazon mostly ask Graph Medium questions for example:

    323. Number of Connected Components in an Undirected Graph

    547. Number of Provinces

    http://leetcode.com/problems/generate-parentheses

    This Question I have not seen in any platform. So I will be giving the question description. We have been given a string with parenthesis and characters in between. The parenthesis can be invalid also if it's invalid we have to return -1 and if it's valid then we need to find the maximum depth of the brackets.For eg. let s = "((((X))(((Y)))))" Output will be 5 in this caseThe string can have characters in between the brackets and it can be without characters in between also. I gave him the approach and after the initial discussion, he told me to optimize the space for validity checking of the brackets. After more discussion, I came with an optimized approach and he told it to code it. I wrote the code along with the time and space complexity.

    https://leetcode.com/discuss/interview-question/995825/amazon-onsite-sql-library

    implement business logic for amazon products with friends. Writing a function like you would in a work style

    for the given binary tree find the distance or number of hop required to move from one node to another.

    https://leetcode.com/problems/frog-jump SDE 2

    https://leetcode.com/problems/sliding-puzzle/ SDE 2

    Write a program to print the sum of two roman numbers

    https://leetcode.com/problems/best-time-to-buy-and-sell-stock If there is a tie, then return the minimum days to finish the transaction. Example: [1 2 3 1 3], we can buy at index 0 and sell at 2, the profit is 2. but we can also buy at index 3 and sell at 4 which only takes 2 days. So return [3, 4]

    describe the differences between Set, Map, Array, List and which data structure should be used with different scenarios

    https://leetcode.com/problems/k-similar-strings/

    We are given a list of cars, and the direction of the road they are in. We need to find the order in which cars leave the intersection. The list of cars have the cars at the intersection in order. However, if two cars are in opposite direction, for example East/West or North/South, they can leave the intersection even though other cars arrived before it.

    Given a list of inputs in the form of a string array, for example [["Item: Bread", "Id:1"], ["Item: Meat", "Id:3"], ["Item: Sauce", Id:2], ["Item: Bread", "Id:4"]], we need to arrange the input string in order and output the result. The interviewer said do not worry about parsing the string. I gave the solution of sorting based on Id and then getting the result. It was very unclear what the interviewer was expecting. Also, I made the mistake of having only screen, and the interviewer said he was nodding to my questions, and I was writing code in another window. This was a very uncomfortable interview.

    Write an API for Linux find command. It was this exact question: https://leetcode.com/discuss/interview-question/369272/Amazon-or-Onsite-or-Linux-Find-Command

        Medium OOD question. Very similar to linux find command question (https://leetcode.com/discuss/interview-question/369272/Amazon-or-Onsite-or-Linux-Find-Command) but for validation of purchases. If you are good at applying SOLID principles, this should be solvable. The question was in Java, I spent a couple of minutes to convert it to Python.

    https://leetcode.com/problems/russian-doll-envelopes/

    https://leetcode.com/problems/best-time-to-buy-and-sell-stock-iii/

    A variation of meeting rooms: https://leetcode.com/problems/meeting-rooms/Given a list of meeting rooms and a meeting reservation request. Find if the reservation request can be fulfilled or not.Follow up: What if the list of meeting rooms is sorted?Edit: I found a similar one here: https://leetcode.com/problems/my-calendar-i/

    Coding: create stack with O(1) push, pop and min.

    K most frequent items(item_id) in a stream. Input is a stream of (item_id,timestamp).

    Then, Interviewer asked me to find frequent items in last hour given a timestamp.

    For example, Given time 6:07 PM, Return k most frequent items from 5:07 PM to 6:07 PM.

    Gave an answer using queue, hashmap and min-heap, Not an optimal answer, But it worked.

    https://leetcode.com/problems/integer-to-roman/

    https://leetcode.com/problems/reorder-data-in-log-files/

    Design and implement a playlist of a user’s most recently played songs on Amazon music. It should support the following operations: getSong and addSong.

    getSong – user should be able to search and get the song from the playlist if the song exists.

    addSong – add the song into the playlist if the song is not already present.

    Design a Parking Lot , Which takes assigns a ticket number a when car arrives and a vacant parking slot is available and rejects if not, Empty the parking slot when car departs. There were different types of cars and parking spots(small,medium and large).

    https://leetcode.com/problems/longest-common-subsequence/

    https://leetcode.com/problems/longest-consecutive-sequence/

    https://leetcode.com/problems/trapping-rain-water/

    Merge k sorted linked list & array. (Highly scalable solution was expected)

    Implementaion of coin change variation of dynamic programming. -

    https://leetcode.com/problems/design-in-memory-file-system/

    https://leetcode.com/problems/copy-list-with-random-pointer/

    https://leetcode.com/problems/product-of-array-except-self/

    https://leetcode.com/problems/median-of-two-sorted-arrays/

    https://leetcode.com/problems/rectangle-overlap/

    https://leetcode.com/problems/design-tic-tac-toe/

    https://leetcode.com/problems/longest-consecutive-sequence/solution/

    https://leetcode.com/problems/concatenated-words/

    https://leetcode.com/problems/word-search-ii/

    https://leetcode.com/problems/making-file-names-unique/

        Follow up question - Assume the tree as a Binary Search Tree & was asked to solve it.

    https://leetcode.com/problems/find-all-anagrams-in-a-string/

    Largest pair sum that is less than or equal to k in an array

    https://leetcode.com/discuss/interview-question/369272/Amazon-or-Onsite-or-Linux-FindCommand

    https://leetcode.com/problems/rotting-oranges/

    https://leetcode.com/problems/all-paths-from-source-to-target/

    https://leetcode.com/discuss/interview-question/algorithms/124715/amazon-is-cheese-reachable-in-the-maze

    Implement operations for an AutoComplete feature. New Grad 2021

        InsertWords(words) - Given a stream of words, store the words
        CheckPrefix(prefix) - Returns if the prefix exists
        SearchPrefix(prefix) Given a prefix string, return words starting with the prefix string.Eg: Insert Words {car, cart, carpool, bus, apple, cargo}SearchPrefix (car) -> car, cart, carpool, cargoFollow up questions – SearchPrefix() return in sorted order/ top k results

    Isomorphic Strings New Grad 2021

    Design Unix Find command - https://leetcode.com/discuss/interview-question/609070/Amazon-OOD-Design-Unix-File-Search-API New Grad 2021 Loading... (leetcode.com)

    Design and implement a playlist of a user’s most recently played songs on Amazon music. It should support the following operations: getSong and addSong.

    getSong – user should be able to search and get the song from the playlist if the song exists.

    addSong – add the song into the playlist if the song is not already present.

    In the logistic floor robots entered and exited, how many robot exist at any specific time. interviewer was not very specific about the question and I had to question a lot to understand and construct the problem statement.

    https://leetcode.com/problems/jump-game-ii/

    Sum of all binary search trees in a tree. So, basically, the interviewer wanted to create a tree and then if there was a BST, add the value of all the nodes in the tree. SDE2

    OOP/Coding: Design a game where there are multiple players, you can either add a new player, update their score or display Leadership Board SDE2

    Design phone bill calculator

    [K maximum sum combinations from two arrays] - GeeksfGeeks question

    There are N trees in Jon's backyard and the height of tree i is h[i]. Jon doesn't like the appearance of it and is planning to increase and decrease the height of trees such that the new heights are in strictly increasing order. Every day he can pick one tree and increase or decrease the height by 1 unit. Heights can be 0 or even negative (it's a magical world).
    https://leetcode.com/discuss/interview-question/1171979/a-good-question-of-amazon-sde

    This problem is a variant of closest pair sum. You'll be given two arraysarr1 = { {1, 2000}, {2, 3000}, {3, 4000} }arr2 = { { 1, 5000 }, {2, 3000} }the first element of every pair represents id and the second value represents the value.and a target x = 5000Find the pairs from both the arrays whose vaue add upto a sum which is less than given target and should be close to the target.

    Output for the above example:{ {1, 2} } // Note that the output should be in id's

    I cleared all the test cases for the first problem (will share), but for this problem, I couldn't clear 3 test cases which were of handling duplicates!In the online assesment this problem was sort of tagged as approximate solution, does anyone know what that means?Awaiting for the result!

    https://leetcode.com/problems/find-median-from-data-stream/

    Variation of https://leetcode.com/problems/concatenated-words/

    Given a large list of words. Some of these are compounds, where all parts are also in the List. Write a method that will find all combinations where one word is a composite of two or more words from the same list and return them.

    https://leetcode.com/discuss/interview-question/545748/amazon-subsidiary-phone-concatenated-words

    Given two number in the form of sting, we have to perform two operations: Remove all the zeroes from the number and then add the two numbers.

    Given two numbers in the form of LinkedList we have to add the numbers. But there was a condition that we cannot reverse the linkedlist.

    https://leetcode.com/problems/asteroid-collision/

    https://leetcode.com/problems/best-time-to-buy-and-sell-stock-with-cooldown/

    https://leetcode.com/problems/minimum-knight-moves/

    Group Product Id pairs into Categories ****https://leetcode.com/discuss/interview-question/690707/Amazon-or-Phone-Interview-or-Group-Product-Id-pairs-into-Categories

    https://leetcode.com/problems/word-break-ii/

    Search for smallest element in sorted rotated list

    https://leetcode.com/problems/binary-tree-right-side-view/



Facebook

    https://leetcode.com/discuss/interview-question/1002218/Facebook-or-Google-or-Top-System-Design-Interview-Questions-(Part-1)
    https://leetcode.com/discuss/interview-question/1042229/Facebook-or-Google-or-Top-System-Design-Interview-Questions-(Part-2)
    https://leetcode.com/discuss/interview-question/719253/Design-Facebook-%3A-System-Design-Interview
    https://leetcode.com/discuss/interview-question/124657/Facebook-or-System-Design-or-A-web-crawler-that-will-crawl-Wikipedia

Google

    https://leetcode.com/discuss/interview-question/system-design/496042/Design-video-sharing-platform-like-Youtube
    https://leetcode.com/discuss/interview-question/system-design/733520/Design-YouTube-Very-detailed-design-with-diagrams
    https://leetcode.com/discuss/interview-question/system-design/318811/Google-or-System-design-or-Design-a-translation-service-like-Google-Translate
    https://leetcode.com/discuss/interview-question/system-design/692383/Google-or-Onsite-or-Design-a-organization-pharmacy-shop-with-managers

Amazon

    https://leetcode.com/discuss/interview-question/341980/Amazon-or-System-Design-or-System-to-capture-unique-addresses-in-the-entire-world
    https://leetcode.com/discuss/interview-question/system-design/124557/Amazon's-"Customers-who-bought-this-item-also-bought"-recommendation-system
    https://leetcode.com/discuss/interview-question/system-design/344524/Amazon-or-Design-a-JobTask-Scheduler
    https://leetcode.com/discuss/interview-question/373887/Amazon-or-System-Design-or-A-configuration-management-system

Uber

    https://leetcode.com/discuss/interview-question/124673/Design-a-Location-Sharing-Android-Application
    https://leetcode.com/discuss/interview-question/124542/Design-Uber-Backend
    https://leetcode.com/discuss/interview-question/system-design/124558/Uber-or-Rate-Limiter

Microsoft

    https://leetcode.com/discuss/interview-question/system-design/685310/Microsoft-virtual-or-Design-distributed-counter
    https://leetcode.com/discuss/interview-question/system-design/680047/How-will-you-store-millions-of-subscribers-list-(assume-it-as-email-id)
    https://leetcode.com/discuss/interview-question/system-design/598634/Microsoft-or-Onsite-or-System-Design-or-SDE-2

Others (Does not fall under any particular company):

    https://leetcode.com/discuss/general-discussion/1105898/System-Design%3A-Introduction-to-Distributed-Systems-or-Designing-a-highly-available-system
    https://leetcode.com/discuss/general-discussion/1114279/System-Design%3A-Introduction-to-Distributed-Systems-Pt.-2-or-Design-Highly-available-System
    https://leetcode.com/discuss/general-discussion/1082786/System-Design%3A-Designing-a-distributed-Job-Scheduler-or-Many-interesting-concepts-to-learn
    https://leetcode.com/discuss/general-discussion/1035779/System-Design-Reading-Resources
    https://leetcode.com/discuss/general-discussion/901324/My-System-Design-Interview-Checklist-A-Gateway-to-FAANGs
    https://leetcode.com/discuss/interview-question/124658/Design-URL-Shortening-service-like-TinyURL
    https://leetcode.com/discuss/interview-question/1061256/Tips-on-System-design-from-a-20%2B-YOE-Engineer
    https://leetcode.com/discuss/interview-question/system-design/566057/Machine-Learning-System-Design-%3A-A-framework-for-the-interview-day
    https://leetcode.com/discuss/interview-question/system-design/547669/Algorithm-you-should-know-before-system-design
    https://leetcode.com/discuss/interview-question/system-design/691010/System-Design-for-Mobile-App-Developers


##################################################################################################

Design a simple model of Facebook where people can add other people as friends. In addition, where people can post messages and that messages are visible on their friend's page. The design should be such that it can handle 10M of people. There may be, on an average 100 friends each person has. Every day each person posts around 10 messages on an average.

Use Case

    A user can create their own profile.
    A user can add other users to his friend list.
    Users can post messages to their timeline.
    The system should display posts of friends to the display board/timeline.
    People can like a post.
    People can share their friends post to their own display board/timeline.

Constraints

    Consider a whole network of people as represented by a graph. Each person is a node and each friend
    relationship is an edge of the graph.
    Total number of distinct users / nodes: 10 million
    Total number of distinct friend’s relationship / edges in the graph: 100 * 10 million
    Number of messages posted by a single user per day: 10
    Total number of messages posted by the whole network per day: 10 * 10 million

Basic Design

Our system architecture is divided into two parts:

    First, the web server that will handle all the incoming requests.
    The second database, which will store the entire person's profile, their friend relations and posts.

First, three requirements creating a profile, adding friends, posting messages are written some information
to the database. While the last operation is reading data from the database.

The system will look like this:

    Each user will have a profile.
    There will be a list of friends in each user profile.
    Each user will have their own homepage where his posts will be visible.
    A user can like any post of their friend and that likes will reflect on the actual message shared by his
    friend.

If a user shares some post, then this post will be added to the user home page and all the other friends of
the user will see this post as a new post.

Bottleneck

A number of requests posted per day is 100 million. Approximate some 1000 request are posted per
second. There will be an uneven distribution of load so the system that we will design should be able to
handle a few thousand requests per seconds.

Scalability

Since there is, a heavy load we need horizontal scaling many web servers will be handling the requests.
In doing this we need to have a load balancer, which will distribute the request among the servers.
This approach gives us a flexibility that when the load increases, we can add more web servers to handle
the increased load.
These web servers are responsible for handling new post added by the user. They are responsible for
generating various user homepage and timeline pages. In our case, the client is the web browser,
which is rendering the page for the user.

We need to store data about user profile, Users friend list, User-generated posts, User like statues to the
posts.
Let us find out how much storage we need to store all this data. The total number of users 10 million. Let
us suppose each user is using Facebook for 5 to 6 years, so the total number of posts that a user had
produced in this whole time is approximately 20,000 million or 20 billion. Let us suppose each message
consists of 100 words or 500 characters. Let us assume each character take 2 bytes.

Total memory required = 20 * 500 * 2 billion bytes.
= 20,000 billion bytes
= 20, 000 GB
= 20 TB
1 gigabyte (GB) = 1 billion bytes
1000 gigabytes (GB) = 1 Terabytes 

Most of the memory is taken from the posts and the user profile and friend list will take nominal as
compared with the posts. We can use a relational database like SQL to store this data. Facebook and
twitter are using a relational database to store their data.

Responsiveness is key for social networking site. Databases have their own cache to increase their
performance. Still database access is slow as databases are stored on hard drives and they are slower
than RAM. Database performance can be increased by replication of the database. Requests can be
distributed between the various copies of the databases.

Also, there will be more reads then writes in the database so there can be multiple slave DB which are
used for reading and there can be few master DB for writing. Still database access is slow to we will use
some caching mechanism like Memcached in between application server and database. Highly popular
users and their home page will always remain in the cache.

There may be the case when the replication no longer solves the performance problem. In addition, we
need to do some Geo-location based optimization in our solution.
Again, look for a complete diagram in the scalability theory section.
If it were asked in the interview how you would store the data in the database. The schema of the
database can look like:

Table Users:

1. User Id
2. First Name
3. Last Name
4. Email
5. Password
6. Gender
7. DOB
8. Relationship

Table Posts:

1. Post Id
2.  Author Id
3.  Date of Creation
4.  Content

Table Friends:

1. Relation Id
2. First Friend Id
3. Second Friend Id

Table Likes:

1. Id
2. Post Id
3. User Id

--
how to present to users the timeline (newsfeed generation for your friends). If also this was a key point of the interview you should talk a little about it. It's obvious that you cannot generate news feed on the fly when users connect, it would be too slow.
One solution is to have some worker jobs which asynchronously generates the news feed for each user and cache them (scheduled once a day).
Then a new issue pop up: you would like to have a more responsive system instead of wait one day to have the updates. The solution is to have a queue (probably multiple of them) where you keep track of the news feed to be updated based on the friends list of the users which post messages: when you post a message you also trigger the generation of the news feed for your friends.
Then again a new issue pop up: what's about celebrities which has a lot of friends? One possible approach could be to rank their friends based on the frequency that they are accessing to Facebook home page and trigger only frequent users, updating the other users news feed using only the scheduled job.

d high level idea but the trickiest parts of FB are how serve up the data at scale. For example, user A is very popular and is cached. They make updates to their account that they want someone to see asap, like a new profile pic. How does this work? Can we hit your target of ~1000 TPS with this in mind? Why or why not?

In these situations, there's not really a right or wrong, but how you defend your ideas. Your job is to convince the interviewer that you know enough to put together a reasonably functioning system for the ask.

For example, you could say that you shard the mysql DB by last name, therefore giving you the perf you need, if needed.
You could also say you use write through caching, where writes populate the cache with updated information.

Another huge glaring issue is pagination and their "user feed" system. That home screen, where you load everyone's posts, pages and updates is a critical component of how FB is designed. Figuring that out, and designing something that feeds you almost endless amount of information is a big challenge.

more details on the caching and DB ideas

##################################################################################################

## Design video sharing platform like Youtube

referemce : https://leetcode.com/discuss/interview-question/system-design/496042/Design-video-sharing-platform-like-Youtube

Gathering requirements

The problem description is intended to be ambigious as the interviewer wants to check if we're able to ask reasonable questions, collect requirements and define a core set of features for a minimum viable product (MVP) that we can start to work with.

In this case, I'd like to ask a few questions to make things clear, including

    Q: What are main features of the video sharing platform?
        A: The system will be a public platform that users can watch and upload videos.
    Q: Who will be the users of the system?
        A: Users will be around the world.
    Q: How are they going to use it?
        A: Users will use various kinds of devices to visit our service.
    Q: Is there any external dependencies? What are the upstream and downstream system?
        A: The system will leverage existing authentication system.

Once I get answers for above questions, I'd confirm with the interviewer that I'll design a video platform that enables users to watch and upload videos. Authentication is out of the scope of this problem.

Based on information that I gathered so far, I come up with a bunch of functional and non-functional requirements below and confirm with interviewer.

Functional requirements

    Users can watch videos on the platform
    Users can upload their own videos

Non-functional requirements

    The platform should be highly available
    The response time for users in different regions should be at the same level
    The platform should scale while userbase is increasing

Estimation

The goal of this step is to come up with estimated numbers of how scalable our system should be.

We have two types of requests, read and write. Write request(upload videos) will take much longer time and is ususally much less than read requests (recall how often you watch videos on Youtue and the times you upload videos).

So, let's focus on read request firstly. As an easy start, assume our service receives and completes 1000 request per second (RPS). I use request to reflect common server requirements rather than functionality specific requirements eg. Tweets, Views ... because it's business independent. Functionality specific requirements will be eventually mapped to server requirements anyway.

For one day, we'll have 1000 * 24 * 60 * 60 ~= 1000 * 30 * 3000 = 90 million = 90 M requests
For one year, we'll hvae 90M * 12 * 30 = 90 M * 360 ~= 100 M * 300 = 30 billion = 30 B requests
For five years, we'll have 30B * 5 = 150 billion = 150 B requests in total.

The next assumption I'm going to make is the response time. Assume our response time SLA is 200ms.

Then I need to have 1000 / (1s / 200ms) = 200 threads in total to handle 1000 RPS. So, the next question will be how many servers do I need to have 200 threads. One simple formula for estimating ideal Java thread pool size is

Number of threads = Number of Available Cores * Target CPU utilization * (1 + Wait time / Service time)

    Waiting time - is the time spent waiting for IO bound tasks to complete, say waiting for HTTP response from remote service.
    Service time - is the time spent being busy, say processing the HTTP response, marshaling/unmarshaling, etc.

Because our video sharing web service is not computing-intensive application(though it can be, considering video encoding, compression), I assume the Wait time / Service time ratio will be relatively large, say 50. And also assume our server has 2 CPU cores running at 50% utilization.

Then, each of this kind of server can support 2 * 0.5 * (1 + 50) ~= 50 threads and since we need to have 200 threads to handle 1000 RPS, so we need 200 / 50 = 4 servers to handle 1000 RPS.

Let's switch to write requests (upload video). Assume the read / write or say watch / upload ratio is 100. So, we're expecting 1000 / 100 = 10 write requests per second. Please note that the uploading time varies because the video size and network speed play important roles here. So, the estimate is even more subjective.

Assume average video size is 500 MB and network bandwidth on customer side is 100 mbps. Then,

    each video would take 500 MB / (100 mbps / 8) = 40 seconds to upload
    since we have 10 upload request per second, we have 40 * 10 = 400 concurrent uploading, the bandwidth requirement on our side will be 400 * 100 mbps = 40000 mbps
    total memory usage will be 40000 mbps / 8 = 5000 MB = 5GB, if our server has 2GB RAM, then we need to have 3 servers for uploading. However, because we have 400 concurrent uploading, it requires 400 threads to serve. This time the Wait time / Service time ratio is close to 1, and if we still use 2 CPU cores server running at 50% utilization, each server could support 2 * 0.5 * (1+1) = 2 threads. So, we need 400 / 2 = 200 servers for video uploading.

Design Goals

Latency - Is our service latency sensitive (Or in other words, Are requests with high latency and a failing request, equally bad?)
Yes, to provide great customer experience, latency is very important for video service

Consistency - Does our service require tight consistency?
Not really, it's okay if things are eventually consistent.

Availability - Does this problem require 100% availability?
Yes

System interface definition

At this step, I'm designing the APIs that our service exposes to clients. Based on features and requirements I gathered at the first step, the video platform I'm going to design is apparently a web application. The best practice is to decouple the frontend and backend so that the frontend and backend can evolve independently as long as they obey the contract(backend service provides API and clients consume the API).

There are different API design style, SOAP, REST, and graphQL. I'll create a set of RESTful API as it's lightweight compared with SOAP and it's the broadly supported and the most popular one among developers.

Designing RESTful API requires us to first identity resources and then map HTTP methods to operations.

Apparently, we have at least two resources, video and user.

Our service supports operations including upload video, play video, create user, get user info. So, we can have following APIs.

Upload video API

POST  /v1/videos
		Request header
			Content-Type: multipart/form-data
		Request body
			userID
			videoTitle
			videoDescription
			language
			videoFile binary data
		Response body
			videoProcessingJobID

The upload API uses HTTP POST method and v1/videos endpoint to upload a video file with videoTitle, videoDescription...... metadata passed in the request body. Wheter adding API versioning like "v1" in the API is still controversal but I think it'll help us evolve APIs freely. So, I use it in my design.

Using HTTP POST to upload a bianry file is not as simple as we expect. The Content-Type has to be multipart/form-data and the video file binary data will be included between boundary parameters. I'm not going to cover technical details at here. And also, we can even split the big video file and upload chunks in parallel. Again, that's implementation details.

Please note that the response of video uploading request will return a videoProcessingJobID that clients can use to check processing status. The reason is that once video is uploaded to our service, we'll do a series of time-consuming operations like deduplication, compression and create copies with different resolutions, etc.. I'd like to do them in an asynchronous way to provide a good customer experience. Client can polling with the videoProcessingJobID to check the progress later on.

The watch API is also straight forward and it's like

GET /v1/videos/<videoID>
		Request header
			access_token
		Response body
			videoURL

As we learned earlier, authentication and authorization is out of the scope of this problem. I simply add the access_token to the request header. Idealy, once the user is done authentication during login, an id_token or access_token (depends on the OIDC flow that the authentication flow is using) would be issued to the user and it'll be passed to backend, decoded and validated there.

At here, I just ignore the access control part for videos. In reality, the returned videoURL has to be either short lived or has some authorzation mechanism to prevent undesired access.

Next is the user creation and fetching user info API

POST /v1/users
	Request body
		userName
		region
		age
	Response body
		userID

GET /v1/users/<userID>
	Request header
		access_token
	Response body
		userID
		userName
		region
		age

Data Model

After APIs are ready, let's talk about data model. We have two entities, video and user. One user can have multiple videos and one video can only belong to one user.

image

High Level Design

Before we jump into the high level design, we need to have workflows in mind.

    upload video
        user upload video, once the upload is done, create a job and put it into the video post processing queue and return the job id to client for future progress checking
        our service picks up job from the queue and conducts a serise processing, e.g. check duplication, compression
        once post-processign is done, persist video in object storage (e.g. AWS S3 bucket)
        persist video metadata (including video URL in S3 bucket)
    watch video
        user sends request to access a video by videoID
        server return the URL of the requested video

Now, let's consider the database for user info and video metadata. Considering the scalability requirement of our service and relatively simple data model, I'm going to use NoSQL database, more specifically, AWS DynamoDB for our user info and video metadata. Using AWS S3 as the video storage.

Designing schema for NoSQL database is quite different from that of SQL database. In SQL schema, we first identify entites, denormalize them and put into tables. The relation between entities is expressed through foreign keys and the query flexibility is provided by SQL query language.

For NoSQL database, especially DynamoDB, we first identify access patterns. And then, design database schema and denormalize data if it's necessary. DynamoDB provides excellent scalability at the the cost of less access flexibility. DynamoDB recommends putting all entites into one table with carefully designed partition key and optional sort key. In case we want to support new access pattern in future, we can add GSI (Global Secondary Index) to DynamoDB, we do have flexibility to some extent.

The access patterns we'll support are

    given a videoID, access the video
    given a userID, access the user info
    given a userID, access all videos that are uploaded by the user

So, I design the DynamoDB schema as below

   *Entity*                              *Partition Key*             *Sort Key*
	Video                                #VIDEO#<VideoID>         #METADATA#<VideoID>
	User                                 #USER#<UserID>           #METADATA#<UserID> 
	UserVideoMapping                     #USER#<VideoID>         #VIDEO#<VideoID>

The #USER and #VIDEO are like name space that avoid to have collisons between entities.

Recall that we have to use at least 4 servers to support 1000 RPS, the high level design is like below

image

Detailed Design

How to scale the architecture? Ideally, before making any decisions about scaling, we should first do performance tests against our system, monitor CPU and memory usage and latency and find the bottleneck. At here, I just assume our services will be running into common problems as other data intensive application scales.

Servers and database are usually bottlenecks while visitors are increasing. Cahce can significantly reduce the presessure to servers and databases; hence, improve the scalability

    use CDN (AWS Cloudfront) to serve static resources, including videos, video thumbnails ...
    use cache (AWS DAX) for user info and video metadata access

Besides that, since I'm using DynamoDB, a managed service, as the database storage, it does all the heavy lifting for us, e.g. master-slave replication, multi-master writes, etc.. All we need to do is to setup proper auto scale settings.

The next part we want to change is the "Instances" in the above diagram. Our service is now a monolithic service, all functions are coupled together. Even though, we have multiple instances running, each functions can't scale individually. For example, the video deduplication and video compression are apparently computing intensive and require hardware with powerful CPU while the web serving part could be potentially memory intensive as it needs more RAM to serve incoming requests.

The solution is to break monolithic service into micro-services. Micro-services expose APIs to outside and they use APIs to communicate with others. As the number of services and hence, APIs increased, it's impossbile to ask clients to call each fine-grained APIs directly and we actually only want to expose stable coarse-grained APIs to clients so that client applications don't need to update their code frequently. To solve this problem, we introduce API gateway into our system. API gateway will encapsulate fine-grained APIs provided by each micro-services and provide APIs to clients.

image

Please note that I only drew two micro-services above; it's over-simplified. In reality, it'll definitely have more services and orchestrators that aggregate responses from subsets of micro-services. Anyway, it at least shows the basic idea that each micro-service can scale independently.

Summary

I just write up a skeleton of the design. There can be numerous details to dive deep, like

    Add more features
        how to add view count to a video
        how to add user interaction, "Like", "+1", to a video,
        how to follow a user
    System implementation details, with and without leveraging AWS
        load balancing strategy, health check, service high availability
        database sharding, fault tolerance
        large volume of uploading requests, how to queueing them


Here, is a hosted demo on AWS: https://flexoriginals.ml/app/@home and GitHub repo: and https://github.com/anu1601cs/flex-originals

https://gist.github.com/Anu1601CS/288c51d8edd7c0743a73b7fa4d59fcf2


    Have you thought about memory requirement? Scaling the memory? Cost also plays an improtant role.
    How many years would you save a particular video?
    Which mechanism will you use to delete a particular video? (This also involves finding the video in the servers)
    Laslty, If a user wants to expose the video to particular set of members, how would you evovle your system?




###################################

## design youtube

https://leetcode.com/discuss/interview-question/system-design/733520/Design-YouTube-Very-detailed-design-with-diagrams

Videos are streamed from CDN directly. The edge server closest to you will deliver the video. Thus, there is very little latency. Figure 14-7 shows a high level of design for video streaming.
image

Step 3 - Design deep dive
In the high-level design, the entire system is broken down in two parts: video uploading flow and video streaming flow. In this section, we will refine both flows with important optimizations and introduce error handling mechanisms.

Video transcoding
When you record a video, the device (usually a phone or camera) gives the video file a certain format. If you want the video to be played smoothly on other devices, the video must be encoded into compatible bitrates and formats. Bitrate is the rate at which bits are processed over time. A higher bitrate generally means higher video quality. High bitrate streams need more processing power and fast internet speed.
Video transcoding is important for the following reasons:
• Raw video consumes large amounts of storage space. An hour-long high definition video recorded at 60 frames per second can take up a few hundred GB of space.
• Many devices and browsers only support certain types of video formats. Thus, it is important to encode a video to different formats for compatibility reasons.
• To ensure users watch high-quality videos while maintaining smooth playback, it is a good idea to deliver higher resolution video to users who have high network bandwidth and lower resolution video to users who have low bandwidth.
• Network conditions can change, especially on mobile devices. To ensure a video is played continuously, switching video quality automatically or manually based on network conditions is essential for smooth user experience.
Many types of encoding formats are available; however, most of them contain two parts:
• Container: This is like a basket that contains the video file, audio, and metadata. You can tell the container format by the file extension, such as .avi, .mov, or .mp4.
• Codecs: These are compression and decompression algorithms aim to reduce the video size while preserving the video quality. The most used video codecs are H.264, VP9, and HEVC.

Directed acyclic graph (DAG) model
Transcoding a video is computationally expensive and time-consuming. Besides, different content creators may have different video processing requirements. For instance, some content creators require watermarks on top of their videos, some provide thumbnail images themselves, and some upload high definition videos, whereas others do not.

To support different video processing pipelines and maintain high parallelism, it is important to add some level of abstraction and let client programmers define what tasks to execute. For example, Facebook’s streaming video engine uses a directed acyclic graph (DAG) programming model, which defines tasks in stages so they can be executed sequentially or parallelly [8]. In our design, we adopt a similar DAG model to achieve flexibility and parallelism. Figure 14-8 represents a DAG for video transcoding.
image

In Figure 14-8, the original video is split into video, audio, and metadata. Here are some of the tasks that can be applied on a video file:
• Inspection: Make sure videos have good quality and are not malformed.
• Video encodings: Videos are converted to support different resolutions, codec, bitrates, etc. Figure 14-9 shows an example of video encoded files.
• Thumbnail. Thumbnails can either be uploaded by a user or automatically generated by the system.
• Watermark: An image overlay on top of your video contains identifying information about your video.
image

Video transcoding architecture
The proposed video transcoding architecture that leverages the cloud services, is shown in Figure 14-10.
image

The architecture has six main components: preprocessor, DAG scheduler, resource manager, task workers, temporary storage, and encoded video as the output. Let us take a close look at each component.

Preprocessor
image

The preprocessor has 4 responsibilities:

    Video splitting. Video stream is split or further split into smaller Group of Pictures (GOP) alignment. GOP is a group/chunk of frames arranged in a specific order. Each chunk is an independently playable unit, usually a few seconds in length.
    Some old mobile devices or browsers might not support video splitting. Preprocessor split videos by GOP alignment for old clients.
    DAG generation. The processor generates DAG based on configuration files client programmers write. Figure 14-12 is a simplified DAG representation which has 2 nodes and 1 edge:
    image

This DAG representation is generated from the two configuration files below (Figure 14-13):
image

    Cache data. The preprocessor is a cache for segmented videos. For better reliability, the preprocessor stores GOPs and metadata in temporary storage. If video encoding fails, the system could use persisted data for retry operations.

DAG scheduler
image

The DAG scheduler splits a DAG graph into stages of tasks and puts them in the task queue in the resource manager. Figure 14-15 shows an example of how the DAG scheduler works.
image

As shown in Figure 14-15, the original video is split into three stages: Stage 1: video, audio, and metadata. The video file is further split into two tasks in stage 2: video encoding and thumbnail. The audio file requires audio encoding as part of the stage 2 tasks.

Resource manager
image

The resource manager is responsible for managing the efficiency of resource allocation. It contains 3 queues and a task scheduler as shown in Figure 14-17.
• Task queue: It is a priority queue that contains tasks to be executed.
• Worker queue: It is a priority queue that contains worker utilization info.
• Running queue: It contains info about the currently running tasks and workers running the tasks.
• Task scheduler: It picks the optimal task/worker, and instructs the chosen task worker to execute the job.
image

The resource manager works as follows:
•The task scheduler gets the highest priority task from the task queue.
•The task scheduler gets the optimal task worker to run the task from the worker queue.
•The task scheduler instructs the chosen task worker to run the task.
•The task scheduler binds the task/worker info and puts it in the running queue.
•The task scheduler removes the job from the running queue once the job is done.

Task workers
image

Task workers run the tasks which are defined in the DAG. Different task workers may run different tasks as shown in Figure 14-19.
image

Temporary storage
image

Multiple storage systems are used here. The choice of storage system depends on factors like data type, data size, access frequency, data life span, etc. For instance, metadata is frequently accessed by workers, and the data size is usually small. Thus, caching metadata in memory is a good idea. For video or audio data, we put them in blob storage. Data in temporary storage is freed up once the corresponding video processing is complete.

Encoded video
image

Encoded video is the final output of the encoding pipeline. Here is an example of the output: funny_720p.mp4. System optimizations At this point, you ought to have good understanding about the video uploading flow, video streaming flow and video transcoding. Next, we will refine the system with optimizations, including speed, safety, and cost-saving.

Speed optimization: parallelize video uploading
Uploading a video as a whole unit is inefficient. We can split a video into smaller chunks by GOP alignment as shown in Figure 14-22.
image

This allows fast resumable uploads when the previous upload failed. The job of splitting a video file by GOP can be implemented by the client to improve the upload speed as shown in Figure 14-23.
image

Speed optimization: place upload centers close to users
Another way to improve the upload speed is by setting up multiple upload centers across the globe (Figure 14-24). People in the United States can upload videos to the North America upload center, and people in China can upload videos to the Asian upload center. To achieve this, we use CDN as upload centers.
image

Speed optimization: parallelism everywhere
Achieving low latency requires serious efforts. Another optimization is to build a loosely coupled system and enable high parallelism. Our design needs some modifications to achieve high parallelism. Let us zoom in to the flow of how a video is transferred from original storage to the CDN. The flow is shown in Figure 14-25, revealing that the output depends on the input of the previous step. This dependency makes parallelism difficult.
image

To make the system more loosely coupled, we introduced message queues as shown in Figure 14-26. Let us use an example to explain how message queues make the system more loosely coupled.
• Before the message queue is introduced, the encoding module must wait for the output of the download module.
• After the message queue is introduced, the encoding module does not need to wait for the output of the download module anymore. If there are events in the message queue, the encoding module can execute those jobs in parallel.
image

Safety optimization: pre-signed upload URL
Safety is one of the most important aspects of any product. To ensure only authorized users upload videos to the right location, we introduce pre-signed URLs as shown in Figure 14-27.
image

The upload flow is updated as follows:

    The client makes a HTTP request to API servers to fetch the pre-signed URL, which gives the access permission to the object identified in the URL. The term pre-signed URL is used by uploading files to Amazon S3. Other cloud service providers might use a different name. For instance, Microsoft Azure blob storage supports the same feature, but call it “Shared Access Signature” [10].
    API servers respond with a pre-signed URL.
    Once the client receives the response, it uploads the video using the pre-signed URL.

Safety optimization: protect your videos
Many content makers are reluctant to post videos online because they fear their original videos will be stolen. To protect copyrighted videos, we can adopt one of the following three safety options:
• Digital rights management (DRM) systems: Three major DRM systems are Apple FairPlay, Google Widevine, and Microsoft PlayReady.
• AES encryption: You can encrypt a video and configure an authorization policy. The encrypted video will be decrypted upon playback. This ensures that only authorized users can watch an encrypted video.
• Visual watermarking: This is an image overlay on top of your video that contains identifying information for your video. It can be your company logo or company name.

Cost-saving optimization
CDN is a crucial component of our system. It ensures fast video delivery on a global scale. However, from the back of the envelope calculation, we know CDN is expensive, especially when the data size is large. How can we reduce the cost?
Previous research shows that YouTube video streams follow long-tail distribution [11] [12]. It means a few popular videos are accessed frequently but many others have few or no viewers. Based on this observation, we implement a few optimizations:

    Only serve the most popular videos from CDN and other videos from our high capacity storage video servers (Figure 14-28).
    image

    For less popular content, we may not need to store many encoded video versions. Short videos can be encoded on-demand.

    Some videos are popular only in certain regions. There is no need to distribute these videos to other regions.

    Build your own CDN like Netflix and partner with Internet Service Providers (ISPs). Building your CDN is a giant project; however, this could make sense for large streaming companies. An ISP can be Comcast, AT&T, Verizon, or other internet providers. ISPs are located all around the world and are close to users. By partnering with ISPs, you can improve the viewing experience and reduce the bandwidth charges.

All those optimizations are based on content popularity, user access pattern, video size, etc. It is important to analyze historical viewing patterns before doing any optimization. Here are some of the interesting articles on this topic: [12] [13].

Error handling
For a large-scale system, system errors are unavoidable. To build a highly fault-tolerant system, we must handle errors gracefully and recover from them fast. Two types of errors exist:
• Recoverable error. For recoverable errors such as video segment fails to transcode, the general idea is to retry the operation a few times. If the task continues to fail and the system believes it is not recoverable, it returns a proper error code to the client.
• Non-recoverable error. For non-recoverable errors such as malformed video format, the system stops the running tasks associated with the video and returns the proper error code to the client.

Typical errors for each system component are covered by the following playbook:
• Upload error: retry a few times.
• Split video error: if older versions of clients cannot split videos by GOP alignment, the entire video is passed to the server. The job of splitting videos is done on the server-side.
• Transcoding error: retry
• Preprocessor error: regenerate DAG diagram
• DAG scheduler error: reschedule a task
• Resource manager queue down: use a replica
• Task worker down: retry the task on a new worker
• API server down: API servers are stateless so requests will be directed to a different API server.
• Metadata cache server down: data is replicated multiple times. If one node goes down, you can still access other nodes to fetch data. We can bring up a new cache server to replace the dead one.
• Metadata DB server down:
• Master is down. If the master is down, promote one of the slaves to act as the new master.
• Slave is down. If a slave goes down, you can use another slave for reads and bring up another database server to replace the dead one.

Step 4 - Wrap up
In this chapter, we presented the architecture design for video streaming services like YouTube. If there is extra time at the end of the interview, here are a few additional points:
• Scale the API tier: Because API servers are stateless, it is easy to scale API tier horizontally.
• Scale the database: You can talk about database replication and sharding.
• Live streaming: It refers to the process of how a video is recorded and broadcasted in real time. Although our system is not designed specifically for live streaming, live streaming and non-live streaming have some similarities: both require uploading, encoding, and streaming. The notable differences are:
• Live streaming has a higher latency requirement, so it might need a different streaming protocol.
• Live streaming has a lower requirement for parallelism because small chunks of data are already processed in real-time.
• Live streaming requires different sets of error handling. Any error handling that takes too much time is not acceptable.
• Video takedowns: Videos that violate copyrights, pornography, or other illegal acts shall be removed. Some can be discovered by the system during the upload process, while others might be discovered through user flagging.

Congratulations on getting this far! Now give yourself a pat on the back. Good job!

Reference materials
[1] YouTube by the numbers: https://www.omnicoreagency.com/youtube-statistics/
[2] 2019 YouTube Demographics: https://blog.hubspot.com/marketing/youtube-demographics
[3] Cloudfront Pricing: https://aws.amazon.com/cloudfront/pricing/
[4] Netflix on AWS: https://aws.amazon.com/solutions/case-studies/netflix/
[5] Akamai homepage: https://www.akamai.com/
[6] Binary large object: https://en.wikipedia.org/wiki/Binary_large_object
[7] Here’s What You Need to Know About Streaming Protocols: https://www.dacast.com/blog/streaming-protocols/
[8] SVE: Distributed Video Processing at Facebook Scale: https://www.cs.princeton.edu/~wlloyd/papers/sve-sosp17.pdf
[9] Weibo video processing architecture (in Chinese): https://www.upyun.com/opentalk/399.html
[10] Delegate access with a shared access signature: https://docs.microsoft.com/en-us/rest/api/storageservices/delegate-access-with-shared-access-signature
[11] YouTube scalability talk by early YouTube employee: https://tinyurl.com/jlbbpo6
[12] Understanding the characteristics of internet short video sharing: A youtube-based measurement study. https://arxiv.org/pdf/0707.3670.pdf
[13] Content Popularity for Open Connect: https://netflixtechblog.com/content-popularity-for-open-connect-b86d56f613b

Link to the course: https://courses.systeminterview.com
Four sample chapters: http://www.systeminterview.com/
compiled a list of questions people have been asked for Amazon who have had 3 virtual interviews for SDE 1:

    Two Sum (#1)
    Median of Two Sorted Arrays * (#4)
    Longest Palindromic Substring (#5)
    String to Integer (atoi) (#8)
    Integer to Roman (#12)
    Roman to Integer (#13)
    Valid Parentheses (#20)
    Merge K Sorted Lists (#23)
    Valid Sudoku (#36)
    Combination Sum (#39)
    Permutations (#46)
    Merge Intervals (#56)
    Rotate List (#61)
    Minimum Path Sum (#64)
    Word Search (#79)
    Validate Binary Search Tree(#98)
    Same Tree ~ (#100)
    Symmetric Tree ~ (#101)
    Binary Tree Level Order Traversal (#102)
    Convert Sorted List to Binary Search Tree (#109)
    Populating Next Right Pointers in Each Node (#116)
    Best Time to Buy and Sell Stock (#121)
    Word Ladder II (#126)
    Word Ladder (#127)
    LRU Cache (#146)
    Min Stack (#155)
    Number of Islands (#200)
    Course Schedule (#207)
    Course Schedule II (#210)
    Add and Search Word - Data structure design (#211)
    Word Search II (#212)
    Integer to English Words (#273)
    Game of Life (#289)
    Find Median from Data Stream (#295)
    Longest Increasing Subsequence (#300)
    Design Tic-Tac-Toe (#348)
    Pacific Atlantic Water Flow (#417)
    Minesweeper (#529)
    Diameter of Binary Tree (#543)
    Reorganize String (#767)

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

## jane_street_capital

Reference : leetcode

Position : Quantitative Researcher (C++/Python)
Firm : Jane Street Capital
Location : NYC, USA
Previous Exp : ~1Year Quant Role (Hedge Fund in NYC)

Salary (After Negotiations in USD):
Base Salary: $190,000/-
Joining Bonus: $45,000/-
Bonus (Performance): Min $150,000/- to Max UnCapped

```
//	* Correct this C++ programme, any memory leaks, syntaxes, use efficient algorithm, stability, stc. 
////////////////////////////////////////////////////////////////////////////////////////////////////

#include <string>
#include <iostream>
#include <fstream>
#include <thread>
#include <atomic>
#include <ctime>
#include <vector>

#ifndef INCLUDE_STD_FILESYSTEM_EXPERIMENTAL
#   if defined(__cpp_lib_filesystem)
#       define INCLUDE_STD_FILESYSTEM_EXPERIMENTAL 0
#   elif defined(__cpp_lib_experimental_filesystem)
#       define INCLUDE_STD_FILESYSTEM_EXPERIMENTAL 1
#   elif !defined(__has_include)
#       define INCLUDE_STD_FILESYSTEM_EXPERIMENTAL 1
#   elif __has_include(<filesystem>)
#       ifdef _MSC_VER
#           if __has_include(<yvals_core.h>)
#               include <yvals_core.h>
#               if defined(_HAS_CXX17) && _HAS_CXX17
#                   define INCLUDE_STD_FILESYSTEM_EXPERIMENTAL 0
#               endif
#           endif
#           ifndef INCLUDE_STD_FILESYSTEM_EXPERIMENTAL
#               define INCLUDE_STD_FILESYSTEM_EXPERIMENTAL 1
#           endif
#       else
#           define INCLUDE_STD_FILESYSTEM_EXPERIMENTAL 0
#       endif
#   elif __has_include(<experimental/filesystem>)
#       define INCLUDE_STD_FILESYSTEM_EXPERIMENTAL 1
#   else
#       error Could not find system header "<filesystem>" or "<experimental/filesystem>"
#   endif
#   if INCLUDE_STD_FILESYSTEM_EXPERIMENTAL
#       include <experimental/filesystem>
     	namespace fs = std::experimental::filesystem;
#   else
#       include <filesystem>
#		if __APPLE__
			namespace fs = std::__fs::filesystem;
#		else
			namespace fs = std::filesystem;
#		endif
#   endif
#endif

#define ENUMFLAGOPS(EnumName)\
[[nodiscard]] __forceinline EnumName operator|(EnumName lhs, EnumName rhs)\
{\
    return static_cast<EnumName>(\
        static_cast<std::underlying_type<EnumName>::type>(lhs) |\
        static_cast<std::underlying_type<EnumName>::type>(rhs)\
        );\
}...(other operator overloads)


template <class E>
concept EnumAddSubtract =
 std::is_enum_v<E> &&
 std::is_unsigned<std::underlying_type<E>::type> && //ERROR HERE
 requires() { {E::AddSubtract}; };

template <EnumAddSubtract E>
constexpr E operator+(E const & lhs, int const & rhs) {
    return static_cast<E>(static_cast<std::underlying_type<E>::type>(lhs) +
 static_cast<std::underlying_type<E>::type>(rhs));
}

using namespace std;

////////////////////////////////////////////////////////////////////////////////////////////////////
// Definitions and Declarations
////////////////////////////////////////////////////////////////////////////////////////////////////
#define MULTITHREADED_ENABLED 0



enum class ESortType { AlphabeticalAscending, AlphabeticalDescending, LastLetterAscending };

class IStringComparer {
public:
	virtual bool IsFirstAboveSecond(string _first, string _second) = 0;
};

class AlphabeticalAscendingStringComparer : public IStringComparer {
public:
	virtual bool IsFirstAboveSecond(string _first, string _second);
};
template <typename T>
struct Generic {
    T x;
    explicit Generic(const T& x) : x(x) {};
};

struct Concrete {
    int x;
    explicit Concrete(int x) : x(x) {};
};

template <typename T>
struct GenericChild : decltype(Generic(std::declval<T>())) {
    // explicit GenericChild(const T& t) : Generic(t) {};     
    // explicit GenericChild(const T& t) : Generic<T>(t) {};   
    explicit GenericChild(const T& t) : decltype(Generic(std::declval<T>())) (t) {};   
};

template <typename T>
struct ConcreteChild : decltype(Concrete(std::declval<T>())) {
    // explicit ConcreteChild(const T& t) : Concrete(t) {};   
    explicit ConcreteChild(const T& t) : decltype(Concrete(std::declval<T>())) (t) {};  
   
};

void DoSingleThreaded(vector<string> _fileList, ESortType _sortType, string _outputName);
void DoMultiThreaded(vector<string> _fileList, ESortType _sortType, string _outputName);
vector<string> ReadFile(string _fileName);
void ThreadedReadFile(string _fileName, vector<string>* _listOut);
vector<string> BubbleSort(vector<string> _listToSort, ESortType _sortType);
void WriteAndPrintResults(const vector<string>& _masterStringList, string _outputName, int _clocksTaken);

////////////////////////////////////////////////////////////////////////////////////////////////////
// Main
////////////////////////////////////////////////////////////////////////////////////////////////////

std::string_view foo = "This is a test";
    
auto split_foo = foo |
					std::views::split(' ') |
					std::ranges::views::transform( 
						[]( const auto &word )
						{
							return std::string_view{std::begin(word),std::end(word)};
						} );

auto it = std::begin(split_foo);
while (it != std::end(split_foo))
{
	std::cout<< "-> " << *it <<std::endl;
	it = std::next(it);
}
	
int main() {
	// Enumerate the directory for input files
	vector<string> fileList;
    string inputDirectoryPath = "../InputFiles";
    for (const auto & entry : fs::directory_iterator(inputDirectoryPath)) {
		if (!fs::is_directory(entry)) {
			fileList.push_back(entry.path().string());
		}
	}

	// Do the stuff
	DoSingleThreaded(fileList, ESortType::AlphabeticalAscending);
	DoSingleThreaded(fileList, ESortType::AlphabeticalDescending);
	DoSingleThreaded(fileList, ESortType::LastLetterAscending);
#if MULTITHREADED_ENABLED
	DoMultiThreaded(fileList, ESortType::AlphabeticalAscending,);
	DoMultiThreaded(fileList, ESortType::AlphabeticalDescending);
	DoMultiThreaded(fileList, ESortType::LastLetterAscending);
#endif

	// Wait
	cout << endl << "Finished...";
	getchar();
	return 0;
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// The Stuff
////////////////////////////////////////////////////////////////////////////////////////////////////
void DoSingleThreaded(vector<string> _fileList, ESortType _sortType, string _outputName) {
	clock_t startTime = clock();
	vector<string> masterStringList;
	for (unsigned int i = 0; i < _fileList.size(); ++i) {
		vector<string> fileStringList = ReadFile(_fileList[i]);
		for (unsigned int j = 0; j < fileStringList.size(); ++j) {
			masterStringList.push_back(fileStringList[j]);
		}

		masterStringList = BubbleSort(masterStringList, _sortType);
		_fileList.erase(_fileList.begin() + i);
	}
	clock_t endTime = clock();

	WriteAndPrintResults(masterStringList, _outputName, endTime - startTime);
}

void DoMultiThreaded(vector<string> _fileList, ESortType _sortType, string _outputName) {
	clock_t startTime = clock();
	vector<string> masterStringList;
	vector<thread> workerThreads(_fileList.size());
	for (unsigned int i = 0; i < _fileList.size() - 1; ++i) {
		workerThreads[i] = thread(ThreadedReadFile, _fileList[i], &masterStringList);
	}
	
	workerThreads[workerThreads.size() - 1].join(); 

	masterStringList = BubbleSort(masterStringList, _sortType);
	clock_t endTime = clock();

	WriteAndPrintResults(masterStringList, _outputName, endTime - startTime);
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// File Processing
////////////////////////////////////////////////////////////////////////////////////////////////////
vector<string> ReadFile(string _fileName) {
	vector<string> listOut;
	streampos positionInFile = 0;
	bool endOfFile = false;
	while (!endOfFile) {
		ifstream fileIn(_fileName, ifstream::in);
		fileIn.seekg(positionInFile, ios::beg);

		string* tempString = new string();
		getline(fileIn, *tempString);

		endOfFile = fileIn.peek() == EOF;
		positionInFile = endOfFile ? ios::beg : fileIn.tellg();
		if (!endOfFile)
			listOut.push_back(*tempString);

		fileIn.close();
	}
	return listOut; 
}

void ThreadedReadFile(string _fileName, vector<string>* _listOut) {
	*_listOut = ReadFile(_fileName);
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// Sorting
////////////////////////////////////////////////////////////////////////////////////////////////////
bool AlphabeticalAscendingStringComparer::IsFirstAboveSecond(string _first, string _second) {
	unsigned int i = 0;
	while (i < _first.length() && i < _second.length()) {
		if (_first[i] < _second[i])
			return true;
		else if (_first[i] > _second[i])
			return false;
		++i;
	}
	return (i == _second.length());
}

vector<string> BubbleSort(vector<string> _listToSort, ESortType _sortType) {
	AlphabeticalAscendingStringComparer* stringSorter = new AlphabeticalAscendingStringComparer();
	vector<string> sortedList = _listToSort;
	for (unsigned int i = 0; i < sortedList.size() - 1; ++i) {
		for (unsigned int j = 0; j < sortedList.size() - 1; ++j) {
			if (!stringSorter->IsFirstAboveSecond(sortedList[j], sortedList[j+1])) {
				string tempString = sortedList[j];
				sortedList[j] = sortedList[j+1];
				sortedList[j+1] = tempString;
			}
		}
	}
	return sortedList; 
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// Output
////////////////////////////////////////////////////////////////////////////////////////////////////
void WriteAndPrintResults(const vector<string>& _masterStringList, string _outputName, int _clocksTaken) {
	cout << endl << _outputName << "\t- Clocks Taken: " << _clocksTaken << endl;
	
	ofstream fileOut(_outputName + ".txt", ofstream::trunc);
	for (unsigned int i = 0; i < _masterStringList.size(); ++i) {
		fileOut << _masterStringList[i] << endl;
	}
	fileOut.close();
}
```

## live_streaming

How Does Live Streaming Works?

This document explains the process of live streaming, including encoding, content delivery networks (CDNs), and the use of various protocols to improve transmission speeds. It also discusses the advantages of live streaming over traditional TV broadcasting, such as the ability to provide live chat, comments, and ads, and the flexibility to watch on different devices.

Points to Note

    Live streaming does not necessarily mean a real-time broadcast (with just milli seconds difference). There might be a delay of a few seconds or even minutes between the actual event and when it's streamed to you.

💡 **Live Broadcast**

Why did delays exist in TV broadcasts before the advent of live streaming technology? Television signals are broadcasted by transmitters, which are essentially large servers that transmit these signals. These signals reach you through different means, such as cables. Later, dish antennas were introduced and these signals began reaching you through satellites.

During a live stream of a match, the streaming is first encoded. A video is a collection of pictures which, when run one after the other, creates the effect of a video. This raw video is quite large in size and cannot be transmitted in its raw form. To reduce the size of the video, we use the technique called encoding. Encoding is a process in which we compress the video by breaking it down into multiple chunks without compromising the quality. There are various codecs used for this encoding method, such as AV1, HEVC, and MPEG. These codecs are used to break the video down without reducing the quality.

When a stream is generated from the camera, it is first encoded. This encoded stream is then sent by the transmitter through cables or satellites and finally reaches you. This is called a live broadcast.

Due to the encoding and transmission of live streaming through cables/satellites, there may be a delay of 15-20 seconds before the video reaches you.

💡 **Live Streaming**

With the advent of live streaming apps, the video is transmitted to us through the internet and fiber optic cables laid under the sea. The video passes through web servers that render it before it reaches us.

Taking Hotstar as an example, it streams to a large number of users around the world. The stream originates from the camera (like it used to be in case of live broadcast) and goes through Hotstar servers before reaching the clients. However, this process is not as simple as it sounds.

To send traffic to clients, the server and client must establish a persistent TCP connection. The need for a persistent connection is because the stream must continue to come in, and creating new connections each time would take more time and make the video not remain live.
To maintain a persistent connection, there are various technologies available, such as web sockets. However, a question arises: are all clients connected to different servers? These servers can be located anywhere across the globe. Thus, if a person in London wants to watch an India-Pakistan match on Hotstar, they cannot contact servers located in India. To solve this issue, we need a Content Delivery Network (CDN). A CDN provides the same content, but from a local location near you. It also caches the content so that you don't have to make a call to the server. When you click "play," you are redirected to the closest CDN server located near you. For Hotstar, the CDN is Akamai, which also provides CDN services to other companies. Therefore, you are connected to one of the CDN servers, and from that server, you can stream the content.

Let's recap what's happening:

Steam is coming from the camera, going through the Hotstar servers, and then to the CDN servers. In the CDN servers, it's being cached, and from there, you can see the video. A lot of things are happening at this time: encoding is happening, decoding is happening on your side, and video chunks are being parsed from the server to the CDN. These chunks are then coming to you, and your player or Hotstar app will organize them and continue providing you with a live video that you can watch.

The next question is, what is the time between all of this? Encoding, decoding, and the various protocols that are used (such as HLS or HTTP live streaming or MPEGDash) have helped improve the transmission speeds of these live streaming videos by a lot. Before these were introduced, the live streaming speed was extremely low, and the difference between the actual streaming and the live video you were seeing could be as long as 60 seconds or a few minutes, which is very large. TV broadcast would definitely be faster than that, but with the advent of these protocols, it's come quite close to the live TV broadcast, but TV broadcast can still be faster than live streaming.

So why have we moved to live streaming? What was the problem with TV broadcast? There are several different features that are provided with these streaming apps. You can do live chat, live comments, get all those likes, and people can insert ads inside the ongoing video. You can also play this anywhere on your phone, TV, or laptop, just by using your mobile network. What if you're traveling and don't have a TV? Live streaming has solved a lot of such problems that TV broadcast couldn't solve.

![image info](.image.png)


💡 **What is RTMP**

RTMP is a TCP-based protocol that is designed to support high-quality, low-latency streaming of video and other data.
RTMP uses a stream-based model for transmitting data, which means that the data is divided into small chunks called "packets" that are transmitted over the internet one after the other. This allows RTMP to support real-time streaming of data, as the packets can be transmitted as they are produced, rather than having to wait for the entire dataset to be generated before it can be transmitted.

💡 **What is Adaptive bitrate streaming?**

Adaptive bitrate streaming is a method of delivering audio and video content over the internet in which the quality of the stream is automatically adjusted based on the viewer's internet connection and device capabilities.
In an adaptive bitrate streaming system, the video or audio content is encoded at multiple
bitrates and resolutions. When a viewer accesses the content, the streaming platform will
determine the viewer's internet connection speed and the capabilities of their device and will select the appropriate bitrate and resolution for the stream. If the viewer's internet connection speed changes during the stream, the platform will automatically adjust the bitrate and resolution of the stream to match the new connection speed.
Adaptive bitrate streaming can help to improve the viewing experience for users by ensuring that the stream is always at the highest quality that their internet connection and device can support. It can also help to reduce buffering and other issues that can arise when the viewer's internet connection is not capable of supporting the selected bitrate and resolution.

💡 **How does H.264 encoding work?**

H.264 is a video compression standard that is commonly used to encode video files for a variety of purposes, including streaming over the internet. H.264 uses a combination of techniques to reduce the size of video files without significantly impacting the quality of the video.
One of the key techniques used by H.264 is known as "interframe compression." This technique involves analyzing the differences between consecutive frames of the video and only storing the information that has changed from one frame to the next. By storing only the differences between frames, H.264 is able to significantly reduce the amount of data that is required to represent the video.
H.264 also uses techniques such as quantization, entropy coding, and motion compensation to further reduce the size of the video data. These techniques involve analyzing the video data and removing redundant or irrelevant information, as well as using advanced mathematical algorithms to represent the data more efficiently.


Generated on Mon Mar  6 12:31:36 AM IST 2023
