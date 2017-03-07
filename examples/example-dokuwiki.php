<?php
/**
 * This script builds the file icons for DokuWiki
 *
 * Give the proper directory as first argument
 */

// Composer autoload
require '../vendor/autoload.php';

$dw = '';
if(isset($argv[1])) $dw = $argv[1];
if(!$dw || !is_dir($dw) || !file_exists("$dw/index.php") || !chdir($dw)) {
    echo "Please provide the path to DokuWiki's lib/images/fileicons directory";
    echo "as parameter to this script\n";
    exit(1);
}

$extensions = array(
    'jpg', 'gif', 'png', 'ico',
    'swf', 'mp3', 'ogg', 'wav', 'webm', 'ogv', 'mp4',
    'tgz', 'tar', 'gz', 'bz2', 'zip', 'rar', '7z',
    'pdf', 'ps',
    'rpm', 'deb',
    'doc', 'xls', 'ppt', 'rtf',
    'docx', 'xlsx', 'pptx',
    'sxw', 'sxc', 'sxi', 'sxd',
    'odc', 'odf', 'odg', 'odi', 'odp', 'ods', 'odt',
    'html', 'htm', 'txt', 'conf', 'xml', 'csv',
    // these might be used in downloadable code blocks:
    'c', 'cc', 'cpp', 'h', 'hpp', 'csh', 'diff', 'java', 'pas',
    'pl', 'py', 'sh', 'bash', 'asm', 'htm', 'css', 'js', 'json',
    'cs', 'lua', 'php', 'rb', 'sql'
);

// generate all the icons
@mkdir('32x32');

$DFIB = new \FileIconGenerator\Helper();
$DFIB->create16x16($extensions, '');
$DFIB->create32x32($extensions, '32x32');

copy("jpg.png", "jpeg.png");
copy("32x32/jpg.png", "32x32/jpeg.png");

copy("htm.png", "html.png");
copy("32x32/htm.png", "32x32/html.png");

