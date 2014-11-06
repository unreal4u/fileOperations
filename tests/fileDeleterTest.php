<?php

use org\bovigo\vfs\vfsStream;
use unreal4u\fileDeleter;

/**
 * pid test case.
 */
class fileDeleterTest extends \PHPUnit_Framework_TestCase {
    /**
     * @var pid
     */
    private $_fileDeleter = null;

    /**
     * Contains the filesystem
     * @var vfsStream
     */
    private $_filesystem = null;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp() {
        parent::setUp();

        $structure = array(
            'Core' => array(
                'AbstractFactory' => array(
                    'test.php' => 'some text content',
                    'other.php' => 'Some more text content',
                    'Invalid.csv' => 'Something else',
                ),
                'AnEmptyFolder' => array(),
                'badlocation.php' => 'some bad content',
            ),
            'test.php' => 'Some other content',
        );

        $this->_filesystem = vfsStream::setup('exampleDir', null, $structure);
        $this->_fileDeleter = new fileDeleter();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown() {
        $this->_fileDeleter = null;
        parent::tearDown();
    }

    /**
     * Tests whether setting filename goes well
     */
    public function test_fileDeleter() {
        $options['pattern'] = '/test\.php/';

        $this->_fileDeleter->constructFileList($this->_filesystem->url('exampleDir'), $options)->deleteAll();
        $this->assertFalse($this->_filesystem->hasChild('Core/AbstractFactory/test.php'));
        $this->assertTrue($this->_filesystem->hasChild('Core/AbstractFactory/other.php'));
        $this->assertFalse($this->_filesystem->hasChild('test.php'));
    }
}
