#!/bin/bash

set -e

VERSION="${1#v}"
CHANGELOG="CHANGELOG.md"
OUTPUT="${2:-release-notes.md}"

if [ -z "$VERSION" ]; then
  echo "Usage: extract_changelog.sh <version> [output-file]" >&2
  exit 1
fi

if [ ! -f "$CHANGELOG" ]; then
  echo "Error: $CHANGELOG not found" >&2
  exit 1
fi

awk -v version="$VERSION" '
  /^## \[/ {
    if (found) {
      exit
    }
    if ($0 ~ "^## \\[" version "\\]") {
      found = 1
      next
    }
  }
  found {
    print
  }
' "$CHANGELOG" > "$OUTPUT"

if [ ! -s "$OUTPUT" ]; then
  echo "Error: No changelog entry found for version $VERSION in $CHANGELOG" >&2
  exit 1
fi

echo "Extracted release notes for v$VERSION to $OUTPUT"
