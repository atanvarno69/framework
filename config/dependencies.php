<?php
/**
 * dependencies.php
 *
 * Configuration file for the dependency injection container. Users should edit
 * this file as required.
 *
 * @package   Atan\Framework
 * @author    atanvarno69 <https://github.com/atanvarno69>
 * @copyright 2017 atanvarno.com
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

/** Package use block. */
use Atan\Core\Core;

/** @var string $middlewareConfigPath Path to middleware queue config file. */
$middlewareConfigPath = Core::path(__DIR__, 'middleware.php');

/** @var string $routeConfigPath Path to router config file. */
$routeConfigPath = Core::path(__DIR__, 'routes.php');

/** Return array of DI container definitions. */
return [
    'Emitter' =>
        [Atan\Core\Emitter::class],
    'Example' => [
        Atan\Framework\Example\Example::class,
        [':StreamFactory', ':ResponseFactory'],
    ],
    'MiddlewareRunner' => [
        Atan\Middleware\LazyLoadingRunner::class,
        [
            ':StreamFactory',
            ':ResponseFactory',
            ':Container',
            include $middlewareConfigPath,
        ],
    ],
    'Preparer' => [
        Atan\Core\Preparer::class,
        [':StreamFactory', ':ResponseFactory'],
    ],
    'ResponseFactory' =>
        [Http\Factory\Diactoros\ResponseFactory::class],
    'Router' => [
        Atan\Router\RouterMiddleware::class,
        [
            ':StreamFactory',
            ':ResponseFactory',
            ':Container',
            include $routeConfigPath
        ],
    ],
    'ServerRequestFactory' =>
        [Http\Factory\Diactoros\ServerRequestFactory::class],
    'StreamFactory' =>
        [Http\Factory\Diactoros\StreamFactory::class],
];
