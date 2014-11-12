<?php
namespace unreal4u;

/**
 * Gets the contents of our previously declared iterator
 */
class fileContentsGetter extends fileSelection
{

    public function perform()
    {
        $output = [];
        foreach ($this->_iterator as $file) {
            if (! $file->isDir()) {
                $filename = $file->getPath() . DIRECTORY_SEPARATOR . $file->getFilename();
                $output[$filename] = \file_get_contents($filename);
            }
        }

        return $output;
    }
}
