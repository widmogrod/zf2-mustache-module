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

    'assetic_configuration' => array(
        'routes' => array(
            'mustache'=> array(
                '@base_css',
                '@base_js',
//                '@require',
//                '@require_text_js',
//                '@mustache',
//                '@app_js',
            ),
        ),

        'modules' => array(
            'mustache' => array(
                'root_path' => __DIR__ . '/../view',
                'collections' => array(

                    'mustache_templates' => array(
                        'assets' => array(
                            'mustache/test/*.mustache',
                        ),
                        'options' => array(
                            'move_raw' => true,
                        )
                    ),
                ),
            ),
        )
    )
);
