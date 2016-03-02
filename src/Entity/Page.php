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
     * @param string $slug
     * @param string $title
     * @param string $content
     */
    public function __construct($slug, $title, $content)
    {
        $this->slug = $slug;
        $this->title = $title;
        $this->content = $content;
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
}