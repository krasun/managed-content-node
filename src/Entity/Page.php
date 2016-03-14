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
     * @param int          $id
     * @param string       $slug
     * @param string       $title
     * @param string       $content
     * @param \DateTime    $publishedAt
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
     * @param string $slug
     *
     * @return Page
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $title
     *
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $content
     *
     * @return Page
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
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
     * @param PageCategory $pageCategory
     *
     * @return Page
     */
    public function setPageCategory(PageCategory $pageCategory)
    {
        $this->pageCategory = $pageCategory;

        return $this;
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
        return ($this->getId() == $another->getId());
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'slug' => $this->getSlug(),
            'title' => $this->getTitle(),
            'content' => $this->getContent(),
            'publishedAt' => $this->getPublishedAt(),
            'pageCategory' => $this->getPageCategory()->toArray(),
        ];
    }
}
