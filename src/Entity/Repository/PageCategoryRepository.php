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
        $pageCategoryRows = $this->connection->fetchAll('SELECT `slug`, `title` FROM `managed_content_node_page_category`');

        return array_map(function ($pageCategoryRow) {
            return new PageCategory($pageCategoryRow['slug'], $pageCategoryRow['title']);
        }, $pageCategoryRows);
    }

    /**
     * @param string $pageCategorySlug
     *
     * @return PageCategory|null
     */
    public function findOneBySlug($pageCategorySlug)
    {
        $pageCategoryRow = $this->connection->fetchAssoc(
            'SELECT `slug`, `title`
             FROM `managed_content_node_page_category`
             WHERE `slug` = :pageCategorySlug
             LIMIT 1',
            ['pageCategorySlug' => $pageCategorySlug]
        );

        if (null === $pageCategoryRow) {
            return null;
        }

        return new PageCategory($pageCategoryRow['slug'], $pageCategoryRow['title']);
    }

    /**
     * @param PageCategory $pageCategory
     *
     * @return PageCategoryRepository
     */
    public function store(PageCategory $pageCategory)
    {
        $this->connection->executeQuery(
            'REPLACE `managed_content_node_page_category` (`slug`, `title`) VALUES (:slug, :title)',
            ['slug' => $pageCategory->getSlug(), 'title' => $pageCategory->getTitle()]
        );
    }
}