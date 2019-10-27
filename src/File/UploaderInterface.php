<?php
/**
 * @package         Prism
 * @subpackage      Files\Interfaces
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\File;

defined('JPATH_PLATFORM') or die;

/**
 * An interface of file uploader.
 *
 * @package         Prism
 * @subpackage      Files\Interfaces
 *
 * @deprecated since v1.10
 */
interface UploaderInterface
{
    public function setFile($file);
    public function getDestination();
    public function setDestination($destination);
    public function upload();
}
