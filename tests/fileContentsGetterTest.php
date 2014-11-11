<?php

use org\bovigo\vfs\vfsStream;
use unreal4u\fileContentsGetter;

/**
 * pid test case.
 */
class fileContentsGetterTest extends \PHPUnit_Framework_TestCase {
    /**
     * @var pid
     */
    private $_fileContentsGetter = null;

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
                    'test.php' => 'Text content from /Core/AbstractFactory/test.php',
                    'other.php' => 'Some more text content',
                    'Invalid.csv' => 'Something else',
                ],
                'AnEmptyFolder' => [],
                'badlocation.php' => 'some bad content',
            ],
            'test.php' => 'Text content from /test.php',
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
        $this->_fileContentsGetter = new fileContentsGetter();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown() {
        $this->_fileContentsGetter = null;
        parent::tearDown();
    }

    /**
     * Tests whether setting filename goes well
     */
    public function test_simpleFileContentsGetter() {
        $options['pattern'] = '/test\d*\.php/';

        $fileList = $this->_fileContentsGetter->constructFileList($this->_filesystem->url('exampleDir'), $options)->getFilelist();
        $this->assertCount(3, $fileList);
        $this->assertEquals('Text content from /Core/AbstractFactory/test.php', reset($fileList));
    }
}
