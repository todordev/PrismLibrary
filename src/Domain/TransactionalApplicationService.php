<?php
/**
 * @package      Prism
 * @subpackage   Domain
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism\Domain;

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
