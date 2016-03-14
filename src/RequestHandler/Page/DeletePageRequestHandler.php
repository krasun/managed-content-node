<?php

namespace Asopeli\ManagedContentNode\RequestHandler\Page;

use Asopeli\ManagedContentNode\Entity\Repository\PageRepository;
use Asopeli\ManagedContentNode\Request\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handles page delete requests.
 */
class DeletePageRequestHandler implements RequestHandlerInterface
{
    /**
     * @var PageRepository
     */
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
    public function matches(Request $request)
    {
        return (
            $request->isMethod('DELETE')
            && 'json' == $request->getContentType()
            && in_array('application/json', $request->getAcceptableContentTypes())
            && preg_match('/^\/pages\/(\d+)\/?$/', $request->getPathInfo())
        );
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request)
    {
        preg_match('/^\/pages\/(\d+)\/?$/', $request->getPathInfo(), $parameters);
        list($pathInfo, $id) = $parameters;

        $this->pageRepository->deleteById($id);

        return new Response('', 204);
    }
}
