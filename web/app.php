<?php

require_once __DIR__.'/../vendor/autoload.php';
$parameters = require_once __DIR__.'/../app/parameters.php';

$loader = new \Symfony\Component\Templating\Loader\FilesystemLoader(__DIR__.'/../app/views/%name%');
$templating = new \Symfony\Component\Templating\PhpEngine(
    new \Symfony\Component\Templating\TemplateNameParser(),
    $loader
);

$templating->addHelpers([
    new \Symfony\Component\Templating\Helper\SlotsHelper(),
    new \Knp\Bundle\TimeBundle\Templating\Helper\TimeHelper(
        new \Knp\Bundle\TimeBundle\DateTimeFormatter(
            new \Symfony\Component\Translation\Translator($parameters['locale'])
        )
    )
]);


$connection = \Doctrine\DBAL\DriverManager::getConnection($parameters['database'], new \Doctrine\DBAL\Configuration());
$pageRepository = new \Asopeli\ManagedContentNode\Entity\Repository\PageRepository($connection);
$pageCategoryRepository = new \Asopeli\ManagedContentNode\Entity\Repository\PageCategoryRepository($connection);

$appKernel = (new \Asopeli\ManagedContentNode\AppKernel())
    ->addHandler(
        new \Asopeli\ManagedContentNode\RequestHandler\GetIndexRequestHandler($pageRepository, $pageCategoryRepository, $templating)
    )
    ->addHandler(
        new \Asopeli\ManagedContentNode\RequestHandler\GetPageRequestHandler($pageRepository, $templating)
    )
    ->addHandler(
        new \Asopeli\ManagedContentNode\RequestHandler\GetPagesRequestHandler()
    )
;

$response = $appKernel->handle(\Symfony\Component\HttpFoundation\Request::createFromGlobals());
$response->send();
