<?php namespace Pavlakis\Slim\Behat\Context;

use Symfony\Component\HttpKernel\HttpKernelInterface;

trait App
{
    /**
     * The Slim application.
     *
     * @var HttpKernelInterface
     */
    protected $app;
    /**
     * Set the application.
     *
     * @param HttpKernelInterface $app
     */
    public function setApp(HttpKernelInterface $app)
    {
        $this->app = $app;
    }
    /**
     * Get the application.
     *
     * @return mixed
     */
    public function app()
    {
        return $this->app;
    }
}