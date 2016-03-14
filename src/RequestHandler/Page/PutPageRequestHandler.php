<?php

namespace Asopeli\ManagedContentNode\RequestHandler\Page;

use Asopeli\ManagedContentNode\Entity\Repository\PageCategoryRepository;
use Asopeli\ManagedContentNode\Entity\Repository\PageRepository;
use Asopeli\ManagedContentNode\Request\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Handles page update requests.
 */
class PutPageRequestHandler implements RequestHandlerInterface
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
            $request->isMethod('PUT')
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

        $content = json_decode($request->getContent(), true);

        $page = $this->pageRepository->find($id);
        $page
            ->setSlug($content['slug'])
            ->setTitle($content['title'])
            ->setContent($content['content'])
            ->setPageCategory($this->pageCategoryRepository->find($content['pageCategoryId']))
        ;

        $this->pageRepository->store($page);

        return new JsonResponse($page->toArray());
    }
}