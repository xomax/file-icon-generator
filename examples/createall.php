<?php
// Composer autoload
require '../vendor/autoload.php';

$FIB = new \xomax\FileIconGenerator\Helper();
$FIB->createAll('out');
