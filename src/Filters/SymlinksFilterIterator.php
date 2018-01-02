<?php

declare(strict_types=1);

namespace unreal4u\FileOperations\Filters;

/**
 * Filters a RecursiveDirectoryIterator based on how many seconds ago it was modified
 */
class SymlinksFilterIterator extends \FilterIterator
{
    /**
     * Whether to include broken symlinks
     *
     * @var bool
     */
    private $includeBrokenSymlink;

    /**
     * Constructor
     *
     * @param \Iterator $iterator
     * @param bool $includeBrokenSymlink
     */
    public function __construct(\Iterator $iterator, bool $includeBrokenSymlink = true)
    {
        parent::__construct($iterator);
        $this->includeBrokenSymlink = $includeBrokenSymlink;
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
            return true;
        }

        // Empty filename, so most probably a broken symlink
        return $this->includeBrokenSymlink;
    }
}
