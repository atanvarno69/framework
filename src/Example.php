<?php
/**
 * Example controller file.
 *
 * @package   Atan\Framework
 * @author    atanvarno69 <https://github.com/atanvarno69>
 * @copyright 2017 atanvarno.com
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Atan\Framework\Example;

/** Package use block. */
use Atan\Core\Controller;

/** PSR-7 use block. */
use Psr\Http\Message\{
    ResponseInterface,
    ServerRequestInterface
};

/** PSR-15 use block. */
use Interop\Http\ServerMiddleware\DelegateInterface;

class Example extends Controller
{
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ): ResponseInterface {
        $body = '<!DOCTYPE html>
<html lang="en" dir="ltr">
 <head>
  <title>Atan\Framework &ndash; Hello World</title>
 </head>
 <body>
  <h1>Hello ' . $request->getAttribute('name', 'World') .'</h1>
 </body>
</html>
';
        $response = $this->buildPrototypeResponse()->withStatus('200');
        $response->getBody()->write($body);
        return $response;
    }
}
