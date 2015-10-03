<?php
/**
 * @package      Prism
 * @subpackage   Responses
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Response;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality to manage JSON response.
 *
 * @package      Prism
 * @subpackage   Responses
 */
class Json
{
    protected $success = true;
    protected $title = '';
    protected $text = '';
    protected $data;
    protected $redirectUrl;

    /**
     * Initialize the object.
     *
     * <code>
     * $title = "My title...";
     * $text  = "My message...";
     *
     * $response = new Prism\Response\Json($title, $text);
     * </code>
     *
     * @param string $title
     * @param string $text
     */
    public function __construct($title = '', $text = '')
    {
        $this->title = $title;
        $this->text  = $text;
    }

    /**
     * Set the response as successfully completed.
     *
     * <code>
     * $title = "My title...";
     * $text  = "My message...";
     *
     * $response = new Prism\Response\Json($title, $text);
     * $response->success();
     * </code>
     *
     * @return self
     */
    public function success()
    {
        $this->success = true;

        return $this;
    }

    /**
     * Set the response as completed unsuccessfully.
     *
     * <code>
     * $title = "My title...";
     * $text  = "My message...";
     *
     * $response = new Prism\Response\Json($title, $text);
     * $response->failure();
     * </code>
     *
     * @return self
     */
    public function failure()
    {
        $this->success = false;

        return $this;
    }

    /**
     * Return a response title.
     *
     * <code>
     * $response = new Prism\Response\Json();
     * $title = $response->getTitle();
     * </code>
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set a response title to the object.
     *
     * <code>
     * $title = "My title....";
     *
     * $response = new Prism\Response\Json();
     * $response->setTitle($title);
     * </code>
     *
     * @param string $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Return a response text ( message ).
     *
     * <code>
     * $response = new Prism\Response\Json();
     * $text = $response->getText();
     * </code>
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set a response text to the object.
     *
     * <code>
     * $text = "My text....";
     *
     * $response = new Prism\Response\Json();
     * $response->setText($text);
     * </code>
     *
     * @param string $text
     *
     * @return self
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Return an additional data that comes from response.
     *
     * <code>
     * $response = new Prism\Response\Json();
     * $data = $response->getData();
     * </code>
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set an additional data that comes from the server.
     *
     * <code>
     * $data = array(
     *     "name" => "John Dow",
     *     "website" => "http://itprism.com"
     * );
     *
     * $response = new Prism\Response\Json();
     * $response->setData($url);
     * </code>
     *
     * @param array $data
     *
     * @return self
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Return a URL that should be used from the browser to redirect users to a new page.
     *
     * <code>
     * $response = new Prism\Response\Json();
     * $redirectUrl = $response->getRedirectUrl();
     * </code>
     *
     * @return array
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * Set a URL that should be used from the browser to redirect users to a new page.
     *
     * <code>
     * $url = "http://itprism.com";
     *
     * $response = new Prism\Response\Json();
     * $response->setRedirectUrl($url);
     * </code>
     *
     * @param $url
     * @return self
     */
    public function setRedirectUrl($url)
    {
        $this->redirectUrl = $url;

        return $this;
    }

    /**
     * Return the parameters of the object as a JSON string.
     *
     * <code>
     * $response = new Prism\Response\Json();
     * $jsonResponse = $response->__toString();
     * </code>
     *
     * @return string
     */
    public function __toString()
    {
        $response = array(
            'success' => $this->success,
            'title'   => $this->title,
            'text'    => $this->text
        );

        if (null !== $this->data) {
            $response['data'] = $this->data;
        }

        if (null !== $this->redirectUrl) {
            $response['redirect_url'] = $this->redirectUrl;
        }

        return (string)json_encode($response);
    }
}
