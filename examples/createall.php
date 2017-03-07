<?php
// Composer autoload
require '../vendor/autoload.php';

$FIB = new \FileIconGenerator\Helper();
$FIB->createAll('out');
