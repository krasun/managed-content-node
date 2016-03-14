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
        $pageCategoryRows = $this->connection->fetchAll(
            'SELECT `id`, `slug`, `title` FROM `managed_content_node_page_category`'
        );

        return array_map(function ($pageCategoryRow) {
            return new PageCategory($pageCategoryRow['id'], $pageCategoryRow['slug'], $pageCategoryRow['title']);
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
            'SELECT `id`, `slug`, `title`
             FROM `managed_content_node_page_category`
             WHERE `slug` = :pageCategorySlug
             LIMIT 1',
            ['pageCategorySlug' => $pageCategorySlug]
        );

        if (null === $pageCategoryRow) {
            return null;
        }

        return new PageCategory($pageCategoryRow['id'], $pageCategoryRow['slug'], $pageCategoryRow['title']);
    }

    /**
     * @param PageCategory $pageCategory
     *
     * @return PageCategoryRepository
     */
    public function store(PageCategory $pageCategory)
    {
        if ($pageCategory->getId()) {
            $this->connection->update(
                '`managed_content_node_page_category`',
                ['slug' => $pageCategory->getSlug(), 'title' => $pageCategory->getTitle()],
                ['id' => $pageCategory->getId()]
            );
        } else {
            $this->connection->insert(
                '`managed_content_node_page_category`',
                ['slug' => $pageCategory->getSlug(), 'title' => $pageCategory->getTitle()]
            );

            $id = $this->connection->lastInsertId();
            $reflectionProperty = new \ReflectionProperty(PageCategory::class, 'id');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($pageCategory, $id);
        }

        return $this;
    }

    /**
     * @param int $id
     *
     * @return PageCategoryRepository
     */
    public function deleteById($id)
    {
        $this->connection->delete('`managed_content_node_page_category`', ['id' => $id]);

        return $this;
    }

    /**
     * @param int $id
     *
     * @return PageCategory
     */
    public function find($id)
    {
        $pageCategoryRow = $this->connection->fetchAssoc(
            'SELECT `id`, `slug`, `title`
             FROM `managed_content_node_page_category`
             WHERE `id` = :id
             LIMIT 1',
            ['id' => $id]
        );

        if (null === $pageCategoryRow) {
            return null;
        }

        return new PageCategory($pageCategoryRow['id'], $pageCategoryRow['slug'], $pageCategoryRow['title']);
    }
}
