<?php

namespace Asopeli\ManagedContentNode;

use Asopeli\ManagedContentNode\Request\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Asopeli\ManagedContentNode\RequestHandler;

/**
 * Entry point.
 */
class AppKernel
{
    /**
     * @var array
     */
    private $parameters;

    /**
     * @var RequestHandlerInterface[]
     */
    private $handlers = [];

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Boots application kernel.
     */
    public function boot()
    {
        $loader = new \Symfony\Component\Templating\Loader\FilesystemLoader(__DIR__.'/../app/views/%name%');
        $templating = new \Symfony\Component\Templating\PhpEngine(
            new \Symfony\Component\Templating\TemplateNameParser(),
            $loader
        );

        $templating->addHelpers([
            new \Symfony\Component\Templating\Helper\SlotsHelper(),
            new \Knp\Bundle\TimeBundle\Templating\Helper\TimeHelper(
                new \Knp\Bundle\TimeBundle\DateTimeFormatter(
                    new \Symfony\Component\Translation\Translator($this->parameters['locale'])
                )
            )
        ]);
        foreach ($this->parameters['templateVariables'] as $variableName => $variableValue) {
            $templating->addGlobal($variableName, $variableValue);
        }

        $connection = \Doctrine\DBAL\DriverManager::getConnection($this->parameters['database'], new \Doctrine\DBAL\Configuration());
        $pageRepository = new \Asopeli\ManagedContentNode\Entity\Repository\PageRepository($connection);
        $pageCategoryRepository = new \Asopeli\ManagedContentNode\Entity\Repository\PageCategoryRepository($connection);

        $this
            ->addHandler(
                new RequestHandler\GetIndexRequestHandler($pageRepository, $pageCategoryRepository, $templating)
            )
            ->addHandler(
                new RequestHandler\GetSitemapHandler()
            )
            ->addHandler(
                new RequestHandler\PostPageRequestHandler()
            )
            ->addHandler(
                new RequestHandler\PutPageRequestHandler()
            )
            ->addHandler(
                new RequestHandler\DeletePageRequestHandler()
            )
            ->addHandler(
                new RequestHandler\GetPageRequestHandler($pageRepository, $templating)
            )
            ->addHandler(
                new RequestHandler\GetPagesRequestHandler($pageRepository, $pageCategoryRepository, $templating)
            )
            ->addHandler(
                new RequestHandler\PostPageCategoryRequestHandler()
            )
            ->addHandler(
                new RequestHandler\PutPageCategoryRequestHandler()
            )
            ->addHandler(
                new RequestHandler\DeletePageCategoryRequestHandler()
            )
            ->addHandler(
                new RequestHandler\GetPageCategoryRequestHandler()
            )
            ->addHandler(
                new RequestHandler\GetPageCategoriesRequestHandler()
            )
        ;
    }

    /**
     * @param RequestHandlerInterface $handler
     *
     * @return AppKernel
     */
    public function addHandler(RequestHandlerInterface $handler)
    {
        $this->handlers[] = $handler;

        return $this;
    }

    /**
     * Handles request and returns response.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        foreach ($this->handlers as $handler) {
            if ($handler->matches($request)) {
                return $handler->handle($request);
            }
        }

        return Response::create('', Response::HTTP_NOT_FOUND);
    }
}