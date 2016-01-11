<?php namespace Pavlakis\Slim\Behat\ServiceContainer;

class SlimBooter
{

    /**
     * The base path for the application.
     *
     * @var string
     */
    private $basePath;

    /**
     * The application's config file.
     *
     * @var string
     */
    private $configFile;

    /**
     * The application's dependencies file
     *
     * @var string
     */
    private $dependenciesFile;

    /**
     * The application's middleware file
     *
     * @var string
     */
    private $middlewareFile;

    /**
     * The application's routes file
     *
     * @var string
     */
    private $routesFile;

    /**
     * Create a new Slim booter instance.
     *
     * @param        $basePath
     * @param string $configFile
     * @param string $dependencies
     * @param string $middlewareFile
     * @param string $routesFile
     */
    public function __construct($basePath, $configFile = null, $dependencies = null, $middlewareFile = null, $routesFile = null)
    {
        $this->basePath         = $basePath;
        $this->configFile       = $configFile;
        $this->dependenciesFile = $dependencies;
        $this->middlewareFile   = $middlewareFile;
        $this->routesFile       = $routesFile;
    }

    /**
     * Get the application's base path.
     *
     * @return mixed
     */
    public function basePath()
    {
        return $this->basePath;
    }

    /**
     * Get the application's config file.
     *
     * @return string
     */
    public function getConfigFile()
    {
        return $this->configFile;
    }

    /**
     * The application's dependencies file
     *
     * @return string
     */
    public function getDependenciesFile()
    {
        return $this->dependenciesFile;
    }

    /**
     *
     * @return string
     */
    public function getMiddlewareFile()
    {
        return $this->middlewareFile;
    }

    /**
     * @return string
     */
    public function getRoutesFile()
    {
        return $this->routesFile;
    }

    /**
     * Boot the app.
     *
     * @return mixed
     */
    public function boot()
    {
        // Instantiate the app
        $settings = require $this->basePath() . '/' . $this->getConfigFile();
        $app = new \Slim\App($settings);


        // add dependencies
        if ($this->getDependenciesFile() && $this->assertAppFileExists($this->getDependenciesFile())) {

            require $this->basePath() . '/' . $this->getDependenciesFile();
        }

        // Register middleware
        if ($this->getMiddlewareFile() && $this->assertAppFileExists($this->getMiddlewareFile())) {

            require $this->basePath() . '/' . $this->getMiddlewareFile();
        }

        // Register routes
        if ($this->getRoutesFile() && $this->assertAppFileExists($this->getRoutesFile())) {

            require $this->basePath() . '/' . $this->getRoutesFile();
        }

        return $app;
    }

    /**
     * @param $file
     * @return bool
     */
    private function assertAppFileExists($file)
    {
        return file_exists($this->basePath() . '/' . $file);
    }

}