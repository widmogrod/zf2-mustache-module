<?php
namespace Mustache;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface, ServiceProviderInterface
{
    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include_once __DIR__ . '/config/module.config.php';
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Mustache\View\Strategy' =>  function($sm) {
                    $config = $sm->get('Configuration');
                    $config = $config['mustache'];

                    /** @var $renderer \Mustache\View\Renderer */
                    $renderer = $sm->get('Mustache\View\Renderer');
                    $strategy = new View\Strategy($renderer);
                    return $strategy;
                },
                'Mustache\View\Renderer' =>  function($sm) {
                    $config = $sm->get('Configuration');
                    $config = $config['mustache'];

                    /** @var $pathResolver \Zend\View\Resolver\TemplatePathStack */
                    $pathResolver = clone $sm->get('ViewTemplatePathStack');
                    $pathResolver->setDefaultSuffix($config['suffix']);

                    /** @var $resolver \Zend\View\Resolver\AggregateResolver */
                    $resolver = $sm->get('ViewResolver');
                    $resolver->attach($pathResolver, 2);

                    $engine = new \Mustache_Engine($config);

                    $renderer = new View\Renderer();
                    $renderer->setEngine($engine);
                    $renderer->setSuffix(isset($config['suffix']) ? $config['suffix'] : 'mustache');
                    $renderer->setSuffixLocked((bool)$config['suffixLocked']);
                    $renderer->setResolver($resolver);

                    return $renderer;
                },
            ),
        );
    }

}