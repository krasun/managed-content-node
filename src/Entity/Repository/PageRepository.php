<?php

namespace Asopeli\ManagedContentNode\Entity\Repository;

use Asopeli\ManagedContentNode\Entity\Page;
use Asopeli\ManagedContentNode\Entity\PageCategory;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;

/**
 * Responsible for page persistence.
 */
class PageRepository
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
     * @param \DateTime $date
     * @param string    $slug
     *
     * @return Page|null
     */
    public function findOneByDateAndSlug(\DateTime $date, $slug)
    {
        $pageRow = $this->connection->fetchAssoc(
            'SELECT
                `page`.`id`,
                `page`.`slug`,
                `page`.`title`,
                `page`.`content`,
                `page`.`published_at`,
                `page_category`.`id` `page_category_id`,
                `page_category`.`slug` `page_category_slug`,
                `page_category`.`title` `page_category_title`
             FROM
                `managed_content_node_page` `page` JOIN `managed_content_node_page_category` `page_category`
                    ON `page`.`page_category_id` = `page_category`.`id`
             WHERE
                `page`.`slug` = :slug AND DATE(`page`.`published_at`) = :published_at
            ORDER BY `page`.`published_at` DESC
            LIMIT 1',
            ['slug' => $slug, 'published_at' => $date->format('Y-m-d')]
        );

        if (false === $pageRow) {
            return null;
        }

        return new Page(
            $pageRow['id'],
            $pageRow['slug'],
            $pageRow['title'],
            $pageRow['content'],
            new \DateTime($pageRow['published_at']),
            new PageCategory($pageRow['page_category_id'], $pageRow['page_category_slug'], $pageRow['page_category_title'])
        );
    }

    /**
     * @param string   $pageCategorySlug
     * @param int|null $offset
     * @param int|null $limit
     *
     * @return Page[]
     */
    public function findByPageCategorySlug($pageCategorySlug, $offset = 0, $limit = 10)
    {
        // @todo do not apply limits for null variables
        if ($limit == null) {
            $limit = 100000;
        }

        $pageRows = $this->connection->fetchAll(
            'SELECT
                `page`.`id`,
                `page`.`slug`,
                `page`.`title`,
                `page`.`content`,
                `page`.`published_at`,
                `page_category`.`id` `page_category_id`,
                `page_category`.`slug` `page_category_slug`,
                `page_category`.`title` `page_category_title`
             FROM
                `managed_content_node_page` `page` JOIN `managed_content_node_page_category` `page_category`
                    ON `page`.`page_category_id` = `page_category`.`id`
             WHERE
                `page`.`page_category_slug` = :pageCategorySlug
             ORDER BY `page`.`published_at` DESC
             LIMIT :offset, :limit
             ',
            ['pageCategorySlug' => $pageCategorySlug, 'offset' => (int) $offset, 'limit' => (int) $limit],
            ['pageCategorySlug' => Type::STRING, 'offset' => Type::INTEGER, 'limit' => Type::INTEGER]
        );

        if (count($pageRows) == 0) {
            return [];
        }

        $pages = [];
        foreach ($pageRows as $pageRow) {
            $pages[] = new Page(
                $pageRow['id'],
                $pageRow['slug'],
                $pageRow['title'],
                $pageRow['content'],
                new \DateTime($pageRow['published_at']),
                new PageCategory($pageRow['page_category_id'], $pageRow['page_category_slug'], $pageRow['page_category_title'])
            );
        }

        return $pages;
    }

    /**
     * @return Page[]
     */
    public function findAll()
    {
        $pageRows = $this->connection->fetchAll(
            'SELECT
                `page`.`id`,
                `page`.`slug`,
                `page`.`title`,
                `page`.`content`,
                `page`.`published_at`,
                `page_category`.`id` `page_category_id`,
                `page_category`.`slug` `page_category_slug`,
                `page_category`.`title` `page_category_title`
             FROM
                `managed_content_node_page` `page` JOIN `managed_content_node_page_category` `page_category`
                    ON `page`.`page_category_id` = `page_category`.`id`
             ORDER BY `page`.`published_at` DESC
             '
        );

        if (count($pageRows) == 0) {
            return [];
        }

        $pages = [];
        foreach ($pageRows as $pageRow) {
            $pages[] = new Page(
                $pageRow['id'],
                $pageRow['slug'],
                $pageRow['title'],
                $pageRow['content'],
                new \DateTime($pageRow['published_at']),
                new PageCategory($pageRow['page_category_id'], $pageRow['page_category_slug'], $pageRow['page_category_title'])
            );
        }

        return $pages;
    }

    /**
     * @param Page $page
     *
     * @return PageRepository
     */
    public function store(Page $page)
    {
        if ($page->getId()) {
            $this->connection->update(
                '`managed_content_node_page`',
                [
                    'slug' => $page->getSlug(),
                    'title' => $page->getTitle(),
                    'content' => $page->getContent(),
                    'page_category_id' => $page->getPageCategory()->getId(),
                ],
                ['id' => $page->getId()]
            );
        } else {
            $this->connection->insert(
                '`managed_content_node_page`',
                [
                    'slug' => $page->getSlug(),
                    'title' => $page->getTitle(),
                    'content' => $page->getContent(),
                    'page_category_id' => $page->getPageCategory()->getId(),
                ]
            );

            $id = $this->connection->lastInsertId();
            $reflectionProperty = new \ReflectionProperty(Page::class, 'id');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($page, $id);
        }

        return $this;
    }

    /**
     * @param int $id
     *
     * @return PageRepository
     */
    public function deleteById($id)
    {
        $this->connection->delete('`managed_content_node_page`', ['id' => $id]);

        return $this;
    }

    /**
     * @param int $id
     *
     * @return Page
     */
    public function find($id)
    {
        $pageRow = $this->connection->fetchAssoc(
            'SELECT
                `page`.`id`,
                `page`.`slug`,
                `page`.`title`,
                `page`.`content`,
                `page`.`published_at`,
                `page_category`.`id` `page_category_id`,
                `page_category`.`slug` `page_category_slug`,
                `page_category`.`title` `page_category_title`
             FROM
                `managed_content_node_page` `page` JOIN `managed_content_node_page_category` `page_category`
                    ON `page`.`page_category_id` = `page_category`.`id`
             WHERE
                `page`.`id` = :id
            ORDER BY `page`.`published_at` DESC
            LIMIT 1',
            ['id' => $id]
        );

        if (false === $pageRow) {
            return null;
        }

        return new Page(
            $pageRow['id'],
            $pageRow['slug'],
            $pageRow['title'],
            $pageRow['content'],
            new \DateTime($pageRow['published_at']),
            new PageCategory($pageRow['page_category_id'], $pageRow['page_category_slug'], $pageRow['page_category_title'])
        );
    }
}
