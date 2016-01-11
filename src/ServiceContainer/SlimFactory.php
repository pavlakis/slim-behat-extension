<?php namespace Pavlakis\Slim\Behat\ServiceContainer;

use Behat\MinkExtension\ServiceContainer\Driver\DriverFactory;
use RuntimeException;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class SlimFactory implements DriverFactory
{

    /**
     * {@inheritdoc}
     */
    public function getDriverName()
    {
        return 'slim';
    }

    /**
     * {@inheritdoc}
     */
    public function supportsJavascript()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function buildDriver(array $config)
    {
        $this->assertBrowserkitIsAvailable();

        return new Definition('Pavlakis\Slim\Behat\Driver\KernelDriver', [
            new Reference('slim.app'),
            '%mink.base_url%'
        ]);
    }

    /**
     * Ensure that BrowserKit is available.
     *
     * @throws RuntimeException
     */
    private function assertBrowserkitIsAvailable()
    {
        if ( ! class_exists('Behat\Mink\Driver\BrowserKitDriver')) {
            throw new RuntimeException(
                'Install MinkBrowserKitDriver in order to use the Slim 3 driver.'
            );
        }
    }

}