<?php

include('../vendor/autoload.php');

// Instantiate a deleter in test mode
$fileDeleter = new unreal4u\fileDeleter(true);
$fileDeleter->constructFileList('testdir/', 0, '/test\d{3}\.txt/')->deleteAll();
