<?php
/**
 * @package      Prism
 * @subpackage   Responses
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Response;

/**
 * This class provides functionality to manage JSON response.
 *
 * @package      Prism
 * @subpackage   Responses
 */
final class Json
{
    protected bool $success = false;
    protected array $message = [];
    protected array $data = [];
    protected string $redirectUrl = '';

    /**
     * Initialize the object.
     *
     * <code>
     * $title   = "My title...";
     * $content = "My message...";
     *
     * $response = new Prism\Library\Prism\Response\Json($title, $content);
     * </code>
     *
     * @param string $content
     * @param string $title
     */
    public function __construct(string $content, string $title = '')
    {
        $this->message = array(
            'content'   => $content,
            'title'     => $title,
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
     * $response = new Prism\Library\Prism\Response\Json($title, $content);
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
     * $response = new Prism\Library\Prism\Response\Json($title, $content);
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
     * $response = new Prism\Library\Prism\Response\Json($title, $content);
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
     * $response = new Prism\Library\Prism\Response\Json($title, $content);
     * $response->info();
     * </code>
     *
     * @return self
     */
    public function info()
    {
        $this->success = true;
        $this->message['type'] = 'info';

        return $this;
    }

    /**
     * Return a response title.
     *
     * <code>
     * $response = new Prism\Library\Prism\Response\Json();
     * $title = $response->getTitle();
     * </code>
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->message['title'];
    }

    /**
     * Set a response title to the object.
     * <code>
     * $title = "My title....";
     * $response = new Prism\Library\Prism\Response\Json();
     * $response->setTitle($title);
     * </code>
     *
     * @param string $title
     * @return self
     */
    public function setTitle(string $title)
    {
        $this->message['title'] = $title;

        return $this;
    }

    /**
     * Return a response content ( message ).
     *
     * <code>
     * $response = new Prism\Library\Prism\Response\Json();
     * $content = $response->getContent();
     * </code>
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->message['content'];
    }

    /**
     * Set a response content to the object.
     * <code>
     * $content = "My text....";
     * $response = new Prism\Library\Prism\Response\Json();
     * $response->setText($content);
     * </code>
     *
     * @param string $content
     * @return self
     */
    public function setContent(string $content)
    {
        $this->message['content'] = $content;

        return $this;
    }

    /**
     * Return an additional data that comes from response.
     *
     * <code>
     * $response = new Prism\Library\Prism\Response\Json();
     * $data = $response->getData();
     * </code>
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Set an additional data that comes from the server.
     * <code>
     * $data = array(
     *     "name" => "John Dow",
     *     "website" => "http://itprism.com"
     * );
     * $response = new Prism\Library\Prism\Response\Json();
     * $response->setData($url);
     * </code>
     *
     * @param array $data
     * @return self
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Return a URL that should be used from the browser to redirect users to a new page.
     *
     * <code>
     * $response = new Prism\Library\Prism\Response\Json();
     * $redirectUrl = $response->getRedirectUrl();
     * </code>
     *
     * @return string
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
     * $response = new Prism\Library\Prism\Response\Json();
     * $response->setRedirectUrl($url);
     * </code>
     *
     * @param string $url
     * @return self
     */
    public function setRedirectUrl(string $url)
    {
        $this->redirectUrl = $url;

        return $this;
    }

    /**
     * Return the parameters of the object as a JSON string.
     *
     * <code>
     * $response = new Prism\Library\Prism\Response\Json();
     * $jsonResponse = (string)$response;
     * </code>
     *
     * @return string
     * @throws \JsonException
     */
    public function __toString(): string
    {
        $response = [
            'success' => $this->success
        ];

        if ($this->message['content']) {
            $response['message'] = $this->message;
        }

        if (count($this->data) > 0) {
            $response['data'] = $this->data;
        }

        if ($this->redirectUrl) {
            $response['redirect_url'] = $this->redirectUrl;
        }

        return (string)json_encode($response, JSON_THROW_ON_ERROR);
    }
}
