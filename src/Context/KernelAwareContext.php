<?php namespace Pavlakis\Slim\Behat\Context;

use Behat\Behat\Context\Context;
use Symfony\Component\HttpKernel\HttpKernelInterface;

interface KernelAwareContext extends Context
{

    /**
     * Set the kernel instance on the context.
     *
     * @param \Slim\App $kernel
     * @return mixed
     */
    public function setApp(\Slim\App $kernel);

}