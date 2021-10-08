<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Certificate;

use Certificate\Controller\ControllerFactory;

return [
    'controllers' => [
        'factories' => [
            Controller\CertificateController::class => ControllerFactory::class,
            Controller\DocumentController::class => ControllerFactory::class,
            Controller\DocumentTypeController::class => ControllerFactory::class,
            Controller\PriceHistoryController::class => ControllerFactory::class,
            Controller\IndexController::class => ControllerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [

            'home' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/[:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'certificate' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/certificate[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\CertificateController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'document' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/document[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\DocumentController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'pricehistory' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/pricehistory[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\PriceHistoryController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'documenttype' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/documenttype[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\DocumentTypeController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'Certificate/index/index' => __DIR__ . '/../view/Certificate/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
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
