<?php
/**
 * @package      Prism
 * @subpackage   Video
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Video;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality for parsing video URLs
 * and generating HTML code that can be used for embedding into websites.
 *
 * @package      Prism
 * @subpackage   Video
 */
class Embed
{
    protected $url;
    protected $code;
    protected $service;

    protected $patternYouTube = '#(?<=(?:v|i)=)[a-zA-Z0-9-]+(?=&)|(?<=(?:v|i)\/)[^&\n]+|(?<=embed\/)[^"&\n]+|(?<=(?:v|i)=)[^&\n]+|(?<=youtu.be\/)[^&\n]+#';
    protected $patternVimeo = '#^.*(vimeo\.com\/)((channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)#';

    /**
     * Initialize the object.
     *
     * <code>
     * $url = "http://youtube.com/...";
     *
     * $video = new Prism\Video\Embed($url);
     * </code>
     *
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Parse the URL of video service
     *
     * <code>
     * $url = "http://youtube.com/...";
     *
     * $video = new Prism\Video\Embed($url);
     * $video->parse();
     *
     * </code>
     */
    public function parse()
    {
        $uri  = new \JUri($this->url);
        $host = $uri->getHost();

        // Youtube
        if ((false !== strpos($host, 'youtu')) and (preg_match($this->patternYouTube, $this->url, $matches))) {
            $this->code    = $matches[0];
            $this->service = 'youtube';
            return;
        }

        // Vimeo
        if ((false !== strpos($host, 'vimeo')) and (preg_match($this->patternVimeo, $this->url, $matches))) {
            $this->code    = $matches[5];
            $this->service = 'vimeo';
            return;
        }
    }

    /**
     * Return an ID of a video.
     *
     * <code>
     * $url = "http://youtube.com/...";
     *
     * $video = new Prism\Video\Embed($url);
     * $video->parse();
     *
     * $video->getCode();
     * </code>
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Return an HTML code that can be used for embedding.
     *
     * <code>
     * $url = "http://youtube.com/...";
     *
     * $video = new Prism\Video\Embed($url);
     * $video->parse();
     *
     * $video->getHtmlCode();
     * </code>
     *
     * @return string
     */
    public function getHtmlCode()
    {
        switch ($this->service) {

            case 'youtube':
                $html = '<iframe width="560" height="315" src="//www.youtube.com/embed/' . $this->code . '" frameborder="0" allowfullscreen></iframe>';
                break;

            case 'vimeo':
                $html = '<iframe src="//player.vimeo.com/video/' . $this->code . '" width="500" height="281" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                break;

            default:
                $html = \JText::_('LIB_PRISM_ERROR_INVALID_VIDEO_SERVICE');
                break;
        }

        return $html;
    }
}
