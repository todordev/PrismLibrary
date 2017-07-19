<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Domain;

class TransactionalApplicationService implements ApplicationService
{
    private $session;
    private $service;

    public function __construct(ApplicationService $service, TransactionalSession $session)
    {
        $this->session = $session;
        $this->service = $service;
    }

    public function execute(array $request = array())
    {
        $operation = function () use ($request) {
            return $this->service->execute($request);
        };

        return $this->session->executeAtomically($operation->bindTo($this));
    }
}
