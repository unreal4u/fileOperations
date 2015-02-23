<?php
namespace unreal4u;

/**
 * This file contains all functionality that has to do with file operations (such as iterators)
 */

/**
 * Constructs a list of files (filterable with iterator) according to given input
 */
abstract class fileSelection implements fileActionInterface
{

    /**
     * Object container
     */
    protected $_iterator = null;

    /**
     * Whether we are in test mode or not
     *
     * @var boolean
     */
    protected $_isTestMode = false;

    /**
     * Holds all options
     *
     * @var array
     */
    private $_options = [
        'maxAge' => 0,
        'pattern' => '',
        'recursive' => true,
        'includeBrokenSymlink' => true,
    // 'filters' => [filters\creationTimeFilterIterator],
    ];

    /**
     * Constructor
     *
     * @param string $testMode
     *            Whether to enable test mode. Defaults to false
     */
    public function __construct($testMode = false)
    {
        $this->_isTestMode = (bool) $testMode;
    }

    /**
     * Sets the defaults
     *
     * @param array $options
     * @return \unreal4u\fileSelection
     */
    private function _setDefaults(array $options = [])
    {
        $this->_options = $options + $this->_options;
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
    public function constructFileList($path, array $options = [])
    {
        $this->_setDefaults($options);

        if ($this->_options['recursive'] === true) {
            $this->_iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::CHILD_FIRST
            );
        } else {
            $this->_iterator = new \IteratorIterator(new \directoryIterator($path));
        }

        if (! empty($this->_options['pattern'])) {
            $this->_iterator = new \RegexIterator($this->_iterator, $this->_options['pattern']);
        }

        /*if (! empty($this->_options['includeBrokenSymlink'])) {
            $this->_iterator = new filters\symlinksFilterIterator($this->_iterator, true);
        }*/

        if (! empty($this->_options['maxAge'])) {
            $this->_iterator = new filters\creationTimeFilterIterator($this->_iterator, $this->_options['maxAge']);
        }

        return $this;
    }

    /**
     * Creates a JSON string with all filenames, no content, just filenames
     */
    public function __toString() {
        $result = [];

        if (!empty($this->_iterator)) {
            foreach ($this->_iterator as $file) {
                $result[] = $file->getPath() . DIRECTORY_SEPARATOR . $file->getFilename();
            }
        }

        return \json_encode($result);
    }
}
