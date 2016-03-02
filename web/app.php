<?php

require_once __DIR__.'/../vendor/autoload.php';

$connectionParameters = array(
    'dbname' => 'managed_content_node_test',
    'user' => 'root',
    'password' => '',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
);
$connectionConfiguration = new \Doctrine\DBAL\Configuration();
$connection = \Doctrine\DBAL\DriverManager::getConnection($connectionParameters, $connectionConfiguration);

$pageRepository = new \Asopeli\ManagedContentNode\Entity\Repository\PageRepository($connection);
$pageCategoryRepository = new \Asopeli\ManagedContentNode\Entity\Repository\PageCategoryRepository($connection);

$page = $pageRepository->findOneBySlug('slug1');
$categories = $pageCategoryRepository->findAll();

$appRequestHandler = new \Asopeli\ManagedContentNode\AppKernel();
$response = $appRequestHandler->handle(\Symfony\Component\HttpFoundation\Request::createFromGlobals());
$response->send();
