<?php
/**
 * @package      Prism
 * @subpackage   Controllers
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Controller;

use Joomla\Utilities\ArrayHelper;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains common methods and properties
 * used in work with forms.
 *
 * @package      Prism
 * @subpackage   Controllers
 */
class Form extends \JControllerForm
{
    /**
     * A default link to the extension
     * @var string
     */
    protected $defaultLink = '';

    public function __construct($config)
    {
        parent::__construct($config);
        $this->defaultLink = 'index.php?option=' . \JString::strtolower($this->option);
    }

    /**
     * Display a notice and redirect to a page.
     *
     * @param mixed  $messages Could be array or string.
     * @param string $options
     *
     * $options = array(
     *     "view"    => $view,
     *     "layout"  => $layout,
     *     "id"      => $itemId,
     *     "url_var" => $urlVar
     * );
     */
    protected function displayNotice($messages, $options)
    {
        $message = $this->prepareMessage($messages);
        $this->setMessage($message, 'notice');

        $link = $this->prepareRedirectLink($options);
        $this->setRedirect(\JRoute::_($link, false));
    }

    /**
     * Display a warning and redirect to a page.
     *
     * @param mixed  $messages Could be array or string.
     * @param string $options
     *
     * $options = array(
     *     "view"    => $view,
     *     "layout"  => $layout,
     *     "id"      => $itemId,
     *     "url_var" => $urlVar
     * );
     */
    protected function displayWarning($messages, $options)
    {
        $message = $this->prepareMessage($messages);
        $this->setMessage($message, 'warning');

        $link = $this->prepareRedirectLink($options);
        $this->setRedirect(\JRoute::_($link, false));
    }

    /**
     * Display a error and redirect to a page.
     *
     * @param mixed  $messages Could be array or string.
     * @param string $options
     *
     * $options = array(
     *     "view"    => $view,
     *     "layout"  => $layout,
     *     "id"      => $itemId,
     *     "url_var" => $urlVar
     * );
     */
    protected function displayError($messages, $options)
    {
        $message = $this->prepareMessage($messages);
        $this->setMessage($message, 'error');

        $link = $this->prepareRedirectLink($options);
        $this->setRedirect(\JRoute::_($link, false));
    }

    /**
     * Display a message and redirect to a page.
     *
     * @param mixed  $messages Could be array or string.
     * @param string $options
     *
     * $options = array(
     *     "view"    => $view,
     *     "layout"  => $layout,
     *     "id"      => $itemId,
     *     "url_var" => $urlVar
     * );
     */
    protected function displayMessage($messages, $options)
    {
        $message = $this->prepareMessage($messages);
        $this->setMessage($message, 'message');

        $link = $this->prepareRedirectLink($options);
        $this->setRedirect(\JRoute::_($link, false));
    }

    /**
     * This method parse the message.
     * The message can be array, object ( Exception,... ), string,...
     *
     * @param mixed $message
     *
     * @return string
     */
    protected function prepareMessage($message)
    {
        if (is_array($message)) {

            $result = '';

            foreach ($message as $value) {
                if (is_object($value)) {
                    if ($value instanceof \Exception) {
                        $result .= (string)$value->getMessage() . "\n";
                    }
                } else {
                    $result .= (string)$value . "\n";
                }
            }

        } elseif (is_object($message)) {

            if ($message instanceof \Exception) {
                $result = (string)$message->getMessage();
            } else {
                $result = (string)$message . "\n";
            }

        } else {
            $result = (string)$message;
        }

        return $result;
    }

    /**
     * This method prepare a link where the user will be redirected, when his action be done.
     *
     * @param array $options URL parameters used for generating redirect link.
     *
     * @return string
     */
    protected function prepareRedirectLink($options)
    {
        // Return predefined link
        $forceDirection = ArrayHelper::getValue($options, 'force_direction');
        if (null !== $forceDirection) {
            return $forceDirection;
        }
        $link = $this->defaultLink;

        $view   = ArrayHelper::getValue($options, 'view');
        $layout = ArrayHelper::getValue($options, 'layout');
        $itemId = ArrayHelper::getValue($options, 'id', 0, 'uint');
        $urlVar = ArrayHelper::getValue($options, 'url_var', 'id');

        // Remove standard parameters
        unset($options['view'], $options['layout'], $options['url_var'], $options['id']);

        // Redirect to different of common views
        if (null !== $view) {
            $link .= '&view=' . $view;
        }
        if (null !== $layout) {
            $link .= '&layout=' . $layout;
        }

        if ($itemId > 0) {
            $link .= $this->getRedirectToItemAppend($itemId, $urlVar);
        } else {
            $link .= $this->getRedirectToListAppend();
        }

        // Generate additional parameters
        $extraParams = $this->prepareExtraParameters($options);

        return $link . $extraParams;
    }

    /**
     * Generate URI string from additional parameters.
     *
     * @param array $options
     *
     * @return string
     */
    protected function prepareExtraParameters(array $options)
    {
        $uriString = '';

        foreach ($options as $key => $value) {
            $uriString .= '&' . $key . '=' . $value;
        }

        return $uriString;
    }

    /**
     * This method does cancel action.
     *
     * @param string $key
     *
     * @return void
     */
    public function cancel($key = null)
    {
        $this->setRedirect(\JRoute::_($this->defaultLink . '&view=' . $this->view_list . $this->getRedirectToListAppend(), false));
    }
}
