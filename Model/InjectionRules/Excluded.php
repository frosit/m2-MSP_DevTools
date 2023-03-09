<?php
/*
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\DevTools\Model\InjectionRules;

use Magento\Framework\App\RequestInterface;
use MSP\DevTools\Api\RuleInterface;
use MSP\DevTools\Model\Config;
use Magento\Framework\App\Request\Http;

class Excluded implements RuleInterface
{
    private RequestInterface $request;

    private Config $config;

    private Http $http;

    public function __construct(
        RequestInterface $request,
        Config $config,
        Http $http

    ) {
        $this->config = $config;
        $this->request = $request;
        $this->http = $http;
    }
    public function execute(): bool
    {
        return !$this->matchesPath();
    }

    /**
     * @return bool
     */
    public function matchesPath()
    {
        foreach ($this->config->getExcluded() as $pattern) {
           if(strpos($this->http->getPathInfo(),$pattern) !== false){
               return true;
           }
        }

        return false;
    }
}
