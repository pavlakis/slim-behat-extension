<?php

namespace Pavlakis\Slim\Behat\Context;

/**
 * Trait App
 * @package Pavlakis\Slim\Behat\Context
 */
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
     * @return void
     */
    public function setApp(\Slim\App $app): void
    {
        $this->app = $app;
    }

    /**
     * Get the application.
     *
     * @return \Slim\App
     */
    public function app(): \Slim\App
    {
        return $this->app;
    }
}