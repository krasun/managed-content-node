<?php

require_once __DIR__.'/../vendor/autoload.php';
$parameters = require_once __DIR__.'/../app/parameters.php';

$connection = \Doctrine\DBAL\DriverManager::getConnection($parameters['database'], new \Doctrine\DBAL\Configuration());

$loader = new \Symfony\Component\Templating\Loader\FilesystemLoader(__DIR__.'/../app/views/%name%');
$templating = new \Symfony\Component\Templating\PhpEngine(
    new \Symfony\Component\Templating\TemplateNameParser(),
    $loader
);

$pageRepository = new \Asopeli\ManagedContentNode\Entity\Repository\PageRepository($connection);
$pageCategoryRepository = new \Asopeli\ManagedContentNode\Entity\Repository\PageCategoryRepository($connection);

$appKernel = (new \Asopeli\ManagedContentNode\AppKernel())
    ->addHandler(
        new \Asopeli\ManagedContentNode\RequestHandler\GetPageRequestHandler($pageRepository, $templating)
    )
;

$response = $appKernel->handle(\Symfony\Component\HttpFoundation\Request::createFromGlobals());
$response->send();
