<?php
/**
 * @package      Crowdfunding
 * @subpackage   Helpers
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Command;

use Joomla\CMS\User\User;
use Prism\Library\Prism\Contract\Pipeline\Pipe;

/**
 * Prepare the access state of items.
 *
 * @package Prism\Library\Fundocs\Command
 */
class PrepareItemsAccess implements Pipe
{
    /**
     * @var User
     */
    protected User $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Prepare the access levels of the items.
     *
     * @param $content
     * @param \Closure $next
     */
    public function handle($content, \Closure $next)
    {
        if (is_array($content) && count($content) > 0) {
            $userId = (int)$this->user->get('id');
            $guest  = $this->user->get('guest');
            $groups = $this->user->getAuthorisedViewLevels();

            foreach ($content as $key => $item) {
                // Compute the asset access permissions.
                // Technically guest could edit an article, but lets not check that to improve performance a little.
                if (!$guest) {
                    $asset = 'com_fundocs.item.' . $item->id;

                    // Check general edit permission first.
                    if ($this->user->authorise('core.edit', $asset)) {
                        $item->params->set('access-edit', true);

                    // Now check if edit.own is available.
                    } elseif ($userId > 0 && $this->user->authorise('core.edit.own', $asset)) {
                        // Check for a valid user and that they are the owner.
                        if ($userId === (int)$item->user_id) {
                            $item->params->set('access-edit', true);
                        }
                    }
                }

                // If no access filter is set, the layout takes some responsibility for display of limited information.
                if (!$item->catid || !$item->category_access) {
                    $item->params->set('access-view', in_array((int)$item->access, $groups, true));
                } else {
                    $item->params->set(
                        'access-view',
                        in_array((int)$item->access, $groups, true) && in_array((int)$item->category_access, $groups, true)
                    );
                }
            }
        }
    }
}
