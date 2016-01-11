<?php namespace Pavlakis\Slim\Behat\ServiceContainer;

use Behat\Behat\Context\ServiceContainer\ContextExtension;
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
            ->defaultValue('../../app/settings.php')
            ->end()
            ->scalarNode('dependencies_file')
            ->defaultValue(null)
            ->end()
            ->scalarNode('middleware_file')
            ->defaultValue(null)
            ->end()
            ->scalarNode('routes_file')
            ->defaultValue(null);
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
     * @param \Slim\App $app
     */
    private function loadInitializer(ContainerBuilder $container, $app)
    {
        $definition = new Definition('Pavlakis\Slim\Behat\Context\KernelAwareInitializer', [$app]);

        $definition->addTag(ContextExtension::INITIALIZER_TAG, array('priority' => 0));
        $container->setDefinition('slim.context_initializer', $definition);
    }

}