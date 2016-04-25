<?php
/**
 * @package      Prism
 * @subpackage   Utilities
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Utilities;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that are used for working with files.
 *
 * @package     Prism
 * @subpackage  Utilities
 */
abstract class FileHelper
{
    /**
     * Return line that reads from file.
     * It uses PHP generators to do that.
     *
     * <code>
     * $file = '../../filename.csv';
     *
     * foreach (Prism\Utilities\FileHelper::getLine($file) as $key => $value) {
     * ...
     * }
     * </code>
     *
     * @param string  $file
     *
     * @return \Iterator
     */
    public static function getLine($file)
    {
        $f = fopen($file, 'r');

        try {
            while ($line = fgets($f)) {
                yield $line;
            }
        } finally {
            fclose($f);
        }
    }

    /**
     * Return maximum file size (in KB) that can be uploaded.
     *
     * <code>
     * $maxFileSize = Prism\Utilities\FileHelper::getMaximumFileSize($file);
     * </code>
     *
     * @param int $maxFileSizeByUser Maximum file size set by user.
     * @param string $format Format that will be returned - MB or KB.
     *
     * @return int
     */
    public static function getMaximumFileSize($maxFileSizeByUser = 0, $format = 'KB')
    {
        $values = array();
        $KB = 1024 * 1024;

        if ($maxFileSizeByUser > 0) {
            $values[] = $maxFileSizeByUser * $KB;
        }

        // Verify file size
        $uploadMaxFileSize  = (int)ini_get('upload_max_filesize');
        if ($uploadMaxFileSize > 0) {
            $values[] = $uploadMaxFileSize * $KB;
        }

        $postMaxSize  = (int)(ini_get('post_max_size'));
        if ($postMaxSize > 0) {
            $values[] = $postMaxSize * $KB;
        }

        $memoryLimit = (int)(ini_get('memory_limit'));
        if ($memoryLimit !== -1) {
            $memoryLimit *= $KB;
        }

        if ($memoryLimit > 0) {
            $values[] = $memoryLimit;
        }

        $result = min($values);

        return (($result > 0.0) and (strcmp($format, 'MB') === 0)) ? $result / $KB : $result;
    }
}
