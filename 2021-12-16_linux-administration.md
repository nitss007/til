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


