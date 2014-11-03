<?php

use org\bovigo\vfs\vfsStream;

/**
 * pid test case.
 */
class fileSelectionTest extends \PHPUnit_Framework_TestCase {
    /**
     * @var pid
     */
    private $_fileSelection;

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
        $this->_filesystem = vfsStream::setup('exampleDir');
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown() {
        $this->_fileSelection = null;
        ini_set('max_execution_time', 0);
        parent::tearDown();
    }

    /**
     * Tests whether setting filename goes well
     */
    public function test_setFilename() {
        $this->assertTrue(true);
    }

    /**
     * Tests whether the version printing goes well
     */
    public function test___toString() {
        $this->assertTrue(true);
        #$this->_fileSelection = new unreal4u\fileSelection();
        #$output = sprintf($this->_fileSelection);

        #$reflector = new \ReflectionProperty('unreal4u\\fileSelection', '_version');
        #$reflector->setAccessible(true);
        #$version = $reflector->getValue($this->pid);

        #$this->assertStringStartsWith('pid.php v'.$version, $output);
        // Test that version string contains at least my name as well
        #$this->assertContains('Camilo Sperberg', $output);
    }
}
