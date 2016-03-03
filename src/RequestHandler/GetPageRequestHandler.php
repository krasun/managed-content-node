<?php

namespace Asopeli\ManagedContentNode\RequestHandler;

use Symfony\Component\HttpFoundation\Request;
use Asopeli\ManagedContentNode\Entity\Repository\PageRepository;
use Asopeli\ManagedContentNode\Request\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

/**
 * Responsible for getting page representations.
 */
class GetPageRequestHandler implements RequestHandlerInterface
{
    /**
     * Regular expression for matching current handler.
     */
    const ROUTE_REGEX = '/^\/(\d{4})\/(\d{2})\/(\d{2})\/([A-Za-z0-9А-яЁё]+)\/?$/u';

    /**
     * @var PageRepository
     */
    private $pageRepository;

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @param PageRepository $pageRepository
     * @param EngineInterface $templating
     */
    public function __construct(
        PageRepository $pageRepository,
        EngineInterface $templating
    )
    {
        $this->pageRepository = $pageRepository;
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

        $page = $this->pageRepository->findOneByDateAndSlug(new \DateTime(), 'asd');
        if (null === $page) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        return new Response(
            $this->templating->render('page.html.php', ['page' => $page])
        );
    }
}