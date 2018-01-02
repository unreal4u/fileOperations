<?php

namespace tests\unreal4u\FileOperations;

use PHPUnit\Framework\TestCase;
use unreal4u\FileOperations\FileDeleter;

/**
 * creationTimeFilterIterator test class
 */
class creationTimeFilterIteratorTest extends TestCase {
    /**
     * @var FileDeleter
     */
    private $fileDeleter;

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown() {
        $this->fileDeleter = null;
        parent::tearDown();
    }

    /**
     * There is no way (yet) in vfsStream to touch a file, so do it the old way
     */
    public function test_Timeout() {
        @\mkdir('tmp'); // Hate to do it, but an error in the tests will create the directory but won't wipe it out
        \touch('tmp/test.test', time() - 30);
        \touch('tmp/test2.test', time() - 10);
        $this->fileDeleter = new FileDeleter();
        $this->fileDeleter->constructFileList('tmp/', ['maxAge' => 15, 'pattern' => '/.*\.test$/'])->perform();
        $this->assertFileNotExists('tmp/test.test');
        $this->assertFileExists('tmp/test2.test');
        \unlink('tmp/test2.test');
        \rmdir('tmp');
        // Ensure cleanup was done properly
        $this->assertFileNotExists('tmp');
    }
}
