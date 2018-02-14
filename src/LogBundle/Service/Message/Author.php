<?php declare(strict_types = 1);

namespace LogBundle\Service\Message;

/**
 * @package LogBundle\Service\Message
 */
class Author
{
    /**
     * @var string[]
     */
    protected $data;


    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->data['author_name'] = $name;
    }

    /**
     * @param string $name
     *
     * @return Author
     */
    public static function create($name)
    {
        return new self($name);
    }

    /**
     * @param string $link
     *
     * @return $this
     */
    public function link($link)
    {
        $this->data['author_link'] = $link;

        return $this;
    }

    /**
     * @param string $icon
     *
     * @return $this
     */
    public function icon($icon)
    {
        $this->data['author_icon'] = $icon;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }
}
