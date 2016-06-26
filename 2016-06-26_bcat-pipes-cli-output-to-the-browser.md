# bcat pipes cli output to the browser

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
