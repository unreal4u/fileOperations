<?php

use unreal4u\fileDeleter;

/**
 * File deleter test class
 *
 * NOTE: This test will also test the fileSelection class
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
        \mkdir('tmp');
        \touch('tmp/test.test', time() - 30);
        \touch('tmp/test2.test', time() - 10);
        $this->_fileDeleter = new fileDeleter();
        $this->_fileDeleter->constructFileList('tmp/', ['maxAge' => 15, 'pattern' => '/.*\.test$/'])->deleteAll();
        $this->assertFileNotExists('tmp/test.test');
        $this->assertFileExists('tmp/test2.test');
        \unlink('tmp/test2.test');
        \rmdir('tmp');
        // Ensure cleanup was done properly
        $this->assertFileNotExists('tmp');
    }
}
