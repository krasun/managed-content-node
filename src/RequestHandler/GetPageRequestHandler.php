<?php

namespace Asopeli\ManagedContentNode\RequestHandler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Asopeli\ManagedContentNode\Entity\Repository\PageRepository;
use Asopeli\ManagedContentNode\Request\RequestHandlerInterface;

/**
 *
 */
class GetPageRequestHandler implements RequestHandlerInterface
{
    /**
     * @var PageRepository
     */1
    private $pageRepository;

    /**
     * @param PageRepository $pageRepository
     */
    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request)
    {
        // TODO: Implement handle() method.
    }

    /**
     * {@inheritdoc}
     */
    public function matches(Request $request)
    {
        // TODO: Implement matches() method.
    }
}