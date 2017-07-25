<?php declare(strict_types=1);

namespace AppBundle\Models\JsonRpc;

use JsonSerializable;

/**
 * @package AppBundle\Models\JsonRpc
 */
class Response implements JsonSerializable
{
    /**
     * @var Error|null
     */
    private $error;

    /**
     * @var mixed|null
     */
    private $result;

    /**
     * @var int|string|null
     */
    private $id;

    /**
     * @param $id
     */
    private function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return Error|null
     */
    public function getError(): ?Error
    {
        return $this->error;
    }

    /**
     * @return mixed|null
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return int|null|string
     */
    public function getId()
    {
        return $this->id;
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
        $jsonArray = [
            'jsonrpc' => '2.0',
            'id'      => $this->id,
        ];

        if ($this->result !== null) {
            $jsonArray['result'] = $this->result;
        }

        if ($this->error !== null) {
            $jsonArray['error'] = $this->error;
        }

        return $jsonArray;
    }

    /**
     * @param int|string|null $id
     * @param mixed           $result
     *
     * @return Response
     */
    public static function success($id, $result): self
    {
        $self         = new self($id);
        $self->result = $result;

        return $self;
    }

    /**
     * @param int|string|null $id
     * @param Error           $error
     *
     * @return Response
     */
    public static function failure($id, Error $error): self
    {
        $self        = new self($id);
        $self->error = $error;

        return $self;
    }
}
