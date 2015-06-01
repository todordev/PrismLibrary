<?php
/**
 * @package      Prism
 * @subpackage   Initialization
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

defined('JPATH_PLATFORM') or die;

if (!defined("PRISM_PATH_LIBRARY")) {
    define("PRISM_PATH_LIBRARY", JPATH_LIBRARIES . "/prism");
}

jimport("joomla.filesystem.file");
jimport("joomla.filesystem.folder");
jimport("joomla.filesystem.path");

JLoader::registerNamespace('Prism', JPATH_LIBRARIES);
/*
// Register constants.
JLoader::register("Prism\\Constants", PRISM_PATH_LIBRARY . '/constants.php');

// Register controllers.
JLoader::register("Prism\\Controller\\Admin", PRISM_PATH_LIBRARY . '/controller/admin.php');
JLoader::register("Prism\\Controller\\Form", PRISM_PATH_LIBRARY . '/controller/form.php');
JLoader::register("Prism\\Controller\\DefaultController", PRISM_PATH_LIBRARY . '/controller/default.php');
JLoader::register("Prism\\Controller\\Form\\Backend", PRISM_PATH_LIBRARY . '/controller/form/backend.php');
JLoader::register("Prism\\Controller\\Form\\Frontend", PRISM_PATH_LIBRARY . '/controller/form/frontend.php');

// Register validators.
JLoader::register("Prism\\Validator\\ValidatorInterface", PRISM_PATH_LIBRARY . "/validator/validatorinterface.php");
JLoader::register("Prism\\Validator\\Date", PRISM_PATH_LIBRARY . "/validator/date.php");

// Register logger classes.
JLoader::register("Prism\\Log\\Log", PRISM_PATH_LIBRARY  . "/log/log.php");
JLoader::register("Prism\\Log\\Writer\\Database", PRISM_PATH_LIBRARY . "/log/writer/database.php");
JLoader::register("Prism\\Log\\Writer\\File", PRISM_PATH_LIBRARY . "/log/writer/file.php");
JLoader::register("Prism\\Log\\WriterInterface", PRISM_PATH_LIBRARY . "/log/writerinterface.php");

// Register general classes.
JLoader::register("Prism\\Date", PRISM_PATH_LIBRARY . "/date.php");
JLoader::register("Prism\\Math", PRISM_PATH_LIBRARY . "/math.php");
JLoader::register("Prism\\String", PRISM_PATH_LIBRARY . "/string.php");
JLoader::register("Prism\\Version", PRISM_PATH_LIBRARY . "/version.php");

// Register response classes.
JLoader::register("Prism\\Response\\Json", PRISM_PATH_LIBRARY . "/response/json.php");

// Register database classes.
JLoader::register("Prism\\Database\\Table", PRISM_PATH_LIBRARY . "/database/table.php");
JLoader::register("Prism\\Database\\TableImmutable", PRISM_PATH_LIBRARY . "/database/tableimmutable.php");
JLoader::register("Prism\\Database\\TableInterface", PRISM_PATH_LIBRARY . "/database/tableinterface.php");
JLoader::register("Prism\\Database\\ArrayObject", PRISM_PATH_LIBRARY . "/database/arrayobject.php");

// Register file classes.
JLoader::register("Prism\\File\\File", PRISM_PATH_LIBRARY . "/file/file.php");
JLoader::register("Prism\\File\\Image", PRISM_PATH_LIBRARY . "/file/image.php");
JLoader::register("Prism\\File\\RemoverInterface", PRISM_PATH_LIBRARY . "/file/removerinterface.php");
JLoader::register("Prism\\File\\UploaderInterface", PRISM_PATH_LIBRARY . "/file/uploaderinterface.php");
JLoader::register("Prism\\File\\UploaderInterface", PRISM_PATH_LIBRARY . "/file/uploaderinterface.php");
*/

// Register some helpers.
JHtml::addIncludePath(PRISM_PATH_LIBRARY .'/ui/helpers');

// Load library language.
$lang = JFactory::getLanguage();
$lang->load('lib_itprism', PRISM_PATH_LIBRARY);
