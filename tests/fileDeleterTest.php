<?php

namespace tests\unreal4u\FileOperations;

use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use unreal4u\FileOperations\FileDeleter;

/**
 * File deleter test class
 *
 * NOTE: This test will also test the fileSelection class
 */
class fileDeleterTest extends TestCase {
    /**
     * @var FileDeleter
     */
    private $fileDeleter;

    /**
     * Contains the filesystem
     * @var vfsStream
     */
    private $filesystem;

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

        $this->filesystem = vfsStream::setup('exampleDir', null, $structure);
        $this->fileDeleter = new FileDeleter();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown() {
        $this->fileDeleter = null;
        parent::tearDown();
    }

    /**
     * Tests whether setting filename goes well
     */
    public function test_simpleFileDeleter() {
        $options['pattern'] = '/test\.php/';

        $this->fileDeleter->constructFileList($this->filesystem->url('exampleDir'), $options)->perform();
        $this->assertFalse($this->filesystem->hasChild('Core/AbstractFactory/test.php'));
        $this->assertTrue($this->filesystem->hasChild('Core/AbstractFactory/other.php'));
        $this->assertFalse($this->filesystem->hasChild('test.php'));
        $this->assertTrue($this->filesystem->hasChild('test002.php'));
        $this->assertTrue($this->filesystem->hasChild('testDirectory002'));
        $this->assertTrue($this->filesystem->hasChild('testDirectory003/testFile002.txt'));
    }

    /**
     * Tests the optional recursion parameter
     */
    public function test_noRecursionFileDeleter() {
        $options['pattern'] = '/test\.php/';
        $options['recursive'] = false;

        $this->fileDeleter->constructFileList($this->filesystem->url('exampleDir'), $options)->perform();
        $this->assertTrue($this->filesystem->hasChild('Core/AbstractFactory/test.php'));
        $this->assertTrue($this->filesystem->hasChild('Core/AbstractFactory/other.php'));
        $this->assertFalse($this->filesystem->hasChild('test.php'));
        $this->assertTrue($this->filesystem->hasChild('test002.php'));
        $this->assertTrue($this->filesystem->hasChild('testDirectory002'));
        $this->assertTrue($this->filesystem->hasChild('testDirectory003/testFile002.txt'));
    }

    /**
     * Tests whether the class is able to delete a directory
     */
    public function test_deleteDirectory() {
        $options['recursive'] = true;
        $options['pattern'] = '/testDirectory\d{3}/';

        $this->fileDeleter->constructFileList($this->filesystem->url('exampleDir'), $options)->perform();
        $this->assertTrue($this->filesystem->hasChild('Core/AbstractFactory/test.php'));
        $this->assertTrue($this->filesystem->hasChild('Core/AbstractFactory/other.php'));
        $this->assertTrue($this->filesystem->hasChild('test.php'));
        $this->assertTrue($this->filesystem->hasChild('test002.php'));
        $this->assertFalse($this->filesystem->hasChild('testDirectory002'));
        $this->assertFalse($this->filesystem->hasChild('testDirectory003/testFile002.txt'));
        $this->assertTrue($this->filesystem->hasChild('testDirectoryNNN'));
    }

    /**
     * Tests whether the test mode works and doesn't actually delete anything
     */
    public function test_TestMode() {
        $options['pattern'] = '/test\.php/';
        $options['recursive'] = false;

        $this->fileDeleter = new FileDeleter(true);
        $this->fileDeleter->constructFileList($this->filesystem->url('exampleDir'), $options)->perform();
        $this->assertTrue($this->filesystem->hasChild('test.php'));
    }

    /**
     * Tests whether filtering without using the regex iterator works as intended
     */
    public function test_noPattern() {
        $this->fileDeleter->constructFileList($this->filesystem->url('exampleDir'))->perform();
        $this->assertFalse($this->filesystem->hasChild('Core/AbstractFactory/test.php'));
        $this->assertFalse($this->filesystem->hasChild('test.php'));
        $this->assertFalse($this->filesystem->hasChild('testDirectoryNNN'));
    }

    /* @TODO
    public function test_brokenSymlink() {
        #\symlink($this->_filesystem->path('mySymlink'), $this->_filesystem->path('test.php'));
        #var_dump($this->_filesystem->path('test.php'));

        #var_dump($this->_filesystem->getChild('test.php')->getRealChildName());

        #print_r(vfsStream::inspect(new org\bovigo\vfs\visitor\vfsStreamStructureVisitor())->getStructure());
        #\unlink($this->_filesystem->url('test.php'));

        #$this->assertFalse($this->_filesystem->hasChild('test.php'));
        #$this->assertTrue($this->_filesystem->hasChild('test.php'));
    }
    */
}
