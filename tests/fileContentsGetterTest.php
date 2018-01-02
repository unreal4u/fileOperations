<?php

namespace tests\unreal4u\FileOperations;

use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use unreal4u\FileOperations\FileContentsGetter;

/**
 * FileContentsGetter test case.
 */
class fileContentsGetterTest extends TestCase {
    /**
     * @var FileContentsGetter
     */
    private $fileContentsGetter;

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

        $this->filesystem = vfsStream::setup('exampleDir', null, $structure);
        $this->fileContentsGetter = new FileContentsGetter();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown() {
        $this->fileContentsGetter = null;
        parent::tearDown();
    }

    /**
     * Tests whether setting filename goes well
     */
    public function test_simpleFileContentsGetter() {
        $options['pattern'] = '/test\d*\.php/';

        $this->fileContentsGetter->constructFileList($this->filesystem->url('exampleDir'), $options)->perform();
        $fileList = $this->fileContentsGetter->getOutput();
        $this->assertCount(3, $fileList);
        $this->assertEquals('Text content from /Core/AbstractFactory/test.php', reset($fileList));
    }
}
