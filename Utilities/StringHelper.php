<?php
/**
 * @package      Prism
 * @subpackage   Utilities
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Utilities;

use Joomla\Utilities\ArrayHelper;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that are used for handling strings.
 *
 * @package     Prism
 * @subpackage  Utilities
 */
class StringHelper
{
    /**
     * The method generates random string.
     * You can set a prefix and specify the length of the string.
     *
     * <code>
     * $hash = Prism\Utilities\StringHelper::generateRandomString(32, "GEN");
     *
     * echo $hash;
     * </code>
     *
     * @param integer $length The length of the string, that will be generated.
     * @param string  $prefix A prefix, which will be added at the beginning of the string.
     *
     * @return string
     */
    public static function generateRandomString($length = 10, $prefix = '')
    {
        // Generate string
        $hash = md5(uniqid(time() + mt_rand(), true));
        $hash = substr($hash, 0, $length);

        // Add prefix
        if (trim($prefix)) {
            $hash = $prefix . $hash;
        }

        return $hash;
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
     * $amount = Prism\Utilities\StringHelper::getAmount(100, GBP, $options);
     *
     * echo $amount;
     * </code>
     *
     * @param float $amount Amount value.
     * @param string $currency Currency Code ( GBP, USD, EUR,...)
     * @param array $options Options - "intl", "locale", "symbol",...
     *
     * @return string
     */
    public static function getAmount($amount, $currency, array $options = array())
    {
        $useIntl   = ArrayHelper::getValue($options, 'intl', false, 'bool');
        $locale    = ArrayHelper::getValue($options, 'locale');
        $symbol    = ArrayHelper::getValue($options, 'symbol');
        $position  = ArrayHelper::getValue($options, 'position', 0, 'int');

        // Use PHP Intl library.
        if ($useIntl and extension_loaded('intl')) { // Generate currency string using PHP NumberFormatter ( Internationalization Functions )

            // Get current locale code.
            if (!$locale) {
                $lang   = \JFactory::getLanguage();
                $locale = $lang->getName();
            }

            $numberFormat = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
            $result       = $numberFormat->formatCurrency($amount, $currency);

        } else { // Generate a custom currency string.

            if (\JString::strlen($symbol) > 0) { // Symbol

                if (0 === $position) { // Symbol at the beginning.
                    $result = $symbol . $amount;
                } else { // Symbol at end.
                    $result = $amount . $symbol;
                }

            } else { // Code
                $result = $amount . $currency;
            }
        }

        return $result;
    }

    /**
     * Clean tags, spaces and newlines.
     *
     * <code>
     * $content = "If you can <strong>dream</strong> it, you can do it. "
     *
     * echo Prism\Utilities\StringHelper:clean($content);
     * </code>
     *
     * @param string $content
     * @return string
     */
    public static function clean($content)
    {
        $content = strip_tags($content);
        $content = \JString::trim(preg_replace('/\r|\n/', ' ', $content));

        return $content;
    }

    /**
     * Return part of a string without break words.
     *
     * <code>
     * $offset  = 0;
     * $length  = 25;
     * $content = "If you can dream it, you can do it."
     *
     * echo Prism\Utilities\StringHelper::substr($content, $offset, $length);
     * </code>
     *
     * @param string $content
     * @param integer $offset
     * @param integer $length
     *
     * @return string
     */
    public static function substr($content, $offset, $length)
    {
        $pos     = \JString::strpos($content, ' ', $length);
        $content = \JString::substr($content, $offset, $pos);

        return $content;
    }

    /**
     * Parse string that contains names and values.
     *
     * <code>
     *
     * // String like this "name1=value1&name2=value2&name3=value3".
     * $rawPost  = file_get_contents("php://input");
     *
     * $post = Prism\Utilities\StringHelper::parseNameValue($content);
     * </code>
     *
     * @param string $content
     *
     * @return array
     */
    public static function parseNameValue($content)
    {
        $result = array();

        $data = explode('&', $content);
        foreach ($data as $value) {
            $value = explode('=', $value);

            if (count($value) === 2) {
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
}
