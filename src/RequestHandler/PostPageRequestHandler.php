<?php

namespace Asopeli\ManagedContentNode\RequestHandler;

use Asopeli\ManagedContentNode\Request\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handles page create requests.
 */
class PostPageRequestHandler implements RequestHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function matches(Request $request)
    {
        return (
            $request->isMethod('POST')
            && $request->getPathInfo() == '/pages'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request)
    {

    }
}