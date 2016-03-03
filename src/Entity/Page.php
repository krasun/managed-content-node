<?php

namespace Asopeli\ManagedContentNode\Entity;

/**
 * Represents page.
 */
class Page
{
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
     * @param string $slug
     * @param string $title
     * @param string $content
     * @param \DateTime $publishedAt
     * @param PageCategory $pageCategory
     */
    public function __construct($slug, $title, $content, \DateTime $publishedAt, PageCategory $pageCategory)
    {
        $this->slug = $slug;
        $this->title = $title;
        $this->content = $content;
        $this->publishedAt = $publishedAt;
        $this->pageCategory = $pageCategory;
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
}