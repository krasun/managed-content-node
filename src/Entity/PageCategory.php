<?php

namespace Asopeli\ManagedContentNode\Entity;

/**
 * Represents page category.
 */
class PageCategory
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
     * @param int    $id
     * @param string $slug
     * @param string $title
     */
    public function __construct($id, $slug, $title)
    {
        $this->id = $id;
        $this->slug = $slug;
        $this->title = $title;
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
     * @param PageCategory $another
     *
     * @return bool
     */
    public function equals(PageCategory $another)
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
        ];
    }
}
