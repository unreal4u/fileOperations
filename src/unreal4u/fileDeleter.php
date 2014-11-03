<?php
namespace unreal4u;

/**
 * Gets the contents of our previously declared iterator
 */
class fileDeleter extends fileSelection
{

    /**
     * Performs the actual deletion of the previous delete selection
     *
     * @return directoryDeletion Returns same object for easy method concatenation
     */
    public function deleteAll()
    {
        foreach ($this->_iterator as $file) {
            $fullFile = $file->getPath() . DIRECTORY_SEPARATOR . $file->getFilename();
            $this->deletedFiles[] = $fullFile;
            if ($this->_isTestMode) {
                printf('[TESTMODE] Removing file or directory "%s"' . PHP_EOL, $fullFile);
            } else {
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
