<?php

namespace Asopeli\ManagedContentNode\RequestHandler;

use Asopeli\ManagedContentNode\Request\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Decorates request handler for security.
 */
class SecuredRequestHandler implements RequestHandlerInterface
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var RequestHandlerInterface
     */
    private $decoratedRequestHandler;

    /**
     * @param string                  $apiKey
     * @param RequestHandlerInterface $decoratedRequestHandler
     */
    public function __construct($apiKey, RequestHandlerInterface $decoratedRequestHandler)
    {
        $this->apiKey = $apiKey;
        $this->decoratedRequestHandler = $decoratedRequestHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function matches(Request $request)
    {
        return $this->decoratedRequestHandler->matches($request);
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request)
    {
        if ($this->apiKey === $request->headers->get('X-API-Key')) {
            return $this->decoratedRequestHandler->handle($request);
        }

        return new Response('', Response::HTTP_UNAUTHORIZED);
    }
}
