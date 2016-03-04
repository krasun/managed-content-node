<?php

namespace Asopeli\ManagedContentNode\RequestHandler;

use Asopeli\ManagedContentNode\Request\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

/**
 * Responsible for getting index representation.
 */
class GetIndexRequestHandler implements RequestHandlerInterface
{
    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @param EngineInterface $templating
     */
    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    /**
     * {@inheritdoc}
     */
    public function matches(Request $request)
    {
        return $request->isMethod('GET') && ($request->getPathInfo() == '/');
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request)
    {
        return new Response($this->templating->render('index.html.php', [

        ]));
    }
}