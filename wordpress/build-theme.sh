#!/usr/bin/env bash
#
# Build an installable WordPress theme zip for the PulseLyft theme.
# Output: wordpress/pulselyft.zip  (archive root is the `pulselyft/` folder,
# exactly as WordPress expects for Appearance -> Themes -> Add New -> Upload Theme).
#
# Usage:
#   cd wordpress && ./build-theme.sh
#
set -euo pipefail

cd "$(dirname "$0")"

THEME_DIR="pulselyft"
OUT="pulselyft.zip"

if [ ! -f "${THEME_DIR}/style.css" ]; then
  echo "Error: ${THEME_DIR}/style.css not found. Run this from the wordpress/ directory." >&2
  exit 1
fi

rm -f "${OUT}"

if command -v zip >/dev/null 2>&1; then
  zip -r -q "${OUT}" "${THEME_DIR}" \
    -x "*.DS_Store" "*/.git/*" "*/node_modules/*"
else
  # Fallback for environments without the `zip` binary.
  php -r '
    $zip = new ZipArchive();
    $zip->open($argv[1], ZipArchive::CREATE | ZipArchive::OVERWRITE);
    $base = realpath($argv[2]);
    $it = new RecursiveIteratorIterator(
      new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS)
    );
    foreach ($it as $f) {
      $path = $f->getPathname();
      $local = $argv[2] . "/" . substr($path, strlen($base) + 1);
      $local = str_replace("\\", "/", $local);
      if (strpos($local, ".DS_Store") !== false) { continue; }
      $zip->addFile($path, $local);
    }
    $zip->close();
  ' "${OUT}" "${THEME_DIR}"
fi

echo "Built ${OUT} ($(du -h "${OUT}" | cut -f1))"
echo "Install: WordPress admin -> Appearance -> Themes -> Add New -> Upload Theme -> ${OUT}"
