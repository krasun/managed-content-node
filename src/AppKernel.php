<?php

namespace Asopeli\ManagedContentNode;

use Asopeli\ManagedContentNode\Request\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Asopeli\ManagedContentNode\RequestHandler\Page;
use Asopeli\ManagedContentNode\RequestHandler\PageCategory;
use Symfony\Component\Translation\Loader\XliffFileLoader;

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

        $this->boot();
    }

    /**
     * Boots application kernel.
     */
    private function boot()
    {
        $translator = new \Symfony\Component\Translation\Translator($this->parameters['locale']);
        $translator->addLoader('xliff', new XliffFileLoader());
        foreach ($this->parameters['translations'] as $translation) {
            $translator->addResource($translation['format'], $translation['resource'], $translation['locale'], $translation['domain']);
        }

        $loader = new \Symfony\Component\Templating\Loader\FilesystemLoader(__DIR__.'/../app/views/%name%');
        $templating = new \Symfony\Component\Templating\PhpEngine(
            new \Symfony\Component\Templating\TemplateNameParser(),
            $loader
        );
        $templating->setCharset($this->parameters['charset']);
        $templating->addHelpers([
            new \Symfony\Component\Templating\Helper\SlotsHelper(),
            new \Knp\Bundle\TimeBundle\Templating\Helper\TimeHelper(
                new \Knp\Bundle\TimeBundle\DateTimeFormatter(
                    $translator
                )
            ),
        ]);
        foreach ($this->parameters['templateVariables'] as $variableName => $variableValue) {
            $templating->addGlobal($variableName, $variableValue);
        }

        $connection = \Doctrine\DBAL\DriverManager::getConnection($this->parameters['database'], new \Doctrine\DBAL\Configuration());
        $pageRepository = new \Asopeli\ManagedContentNode\Entity\Repository\PageRepository($connection);
        $pageCategoryRepository = new \Asopeli\ManagedContentNode\Entity\Repository\PageCategoryRepository($connection);

        $this
            ->registerHandler(
                new RequestHandler\GetIndexRequestHandler($pageRepository, $pageCategoryRepository, $templating)
            )
            ->registerHandler(
                new RequestHandler\GetSitemapHandler()
            )
            ->registerHandler(
                new RequestHandler\SecuredRequestHandler(
                    $this->parameters['apiKey'],
                    new Page\PostPageRequestHandler($pageRepository, $pageCategoryRepository)
                )
            )
            ->registerHandler(
                new RequestHandler\SecuredRequestHandler(
                    $this->parameters['apiKey'],
                    new Page\PutPageRequestHandler($pageRepository, $pageCategoryRepository)
                )
            )
            ->registerHandler(
                new RequestHandler\SecuredRequestHandler(
                    $this->parameters['apiKey'],
                    new Page\DeletePageRequestHandler($pageRepository)
                )
            )
            ->registerHandler(
                new Page\GetPageRequestHandler($pageRepository, $templating)
            )
            ->registerHandler(
                new Page\GetPagesByPageCategoryRequestHandler($pageRepository, $pageCategoryRepository, $templating)
            )
            ->registerHandler(
                new RequestHandler\SecuredRequestHandler(
                    $this->parameters['apiKey'],
                    new PageCategory\PostPageCategoryRequestHandler($pageCategoryRepository)
                )
            )
            ->registerHandler(
                new RequestHandler\SecuredRequestHandler(
                    $this->parameters['apiKey'],
                    new PageCategory\PutPageCategoryRequestHandler($pageCategoryRepository)
                )
            )
            ->registerHandler(
                new RequestHandler\SecuredRequestHandler(
                    $this->parameters['apiKey'],
                    new PageCategory\DeletePageCategoryRequestHandler($pageCategoryRepository)
                )
            )
            ->registerHandler(
                new PageCategory\GetPageCategoryRequestHandler()
            )
            ->registerHandler(
                new PageCategory\GetPageCategoriesRequestHandler()
            )
        ;
    }

    /**
     * @param RequestHandlerInterface $handler
     *
     * @return AppKernel
     */
    public function registerHandler(RequestHandlerInterface $handler)
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
