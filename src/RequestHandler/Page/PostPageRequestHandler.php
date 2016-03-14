<?php

namespace Asopeli\ManagedContentNode\RequestHandler\Page;

use Asopeli\ManagedContentNode\Entity\Page;
use Asopeli\ManagedContentNode\Entity\Repository\PageCategoryRepository;
use Asopeli\ManagedContentNode\Entity\Repository\PageRepository;
use Asopeli\ManagedContentNode\Request\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Handles page create requests.
 */
class PostPageRequestHandler implements RequestHandlerInterface
{
    /**
     * @var PageRepository
     */
    private $pageRepository;

    /**
     * @var PageCategoryRepository
     */
    private $pageCategoryRepository;

    /**
     * @param PageRepository $pageRepository
     * @param PageCategoryRepository $pageCategoryRepository
     */
    public function __construct(PageRepository $pageRepository, PageCategoryRepository $pageCategoryRepository)
    {
        $this->pageRepository = $pageRepository;
        $this->pageCategoryRepository = $pageCategoryRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function matches(Request $request)
    {
        return (
            $request->isMethod('POST')
            && $request->getPathInfo() == '/pages'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        $page = new Page(
            null,
            $content['slug'],
            $content['title'],
            $content['content'],
            new \DateTime($content['publishedAt']),
            $this->pageCategoryRepository->find($content['pageCategoryId'])
        );

        $this->pageRepository->store($page);

        return new JsonResponse($page->toArray());
    }
}