<?php
/**
 * @package     Prism\Library\Prism\Filesystem
 * @subpackage
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

namespace Prism\Library\Prism\Filesystem;


class Image extends File
{
    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     * @return File
     */
    public function setAttributes(array $attributes): File
    {
        $this->attributes = $attributes;
        return $this;
    }

}
