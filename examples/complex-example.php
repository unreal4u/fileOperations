<?php

include('../vendor/autoload.php');

// Instantiate a deleter in test mode
$fileDeleter = new unreal4u\fileDeleter(true);
// Our regex: get every file that complies with "test(3 numeric characters).txt"
$fileDeleter->constructFileList('testdir/', ['maxAge' => 0, 'pattern' => '/test\d{3}\.txt/'])->deleteAll();

// Lets instantiate now a fileContentsGetter:
$fileContentsGetter = new unreal4u\fileContentsGetter();
// Our regex: get every file that complies with "test(3 numeric characters)"
$fileList = $fileContentsGetter->constructFileList('testdir/', ['maxAge' => 0, 'pattern' => '/test\d{3}/'])->getFilelist();

var_dump($fileList);
