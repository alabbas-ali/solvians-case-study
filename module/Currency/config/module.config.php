<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Currency;

use Currency\Controller\ControllerFactory;

return [
    'controllers' => [
        'factories' => [
            Controller\CurrencyController::class => ControllerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'currency' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/currency[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\CurrencyController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    
    'view_manager' => [
        'template_path_stack' => [
            __NAMESPACE__ => __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
    
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Model')
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Model' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
];