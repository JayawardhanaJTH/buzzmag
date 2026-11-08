<#
.SYNOPSIS
    Builds a WordPress-ready theme zip for upload (Appearance > Themes > Add New > Upload Theme).

.DESCRIPTION
    - Reads the Version from style.css
    - Packs every theme file under a top-level folder named after the theme slug
      (WordPress requires: <slug>/style.css inside the zip)
    - Uses forward slashes in zip entries (works on Linux hosting; Windows "Send to > Compressed folder"
      and old Compress-Archive can produce backslash paths that break on Linux servers)
    - Excludes dev-only files (.git, docs, this script, dist/)

.EXAMPLE
    pwsh -File .\build-zip.ps1
    pwsh -File .\build-zip.ps1 -Slug newbrand
#>
param(
    # Folder name the theme will have on the server. Default = current folder name.
    # WARNING: changing the slug makes WordPress treat it as a NEW theme (see PROJECT_MEMORY.md section 11).
    [string]$Slug = (Split-Path -Leaf $PSScriptRoot),
    [string]$OutDir = (Join-Path $PSScriptRoot 'dist')
)

$ErrorActionPreference = 'Stop'
Add-Type -AssemblyName System.IO.Compression
Add-Type -AssemblyName System.IO.Compression.FileSystem

$root = $PSScriptRoot

# Version from style.css header
$styleHeader = (Get-Content (Join-Path $root 'style.css') -TotalCount 20) -join "`n"
$version = if ($styleHeader -match 'Version:\s*([^\r\n]+)') { $Matches[1].Trim() } else { 'dev' }

# Dev-only paths to exclude (relative, forward slashes). Folders end with '/'.
$excludeDirs  = @('.git/', '.vscode/', '.idea/', 'dist/', 'node_modules/', 'docs/')
$excludeFiles = @('build-zip.ps1', '.gitignore', '.gitattributes', '.editorconfig',
                  'PROJECT_MEMORY.md', 'COMPONENT_MAP.md', 'DEPLOYMENT.md', 'CHANGELOG.md',
                  'Thumbs.db', '.DS_Store', 'desktop.ini')

New-Item -ItemType Directory -Force -Path $OutDir | Out-Null
$zipPath = Join-Path $OutDir ("{0}-{1}.zip" -f $Slug, $version)
if (Test-Path $zipPath) { Remove-Item $zipPath -Force }

$files = Get-ChildItem -Path $root -Recurse -File -Force | Where-Object {
    $rel = $_.FullName.Substring($root.Length).TrimStart('\', '/') -replace '\\', '/'
    $_ | Add-Member -NotePropertyName Rel -NotePropertyValue $rel -Force
    -not ($excludeDirs | Where-Object { $rel.StartsWith($_) }) -and
    -not ($excludeFiles -contains $_.Name)
}

$zip = [System.IO.Compression.ZipFile]::Open($zipPath, [System.IO.Compression.ZipArchiveMode]::Create)
try {
    foreach ($f in $files) {
        $entryName = "$Slug/$($f.Rel)"
        [System.IO.Compression.ZipFileExtensions]::CreateEntryFromFile(
            $zip, $f.FullName, $entryName, [System.IO.Compression.CompressionLevel]::Optimal) | Out-Null
    }
}
finally {
    $zip.Dispose()
}

$sizeMB = [math]::Round((Get-Item $zipPath).Length / 1MB, 2)
Write-Host ""
Write-Host "Built: $zipPath" -ForegroundColor Green
Write-Host "Theme slug: $Slug | Version: $version | Files: $($files.Count) | Size: $sizeMB MB"
Write-Host "Upload via: wp-admin > Appearance > Themes > Add New > Upload Theme"
