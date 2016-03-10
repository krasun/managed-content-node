<?php
/**
 * Created by PhpStorm.
 * User: krasundmytro
 * Date: 3/10/16
 * Time: 22:59
 */

namespace Asopeli\ManagedContentNode\RequestHandler;

use Asopeli\ManagedContentNode\Request\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handles page update requests.
 */
class PutPageRequestHandler implements RequestHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function matches(Request $request)
    {
        // TODO: Implement matches() method.
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request)
    {
        // TODO: Implement handle() method.
    }
}