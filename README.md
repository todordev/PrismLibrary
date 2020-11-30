Prism Library 
=================
( Version 2.0 )
- - -

This is a collection of PHP classes used in many ITPrism extensions. 

## Installation

The preferred method of installation to PHP Frameworks is via [Packagist](https://packagist.org/packages/itprism/prism-library) and [Composer](https://getcomposer.org/). Run the following command to install the package and add it as a requirement to your project's `composer.json`:

```bash
composer require itprism/prism-library
```

## Building Joomla! package

Follow next steps to build a package that you will be able to install on your Joomla! website.

_**NOTE**: You need [Apache Ant](http://ant.apache.org/manual/install.html) to build the package._

1. Clone this repository.
2. Install required packages executing `composer update`.
3. Go to folder __build__.
4. Rename file _antconfig.dist.txt_ to _antconfig.txt_.
5. Enter the path to the folder where you cloned this repository. You have to enter the path as value of variable __cfg.sourceDir__ in _antconfig.txt_.
6. Execute `ant` in your console.

```bash
ant
```

## Download
You can [download Prism Library package](http://itprism.com/free-joomla-extensions/others/software-development-kit) from the website of ITPrism.

## License
Prism Library is under [GPLv3 license](http://www.gnu.org/licenses/gpl-3.0.en.html).