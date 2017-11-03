<?php declare(strict_types=1);

namespace LogBundle\Service\Message;

/**
 * @package LogBundle\Service\Message
 */
class Message
{
    /**
     * @var Attachment[]
     */
    protected $attachments;

    /**
     * @var string
     */
    protected $text;

    /**
     * Message constructor.
     */
    public function __construct()
    {
        $this->attachments = [];
    }

    /**
     * @return Message
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function text($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @param Attachment $attachment
     *
     * @return $this
     */
    public function attach(Attachment $attachment)
    {
        $this->attachments[] = $attachment;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $message = [];

        if ($this->text !== null) {
            $message['text'] = $this->text;
        }

        if (count($this->attachments) > 0) {
            $message['attachments'] = array_map(
                function (Attachment $attachment) {
                    return $attachment->toArray();
                },
                $this->attachments
            );
        }

        return $message;
    }
}
