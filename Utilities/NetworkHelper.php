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
 * This class contains methods that are used for handling strings.
 *
 * @package     Prism
 * @subpackage  Utilities
 */
abstract class NetworkHelper
{
    /**
     * Retrieves the best guess of the client's actual IP address.
     * Takes into account numerous HTTP proxy headers due to variations
     * in how different ISPs handle IP addresses in headers between hops.
     *
     * @return string
     */
    public static function getIpAddress()
    {
        // check for shared internet/ISP IP
        if (!empty($_SERVER['HTTP_CLIENT_IP']) and self::isValidIp($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        // check for IPs passing through proxies
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // check if multiple ips exist in var
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
                $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach ($ipList as $ip) {
                    if (self::isValidIp($ip)) {
                        return $ip;
                    }
                }
            } else {
                if (self::isValidIp($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    return $_SERVER['HTTP_X_FORWARDED_FOR'];
                }
            }
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED']) and self::isValidIp($_SERVER['HTTP_X_FORWARDED'])) {
            return $_SERVER['HTTP_X_FORWARDED'];
        }

        if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) and self::isValidIp($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        }

        if (!empty($_SERVER['HTTP_FORWARDED_FOR']) and self::isValidIp($_SERVER['HTTP_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_FORWARDED_FOR'];
        }

        if (!empty($_SERVER['HTTP_FORWARDED']) and self::isValidIp($_SERVER['HTTP_FORWARDED'])) {
            return $_SERVER['HTTP_FORWARDED'];
        }

        // return unreliable ip since all else failed
        if (!empty($_SERVER['REMOTE_ADDR']) and self::isValidIp($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        }

        return '';
    }

    /**
     * Ensures an ip address is both a valid IP and does not fall within
     * a private network range.
     *
     * @param string $ip
     *
     * @return bool
     */
    public static function isValidIp($ip)
    {
        if (strpos($ip, ':') === false) { // IPv4
            if (strtolower($ip) === 'unknown') {
                return false;
            }

            // generate ipv4 network address
            $ip = ip2long($ip);

            // if the ip is set and not equivalent to 255.255.255.255
            if ($ip !== false && $ip !== -1) {
                // make sure to get unsigned long representation of ip
                // due to discrepancies between 32 and 64 bit OSes and
                // signed numbers (ints default to signed in PHP)
                $ip = sprintf('%u', $ip);

                // do private network range checking.
                if ($ip >= 0 && $ip <= 50331647) {
                    return false;
                }
                if ($ip >= 167772160 && $ip <= 184549375) {
                    return false;
                }
                if ($ip >= 2130706432 && $ip <= 2147483647) {
                    return false;
                }
                if ($ip >= 2851995648 && $ip <= 2852061183) {
                    return false;
                }
                if ($ip >= 2886729728 && $ip <= 2887778303) {
                    return false;
                }
                if ($ip >= 3221225984 && $ip <= 3221226239) {
                    return false;
                }
                if ($ip >= 3232235520 && $ip <= 3232301055) {
                    return false;
                }
                if ($ip >= 4294967040) {
                    return false;
                }

                if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                    return false;
                }
            }
        } else {
            if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Return cURL version.
     *
     * @return string
     */
    public static function getCurlVersion()
    {
        $version = '--';

        if (function_exists('curl_version')) {
            $curlVersionInfo   = curl_version();
            $version           = $curlVersionInfo['version'];
        }

        return $version;
    }

    /**
     * Return Open SSL version.
     *
     * @return string
     */
    public static function getOpenSslVersion()
    {
        $openSSLVersion = '--';

        if (function_exists('curl_version')) {
            $curlVersionInfo   = curl_version();
            $openSSLVersionRaw = $curlVersionInfo['ssl_version'];
            // OpenSSL version typically reported as "OpenSSL/1.0.1e", I need to convert it to 1.0.1.5
            $parts             = explode('/', $openSSLVersionRaw, 2);
            $openSSLVersionRaw = (count($parts) > 1) ? $parts[1] : $openSSLVersionRaw;
            $openSSLVersion    = substr($openSSLVersionRaw, 0, -1) . '.' . (ord(substr($openSSLVersionRaw, -1)) - 96);
        }

        return $openSSLVersion;
    }
}
