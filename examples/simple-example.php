<?php

include('../vendor/autoload.php');

// Instantiate a deleter in test mode
$fileDeleter = new unreal4u\fileDeleter((boolean)true);
// Our regex: get every file that complies with "test(3 numeric characters).txt"
$fileDeleter->constructFileList('testdir/')->perform();
