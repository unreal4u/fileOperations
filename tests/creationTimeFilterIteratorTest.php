<?php

use unreal4u\fileDeleter;

/**
 * creationTimeFilterIterator test class
 */
class creationTimeFilterIterator extends \PHPUnit_Framework_TestCase {
    /**
     * @var pid
     */
    private $_fileDeleter = null;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp() {
        parent::setUp();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown() {
        $this->_fileDeleter = null;
        parent::tearDown();
    }

    /**
     * There is no way (yet) in vfsStream to touch a file, so do it the old way
     */
    public function test_Timeout() {
        @\mkdir('tmp'); // Hate to do it, but an error in the tests will create the directory but won't wipe it out
        \touch('tmp/test.test', time() - 30);
        \touch('tmp/test2.test', time() - 10);
        $this->_fileDeleter = new fileDeleter();
        $this->_fileDeleter->constructFileList('tmp/', ['maxAge' => 15, 'pattern' => '/.*\.test$/'])->perform();
        $this->assertFileNotExists('tmp/test.test');
        $this->assertFileExists('tmp/test2.test');
        \unlink('tmp/test2.test');
        \rmdir('tmp');
        // Ensure cleanup was done properly
        $this->assertFileNotExists('tmp');
    }
}
