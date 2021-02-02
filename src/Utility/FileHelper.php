<?php
/**
 * @package      Prism\Library\Prism\Utility
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Utility;

use Generator;

/**
 * This class contains methods that are used for working with files.
 *
 * @package Prism\Library\Prism\Utility
 */
final class FileHelper
{
    /**
     * Return line that reads from file.
     * It uses PHP generators to do that.
     * <code>
     * $file = '../../filename.csv';
     * foreach (FileHelper::getLine($file) as $key => $value) {
     * ...
     * }
     * </code>
     *
     * @param string $file
     * @return Generator
     */
    public static function getLine(string $file): Generator
    {
        $f = fopen($file, 'rb');

        try {
            while ($line = fgets($f)) {
                yield $line;
            }
        } finally {
            fclose($f);
        }
    }
}
