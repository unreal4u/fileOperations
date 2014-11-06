fileOperations
======

Credits
--------

This class is made by unreal4u (Camilo Sperberg). [unreal4u.com/](http://unreal4u.com/)

About this class
--------

* This class will allow you to select files and perform operations on them.
* A few examples are included, such as get the contents or delete them
* Endless posibilities: just create your own and extend the abstract fileSelection class

Disclaimer
---------

Usage of this class is entirely up to you. Read all documentation before you use this class!

Detailed description
---------

This package is a collection of functions related to file manipulation. The idea behind it is actually pretty simple:
with the base class fileSelection you select files, based on several parameters, such as maximum age of the file, or
based on a regex selector.

After you have made your selection, you proceed to do the action. That action are actually classes that extend the base
class and implement the final action which can be whatever you want. Included are 2 examples: a fileDeleter; which as
the name states, is able to delete files (it also has a test mode, I suggest you use that before you put any code on
production); and a contentGetter, which reads the file out and puts together an array with data.

Basic usage
----------

<pre>include('vendor/autoload.php');
// Instantiate a deleter in test mode
$fileDeleter = new unreal4u\fileDeleter(true);
$fileDeleter->constructFileList('testdir/', 0, '/test\d{3}\.txt/')->deleteAll();
</pre>

* Congratulations! All files that comply with the requirements would have been deleted!
* Please see examples and PHPUnit tests for more options and advanced usage

Composer
----------

This class has support for Composer install and is the prefered method. Just add the following section to your
composer.json with:

<pre>
{
    "require": {
        "unreal4u/file-operations": "@stable"
    }
}
</pre>

Pending
---------

* Unit tests!!
* Change arguments in fileSelection to an array, with (optional) function callbacks
* Also include broken symlinks as an optional parameter
* Better documentation
* More examples
* A first stable release

Version History
----------

* 0.1.0:
    * Created basic class
* 0.1.1:
    * More documentation
    * More examples
    * Minor improvements: assume a default of 0 seconds of maximum file age
* 0.1.2:
    * Array can be passed on with options
    * First PHPUnit tests

Contact the author
-------

* Twitter: [@unreal4u](http://twitter.com/unreal4u)
* Website: [http://unreal4u.com/](http://unreal4u.com/)
* Github:  [http://www.github.com/unreal4u](http://www.github.com/unreal4u)
