<?php

declare(strict_types=1);

namespace unreal4u\FileOperations;

/**
 * Our common interface with all stuff that must be implemented in the subclasses
 */
interface FileActionInterface
{
    /**
     * The associated action that the subclass has to implement will be done when perform() is called
     * @return FileActionInterface
     */
    public function perform(): FileActionInterface;

    /**
     * Basic constructor which will be responsible to construct the file list on which to perform an operation
     *
     * @param string $path
     * @param array $options
     * @return FileActionInterface
     */
    public function constructFileList(string $path, array $options = []): FileActionInterface;
}
