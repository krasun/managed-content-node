<?php

namespace Asopeli\ManagedContentNode\RequestHandler\Page;

use Asopeli\ManagedContentNode\Entity\Repository\PageCategoryRepository;
use Asopeli\ManagedContentNode\Entity\Repository\PageRepository;
use Asopeli\ManagedContentNode\Request\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

/**
 * Responsible for getting page collection representations.
 */
class GetPagesRequestHandler implements RequestHandlerInterface
{
    /**
     * Regular expression for matching current handler.
     */
    const ROUTE_REGEX = '/^\/category\/([A-Za-z0-9А-яЁё]+)\/?$/u';

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
     * @param PageRepository $pageRepository
     * @param PageCategoryRepository $pageCategoryRepository
     * @param EngineInterface $templating
     */
    public function __construct(
        PageRepository $pageRepository,
        PageCategoryRepository $pageCategoryRepository,
        EngineInterface $templating
    )
    {
        $this->pageRepository = $pageRepository;
        $this->pageCategoryRepository = $pageCategoryRepository;
        $this->templating = $templating;
    }

    /**
     * {@inheritdoc}
     */
    public function matches(Request $request)
    {
        return (
            $request->isMethod('GET')
            && preg_match(self::ROUTE_REGEX, urldecode($request->getPathInfo()))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request)
    {
        preg_match(self::ROUTE_REGEX, urldecode($request->getPathInfo()), $parameters);
        list($pathInfo, $pageCategorySlug) = $parameters;

        $pageCategory = $this->pageCategoryRepository->findOneBySlug($pageCategorySlug);
        if (null === $pageCategory) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $pages = $this->pageRepository->findByPageCategorySlug($pageCategory->getSlug(), null, null);

        return new Response($this->templating->render('pages.html.php', [
            'pages' => $pages,
            'pageCategory' => $pageCategory
        ]));
    }
}