<?php

namespace Asopeli\ManagedContentNode\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestMatcherInterface;

/**
 * Responsible for request handling.
 */
interface RequestHandlerInterface extends RequestMatcherInterface
{
    /**
     * Handles request and returns response.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request);
}
