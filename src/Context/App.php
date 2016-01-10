<?php namespace Pavlakis\Slim\Behat\Context;

trait App
{
    /**
     * The Slim application.
     *
     * @var \Slim\App
     */
    protected $app;

    /**
     * Set the application.
     *
     * @param \Slim\App $app
     */
    public function setApp(\Slim\App $app)
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