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
     * @param string $slug
     */
    public function __construct($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}