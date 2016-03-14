<?php

namespace Asopeli\ManagedContentNode\RequestHandler;

use Asopeli\ManagedContentNode\Entity\Repository\PageCategoryRepository;
use Asopeli\ManagedContentNode\Entity\Repository\PageRepository;
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
     * @var PageRepository
     */
    private $pageRepository;

    /**
     * @var PageCategoryRepository
     */
    private $pageCategoryRepository;

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @param PageRepository         $pageRepository
     * @param PageCategoryRepository $pageCategoryRepository
     * @param EngineInterface        $templating
     */
    public function __construct(
        PageRepository $pageRepository,
        PageCategoryRepository $pageCategoryRepository,
        EngineInterface $templating
    ) {
        $this->pageRepository = $pageRepository;
        $this->pageCategoryRepository = $pageCategoryRepository;
        $this->templating = $templating;
    }

    /**
     * {@inheritdoc}
     */
    public function matches(Request $request)
    {
        return $request->isMethod('GET') && ($request->getPathInfo() == '/' || $request->getPathInfo() == '');
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request)
    {
        $pages = $this->pageRepository->findAll();
        $pageCategories = $this->pageCategoryRepository->findAll();

        return new Response($this->templating->render('index.html.php', [
            'pages' => $pages,
            'pageCategories' => $pageCategories,
        ]));
    }
}
