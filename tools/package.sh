#!/usr/bin/env bash
set -euo pipefail

PLUGIN_SLUG="cf7-datetime-addon"
VERSION=$(grep "Version:" "${PLUGIN_SLUG}.php" | head -1 | sed 's/.*Version:\s*//' | tr -d '[:space:]' || echo "1.0.0")
OUTDIR="dist"
WORK="/tmp/${PLUGIN_SLUG}-pkg"
ZIPNAME="${PLUGIN_SLUG}-${VERSION}.zip"

rm -rf "$WORK" && mkdir -p "$WORK" "$OUTDIR"

# ensure build has run before copying; comment out if you’ve done it already
echo "Installing dependencies..."
npm ci && npm run build && composer install --no-dev --prefer-dist --optimize-autoloader || true

# copy plugin into WORK, excluding files listed in .distignore
rsync -a --delete --exclude-from=.distignore "./" "$WORK/${PLUGIN_SLUG}/"

# make zip
(cd "$WORK" && zip -r "$ZIPNAME" "${PLUGIN_SLUG}")

mv "$WORK/$ZIPNAME" "$OUTDIR/"
echo "Created: $OUTDIR/$ZIPNAME"