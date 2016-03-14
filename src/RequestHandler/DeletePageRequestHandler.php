<?php

namespace Asopeli\ManagedContentNode\RequestHandler;

use Asopeli\ManagedContentNode\Request\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handles page delete requests.
 */
class DeletePageRequestHandler implements RequestHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function matches(Request $request)
    {
//        return ($request->isMethod('DELETE') && $request->getPathInfo());
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request)
    {
        // TODO: Implement handle() method.
    }
}