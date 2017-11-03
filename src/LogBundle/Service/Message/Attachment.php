<?php declare(strict_types=1);

namespace LogBundle\Service\Message;

/**
 * @package LogBundle\Service\Message
 */
class Attachment
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var Field[]
     */
    protected $fields;

    /**
     * Attachment constructor.
     */
    public function __construct()
    {
        $this->data['mrkdwn_in'] = ['pretext', 'title'];
        $this->fields            = [];
    }

    /**
     * @return Attachment
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @param string $fallback
     *
     * @return $this
     */
    public function fallback($fallback)
    {
        $this->data['fallback'] = $fallback;
        return $this;
    }

    /**
     * @param string $color
     *
     * @return $this
     */
    public function color($color)
    {
        $this->data['color'] = $color;
        return $this;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function title($title)
    {
        $this->data['title'] = $title;
        return $this;
    }

    /**
     * @param string $pretext
     *
     * @return $this
     */
    public function pretext($pretext)
    {
        $this->data['pretext'] = $pretext;
        return $this;
    }

    /**
     * @param string $footer
     *
     * @return $this
     */
    public function footer($footer)
    {
        $this->data['footer'] = $footer;
        return $this;
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function text($text)
    {
        $this->data['text'] = $text;
        $this->fallback($text);

        return $this;
    }

    /**
     * @param string $link
     *
     * @return $this
     */
    public function link($link)
    {
        $this->data['title_link'] = $link;
        return $this;
    }

    /**
     * @param string $imageUrl
     *
     * @return $this
     */
    public function image($imageUrl)
    {
        $this->data['image_url'] = $imageUrl;
        return $this;
    }

    /**
     * @param string $thumbnailUrl
     *
     * @return $this
     */
    public function thumbnail($thumbnailUrl)
    {
        $this->data['thumb_url'] = $thumbnailUrl;
        return $this;
    }

    /**
     * @param int $timestamp
     *
     * @return $this
     */
    public function ts($timestamp = null)
    {
        $this->data['ts'] = $timestamp !== null ? $timestamp : time();
        return $this;
    }

    /**
     * @param Author $author
     *
     * @return $this
     */
    public function author(Author $author)
    {
        $this->data = array_merge($this->data, $author->toArray());
        return $this;
    }

    /**
     * @param Field $field
     *
     * @return $this
     */
    public function addField(Field $field)
    {
        $this->fields[] = $field;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_merge($this->data, [
            'fields' => array_map(
                function (Field $field) {
                    return $field->toArray();
                },
                $this->fields
            )
        ]);
    }
}
