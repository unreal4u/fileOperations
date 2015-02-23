<?php
use org\bovigo\vfs\vfsStream;
use unreal4u\fileContentsGetter;

/**
 * FileContentsGetter test case.
 */
class fileSelectorTest extends \PHPUnit_Framework_TestCase {
    /**
     * Object container
     */
    protected $_fileContentsGetter = null;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp() {
        parent::setUp();

        $structure = [
            'íntérñatiönalízédÑame.intl' => 'íntérñatiönalízédÑame content', // 2 bytes characters
            '漢A字BC.intl' => '漢A字BC content', // 3 bytes characters
            '𠜎𠜱𠝹𠱓.intl' => '𠜎𠜱𠝹𠱓 content', // 4 bytes characters
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
     * Tests json_encoded output of the class
     */
    public function test_toString() {
        $options['pattern'] = '/\.intl$/';

        $fileList = $this->_fileContentsGetter->constructFileList($this->_filesystem->url('exampleDir'), $options);
        $fileList = \json_decode(sprintf($this->_fileContentsGetter));

        $expected = [
        'vfs://exampleDir/íntérñatiönalízédÑame.intl',
        'vfs://exampleDir/漢A字BC.intl',
        'vfs://exampleDir/𠜎𠜱𠝹𠱓.intl',
        ];
        $this->assertCount(3, $fileList);
        $this->assertEquals($expected, $fileList);
    }
}
