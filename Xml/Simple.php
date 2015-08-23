<?php
/**
 * @package      Prism
 * @subpackage   XML
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Xml;

defined('JPATH_PLATFORM') or die;

/**
 * This class extends the native PHP class Simple XML.
 *
 * @package      Prism
 * @subpackage   XML
 */
class Simple extends \SimpleXMLElement
{
    /**
     * Include a CDATA element to an XML content.
     *
     * <code>
     * $sxml = new Prism\Xml\Simple();
     *
     * $sxml->addCData("<strong>This text contains HTML code.</strong>");
     * </code>
     *
     * @param string $cdataText
     */
    public function addCData($cdataText)
    {
        $node = dom_import_simplexml($this);
        $no   = $node->ownerDocument;
        $node->appendChild($no->createCDATASection($cdataText));
    }

    /**
     * Adds a child with $value inside CDATA.
     *
     * @param string $name
     * @param mixed  $value
     *
     * <code>
     * $sxml = new Prism\Xml\Simple();
     *
     * $sxml->addChildCData("body", "<strong>This text contains HTML code.</strong>");
     * </code>
     *
     * @return Simple
     */
    public function addChildCData($name, $value = null)
    {
        $newChild = $this->addChild($name);

        if ($newChild !== null) {
            $node = dom_import_simplexml($newChild);
            $no   = $node->ownerDocument;
            $node->appendChild($no->createCDATASection($value));
        }

        return $newChild;
    }
}
