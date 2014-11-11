<?php

use org\bovigo\vfs\vfsStream;
use unreal4u\fileDeleter;

/**
 * File deleter test class
 *
 * NOTE: This test will also test the fileSelection class
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

        $structure = [
            'Core' => [
                'AbstractFactory' => [
                    'test.php' => 'some text content',
                    'other.php' => 'Some more text content',
                    'Invalid.csv' => 'Something else',
                ],
                'AnEmptyFolder' => [],
                'badlocation.php' => 'some bad content',
            ],
            'test.php' => 'Some other content',
            'test002.php' => 'Content test002.php',
            'testDirectory001' => [],
            'testDirectory002' => [],
            'testDirectory003' => [
               'testFile001.txt' => 'Content testFile001.txt',
               'testFile002.txt' => 'Content testFile002.txt',
            ],
            'testDirectoryNNN' => [],
        ];

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
    public function test_simpleFileDeleter() {
        $options['pattern'] = '/test\.php/';

        $this->_fileDeleter->constructFileList($this->_filesystem->url('exampleDir'), $options)->deleteAll();
        $this->assertFalse($this->_filesystem->hasChild('Core/AbstractFactory/test.php'));
        $this->assertTrue($this->_filesystem->hasChild('Core/AbstractFactory/other.php'));
        $this->assertFalse($this->_filesystem->hasChild('test.php'));
        $this->assertTrue($this->_filesystem->hasChild('test002.php'));
        $this->assertTrue($this->_filesystem->hasChild('testDirectory002'));
        $this->assertTrue($this->_filesystem->hasChild('testDirectory003/testFile002.txt'));
    }

    public function test_noRecursionFileDeleter() {
        $options['pattern'] = '/test\.php/';
        $options['recursive'] = false;

        $this->_fileDeleter->constructFileList($this->_filesystem->url('exampleDir'), $options)->deleteAll();
        $this->assertTrue($this->_filesystem->hasChild('Core/AbstractFactory/test.php'));
        $this->assertTrue($this->_filesystem->hasChild('Core/AbstractFactory/other.php'));
        $this->assertFalse($this->_filesystem->hasChild('test.php'));
        $this->assertTrue($this->_filesystem->hasChild('test002.php'));
        $this->assertTrue($this->_filesystem->hasChild('testDirectory002'));
        $this->assertTrue($this->_filesystem->hasChild('testDirectory003/testFile002.txt'));
    }

    public function test_deleteDirectory() {
        $options['recursive'] = true;
        $options['pattern'] = '/testDirectory\d{3}/';

        $this->_fileDeleter->constructFileList($this->_filesystem->url('exampleDir'), $options)->deleteAll();
        $this->assertTrue($this->_filesystem->hasChild('Core/AbstractFactory/test.php'));
        $this->assertTrue($this->_filesystem->hasChild('Core/AbstractFactory/other.php'));
        $this->assertTrue($this->_filesystem->hasChild('test.php'));
        $this->assertTrue($this->_filesystem->hasChild('test002.php'));
        $this->assertFalse($this->_filesystem->hasChild('testDirectory002'));
        $this->assertFalse($this->_filesystem->hasChild('testDirectory003/testFile002.txt'));
        $this->assertTrue($this->_filesystem->hasChild('testDirectoryNNN'));
    }

    public function test_TestMode() {
        $options['pattern'] = '/test\.php/';
        $options['recursive'] = false;

        $this->_fileDeleter = new fileDeleter(true);
        $this->expectOutputString('[DRY-RUN] Removing file or directory "vfs://exampleDir/test.php"<br />'.PHP_EOL);
        $this->_fileDeleter->constructFileList($this->_filesystem->url('exampleDir'), $options)->deleteAll();
    }
}
