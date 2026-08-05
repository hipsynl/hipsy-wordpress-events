# Releasing Hipsy Events

This project publishes installable WordPress plugin zips via GitHub Releases. The release workflow runs automatically when you push a version tag.

## Prerequisites

- Changes are merged on the default branch (`main`)
- You have permission to push tags to the GitHub repository
- Version numbers are updated before tagging (see below)

## Release steps

### 1. Write the changelog entry

Add a new section at the top of [`CHANGELOG.md`](../CHANGELOG.md) for the release version:

```markdown
## [1.2.2] - 2026-08-05

### Security
- ...

### Fixed
- ...

### Changed
- ...
```

The release workflow extracts the section matching the tag (e.g. `v1.2.2` → `## [1.2.2]`). If no matching entry exists, the workflow fails.

Preview locally:

```bash
chmod +x scripts/extract_changelog.sh
./scripts/extract_changelog.sh 1.2.2
```

### 2. Bump the version

Update the plugin version in both places so the zip and WordPress readme stay in sync:

- [`hipsy-events.php`](../hipsy-events.php) — `Version:` header (source of truth for WordPress)
- [`package.json`](../package.json) — `version` field (used by `scripts/generate_wp_readme.sh` for `readme.txt` in the zip)

Example: `1.2.1` → `1.2.2`

### 3. Commit and push

```bash
git add CHANGELOG.md hipsy-events.php package.json
git commit -m "Release v1.2.2"
git push origin main
```

Include any other release-related changes in the same commit if needed.

### 4. Create and push a tag

The tag must match the version with a `v` prefix. This triggers the release workflow.

```bash
git tag v1.2.1
git push origin v1.2.1
```

Use annotated tags if you prefer:

```bash
git tag -a v1.2.1 -m "Release v1.2.1"
git push origin v1.2.1
```

### 5. Wait for GitHub Actions

After the tag push, the [Release workflow](../.github/workflows/release.yml) will:

1. Install dependencies with Yarn
2. Run `yarn build` (compiles assets and runs `scripts/build_zip.sh`)
3. Extract release notes from `CHANGELOG.md` for the tagged version
4. Create a GitHub Release for the tag with those notes
5. Upload `hipsy-events.zip` as a release asset

Check progress under **Actions** in the GitHub repository.

## Download URL

Each release provides:

```
https://github.com/hipsynl/hipsy-wordpress-events/releases/download/vX.Y.Z/hipsy-events.zip
```

For the latest release:

```
https://github.com/hipsynl/hipsy-wordpress-events/releases/latest/download/hipsy-events.zip
```

## Local build (optional)

To build the zip locally before tagging:

```bash
chmod +x scripts/build_zip.sh scripts/generate_wp_readme.sh
yarn install
yarn build
```

This creates `hipsy-events.zip` in the project root.

## Troubleshooting

**Workflow did not run**

- Confirm the tag starts with `v` (e.g. `v1.2.1`, not `1.2.1`)
- Confirm the tag was pushed: `git push origin v1.2.1`

**Release already exists for this tag**

- Delete the tag locally and on GitHub, fix the issue, then recreate and push the tag
- Or bump to a new patch version and tag again

**Build failed in CI**

- Run `yarn build` locally to reproduce
- Ensure `yarn.lock` is committed and up to date

**Wrong version in the zip readme**

- `readme.txt` inside the zip is generated from `package.json`, not `hipsy-events.php`
- Keep both version fields in sync when releasing

**Release notes are empty or workflow failed on changelog**

- Ensure `CHANGELOG.md` has a section header exactly matching the tag: `## [1.2.2]`
- Preview with `./scripts/extract_changelog.sh 1.2.2`
- For an already-published release with wrong notes, edit the release manually on GitHub (the zip is unaffected)
