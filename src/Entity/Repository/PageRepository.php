<?php

namespace Asopeli\ManagedContentNode\Entity\Repository;

use Asopeli\ManagedContentNode\Entity\Page;
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
            'SELECT `slug`, `title`, `content`, `published_at` FROM `managed_content_node_page` WHERE `slug` = :slug LIMIT 1',
            ['slug' => $slug]
        );

        if (false === $pageRow) {
            return null;
        }

        return new Page(
            $pageRow['slug'],
            $pageRow['title'],
            $pageRow['content']
        );
    }
}