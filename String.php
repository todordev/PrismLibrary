<?php
/**
 * @package      Prism
 * @subpackage   Strings
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism;

use Joomla\Utilities\ArrayHelper;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that are used for handling strings.
 *
 * @package     Prism
 * @subpackage  Strings
 *
 * @deprecated 1.10  Use {@link \Prism\Utilities\StringHelper} instead unless otherwise noted.
 */
class String
{
    protected $content;

    /**
     * Initialize the object.
     *
     * <code>
     * $content = "If you can dream it, you can do it."
     *
     * $string = new Prism\String($content);
     * </code>
     * 
     * @param string $content
     */
    public function __construct($content = "")
    {
        $this->content = (string)$content;
    }

    /**
     * The method generates random string.
     * You can set a prefix and specify the length of the string.
     *
     * <code>
     * $hash = new Prism\String;
     * $hash->generateRandomString(32, "GEN");
     *
     * echo $hash;
     * </code>
     *
     * @param integer $length The length of the string, that will be generated.
     * @param string  $prefix A prefix, which will be added at the beginning of the string.
     *
     * @return string
     *
     * @deprecated since v1.10
     */
    public function generateRandomString($length = 10, $prefix = "")
    {
        // Generate string
        $hash = md5(uniqid(time() + mt_rand(), true));
        $hash = substr($hash, 0, $length);

        // Add prefix
        if (!empty($prefix)) {
            $hash = $prefix . $hash;
        }

        $this->content = $hash;

        return $this;
    }

    /**
     * Generate a string of amount based on location.
     * The method uses PHP NumberFormatter ( Internationalization Functions ).
     * If the internationalization library is not loaded, the method generates a simple string ( 100 USD, 500 EUR,... )
     *
     * <code>
     * $options = array(
     *     "intl" => true",
     *     "locale" => "en_GB",
     *     "symbol" => "£",
     *     "position" => 0 // 0 for symbol on the left side, 1 for symbole on the right side.
     * );
     *
     * $amount = new Prism\String(100);
     * $amount->getAmount(GBP, $options);
     *
     * echo $amount;
     * </code>
     *
     * @param string $currency Currency Code ( GBP, USD, EUR,...)
     * @param array $options Options - "intl", "locale", "symbol",...
     *
     * @return string
     *
     * @deprecated since v1.10
     */
    public function getAmount($currency, $options = array())
    {
        $useIntl   = ArrayHelper::getValue($options, "intl", false, "bool");
        $locale    = ArrayHelper::getValue($options, "locale");
        $symbol    = ArrayHelper::getValue($options, "symbol");
        $position  = ArrayHelper::getValue($options, "position");

        // Use PHP Intl library.
        if ($useIntl and extension_loaded('intl')) { // Generate currency string using PHP NumberFormatter ( Internationalization Functions )

            // Get current locale code.
            if (!$locale) {
                $lang   = \JFactory::getLanguage();
                $locale = $lang->getName();
            }

            $numberFormat = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
            $amount       = $numberFormat->formatCurrency($this->content, $currency);

        } else { // Generate a custom currency string.

            if (!empty($symbol)) { // Symbol

                if (0 == $position) { // Symbol at the beginning.
                    $amount = $symbol . $this->content;
                } else { // Symbol at end.
                    $amount = $this->content . $symbol;
                }

            } else { // Code
                $amount = $this->content . $currency;
            }

        }

        return $amount;
    }

    /**
     * Clean tags, spaces and newlines.
     *
     * <code>
     * $content = "If you can <strong>dream</strong> it, you can do it. "
     *
     * $string = new Prism\String($content);
     * $string->clean();
     *
     * echo $string;
     * </code>
     *
     * @return self
     *
     * @deprecated since v1.10
     */
    public function clean()
    {
        $this->content = strip_tags($this->content);
        $this->content = \JString::trim(preg_replace('/\r|\n/', ' ', $this->content));

        return $this;
    }

    /**
     * Return part of a string without break words.
     *
     * <code>
     * $offset  = 0;
     * $length  = 25;
     * $content = "If you can dream it, you can do it."
     *
     * $string = new Prism\String();
     * $string->substr($offset, $length);
     *
     * echo $string;
     * </code>
     *
     * @param integer $offset
     * @param integer $length
     *
     * @return self
     *
     * @deprecated since v1.10
     */
    public function substr($offset, $length)
    {
        $pos           = \JString::strpos($this->content, ' ', $length);
        $this->content = \JString::substr($this->content, $offset, $pos);

        return $this;
    }

    /**
     * Parse string that contains names and values.
     *
     * <code>
     *
     * // String like this "name1=value1&name2=value2&name3=value3".
     * $rawPost  = file_get_contents("php://input");
     *
     * $string = new Prism\String($content);
     * $post   = $string->parseNameValue();
     * </code>
     *
     * @return array
     *
     * @deprecated since v1.10
     */
    public function parseNameValue()
    {
        $result = array();

        $data = explode("&", $this->content);
        foreach ($data as $value) {
            $value = explode("=", $value);

            if (count($value) == 2) {

                $value[0] = urldecode($value[0]);
                $value[1] = urldecode($value[1]);

                $result[$value[0]] = $value[1];
            }

        }

        if (!is_array($result)) {
            $result = array();
        }

        return $result;
    }

    /**
     * Return object value as a string.
     * 
     * @return string
     */
    public function __toString()
    {
        return (string)$this->content;
    }
}
