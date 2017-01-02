<?php
/**
 * main.php
 *
 * Bootstraps the application. Users should edit this file.
 *
 * @package   Atan\Framework
 * @author    atanvarno69 <https://github.com/atanvarno69>
 * @copyright 2017 atanvarno.com
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

/** Package use block. */
use Atan\{
    Core\Core,
    Dependency\Container
};

/** Include the autoloader. */
require dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'vendor'
    . DIRECTORY_SEPARATOR
    . 'autoload.php';

/** @var string $configDir Configuration directory path. */
$configDir = Core::path(dirname(__DIR__), 'app', 'config');

/** @var Interop\Container\ContainerInterface $container DI container. */
$container = new Container(include Core::path($configDir, 'dependencies.php'));

/** @var Psr\Http\Message\ServerRequestInterface $request HTTP request. */
$request = ($container->get('ServerRequestFactory'))
    ->createServerRequestFromGlobals();

/** @var Interop\Http\Middleware\DelegateInterface $middleware Middleware runner. */
$middleware = $container->get('MiddlewareRunner');

/** @var Atan\Http\Emitter $emitter HTTP response emitter. */
$emitter = $container->get('Emitter');

/** @var Psr\Http\Message\ResponseInterface $response HTTP response from middleware. */
$response = $middleware->process($request);

/** Emit the response */
$emitter($response);