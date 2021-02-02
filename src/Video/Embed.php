<?php
/**
 * @package      Prism\Library\Prism\Video
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Video;

use Joomla\Uri\Uri;

/**
 * This class provides functionality for parsing video URLs
 * and generating HTML code that can be used for embedding into websites.
 *
 * @package Prism\Library\Prism\Video
 * @todo It should be reworked.
 */
final class Embed
{
    protected string $url;
    protected string $code;
    protected $service;

    protected string $patternYouTube = '#(?<=(?:v|i)=)[a-zA-Z0-9-]+(?=&)|(?<=(?:v|i)\/)[^&\n]+|(?<=embed\/)[^"&\n]+|(?<=(?:v|i)=)[^&\n]+|(?<=youtu.be\/)[^&\n]+#';
    protected string $patternVimeo = '#^.*(vimeo\.com\/)((channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)#';

    /**
     * Initialize the object.
     *
     * <code>
     * $url = "http://youtube.com/...";
     *
     * $video = new Prism\Library\Prism\Video\Embed($url);
     * </code>
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Parse the URL of video service
     *
     * <code>
     * $url = "http://youtube.com/...";
     *
     * $video = new Prism\Library\Prism\Video\Embed($url);
     * $video->parse();
     *
     * </code>
     */
    public function parse(): void
    {
        $uri  = new Uri($this->url);
        $host = $uri->getHost();

        // Youtube
        if ((str_contains($host, 'youtu')) && preg_match($this->patternYouTube, $this->url, $matches)) {
            $this->code    = $matches[0];
            $this->service = 'youtube';
            return;
        }

        // Vimeo
        if ((str_contains($host, 'vimeo')) && preg_match($this->patternVimeo, $this->url, $matches)) {
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
     * $video = new Prism\Library\Prism\Video\Embed($url);
     * $video->parse();
     *
     * $video->getCode();
     * </code>
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Return an HTML code that can be used for embedding.
     *
     * <code>
     * $url = "http://youtube.com/...";
     *
     * $video = new Prism\Library\Prism\Video\Embed($url);
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
                $html = '';
                break;
        }

        return $html;
    }
}
