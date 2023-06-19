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
    "name": "Test Variant {{\$randomInt}}",
    "id": "{{\$guid}}"
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

## javascript_Day1_Closure_Hoisting



An awesome thing about JavaScript is your browser has a built-in execution environment. You can read more on how to execute code within your browser (and view a website's code) here.


### Function Syntax

```
function f(.. args){}
function -> keyword
f-> function name
.. args --> variable length parameters
function f(a,b){
    return a+b;
}
```

### Anonymous Function
function name can be optionally excluded in defination

```
var f = function (a,b) => {
    return a+b;
}
```

### Immediately invoked expressions (IIFE)
create a function and Immediately execute it
```
const result  = (function(a,b){
    const sum = a+b;
}(3,4));
```

It gives you the opportunity to encapsulate a variable within a new scope. For example, another developer can immediately see that sum can't be used anywhere outside the function body.


### Functions within functions

we can create function within Function and return them

function fun(){
    return function(a,b){
        const sum = a+b;
        return sum;
    }
}
const f = fun();
console.log(f(2,3));

In this example, createFunction() returns a new function. Then that function can be used as normal.

### Function Hoisting

when we use function before it is initialized

function fun(){
    return f;
    function f(a,b){
        const sum = a+b;
        return sum;
    }
}
const f = fun();
console.log(f(3,4));

In this example, the function is returned before it is initialized. Although it is valid syntax, it is sometimes considered bad practice as it can reduce readability.


## Closures
When a function is created, it has access to a reference to all the variables declared around it. Lexical environment.
the combination of environment and function is called closure.
function createAdder(a){
    function f(b){
        const  sum = a+b;
        return sum;
    }
    return f;
}
const f = createAdder(3);
console.log(f(a));

createAdder passes the first parameter a and the inner function has access to it. This way, createAdder serves as a factory of new functions, with each returned function having different behavior


## Arrow Syntax
function keyword can be excluded with =>

const f = ()=> {return "hello";}
const f = ()=>  "hello";

## Differences

There are 3 major differences between arrow syntax and function syntax.

    More minimalistic syntax. This is especially true for anonymous functions and single-line functions. For this reason, this way is generally preferred when passing short anonymous functions to other functions.
    No automatic hoisting. You are only allowed to use the function after it was declared. This is generally considered a good thing for readability.
    Can't be bound to this, super, and arguments or be used as a constructor. These are all complex topics in themselves but the basic takeaway should be that arrow functions are simpler in their feature set. You can read more about these differences https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/Arrow_functions

## Rest Arguments

You can use rest syntax to access all the passed arguments as an array. This isn't necessary for this problem, but it will be a critical concept for many problems. You can read more about ... syntax.


```
function f(...args) {
  const sum = args[0] + args[1];
  return sum;
}
console.log(f(3, 4));
```

### Why
creating generic factory functions that accepts any functon as input and return a new version of function with specific modification called higher order function.

eg logged function factory

function log(inputFunction){
    return function(..args){
        console.log("Input", args);
        const result = inputFunction(..args);
        console.log("Output", result);
        return result;
    }
}
## back of envelope calculations

In a system design interview, the chances are high that you will be asked to estimate QPS (Queries per second) and Storage of the system using a back-of-the-envelope estimation.
There are various scales and numbers anyone appearing for System Design Interview should know. Some of the scales are as follows -

Number Scale

| ** Name ** | *Number* | * Number of Zeros|
| :--- | :---: | :---: |
| **1 Hundred** | 100 | 2 zeros |
| **1 Thousand** | 1000 | 3 zeros |
| *1  Million (M)*** | 1_000_000 | 6 zeros |
| *1  Billion (B)*** | 1_000_000_000 | 9 zeros |
| *1 Trillion (T)*** | 1000_000_000_000 | 12 zeros |
| *1 quadTrillion *** | 1000_000_000_000_000 | 15 zeros |


Power of Two's Scale

In a system design interview, the volume of huge data is measured on the power of 2. It gets as low as bits and bytes. A byte is measured as 8 bits. Estimations become easier if we co-relate the below table with the number table and make a rough approximation. The interviewer will expect you to know these scales.

| ** Name ** | *Power* | * Value|
| :--- | :---: | :---: |
| **1 KB ( KiloByte )** | 2^10 | 1024 ~1K |
| **1 MB ( Mega Byte )** | 2^20 | 1048576 ~ 1M |
| *1  GB ( Giga Byte)*** | 2^30 | 1073741824 ~1B |
| *1  TB ( TeraByte )  *** | 2^ 40 | 1099511627776 ~1T |
| *1  PB ( PetaByte) *** | 2^50 | 1125899906842624 ~1 QuadTrillion |

Latency Numbers

In a system design interview, the latency numbers play a vital role in estimations and in having the knowledge, like how much time certain components take to perform certain operations. Below are some of the latency numbers of various operations -

| ** Operation ** | * Time Taken* |
| :--- | :---: |
| ** L1 cache reference ** | .5 ns |
| ** Branch mispredict ** | 5 ns |
| ** L2 cache reference  ** | 7 ns |
| ** Mutex Lock/Unlock ** | 100 ns |
| ** Main Memory refernct ** | 100 ns |
| ** compress 1k byte with zippy ** | 10000 ns = 10 micros second |
| ** send 2k byte over 1Gbps network ** | 2*8* 10^12/10^9 ns = 20,000 ns  = 20 micro second |



| ** Operation ** | *Time taken* |
| :--- | :---: |
| ** Read 1MB sequentail from memory** | 250 micro seconds |
| ** Round trip bw same data center** | 500  micro seconds |
| ** Disk seek ** | 10 mseconds |
| ** Read 1MB sequentail from network** | 10  mseconds |
| ** Read 1MB sequentail from disk ** | 30  mseconds |
| ** send packets california to netherlands** | 150 mseconds |

Availability Numbers

In a system design interview, the High Availability discussion will happen for sure. It is defined as the ability of the system to be operational for a longer period of time. Below are some of the availability numbers you should know

| *** Availability %** | * Downtime per year* | * Downtime per month* | * Downtime per day * |
| :--- | :---: |:---: |:---: |
|90% (one nine) |36.53 days |73.05 hours | 2.40 hours|
|99% (two nines) | 3.65 days | 7.31 hours | 14.40 mins|
|99.9% (three nines) | 8.77 hours | 43.83 mins | 1.44 mins|
|99.99% (four nines) | 52.60 mins | 4.38 mins | 8.64 secs|
|99.999% (five nines) | 5.26 mins | 26.30 secs | 864.00 millisecs|
|99.9999% (six nines) | 31.56 secs |2.63 secs |86.40 millisecs|
|99.99999% (seven nines) | 3.16 secs |262.98 millisecs |8.64 millisecs|
|99.999999% (eight nines)| 315.58 millisecs | 26.30 millisecs | 864.00 microsecs)|
|99.9999999% (nine nines) |31.56 millisecs |2.63 millisecs |86.40 microsecs|


Blob/Object Storage Sizes

In a system design, there are various big systems that involve types of blobs/objects like images, videos, audio, etc. Below are some of the approximate storage sizes of various blobs/objects -

| **Object Type ** | *Size* |
| :--- | :---: |
|char (Unicode) | 2B|
|uuID | 16B|
|Thumbnails | 20-30 KB|
|Website image | 200-300 KB|
|Mobile image | 2-3 MB|
|Documents like books, reports, govt Ids etc | 1-3 MB|
|Audio files like songs, recordings etc | 4-5 MB|
|1 min 720px video | 60 MB|
|1 min 1080px video | 130 MB|
|1 min 4K video|350 MB

Generated on Mon Jun 19 09:16:59 PM IST 2023
