<?php

namespace Asopeli\ManagedContentNode\RequestHandler;

use Asopeli\ManagedContentNode\Entity\Repository\PageCategoryRepository;
use Asopeli\ManagedContentNode\Request\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handles page category delete requests.
 */
class DeletePageCategoryRequestHandler implements RequestHandlerInterface
{
    /**
     * @var PageCategoryRepository
     */
    private $pageCategoryRepository;

    /**
     * @param PageCategoryRepository $pageCategoryRepository
     */
    public function __construct(PageCategoryRepository $pageCategoryRepository)
    {
        $this->pageCategoryRepository = $pageCategoryRepository;
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
            && preg_match('/^\/page-categories\/(\d+)\/?$/', $request->getPathInfo())
        );

    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request)
    {
        preg_match('/^\/page-categories\/(\d+)\/?$/', $request->getPathInfo(), $parameters);
        list($pathInfo, $id) = $parameters;

        $this->pageCategoryRepository->deleteById($id);

        return new Response('', 204);
    }
}