<?php
/**
 * @package      Prism\Library\Prism\Response
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2021 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Response;

/**
 * This class provides functionality to manage JSON response.
 *
 * @package  Prism\Library\Prism\Response
 */
final class JsonResponse
{
    protected bool $success;
    protected array $data = [];
    protected string $redirectUrl = '';
    protected ResponseMessage $message;

    /**
     * Initialize the object.
     * <code>
     * $response = new JsonResponse();
     * </code>
     *
     * @param false $success
     */
    public function __construct(bool $success = false)
    {
        $this->success = $success;
    }

    /**
     * Returns the response message.
     *
     * @return ResponseMessage
     */
    public function getMessage(): ResponseMessage
    {
        return $this->message;
    }

    /**
     * Set response message.
     * <code>
     * $title   = "My title...";
     * $content = "My message...";
     * $type = "info"; // warning, error or info
     * $response = new JsonResponse();
     * $response->setMessage(new Message($content, $title, $type));
     * </code>
     *
     * @param ResponseMessage $message
     * @return JsonResponse
     */
    public function setMessage(ResponseMessage $message): JsonResponse
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set the response as successfully completed.
     *
     * @return JsonResponse
     */
    public function success(): JsonResponse
    {
        $this->success = true;
        return $this;
    }

    /**
     * Set the response as completed unsuccessfully.
     *
     * @return JsonResponse
     */
    public function failure(): JsonResponse
    {
        $this->success = false;
        return $this;
    }

    /**
     * Return an additional data that comes from response.
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
     * $response = new JsonResponse();
     * $response->setData($data);
     * </code>
     *
     * @param array $data
     * @return JsonResponse
     */
    public function setData(array $data): JsonResponse
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Return a URL that should be used from the browser to redirect users to a new page.
     *
     * @return string
     */
    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }

    /**
     * Set a URL that should be used from the browser to redirect users to a new page.
     *
     * <code>
     * $url = "http://itprism.com";
     *
     * $response = new JsonResponse();
     * $response->setRedirectUrl($url);
     * </code>
     *
     * @param string $url
     * @return JsonResponse
     */
    public function setRedirectUrl(string $url): JsonResponse
    {
        $this->redirectUrl = $url;

        return $this;
    }

    /**
     * Return the parameters of the object as a JSON string.
     *
     * <code>
     * $response = new JsonResponse();
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

        if ($this->message->hasContent()) {
            $response['message'] = $this->message->toArray();
        }

        if (count($this->data) > 0) {
            $response['data'] = $this->data;
        }

        if ($this->redirectUrl) {
            $response['redirect_url'] = $this->redirectUrl;
        }

        return json_encode($response, JSON_THROW_ON_ERROR);
    }
}
