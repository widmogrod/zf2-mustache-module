<?php
namespace Mustache\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Mustache\View\Renderer;

class RendererFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');
        $config = $config['mustache'];

        /** @var $pathResolver \Zend\View\Resolver\TemplatePathStack */
        $pathResolver = clone $serviceLocator->get('ViewTemplatePathStack');
        $pathResolver->setDefaultSuffix($config['suffix']);

        /** @var $resolver \Zend\View\Resolver\AggregateResolver */
        $resolver = $serviceLocator->get('ViewResolver');
        $resolver->attach($pathResolver, 2);

        $engine = new \Mustache_Engine($config);

        $renderer = new Renderer();
        $renderer->setEngine($engine);
        $renderer->setSuffix(isset($config['suffix']) ? $config['suffix'] : 'mustache');
        $renderer->setSuffixLocked((bool)$config['suffixLocked']);
        $renderer->setResolver($resolver);

        return $renderer;
    }
}