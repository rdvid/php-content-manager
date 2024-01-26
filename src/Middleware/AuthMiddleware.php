<?php

namespace App;

use Psr\Http\Server\MiddlewareInterface;

// arrange new forms to implement guard middleware and ensure logging perform

class AuthMiddleware implements MiddlewareInterface
{
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface
    {
        // Calling $handler->handle() delegates control to the *next* middleware
        // In your application's queue.
        $response = $handler->handle($request);

        if (!$request->getCookie('landing_page')) {
            $expiry = new Time('+ 1 year');
            $response = $response->withCookie(new Cookie(
                'landing_page',
                $request->getRequestTarget(),
                $expiry
            ));
        }

        return $response;
    }
}
