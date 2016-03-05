<?php

namespace Asopeli\ManagedContentNode\RequestHandler;

use Asopeli\ManagedContentNode\Request\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Responsible for getting page collection representations.
 */
class GetPagesRequestHandler implements RequestHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function matches(Request $request)
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request)
    {
        // TODO: Implement handle() method.
    }
}