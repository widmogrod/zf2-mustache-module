<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Mustache\Controller\Test' => 'Mustache\Controller\TestController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'mustache' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'Mustache\View\Strategy'
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Mustache\View\Strategy' =>  'Mustache\Service\StrategyFactory',
            'Mustache\View\Renderer' =>  'Mustache\Service\RendererFactory',
        ),
    ),

    'mustache' => array(
        'suffix' => 'mustache',
        'suffixLocked' => true,
        'cache' => __DIR__ . '/../../../data/mustache'
    ),

    'router' => array(
        'routes' => array(
            'mustache' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/mustache[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Mustache\Controller\Test',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
);
