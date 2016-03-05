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
     * @param string $slug
     *
     * @return Page|null
     */
    public function findOneByDateAndSlug(\DateTime $date, $slug)
    {
        $pageRow = $this->connection->fetchAssoc(
            'SELECT
                `page`.`slug`,
                `page`.`title`,
                `page`.`content`,
                `page`.`published_at`,
                `page_category`.`slug` `page_category_slug`,
                `page_category`.`title` `page_category_title`
             FROM
                `managed_content_node_page` `page` JOIN `managed_content_node_page_category` `page_category`
                    ON `page`.`page_category_slug` = `page_category`.`slug`
             WHERE
                `page`.`slug` = :slug AND `page`.`published_at` = :published_at
            ORDER BY `page`.`published_at` DESC
            LIMIT 1',
            ['slug' => $slug, 'published_at' => $date->format('Y-m-d')]
        );

        if (false === $pageRow) {
            return null;
        }

        return new Page(
            $pageRow['slug'],
            $pageRow['title'],
            $pageRow['content'],
            new \DateTime($pageRow['published_at']),
            new PageCategory($pageRow['page_category_slug'], $pageRow['page_category_title'])
        );
    }

    /**
     * @param string $pageCategorySlug
     * @param int $offset
     * @param int $limit
     *
     * @return Page|null
     */
    public function findByPageCategorySlug($pageCategorySlug, $offset = 0, $limit = 10)
    {
        $pageRows = $this->connection->fetchAll(
            'SELECT
                `page`.`slug`,
                `page`.`title`,
                `page`.`content`,
                `page`.`published_at`,
                `page_category`.`slug` `page_category_slug`,
                `page_category`.`title` `page_category_title`
             FROM
                `managed_content_node_page` `page` JOIN `managed_content_node_page_category` `page_category`
                    ON `page`.`page_category_slug` = `page_category`.`slug`
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
                $pageRow['slug'],
                $pageRow['title'],
                $pageRow['content'],
                new \DateTime($pageRow['published_at']),
                new PageCategory($pageRow['page_category_slug'], $pageRow['page_category_title'])
            );
        }

        return $pages;
    }
}