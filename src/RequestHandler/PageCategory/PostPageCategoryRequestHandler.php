<?php

namespace Asopeli\ManagedContentNode\RequestHandler\PageCategory;

use Asopeli\ManagedContentNode\Entity\PageCategory;
use Asopeli\ManagedContentNode\Entity\Repository\PageCategoryRepository;
use Asopeli\ManagedContentNode\Request\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handling page category creating requests.
 */
class PostPageCategoryRequestHandler implements RequestHandlerInterface
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
            $request->isMethod('POST')
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
        $content = json_decode($request->getContent(), true);
        $pageCategory = new PageCategory(null, $content['slug'], $content['title']);

        $this->pageCategoryRepository->store($pageCategory);

        return new JsonResponse($pageCategory->toArray());
    }
}