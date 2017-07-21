<?php
/**
 * @package      Prism
 * @subpackage   Responses
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Response;

/**
 * This class provides functionality to manage JSON response.
 *
 * @package      Prism
 * @subpackage   Responses
 */
class Json
{
    protected $success = true;
    protected $message = array();
    protected $data;
    protected $redirectUrl;

    /**
     * Initialize the object.
     *
     * <code>
     * $title   = "My title...";
     * $content = "My message...";
     *
     * $response = new Prism\Response\Json($title, $content);
     * </code>
     *
     * @param string $title
     * @param string $content
     */
    public function __construct($title = '', $content = '')
    {
        $this->message = array(
            'title'     => $title,
            'content'   => $content,
            'type'      => '',
        );
    }

    /**
     * Set the response as successfully completed.
     *
     * <code>
     * $title = "My title...";
     * $content  = "My message...";
     *
     * $response = new Prism\Response\Json($title, $content);
     * $response->success();
     * </code>
     *
     * @return self
     */
    public function success()
    {
        $this->success = true;
        $this->message['type'] = 'success';

        return $this;
    }

    /**
     * Set the response as completed unsuccessfully.
     *
     * <code>
     * $title = "My title...";
     * $content  = "My message...";
     *
     * $response = new Prism\Response\Json($title, $content);
     * $response->failure();
     * </code>
     *
     * @return self
     */
    public function failure()
    {
        $this->success = false;
        $this->message['type'] = 'error';

        return $this;
    }

    /**
     * Set the response as warning message.
     *
     * <code>
     * $title = "My title...";
     * $content  = "My message...";
     *
     * $response = new Prism\Response\Json($title, $content);
     * $response->warning();
     * </code>
     *
     * @return self
     */
    public function warning()
    {
        $this->success = false;
        $this->message['type'] = 'warning';

        return $this;
    }

    /**
     * Set the response as info message.
     *
     * <code>
     * $title = "My title...";
     * $content  = "My message...";
     *
     * $response = new Prism\Response\Json($title, $content);
     * $response->info();
     * </code>
     *
     * @return self
     */
    public function info()
    {
        $this->success = true;
        $this->message['type'] = 'type';

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
        return $this->message['title'];
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
        $this->message['title'] = $title;

        return $this;
    }

    /**
     * Return a response text ( message ).
     *
     * <code>
     * $response = new Prism\Response\Json();
     * $content = $response->getText();
     * </code>
     *
     * @return string
     *
     * @deprecated v1.19.5
     */
    public function getText()
    {
        return $this->getContent();
    }

    /**
     * Set a response text to the object.
     *
     * <code>
     * $content = "My text....";
     *
     * $response = new Prism\Response\Json();
     * $response->setText($content);
     * </code>
     *
     * @param string $content
     *
     * @return self
     *
     * @deprecated v1.19.5 Use setContent
     */
    public function setText($content)
    {
        $this->setContent($content);

        return $this;
    }

    /**
     * Return a response content ( message ).
     *
     * <code>
     * $response = new Prism\Response\Json();
     * $content = $response->getContent();
     * </code>
     *
     * @return string
     */
    public function getContent()
    {
        return $this->message['content'];
    }

    /**
     * Set a response content to the object.
     *
     * <code>
     * $content = "My text....";
     *
     * $response = new Prism\Response\Json();
     * $response->setText($content);
     * </code>
     *
     * @param string $content
     *
     * @return self
     */
    public function setContent($content)
    {
        $this->message['content'] = $content;

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
            'success' => $this->success
        );

        if ($this->message['content']) {
            $response['message'] = $this->message;

            // Remove this when I am ready to remove deprecated code.
            $response['text']    = $this->message['content'];
            if ($this->message['title']) {
                $response['title'] = $this->message['title'];
            } else {
                unset($this->message['title']);
            }
        }

        if ($this->data !== null) {
            $response['data'] = $this->data;
        }

        if ($this->redirectUrl !== null) {
            $response['redirect_url'] = $this->redirectUrl;
        }

        return (string)json_encode($response);
    }
}
