<?php

namespace Asopeli\ManagedContentNode\RequestHandler\PageCategory;

use Asopeli\ManagedContentNode\Entity\Repository\PageCategoryRepository;
use Asopeli\ManagedContentNode\Request\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Handles page categories get requests.
 */
class GetPageCategoriesRequestHandler implements RequestHandlerInterface
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
            $request->isMethod('GET')
            && 'json' == $request->getContentType()
            && in_array('application/json', $request->getAcceptableContentTypes())
            && preg_match('/^\/page-categories\/?$/', $request->getPathInfo())
        );
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request)
    {
        $pageCategories = $this->pageCategoryRepository->findAll();

        return new JsonResponse($pageCategories);
    }
}
