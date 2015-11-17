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
        
        $engine = new \Mustache_Engine( $this->setConfigs($config) );

        $renderer = new Renderer();
        $renderer->setEngine($engine);
        $renderer->setSuffix(isset($config['suffix']) ? $config['suffix'] : 'mustache');
        $renderer->setSuffixLocked((bool)$config['suffixLocked']);
        $renderer->setResolver($resolver);

        return $renderer;
    }
    
    /**
     * 
     * @param array $config
     * @return \Mustache_Loader_FilesystemLoader
     */
    private function setConfigs(array $config) 
    {
        if(isset($config["partials_loader"]) && !is_object($config["partials_loader"])) {
            $path = $config["partials_loader"];
            $options = array();
            if(is_array($config["partials_loader"])) {
                $path = $config["partials_loader"][0];
                unset($config["partials_loader"][0]);
                if(is_array($config["partials_loader"]) && count($config["partials_loader"]) > 0){
                    $options = $config["partials_loader"];
                }
            }
            $config["partials_loader"] = new \Mustache_Loader_FilesystemLoader($path, $options);
        }
        
        if(isset($config["loader"]) && !is_object($config["loader"])) {
            $options = array();
            $path = $config["loader"][0];
            unset($config["loader"][0]);
            if(is_array($config["loader"]) && count($config["loader"]) > 0){
                $options = $config["loader"];
            }
            $config["loader"] = new \Mustache_Loader_FilesystemLoader($path, $options);
        }
        return $config;
    }
}