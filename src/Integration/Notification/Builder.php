<?php
/**
 * @package      Prism
 * @subpackage   Integrations\Profiles
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@prism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Integration\Notification;

use Joomla\Registry\Registry;

/**
 * This class contains methods which creates social profile object,
 * based on social extension name.
 *
 * @package      Prism
 * @subpackage   Integrations\Notifications
 */
abstract class Builder
{
    /**
     * Build Notification object.
     *
     * <code>
     * $config = new Registry([
     *    "env" => 'joomla', // It could be joomla, laravel, symfony
     *    "platform" => "socialcommunity",
     * ]);
     *
     * $data = new Registry([
     *      'content' => '....',
     *      'created_at' => '2012-12-12',
     *      'status' => 'new',
     *      'image' => '...',
     *      'url' => '...',
     *      'target_id' => 2
     * ]);
     *
     * $notification = Prism\Library\Integration\Notification\Builder::build($config, $data);
     * </code>
     *
     * @param  Registry  $config Options used in the process of building an object.
     * @param  Registry  $data
     *
     * @return Notification|null
     */
    public static function build(Registry $config, Registry $data)
    {
        $notification = null;
        $class = 'Prism\Library\\Integration\\Notification\\Builder\\'.ucfirst($config->get('env'));
        if ($config->get('env') and class_exists($class)) {
            $builder = new $class($config, $data);
            $notification = $builder->build();
        }

        return $notification;
    }
}
