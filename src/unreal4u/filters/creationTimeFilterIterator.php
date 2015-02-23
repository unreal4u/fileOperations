<?php
namespace unreal4u\filters;

/**
 * Filters a RecursiveDirectoryIterator based on how many seconds ago it was modified
 */
class creationTimeFilterIterator extends \FilterIterator
{

    /**
     * From which timestamp we must consider a file to be valid to be considered
     *
     * @var int
     */
    protected $_fromTimestamp = 0;

    /**
     * Constructor
     *
     * @param \Iterator $iterator
     * @param int $secondsAgo
     */
    public function __construct(\Iterator $iterator, $secondsAgo)
    {
        parent::__construct($iterator);
        $this->_fromTimestamp = time() - $secondsAgo;
    }

    /**
     * All files that comply with this rule will be considered
     *
     * @see FilterIterator::accept()
     */
    public function accept()
    {
        $filename = $this->getRealPath();
        // Broken symlinks will have an empty RealPath (because they don't exist)
        if (! empty($filename)) {
            return ($this->getMTime() <= $this->_fromTimestamp);
        }

        // Empty filename, so most probably a broken symlink
        return false;
    }
}
