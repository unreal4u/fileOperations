<?php

declare(strict_types=1);

namespace unreal4u\FileOperations\Filters;

/**
 * Filters a RecursiveDirectoryIterator based on how many seconds ago it was modified
 */
class CreationTimeFilterIterator extends \FilterIterator
{
    /**
     * From which timestamp we must consider a file to be valid to be considered
     *
     * @var int
     */
    protected $fromTimestamp = 0;

    /**
     * Constructor
     *
     * @param \Iterator $iterator
     * @param int $secondsAgo
     */
    public function __construct(\Iterator $iterator, $secondsAgo)
    {
        parent::__construct($iterator);
        $this->fromTimestamp = time() - $secondsAgo;
    }

    /**
     * All files that comply with this rule will be considered
     *
     * @see FilterIterator::accept()
     */
    public function accept(): bool
    {
        $filename = $this->getRealPath();
        // Broken symlinks will have an empty RealPath (because they don't exist)
        if (!empty($filename)) {
            return ($this->getMTime() <= $this->fromTimestamp);
        }

        // Empty filename, so most probably a broken symlink
        return false;
    }
}
