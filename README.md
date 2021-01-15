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


Generated on Fr 15. Jan 10:22:03 CET 2021
