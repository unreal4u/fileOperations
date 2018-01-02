<?php

namespace tests\unreal4u\FileOperations;

use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use unreal4u\FileOperations\FileContentsGetter;

/**
 * FileContentsGetter test case.
 */
class fileSelectorTest extends TestCase
{
    /**
     * @var FileContentsGetter
     */
    protected $fileContentsGetter;

    private $filesystem;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $structure = [
            'íntérñatiönalízédÑame.intl' => 'íntérñatiönalízédÑame content', // 2 bytes characters
            '漢A字BC.intl' => '漢A字BC content', // 3 bytes characters
            '𠜎𠜱𠝹𠱓.intl' => '𠜎𠜱𠝹𠱓 content', // 4 bytes characters
        ];

        $this->filesystem = vfsStream::setup('exampleDir', null, $structure);
        $this->fileContentsGetter = new FileContentsGetter();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->fileContentsGetter = null;
        parent::tearDown();
    }

    /**
     * Tests json_encoded output of the class
     */
    public function test_toString()
    {
        $options['pattern'] = '/\.intl$/';

        $this->fileContentsGetter->constructFileList($this->filesystem->url('exampleDir'), $options);
        $fileList = \json_decode(sprintf($this->fileContentsGetter));

        $expected = [
            'vfs://exampleDir/íntérñatiönalízédÑame.intl',
            'vfs://exampleDir/漢A字BC.intl',
            'vfs://exampleDir/𠜎𠜱𠝹𠱓.intl',
        ];
        $this->assertCount(3, $fileList);
        $this->assertEquals($expected, $fileList);
    }
}
