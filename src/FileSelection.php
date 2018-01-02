<?php

declare(strict_types=1);

namespace unreal4u\FileOperations;

/**
 * This file contains all functionality that has to do with file operations (such as iterators)
 */

use Psr\Log\LoggerInterface;
use unreal4u\Dummy\Logger;
use unreal4u\FileOperations\Filters\CreationTimeFilterIterator;

/**
 * Constructs a list of files (filterable with iterator) according to given input
 */
abstract class FileSelection implements FileActionInterface
{
    /**
     * Object container
     * @var \Iterator
     */
    protected $iterator;

    /**
     * Whether we are in test mode or not
     *
     * @var boolean
     */
    protected $isTestMode = false;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Holds all options
     *
     * @var array
     */
    private $options = [
        'maxAge' => 0,
        'pattern' => '',
        'recursive' => true,
        'includeBrokenSymlink' => true,
        // 'Filters' => [Filters\creationTimeFilterIterator],
    ];

    /**
     * @param bool $testMode Whether to enable test mode. Defaults to false
     * @param LoggerInterface|null $logger
     */
    public function __construct(bool $testMode = false, LoggerInterface $logger = null)
    {
        $this->isTestMode = $testMode;
        if ($logger === null) {
            $logger = new Logger();
        }

        $this->logger = $logger;
    }

    /**
     * Sets the defaults
     *
     * @param array $options
     * @return \unreal4u\fileSelection
     */
    private function setDefaults(array $options = []): self
    {
        $this->options = $options + $this->options;
        return $this;
    }

    /**
     * Initializes the iterator and retrieves list of files
     *
     * @param string $path
     *            The path we want to check
     * @param array $options
     *            Array with options, for now these are 'pattern', 'maxAge', 'recursive' and 'includeBrokenSymlink'
     * @return \unreal4u\fileSelection Returns same object for easy method concatenation
     */
    public function constructFileList(string $path, array $options = []): FileActionInterface
    {
        $this->setDefaults($options);

        if ($this->options['recursive'] === true) {
            $this->iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::CHILD_FIRST
            );
        } else {
            $this->iterator = new \IteratorIterator(new \directoryIterator($path));
        }

        if (!empty($this->options['pattern'])) {
            $this->iterator = new \RegexIterator($this->iterator, $this->options['pattern']);
        }

        /*if (! empty($this->_options['includeBrokenSymlink'])) {
            $this->_iterator = new Filters\symlinksFilterIterator($this->_iterator, true);
        }*/

        if (!empty($this->options['maxAge'])) {
            $this->iterator = new CreationTimeFilterIterator($this->iterator, $this->options['maxAge']);
        }

        return $this;
    }

    /**
     * Creates a JSON string with all filenames, no content, just filenames
     */
    public function __toString(): string
    {
        $result = [];

        if (!empty($this->iterator)) {
            foreach ($this->iterator as $file) {
                $result[] = $file->getPath() . DIRECTORY_SEPARATOR . $file->getFilename();
            }
        }

        return \json_encode($result);
    }
}
