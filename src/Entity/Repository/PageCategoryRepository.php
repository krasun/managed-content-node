<?php

namespace Asopeli\ManagedContentNode\Entity\Repository;

use Asopeli\ManagedContentNode\Entity\PageCategory;
use Doctrine\DBAL\Connection;

/**
 * Responsible for page category persistence.
 */
class PageCategoryRepository
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return PageCategory[]
     */
    public function findAll()
    {
        $pageCategoryRows = $this->connection->fetchAll('SELECT `slug` FROM `managed_content_node_page_category`');

        return array_map(function ($pageCategoryRow) {
            return new PageCategory($pageCategoryRow['slug']);
        }, $pageCategoryRows);
    }
}