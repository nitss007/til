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





