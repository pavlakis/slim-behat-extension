<?php namespace Pavlakis\Slim\Behat\Driver;

use Behat\Mink\Driver\BrowserKitDriver;
use Symfony\Component\HttpKernel\Client;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class KernelDriver extends BrowserKitDriver
{

    /**
     * Create a new KernelDriver.
     *
     * @param \Slim\App     $app
     * @param string|null   $baseUrl
     */
    public function __construct(\Slim\App $app, $baseUrl = null)
    {
        parent::__construct(new Client($app), $baseUrl);
    }

    /**
     * Refresh the driver.
     *
     * @param \Slim\App $app
     * @return KernelDriver
     */
    public function reboot($app)
    {
        return $this->__construct($app);
    }

}