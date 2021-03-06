[![Latest Stable Version](https://poser.pugx.org/unreal4u/file-operations/v/stable.png)](https://packagist.org/packages/unreal4u/file-operations)
[![Build Status](https://travis-ci.org/unreal4u/fileOperations.png?branch=master)](https://travis-ci.org/unreal4u/fileOperations)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/unreal4u/fileOperations/badges/quality-score.png?s=bda9bffddbd3a8fb7f24782c42dfd4d57ea0d2d8)](https://scrutinizer-ci.com/g/unreal4u/fileOperations/)
[![License](https://poser.pugx.org/unreal4u/file-operations/license.png)](https://packagist.org/packages/unreal4u/file-operations)

# unreal4u/file-operations

This class is able to retrieve files based on several parameters and perform configurable and extendable operations on
them.

## Credits

This class is made by unreal4u (Camilo Sperberg). [unreal4u.com/](http://unreal4u.com/)

# About this class

* This class will allow you to select files and perform operations on them.
* A few examples are included, such as get the contents or delete them
* Endless posibilities: just create your own and extend the abstract fileSelection class
* Needs PHP7+

# Disclaimer

Usage of this class is entirely up to you. Read all documentation before you use this class!

## Detailed description

This package is a collection of functions related to file manipulation. The idea behind it is actually pretty simple:
with the base class fileSelection you select files, based on several parameters, such as maximum age of the file, or
based on a regex selector.

After you have made your selection, you proceed to do the action. That action are actually classes that extend the base
class and implement the final action which can be whatever you want. Included are 2 examples: a fileDeleter; which as
the name states, is able to delete files (it also has a test mode, I suggest you use that before you put any code on
production); and a contentGetter, which reads the file out and puts together an array with data.

## Basic usage

```php
<?php

include 'vendor/autoload.php';
// Instantiate a deleter in test mode
$fileDeleter = new unreal4u\FileOperations\fileDeleter(true);
$options = [
    'pattern' => '/test\d{3}\.txt/',
];
$fileDeleter->constructFileList('testdir/', $options)->perform();
```

* Congratulations! All files that comply with the requirements would have been deleted!
* Please see examples and PHPUnit tests for more options and advanced usage

# Composer

This class has support for Composer install and is the prefered method. Just add the following section to your
composer.json with:

```json
{
    "require": {
        "unreal4u/file-operations": "@stable"
    }
}
```

# Pending

* Change arguments in fileSelection to an array, with (optional) function callbacks
* Better documentation
* A first stable release

# Version History

This package will be compatible with Semver once it reaches v1.0.0.

* 0.4.0:
    * PHP7+ compatibility
* 0.2.0:
    * BC breakage: function names changed
    * Common interface
* 0.1.3:
    * Complete code coverage
* 0.1.2:
    * Array can be passed on with options
    * First PHPUnit tests
* 0.1.1:
    * More documentation
    * More examples
    * Minor improvements: assume a default of 0 seconds of maximum file age
* 0.1.0:
    * Created basic class

# Contact the author

* Twitter: [@unreal4u](https://twitter.com/unreal4u)
* Github:  [https://www.github.com/unreal4u](https://www.github.com/unreal4u)
