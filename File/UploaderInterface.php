<?php
/**
 * @package         Prism
 * @subpackage      Files\Interfaces
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

namespace Prism\File;

defined('JPATH_PLATFORM') or die;

/**
 * An interface of file uploader.
 *
 * @package         Prism
 * @subpackage      Files\Interfaces
 */
interface UploaderInterface
{
    public function setFile($file);
    public function getDestination();
    public function setDestination($destination);
    public function upload();
}
