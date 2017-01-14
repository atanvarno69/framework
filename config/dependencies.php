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
use Atan\Framework\Core;

/** @var string $middlewareConfigPath Path to middleware queue config file. */
$middlewareConfigPath = Core::path(__DIR__, 'middleware.php');

/** @var string $routeConfigPath Path to router config file. */
$routeConfigPath = Core::path(__DIR__, 'routes.php');

/** Return array of DI container definitions. */
return [
    /*
     * Example controller.
     *
     * You should replace this with your own controllers. Be sure to update
     * `routes.php` in this directory too.
     */
    'Example' => [
        Atan\Framework\Example\Example::class,
        [':StreamFactory', ':ResponseFactory'],
    ],

    /*
     * Interoperable components.
     *
     * These may be swapped out for any component that implements the
     * interface listed. Be sure to update `composer.json` if you do.
     */
    // Interop/Http/Factory/ResponseFactoryInterface PSR-17 response factory.
    'ResponseFactory' => [
        Http\Factory\Diactoros\ResponseFactory::class,
    ],

    // Interop/Http/Factory/ServerRequestFactoryInterface PSR-17 server
    // request factory.
    'ServerRequestFactory' => [
        Http\Factory\Diactoros\ServerRequestFactory::class,
    ],

    // Interop/Http/Factory/StreamFactoryInterface PSR-17 stream factory.
    'StreamFactory' => [
        Http\Factory\Diactoros\StreamFactory::class,
    ],

    // A PSR-15 server middleware dispatcher. If you swap this out, ensure
    // the configuration for the new dispatcher is correct and the method
    // call in `main.php` to generate a response works.
    'MiddlewareRunner' => [
        Atan\Middleware\LazyLoadingRunner::class,
        [
            ':StreamFactory',
            ':ResponseFactory',
            ':Container',
            include $middlewareConfigPath,
        ],
    ],

    /*
     * Tightly coupled components.
     *
     * These can be swapped out, but will require a bit more work.
     */
    // A means to emit a PSR-7 response.
    'Emitter' =>
        [Atan\Core\Emitter::class],

    // PSR-15 middleware to prepare a response.
    'Preparer' => [
        Atan\Core\Preparer::class,
        [':StreamFactory', ':ResponseFactory'],
    ],

    // PSR-15 middleware router.
    'Router' => [
        Atan\Router\RouterMiddleware::class,
        [
            ':StreamFactory',
            ':ResponseFactory',
            ':Container',
            include $routeConfigPath
        ],
    ],
];
