<?php
/**
 * @package      Prism
 * @subpackage   Controllers
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Controller;

use Joomla\CMS\Router\Route;

trait MessagePrepareMethods
{
    /**
     * Display a notice and redirect to a page.
     *
     * <code>
     * $options = array(
     *     "view"    => $view,
     *     "layout"  => $layout,
     *     "id"      => $itemId,
     *     "url_var" => $urlVar
     * );
     * </code>
     *
     * @param mixed  $messages Could be array or string.
     * @param array $options
     *
     * @throws \InvalidArgumentException
     */
    protected function displayNotice($messages, $options)
    {
        $message = $this->prepareMessage($messages);
        $this->setMessage($message, 'notice');

        $link = $this->prepareRedirectLink($options);
        $this->setRedirect(Route::_($link, false));
    }

    /**
     * Display a warning and redirect to a page.
     *
     * <code>
     * $options = array(
     *     "view"    => $view,
     *     "layout"  => $layout,
     *     "id"      => $itemId,
     *     "url_var" => $urlVar
     * );
     * </code>
     *
     * @param mixed  $messages Could be array or string.
     * @param array $options
     *
     * @throws \InvalidArgumentException
     */
    protected function displayWarning($messages, $options)
    {
        $message = $this->prepareMessage($messages);
        $this->setMessage($message, 'warning');

        $link = $this->prepareRedirectLink($options);
        $this->setRedirect(Route::_($link, false));
    }

    /**
     * Display a error and redirect to a page.
     *
     * <code>
     * $options = array(
     *     "view"    => $view,
     *     "layout"  => $layout,
     *     "id"      => $itemId,
     *     "url_var" => $urlVar
     * );
     * </code>
     *
     * @param mixed  $messages Could be array or string.
     * @param array $options
     *
     * @throws \InvalidArgumentException
     */
    protected function displayError($messages, $options)
    {
        $message = $this->prepareMessage($messages);
        $this->setMessage($message, 'error');

        $link = $this->prepareRedirectLink($options);
        $this->setRedirect(Route::_($link, false));
    }

    /**
     * Display a message and redirect to a page.
     * <code>
     * $options = array(
     *     "view"    => $view,
     *     "layout"  => $layout,
     *     "id"      => $itemId,
     *     "url_var" => $urlVar
     * );
     * </code>
     *
     * @param mixed  $messages Could be array or string.
     * @param array $options
     *
     * @throws \InvalidArgumentException
     */
    protected function displayMessage(mixed $messages, $options)
    {
        $message = $this->prepareMessage($messages);
        $this->setMessage($message);

        $link = $this->prepareRedirectLink($options);
        $this->setRedirect(Route::_($link, false));
    }

    /**
     * This method parse the message.
     * The message can be array, object ( Exception,... ), string,...
     *
     * @param mixed $message
     *
     * @return string
     */
    protected function prepareMessage(mixed $message): string
    {
        if (is_array($message)) {
            $result = '';

            foreach ($message as $value) {
                if (is_object($value)) {
                    if ($value instanceof \Exception) {
                        $result .= $value->getMessage() . "\n";
                    }
                } else {
                    $result .= $value . "\n";
                }
            }

        } elseif (is_object($message)) {
            if ($message instanceof \Exception) {
                $result = (string)$message->getMessage();
            } else {
                $result = $message . "\n";
            }

        } else {
            $result = (string)$message;
        }

        return $result;
    }

}
