<?php

namespace App\Model;

use Doctrine\Inflector\InflectorFactory;
use Doctrine\Inflector\Language;

class Activite
{
    private string $title;

    private string $image;

    private string $content;

    public function __construct(string $title, string $image, string $content)
    {
        $this->title = $title;
        $this->image = $image;
        $this->content = $content;
    }

    public function getSlug()
    {
        $inflector = InflectorFactory::createForLanguage(Language::FRENCH);
        return $inflector->build()->urlize($this->title);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Activite
     */
    public function setTitle(string $title): Activite
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return Activite
     */
    public function setImage(string $image): Activite
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Activite
     */
    public function setContent(string $content): Activite
    {
        $this->content = $content;
        return $this;
    }
}
