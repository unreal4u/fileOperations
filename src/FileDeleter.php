<?php

declare(strict_types=1);

namespace unreal4u\FileOperations;

/**
 * Gets the contents of our previously declared iterator
 */
class FileDeleter extends FileSelection
{
    /**
     * Contains the full path of all files that were deleted
     * @var array
     */
    public $deletedFiles = [];

    /**
     * Performs the actual deletion of the previous delete selection
     *
     * @return FileDeleter Returns same object for easy method concatenation
     */
    public function perform(): FileActionInterface
    {
        foreach ($this->iterator as $file) {
            $fullFile = $file->getPath() . DIRECTORY_SEPARATOR . $file->getFilename();
            $this->deletedFiles[] = $fullFile;
            $this->logger->info('Removing', ['file' => $fullFile, 'dry-run' => $this->isTestMode]);
            if ($this->isTestMode === false) {
                if ($file->isDir()) {
                    rmdir($fullFile);
                } else {
                    unlink($fullFile);
                }
            }
        }

        return $this;
    }
}
