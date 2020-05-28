<?php
/**
 * @package      Prism
 * @subpackage   Controllers
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Controller;

use Joomla\CMS\MVC\Controller\AdminController as JoomlaAdminController;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\String\StringHelper;
use Joomla\Utilities\ArrayHelper;

/**
 * This class contains common methods and properties
 * used in work with admin actions.
 *
 * @package      Prism
 * @subpackage   Controllers
 */
class AdminController extends JoomlaAdminController
{
    /**
     * A default link to the extension
     * @var string
     */
    protected $defaultLink = '';

    /**
     * Admin constructor.
     *
     * @param                          $config
     * @param MVCFactoryInterface|null $factory
     * @param null                     $app
     * @param null                     $input
     *
     * @throws \Exception
     */
    public function __construct($config, MVCFactoryInterface $factory = null, $app = null, $input = null)
    {
        parent::__construct($config, $factory, $app, $input);

        $this->defaultLink = 'index.php?option=' . strtolower($this->option);
    }

    /**
     * Display a notice and redirect to a page
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
     * @param mixed $messages Could be array or string.
     * @param array $options
     *
     * @throws \InvalidArgumentException
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
     * <code>
     * $options = array(
     *      "view"    => $view,
     *      "layout"  => $layout,
     *      "id"      => $itemId,
     *      "url_var" => $urlVar
     *  );
     * </code>
     *
     * @param mixed $messages Could be array or string.
     * @param array $options
     *
     * @throws \InvalidArgumentException
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
     * <code>
     * $options =  array(
     *      "view"    => $view,
     *      "layout"  => $layout,
     *      "id"      => $itemId,
     *       "url_var" => $urlVar
     * );
     * </code>
     *
     * @param mixed $messages Could be array or string.
     * @param array $options
     *
     * @throws \InvalidArgumentException
     */
    protected function displayError($messages, $options)
    {
        $message = $this->prepareMessage($messages);
        $this->setMessage($message, 'error');

        $link = $this->prepareRedirectLink($options);
        $this->setRedirect(\JRoute::_($link, false));
    }

    /**
     * Display a message and redirect to a page
     *
     * <code>
     * $options = array(
     *      "view"    => $view,
     *      "layout"  => $layout,
     *      "id"      => $itemId,
     *      "url_var" => $urlVar,
     * );
     * </code>
     *
     * @param mixed $messages Could be array or string
     * @param array $options
     *
     * @throws \InvalidArgumentException
     */
    protected function displayMessage($messages, $options)
    {
        $message = $this->prepareMessage($messages);
        $this->setMessage($message);

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
    protected function prepareMessage($message): string
    {
        $result = '';

        if (is_array($message)) {
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

    /**
     * This method prepare a link where the user will be redirected
     * after action he has done.
     *
     * @param array $options URL parameters used for generating redirect link.
     *
     * @throws \InvalidArgumentException
     * @return string
     */
    protected function prepareRedirectLink($options): string
    {
        // Return predefined link
        $forceDirection = ArrayHelper::getValue($options, 'force_direction');
        if (null !== $forceDirection) {
            return $forceDirection;
        }

        $link = $this->defaultLink;

        $view   = ArrayHelper::getValue($options, 'view');
        $layout = ArrayHelper::getValue($options, 'layout');

        // Remove standard parameters
        unset($options['view'], $options['layout']);

        // Set the view value
        if (StringHelper::strlen($view) > 0) {
            $link .= '&view=' . $view;
        }
        if (StringHelper::strlen($layout) > 0) {
            $link .= '&layout=' . $layout;
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
    protected function prepareExtraParameters(array $options): string
    {
        $uriString = '';

        foreach ($options as $key => $value) {
            $uriString .= '&' . $key . '=' . $value;
        }

        return $uriString;
    }

    /**
     * @return string
     */
    public function backToDashboard(): string
    {
        $this->setRedirect(\JRoute::_($this->defaultLink, false));
    }
}