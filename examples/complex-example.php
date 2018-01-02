<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use unreal4u\FileOperations\FileContentsGetter;
use unreal4u\FileOperations\FileDeleter;

include '../vendor/autoload.php';

$logger = new Logger('complexExample');
$logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));

// Instantiate a deleter in test mode
$fileDeleter = new FileDeleter(true, $logger);
// Our regex: get every file that complies with "test(3 numeric characters).txt"
$fileDeleter->constructFileList('testdir/', ['maxAge' => 0, 'pattern' => '/test\d{3}\.txt/'])->perform();

// Lets instantiate now a fileContentsGetter:
$fileContentsGetter = new FileContentsGetter(true, $logger);
// Our regex: get every file that complies with "test(3 numeric characters)"
$fileList = $fileContentsGetter->constructFileList('testdir/', ['maxAge' => 0, 'pattern' => '/test\d{3}/'])->perform();

#var_dump($fileList);
