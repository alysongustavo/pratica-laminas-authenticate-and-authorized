<?php

namespace Admin;

use Admin\Controller\AuthController;
use Admin\Controller\Factory\PrivilegeControllerFactory;
use Admin\Controller\Factory\ResourceControllerFactory;
use Admin\Controller\Factory\RoleControllerFactory;
use Admin\Controller\Factory\UserControllerFactory;
use Admin\Controller\IndexController;
use Admin\Controller\PrivilegeController;
use Admin\Controller\ResourceController;
use Admin\Controller\RoleController;
use Admin\Controller\UserController;
use Admin\Form\Factory\PrivilegeFormFactory;
use Admin\Form\Factory\RoleFormFactory;
use Admin\Form\Factory\UserFormFactory;
use Admin\Form\PrivilegeForm;
use Admin\Form\ResourceForm;
use Admin\Form\RoleForm;
use Admin\Form\UserForm;
use Admin\Service\AclService;
use Admin\Service\Factory\AclServiceFactory;
use Admin\Service\Factory\PrivilegeServiceFactory;
use Admin\Service\Factory\ResourceServiceFactory;
use Admin\Service\Factory\RoleServiceFactory;
use Admin\Service\Factory\UserServiceFactory;
use Admin\Service\PrivilegeService;
use Admin\Service\ResourceService;
use Admin\Service\RoleService;
use Admin\Service\UserService;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'admin' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/admin',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action' => 'dashboard'
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'auth' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/auth/login',
                            'defaults' => [
                                'controller' => AuthController::class,
                                'action' => 'login'
                            ]
                        ]
                    ],
                    'user' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/user[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9_-]*'
                            ],
                            'defaults' => [
                                'controller' => UserController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'role' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/role[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9_-]*'
                            ],
                            'defaults' => [
                                'controller' => RoleController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'resource' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/resource[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9_-]*'
                            ],
                            'defaults' => [
                                'controller' => ResourceController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'privilege' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/privilege[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9_-]*'
                            ],
                            'defaults' => [
                                'controller' => PrivilegeController::class,
                                'action' => 'index'
                            ]
                        ]
                    ]
                ]

            ]
        ]
    ],
    'controllers' => [
        'factories' => [
            AuthController::class => InvokableFactory::class,
            IndexController::class => InvokableFactory::class,
            UserController::class => UserControllerFactory::class,
            RoleController::class => RoleControllerFactory::class,
            ResourceController::class => ResourceControllerFactory::class,
            PrivilegeController::class => PrivilegeControllerFactory::class
        ]
    ],
    'service_manager' => [
        'factories' => [
            UserService::class => UserServiceFactory::class,
            RoleService::class => RoleServiceFactory::class,
            ResourceService::class => ResourceServiceFactory::class,
            PrivilegeService::class => PrivilegeServiceFactory::class,
            AclService::class => AclServiceFactory::class,

            // Servicos dos formularios
            RoleForm::class => RoleFormFactory::class,
            UserForm::class => UserFormFactory::class,
            PrivilegeForm::class => PrivilegeFormFactory::class,
        ]
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/admin'           => __DIR__ . '/../view/layout/admin.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity'],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
    ],
];