<?php
/**
 * main.php
 *
 * Bootstraps the application. You should edit this file.
 *
 * @package   Atan\Framework
 * @author    atanvarno69 <https://github.com/atanvarno69>
 * @copyright 2017 atanvarno.com
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

/** Package use block. */
use Atan\{
    Dependency\Container,
    Framework\Core
};

/** Include the autoloader. */
require dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'vendor'
    . DIRECTORY_SEPARATOR
    . 'autoload.php';

/** Set PHP's built-in error reporting. */
Core::error(true);

/** @var string[] $dir Array of directory paths. */
$dir = include Core::path(dirname(__DIR__), 'config', 'directories.php');

/** @var Interop\Container\ContainerInterface $container DI container. */
$container = new Container(
    include Core::path($dir['config'], 'dependencies.php')
);

/** @var Psr\Http\Message\ServerRequestInterface $request HTTP request. */
$request = ($container->get('ServerRequestFactory'))
    ->createServerRequest($_SERVER);

/** @var Atan\Middleware\LazyLoadingRunner $middleware Middleware runner. */
$middleware = $container->get('MiddlewareRunner');

/** @var Atan\Core\Emitter $emitter HTTP response emitter. */
$emitter = $container->get('Emitter');

/** @var Psr\Http\Message\ResponseInterface $response HTTP response from middleware. */
$response = $middleware->dispatch($request);

/** Emit the response */
$emitter->emit($response);
