<?php

require_once __DIR__.'/../vendor/autoload.php';

$parameters = require_once __DIR__.'/../app/parameters.php';
$appKernel = new \Asopeli\ManagedContentNode\AppKernel($parameters);

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
$response = $appKernel->handle($request);

$response->send();
