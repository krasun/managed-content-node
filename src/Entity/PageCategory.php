<?php

namespace Asopeli\ManagedContentNode\Entity;

/**
 * Represents page category.
 */
class PageCategory
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
     * @param string $slug
     * @param string $title
     */
    public function __construct($slug, $title)
    {
        $this->slug = $slug;
        $this->title = $title;
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
}