<?php

use unreal4u\FileOperations\FileDeleter;

include '../vendor/autoload.php';

// Instantiate a deleter in test mode
$fileDeleter = new FileDeleter(true);
// Our regex: get every file that complies with "test(3 numeric characters).txt"
$fileDeleter->constructFileList('testdir/')->perform();
