<?php

namespace Asopeli\ManagedContentNode\RequestHandler\PageCategory;

use Asopeli\ManagedContentNode\Entity\PageCategory;
use Asopeli\ManagedContentNode\Entity\Repository\PageCategoryRepository;
use Asopeli\ManagedContentNode\Request\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Handles page category update requests.
 */
class PutPageCategoryRequestHandler implements RequestHandlerInterface
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
            $request->isMethod('PUT')
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

        $content = json_decode($request->getContent(), true);
        $pageCategory = new PageCategory((int) $id, $content['slug'], $content['title']);

        $this->pageCategoryRepository->store($pageCategory);

        return new JsonResponse($pageCategory->toArray());
    }
}