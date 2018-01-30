<?php

define('PATH_PRISM_LIBRARY_TESTS', __DIR__);

define('PATH_JOOMLA_LIBRARIES', str_replace(DIRECTORY_SEPARATOR.'Prism'.DIRECTORY_SEPARATOR.'tests', '', PATH_PRISM_LIBRARY_TESTS));

define('PATH_PRISM_LIBRARY', PATH_JOOMLA_LIBRARIES.DIRECTORY_SEPARATOR.'Prism');
define('PATH_PRISM_LIBRARY_VENDOR', PATH_PRISM_LIBRARY.DIRECTORY_SEPARATOR.'vendor');
define('PATH_PRISM_LIBRARY_TESTS_UNIT', PATH_PRISM_LIBRARY_TESTS .DIRECTORY_SEPARATOR.'unit');
define('PATH_PRISM_LIBRARY_TESTS_STUBS_DATA', PATH_PRISM_LIBRARY_TESTS_UNIT .DIRECTORY_SEPARATOR.'stubs'. DIRECTORY_SEPARATOR .'data');

define('PATH_JOOMLA_ROOT', str_replace(DIRECTORY_SEPARATOR.'libraries', '', PATH_JOOMLA_LIBRARIES));
define('PATH_JOOMLA_TESTS', PATH_JOOMLA_ROOT .DIRECTORY_SEPARATOR. 'tests');
define('PATH_JOOMLA_TESTS_UNIT', PATH_JOOMLA_TESTS .DIRECTORY_SEPARATOR.'unit');

spl_autoload_register(function ($class) {
    if (strpos($class, 'Prism') === 0) {
        $file = PATH_JOOMLA_LIBRARIES .DIRECTORY_SEPARATOR. $class .'.php';

        if (file_exists($file)) {
            require_once $file;
        }
    }
});

// Include the main bootstrap and config file.
require_once PATH_JOOMLA_TESTS_UNIT .DIRECTORY_SEPARATOR. 'bootstrap.php';
