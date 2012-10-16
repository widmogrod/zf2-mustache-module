<?php
namespace Mustache\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Mustache\View\Strategy;

class StrategyFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $renderer \Mustache\View\Renderer */
        $renderer = $serviceLocator->get('Mustache\View\Renderer');
        $strategy = new Strategy($renderer);
        return $strategy;
    }
}