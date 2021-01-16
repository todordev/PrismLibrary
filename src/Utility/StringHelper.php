<?php
/**
 * @package      Prism
 * @subpackage   Utility
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Utility;

use Joomla\Utility\ArrayHelper as JArrayHelper;

/**
 * This class contains methods that are used for handling strings.
 *
 * @package     Prism
 * @subpackage  Utility
 */
abstract class StringHelper
{
    /**
     * The method generates random string.
     * You can set a prefix and specify the length of the string.
     *
     * <code>
     * $hash = Prism\Library\Prism\Utility\StringHelper::generateRandomString(32, "GEN");
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
     * $amount = Prism\Library\Prism\Utility\StringHelper::getAmount(100, GBP, $options);
     *
     * echo $amount;
     * </code>
     *
     * @param float $amount Amount value.
     * @param string $currency Currency Code ( GBP, USD, EUR,...)
     * @param array $options Options - "intl", "locale", "symbol",...
     *
     * @throws \InvalidArgumentException
     * @return string
     *
     * @deprecated 1.19
     */
    public static function getAmount($amount, $currency, array $options = array())
    {
        $useIntl   = JArrayHelper::getValue($options, 'intl', false, 'bool');
        $locale    = JArrayHelper::getValue($options, 'locale');
        $symbol    = JArrayHelper::getValue($options, 'symbol');
        $position  = JArrayHelper::getValue($options, 'position', 0, 'int');

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

            if ($symbol !== null and $symbol !== '') { // Symbol

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
     * echo Prism\Library\Prism\Utility\StringHelper:clean($content);
     * </code>
     *
     * @param string $content
     * @return string
     */
    public static function clean($content)
    {
        $content = strip_tags($content);
        $content = trim(preg_replace('/\r|\n/', ' ', $content));

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
     * echo Prism\Library\Prism\Utility\StringHelper::substr($content, $offset, $length);
     * </code>
     *
     * @param string $content
     * @param int $offset
     * @param int $length
     *
     * @return string
     */
    public static function substr($content, $offset, $length)
    {
        $pos     = strpos($content, ' ', $length);
        $content = substr($content, $offset, $pos);

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
     * $post = Prism\Library\Prism\Utility\StringHelper::parseNameValue($content);
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

        return $result;
    }

    /**
     * Convert a string to new one that can be used in the URL.
     *
     * <code>
     * $name = 'John Dow';
     *
     * // Converted to 'john-dow'.
     * $alias = Prism\Library\Prism\Utility\StringHelper::stringUrlSafe($name);
     * </code>
     *
     * @param string $string
     *
     * @return string
     */
    public static function stringUrlSafe($string)
    {
        $config = \JFactory::getConfig();
        if ((int)$config->get('unicodeslugs') === 1) {
            return \JFilterOutput::stringUrlUnicodeSlug($string);
        } else {
            return \JFilterOutput::stringURLSafe($string);
        }
    }

    /**
     * Generate MD5 hash based on name and value.
     *
     * <code>
     * $id = 1;
     * $name = 'John Dow';
     *
     * $alias = Prism\Library\Prism\Utility\StringHelper::generateMd5Hash($name, $id);
     * </code>
     *
     * @param string $name
     * @param mixed $value
     *
     * @return string
     */
    public static function generateMd5Hash($name, $value)
    {
        if (is_array($value)) {
            $result = '';
            foreach ($value as $key => $v) {
                if (!is_scalar($v)) {
                    continue;
                }

                $result .= trim($key).':'.trim($v);
            }
            $value = $result;
        }

        return md5($name.':'.$value);
    }

    /**
     * Generate a URI string by a given list of parameters.
     *
     * <code>
     * $params = array(
     *     'view' => 'details',
     *     'id' => 1
     * );
     *
     * $urlParameters = Prism\Library\Prism\Utility\StringHelper::generate($params);
     * </code>
     *
     * @param array $params
     *
     * @return string
     */
    public static function generateUrlParams($params)
    {
        $result = '';
        foreach ($params as $key => $param) {
            $result .= '&' . rawurlencode($key) . '=' . rawurlencode($param);
        }

        return $result;
    }

    /**
     * Strip tags and white spaces in a string.
     *
     * <code>
     * $htmlString = '<a href="https://funfex.com"'>FunFex.com</a>';
     *
     * Prism\Library\Prism\Utility\StringHelper::stripTagsAndSpaces($htmlString);
     * </code>
     *
     * @param $string
     * @return string
     */
    public static function stripTagsAndSpaces(string $string): string
    {
        // Strip HTML Tags
        $clear = strip_tags($string);

        // Clean up things like &amp;
        $clear = html_entity_decode($clear);

        // Strip out any url-encoded stuff
        $clear = urldecode($clear);

        // Replace non-AlNum characters with space
        $clear = preg_replace('/[^A-Za-z0-9]/', ' ', $clear);

        // Replace Multiple spaces with single space
        $clear = preg_replace('/ +/', ' ', $clear);

        // Trim the string of leading/trailing space
        return trim($clear);
    }
}
