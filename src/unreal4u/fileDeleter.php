<?php
namespace unreal4u;

/**
 * Gets the contents of our previously declared iterator
 */
class fileDeleter extends fileSelection
{

    /**
     * Contains the full path of all files that were deleted
     * @var array
     */
    public $deletedFiles = [];

    /**
     * Performs the actual deletion of the previous delete selection
     *
     * @return fileDeleter Returns same object for easy method concatenation
     */
    public function perform()
    {
        foreach ($this->_iterator as $file) {
            $fullFile = $file->getPath() . DIRECTORY_SEPARATOR . $file->getFilename();
            $this->deletedFiles[] = $fullFile;
            if ($this->_isTestMode) {
                \printf('[DRY-RUN] Removing file or directory "%s"<br />' . PHP_EOL, $fullFile);
            } else {
                if ($file->isDir()) {
                    \rmdir($fullFile);
                } else {
                    \unlink($fullFile);
                }
            }
        }

        return $this;
    }
}
