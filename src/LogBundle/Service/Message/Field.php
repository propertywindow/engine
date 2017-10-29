<?php declare(strict_types=1);

namespace LogBundle\Service\Message;

/**
 * @package LogBundle\Service\Message
 */
class Field
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var bool
     */
    protected $short;

    /**
     * @param string $title
     * @param string $value
     * @param bool   $short
     */
    public function __construct($title, $value, $short = false)
    {
        $this->title = $title;
        $this->value = $value;
        $this->short = $short;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'title' => $this->title,
            'value' => $this->value,
            'short' => $this->short
        ];
    }
}
