<?php
namespace unreal4u;

/**
 * Our common interface with all stuff that must be implemented in the subclasses
 */
interface fileActionInterface
{

    /**
     * The action that the subclass has to implement
     */
    public function perform();

    /**
     * Basic constructor which will be responsible to construct the file list on which to perform an operation
     *
     * @param string $path
     * @param array $options
     */
    public function constructFileList($path, array $options = []);
}
