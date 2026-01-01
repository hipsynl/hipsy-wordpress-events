#!/bin/bash
set -e

INPUT_MD="readme.md"
OUTPUT_TXT="readme.txt"
PACKAGE_JSON="package.json"

# Extract values from package.json
# Try using jq if available, otherwise use node (should be available in Node.js projects)
if command -v jq &> /dev/null; then
    VERSION=$(jq -r '.version' "$PACKAGE_JSON")
    REQUIRES_AT_LEAST=$(jq -r '.wordpress.requiresAtLeast // "6.0"' "$PACKAGE_JSON")
    TESTED_UP_TO=$(jq -r '.wordpress.testedUpTo // "6.2.2"' "$PACKAGE_JSON")
elif command -v node &> /dev/null; then
    # Fallback: use node to parse JSON
    VERSION=$(node -p "require('./$PACKAGE_JSON').version")
    REQUIRES_AT_LEAST=$(node -p "require('./$PACKAGE_JSON').wordpress?.requiresAtLeast || '6.0'")
    TESTED_UP_TO=$(node -p "require('./$PACKAGE_JSON').wordpress?.testedUpTo || '6.2.2'")
else
    # Last resort: basic grep/sed (may not work for nested JSON)
    echo "Warning: Neither jq nor node found. Using basic parsing." >&2
    VERSION=$(grep -o '"version": "[^"]*"' "$PACKAGE_JSON" | head -1 | sed 's/"version": "\(.*\)"/\1/')
    REQUIRES_AT_LEAST="6.0"
    TESTED_UP_TO="6.2.2"
fi

# --- WordPress readme header ---
cat <<EOF > "$OUTPUT_TXT"
=== Hipsy Events ===

Contributors: hipsy,howaboutyes
Donate link: https://hipsy.nl
Tags: events, tickets

Requires at least: $REQUIRES_AT_LEAST
Tested up to: $TESTED_UP_TO
Stable tag: $VERSION

License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

EOF

# --- Convert Markdown body ---
# Basic, explicit conversions (no black-box tooling)
sed \
  -e 's/^## \(.*\)/== \1 ==/' \
  -e 's/^### \(.*\)/= \1 =/' \
  -e 's/^# \(.*\)/== \1 ==/' \
  -e 's/\*\*\([^*]*\)\*\*/\*\1\*/g' \
  "$INPUT_MD" >> "$OUTPUT_TXT"