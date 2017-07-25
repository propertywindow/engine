<?php declare(strict_types=1);

namespace AppBundle\Models\JsonRpc;

use JsonSerializable;

/**
 * @package AppBundle\Models\JsonRpc
 */
class Error implements JsonSerializable
{
    /**
     * @var int
     */
    private $code;

    /**
     * @var string|null
     */
    private $message;

    /**
     * @var mixed
     */
    private $data;

    /**
     * @param int         $code
     * @param string|null $message
     * @param mixed       $data
     */
    public function __construct(int $code, ?string $message, $data = null)
    {
        $this->code    = $code;
        $this->message = $message;
        $this->data    = $data;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return null|string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            "code"    => $this->code,
            "message" => $this->message,
            "data"    => $this->data,
        ];
    }
}
