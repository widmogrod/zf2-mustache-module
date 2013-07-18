<?php
return array(

    'view_manager' => array(
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
        'cache' => __DIR__ . '/../../../../data/mustache'
    ),
);
