<?php
/**
 * @package      Prism
 * @subpackage   XML
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Xml;

use SimpleXMLElement;

/**
 * This class extends the native PHP class Simple XML.
 *
 * @package      Prism
 * @subpackage   XML
 */
class Simple extends SimpleXMLElement
{
    /**
     * Include a CDATA element to an XML content.
     * <code>
     * $sxml = new Prism\Library\Prism\Xml\Simple();
     * $sxml->addCData("<strong>This text contains HTML code.</strong>");
     * </code>
     *
     * @param string $cdataText
     */
    public function addCData(string $cdataText)
    {
        $node = dom_import_simplexml($this);
        $no   = $node->ownerDocument;
        $node->appendChild($no->createCDATASection($cdataText));
    }

    /**
     * Adds a child with $value inside CDATA.
     *
     * @param string $name
     * @param string $value
     * <code>
     * $sxml = new Prism\Library\Prism\Xml\Simple();
     * $sxml->addChildCData("body", "<strong>This text contains HTML code.</strong>");
     * </code>
     * @return SimpleXMLElement
     */
    public function addChildCData(string $name, string $value = '')
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
