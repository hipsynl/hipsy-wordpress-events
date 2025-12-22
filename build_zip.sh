#!/bin/bash

# Exit on error
set -e

PLUGIN_SLUG="hipsy-events"
ZIP_NAME="hipsy-events.zip"

echo "🚀 Starting build process for $PLUGIN_SLUG..."

# 1. Install dependencies
if command -v yarn &> /dev/null && [ -f "yarn.lock" ]; then
    echo "📦 Installing dependencies with yarn..."
    yarn install
else
    echo "📦 Installing dependencies with npm..."
    npm install
fi

# 2. Build Assets
echo "🎨 Building assets..."

# Compile Sass (Laravel Mix)
# Using npx to ensure we use the local package version
echo "   - Running Laravel Mix (Sass compilation)..."
npx mix

# Compile Tailwind
# Input comes from the output of Sass (styles/css/main.css)
echo "   - Running Tailwind CSS (Minification)..."
npx tailwindcss -i ./styles/css/main.css -o ./styles/dist/main.css --minify

# 3. Create cleanup/temp directory
echo "🧹 Preparing temporary directory..."
rm -rf "$PLUGIN_SLUG" "$ZIP_NAME"
mkdir "$PLUGIN_SLUG"

# 4. Copy files
echo "g Copying files..."

# Copy Root files
cp hipsy-events.php "$PLUGIN_SLUG/"
cp readme.txt "$PLUGIN_SLUG/"
# cp readme.md "$PLUGIN_SLUG/" # Optional: usually WP uses readme.txt, but safe to include if desired.

# Copy Directories
# recursive copy
cp -r functions "$PLUGIN_SLUG/"
cp -r templates "$PLUGIN_SLUG/"
cp -r img "$PLUGIN_SLUG/"
cp -r blocks "$PLUGIN_SLUG/"

# Copy Styles
# We need to preserve the directory structure expected by the plugin:
# wp_enqueue_style('hipsy-events-style', plugins_url('../styles/dist/main.css', __FILE__));
# So we need styles/dist/main.css inside the plugin folder.
mkdir -p "$PLUGIN_SLUG/styles/dist"
cp styles/dist/main.css "$PLUGIN_SLUG/styles/dist/"

# 5. Zip it up
echo "🤐 Zipping..."
zip -r "$ZIP_NAME" "$PLUGIN_SLUG" -x "*/.DS_Store" "*/__MACOSX"

# 6. Cleanup
echo "🧹 Cleaning up..."
rm -rf "$PLUGIN_SLUG"

echo "✅ Done! Created $ZIP_NAME"
