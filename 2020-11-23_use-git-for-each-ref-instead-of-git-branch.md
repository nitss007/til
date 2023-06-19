## Use git for-each-ref instead of git branch

`git for-each-ref` is better suited for automated branch parsing than `git branch`.

Example usage which deletes branches which aren't on upstream:

```bash
git for-each-ref --shell --format='ref=%(refname:short); gone=%(if:equals=[gone])%(upstream:track)%(then)gone%(end); if [ "gone" = "$gone" ]; then echo "upstream for $ref is gone, will delete."; git branch -D "$ref"; else echo "will not delete $ref."; fi' 'refs/heads/**' | while read cmd; do eval "$cmd"; done
```

