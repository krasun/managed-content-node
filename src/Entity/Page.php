<?php

namespace Asopeli\ManagedContentNode\Entity;

/**
 * Represents page.
 */
class Page
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var \DateTime
     */
    private $publishedAt;
    /**
     * @var PageCategory
     */
    private $pageCategory;

    /**
     * @param int $id
     * @param string $slug
     * @param string $title
     * @param string $content
     * @param \DateTime $publishedAt
     * @param PageCategory $pageCategory
     */
    public function __construct($id, $slug, $title, $content, \DateTime $publishedAt, PageCategory $pageCategory)
    {
        $this->id = $id;
        $this->slug = $slug;
        $this->title = $title;
        $this->content = $content;
        $this->publishedAt = $publishedAt;
        $this->pageCategory = $pageCategory;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return \DateTime
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @return PageCategory
     */
    public function getPageCategory()
    {
        return $this->pageCategory;
    }

    /**
     * @param Page $another
     *
     * @return bool
     */
    public function equals(Page $another)
    {
        return ($this->getSlug() == $another->getSlug());
    }
}