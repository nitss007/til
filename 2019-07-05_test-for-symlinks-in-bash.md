# Test for symlinks in Bash

Use `-L` instead of `-h` for compatibility.

```bash
if [[ -L /path/to/suspected_symlink ]]; then
  echo "is symlink"
else
  echo "no symlink"
fi  
```

