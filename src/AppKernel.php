<?php

namespace Asopeli\ManagedContentNode;

use Asopeli\ManagedContentNode\Request\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Entry point.
 */
class AppKernel implements RequestHandlerInterface
{
    /**
     * @var RequestHandlerInterface[]
     */
    private $handlers = [];

    /**
     * @param RequestHandlerInterface $handler
     *
     * @return AppKernel
     */
    public function addHandler(RequestHandlerInterface $handler)
    {
        $this->handlers[] = $handler;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function matches(Request $request)
    {
        foreach ($this->handlers as $handler) {
            if ($handler->matches($request)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request)
    {
        foreach ($this->handlers as $handler) {
            if ($handler->matches($request)) {
                return $handler->handle($request);
            }
        }

        return Response::create('', Response::HTTP_NOT_FOUND);
    }
}