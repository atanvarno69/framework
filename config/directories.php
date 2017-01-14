<?php
/**
 * directories.php
 *
 * Configuration file for the directory structure. You should edit this file
 * as required.
 *
 * @package   Atan\Framework
 * @author    atanvarno69 <https://github.com/atanvarno69>
 * @copyright 2017 atanvarno.com
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

/** Package use block. */
use Atan\Framework\Core;

return [
    'root' => dirname(__DIR__),
    'app' => Core::path(dirname(__DIR__), 'app'),
    'assets' => Core::path(dirname(__DIR__), 'assets'),
    'config' => __DIR__,
    'public' => Core::path(dirname(__DIR__), 'public'),
    'resources' => Core::path(dirname(__DIR__), 'resources'),
];