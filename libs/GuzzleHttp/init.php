<?php
/**
 * @package      Prism
 * @subpackage   Payment\iDEAL
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('JPATH_PLATFORM') or die;

JLoader::register('GuzzleHttp\\Cookie\\CookieJar', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Cookie/CookieJar.php');
JLoader::register('GuzzleHttp\\Cookie\\CookieJarInterface', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Cookie/CookieJarInterface.php');
JLoader::register('GuzzleHttp\\Cookie\\FileCookieJar', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Cookie/FileCookieJar.php');
JLoader::register('GuzzleHttp\\Cookie\\SessionCookieJar', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Cookie/SessionCookieJar.php');
JLoader::register('GuzzleHttp\\Cookie\\SetCookie', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Cookie/SetCookie.php');

JLoader::register('GuzzleHttp\\Exception\\BadResponseException', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Exception/BadResponseException.php');
JLoader::register('GuzzleHttp\\Exception\\ClientException', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Exception/ClientException.php');
JLoader::register('GuzzleHttp\\Exception\\ConnectException', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Exception/ConnectException.php');
JLoader::register('GuzzleHttp\\Exception\\GuzzleException', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Exception/GuzzleException.php');
JLoader::register('GuzzleHttp\\Exception\\RequestException', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Exception/RequestException.php');
JLoader::register('GuzzleHttp\\Exception\\SeekException', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Exception/SeekException.php');
JLoader::register('GuzzleHttp\\Exception\\ServerException', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Exception/ServerException.php');
JLoader::register('GuzzleHttp\\Exception\\TooManyRedirectsException', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Exception/TooManyRedirectsException.php');
JLoader::register('GuzzleHttp\\Exception\\TransferException', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Exception/TransferException.php');

JLoader::register('GuzzleHttp\\Handler\\CurlFactory', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Handler/CurlFactory.php');
JLoader::register('GuzzleHttp\\Handler\\CurlFactoryInterface', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Handler/CurlFactoryInterface.php');
JLoader::register('GuzzleHttp\\Handler\\CurlHandler', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Handler/CurlHandler.php');
JLoader::register('GuzzleHttp\\Handler\\CurlMultiHandler', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Handler/CurlMultiHandler.php');
JLoader::register('GuzzleHttp\\Handler\\EasyHandle', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Handler/EasyHandle.php');
JLoader::register('GuzzleHttp\\Handler\\MockHandler', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Handler/MockHandler.php');
JLoader::register('GuzzleHttp\\Handler\\Proxy', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Handler/Proxy.php');
JLoader::register('GuzzleHttp\\Handler\\StreamHandler', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Handler/StreamHandler.php');

JLoader::register('GuzzleHttp\\Promise\\AggregateException', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Promises/AggregateException.php');
JLoader::register('GuzzleHttp\\Promise\\CancellationException', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Promises/CancellationException.php');
JLoader::register('GuzzleHttp\\Promise\\EachPromise', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Promises/EachPromise.php');
JLoader::register('GuzzleHttp\\Promise\\FulfilledPromise', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Promises/FulfilledPromise.php');
JLoader::register('GuzzleHttp\\Promise\\Promise', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Promises/Promise.php');
JLoader::register('GuzzleHttp\\Promise\\PromiseInterface', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Promises/PromiseInterface.php');
JLoader::register('GuzzleHttp\\Promise\\PromisorInterface', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Promises/PromisorInterface.php');
JLoader::register('GuzzleHttp\\Promise\\RejectedPromise', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Promises/RejectedPromise.php');
JLoader::register('GuzzleHttp\\Promise\\RejectionException', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Promises/RejectionException.php');
JLoader::register('GuzzleHttp\\Promise\\TaskQueue', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Promises/TaskQueue.php');

JLoader::register('GuzzleHttp\\Psr7\\AppendStream', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Psr7/AppendStream.php');
JLoader::register('GuzzleHttp\\Psr7\\BufferStream', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Psr7/BufferStream.php');
JLoader::register('GuzzleHttp\\Psr7\\CachingStream', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Psr7/CachingStream.php');
JLoader::register('GuzzleHttp\\Psr7\\DroppingStream', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Psr7/DroppingStream.php');
JLoader::register('GuzzleHttp\\Psr7\\FnStream', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Psr7/FnStream.php');
JLoader::register('GuzzleHttp\\Psr7\\InflateStream', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Psr7/InflateStream.php');
JLoader::register('GuzzleHttp\\Psr7\\LazyOpenStream', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Psr7/LazyOpenStream.php');
JLoader::register('GuzzleHttp\\Psr7\\LimitStream', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Psr7/LimitStream.php');
JLoader::register('GuzzleHttp\\Psr7\\MessageTrait', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Psr7/MessageTrait.php');
JLoader::register('GuzzleHttp\\Psr7\\MultipartStream', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Psr7/MultipartStream.php');
JLoader::register('GuzzleHttp\\Psr7\\NoSeekStream', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Psr7/NoSeekStream.php');
JLoader::register('GuzzleHttp\\Psr7\\PumpStream', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Psr7/PumpStream.php');
JLoader::register('GuzzleHttp\\Psr7\\Request', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Psr7/Request.php');
JLoader::register('GuzzleHttp\\Psr7\\Response', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Psr7/Response.php');
JLoader::register('GuzzleHttp\\Psr7\\Stream', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Psr7/Stream.php');
JLoader::register('GuzzleHttp\\Psr7\\StreamDecoratorTrait', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Psr7/StreamDecoratorTrait.php');
JLoader::register('GuzzleHttp\\Psr7\\StreamWrapper', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Psr7/StreamWrapper.php');
JLoader::register('GuzzleHttp\\Psr7\\Uri', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Psr7/Uri.php');

JLoader::register('GuzzleHttp\\Client', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Client.php');
JLoader::register('GuzzleHttp\\ClientInterface', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/ClientInterface.php');
JLoader::register('GuzzleHttp\\HandlerStack', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/HandlerStack.php');
JLoader::register('GuzzleHttp\\MessageFormatter', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/MessageFormatter.php');
JLoader::register('GuzzleHttp\\Middleware', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Middleware.php');
JLoader::register('GuzzleHttp\\Pool', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Pool.php');
JLoader::register('GuzzleHttp\\PrepareBodyMiddleware', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/PrepareBodyMiddleware.php');
JLoader::register('GuzzleHttp\\RedirectMiddleware', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/RedirectMiddleware.php');
JLoader::register('GuzzleHttp\\RequestOptions', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/RequestOptions.php');
JLoader::register('GuzzleHttp\\RetryMiddleware', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/RetryMiddleware.php');
JLoader::register('GuzzleHttp\\TransferStats', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/TransferStats.php');
JLoader::register('GuzzleHttp\\UriTemplate', PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/UriTemplate.php');

require_once(PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Promises/functions_include.php');
require_once(PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/Psr7/functions_include.php');
require_once(PRISM_PATH_LIBRARY . '/libs/GuzzleHttp/functions_include.php');
