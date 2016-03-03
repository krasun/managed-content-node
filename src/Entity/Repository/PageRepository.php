<?php

namespace Asopeli\ManagedContentNode\Entity\Repository;

use Asopeli\ManagedContentNode\Entity\Page;
use Asopeli\ManagedContentNode\Entity\PageCategory;
use Doctrine\DBAL\Connection;

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
}