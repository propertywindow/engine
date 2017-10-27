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
     * @return array
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
