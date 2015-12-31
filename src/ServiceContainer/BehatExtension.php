<?php namespace Pavlakis\Slim\Behat\ServiceContainer;

use Behat\Behat\Context\ServiceContainer\ContextExtension;
use Behat\Testwork\EventDispatcher\ServiceContainer\EventDispatcherExtension;
use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class BehatExtension implements Extension
{

    /**
     * {@inheritdoc}
     */
    public function getConfigKey()
    {
        return 'slim';
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ExtensionManager $extensionManager)
    {
        if (null !== $minkExtension = $extensionManager->getExtension('mink')) {
            $minkExtension->registerDriverFactory(new SlimFactory);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder
            ->children()
            ->scalarNode('config_file')
            ->defaultValue('src/settings.php')
            ->end()
            ->scalarNode('dependencies_file')
            ->defaultValue('src/depencencies.php')
            ->end()
            ->scalarNode('middleware_file')
            ->defaultValue('src/middleware.php')
            ->end()
            ->scalarNode('routes_file')
            ->defaultValue('src/routes.php');
    }

    /**
     * {@inheritdoc}
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $app = $this->loadSlim($container, $config);

        $this->loadInitializer($container, $app);
    }

    /**
     * Boot up Slim.
     *
     * @param ContainerBuilder $container
     * @param array            $config
     * @return mixed
     */
    private function loadSlim(ContainerBuilder $container, array $config)
    {
        $slim = new SlimBooter(
            $container->getParameter('paths.base'), $config['config_file'], $config['dependencies_file'],
            $config['middleware_file'], $config['routes_file']
        );

        $container->set('slim.app', $app = $slim->boot());

        return $app;
    }

    /**
     * Load the initializer.
     *
     * @param ContainerBuilder    $container
     * @param HttpKernelInterface $app
     */
    private function loadInitializer(ContainerBuilder $container, $app)
    {
        $definition = new Definition('Pavlakis\Slim\Behat\Context\KernelAwareInitializer', [$app]);

        $definition->addTag(EventDispatcherExtension::SUBSCRIBER_TAG, ['priority' => 0]);
        $definition->addTag(ContextExtension::INITIALIZER_TAG, ['priority' => 0]);

        $container->setDefinition('laravel.initializer', $definition);
    }

}