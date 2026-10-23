#!/usr/bin/env bash
set -uo pipefail

if [[ $# -ne 1 ]]; then
    echo "Usage: scan-source.sh DIRECTORY" >&2
    exit 2
fi

root="$1"

# TODO 1: Kiem tra thu muc va tep PHP
if [[ ! -d "$root" ]]; then
    echo "ERROR: Directory not found" >&2
    exit 2
fi

if ! find "$root" -type f -name '*.php' -print -quit | grep -q .; then
    echo "ERROR: No PHP files found" >&2
    exit 2
fi

list="$(mktemp)" || exit 2
trap 'rm -f "$list"' EXIT

if ! find "$root" -type f -name '*.php' -print0 > "$list"; then
    exit 2
fi

total=0
passed=0
failed=0

# TODO 2: Quet tat ca tep PHP
while IFS= read -r -d '' file; do
    total=$((total + 1))

    if php -l "$file" >/dev/null 2>&1; then
        echo "PASS $file"
        passed=$((passed + 1))
    else
        echo "FAIL $file"
        failed=$((failed + 1))
    fi
done < "$list"

printf 'TOTAL=%s PASS=%s FAIL=%s\n' "$total" "$passed" "$failed"

# TODO 3: Tra ve ma thoat
if [[ "$failed" -gt 0 ]]; then
    exit 1
else
    exit 0
fi
