# Build Tools

This directory contains scripts for building and packaging the CF7 DateTime Addon plugin.

## Building a Distribution ZIP

To create a clean ZIP file for distribution (suitable for WordPress.org or manual installation):

```bash
# From the plugin root directory
./tools/package.sh
```

This will:
1. Install Node.js dependencies (`npm ci`)
2. Run the build process (`npm run build`)
3. Install production PHP dependencies (`composer install --no-dev`)
4. Create a clean ZIP file excluding development files
5. Output the ZIP to the `dist/` directory

## GitHub Integration

### Automated Builds

GitHub Actions automatically builds the plugin on:
- Pushes to `main`/`master` branches
- Pull requests
- Release creation

Build artifacts are available for download from the Actions tab.

### Creating a Release

To create a new plugin release:

1. **Update version numbers** in:
   - `cf7-datetime-addon.php` (main plugin file)
   - `tools/package.sh` (VERSION variable)
   - `readme.txt` (Stable tag)

2. **Commit and push changes**

3. **Create a git tag**:
   ```bash
   git tag v1.0.1  # Replace with actual version
   git push origin v1.0.1
   ```

4. **GitHub will automatically**:
   - Build the plugin ZIP
   - Create a GitHub release
   - Attach the ZIP file to the release

## What gets excluded

The build process uses the `.distignore` file to exclude development files from the distribution ZIP. This includes:
- Development tools and scripts (`tools/` directory)
- Test files (`tests/` directory)
- Configuration files (`composer.json`, `package.json`, etc.)
- Development dependencies (`node_modules/`, `vendor/`)
- Version control files (`.git/`, `.gitignore`, etc.)

## Manual build steps

If you prefer to run the build steps manually:

```bash
# Install dependencies
npm ci
npm run build
composer install --no-dev --optimize-autoloader

# Create the ZIP (replace VERSION with actual version)
VERSION="1.0.4"
zip -r "cf7-datetime-addon-${VERSION}.zip" . -x@.distignore
```

## File structure

```
tools/
├── package.sh    # Main build script
└── README.md     # This file

.github/
└── workflows/
    ├── build.yml     # Automated build workflow
    └── release.yml   # Release creation workflow
```
