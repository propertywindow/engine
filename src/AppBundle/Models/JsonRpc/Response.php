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
     * @return array
     */
    public function jsonSerialize()
    {
        $jsonArray = [
            'jsonrpc' => '2.0',
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
     * @param mixed           $result
     *
     * @return Response
     */
    public static function success($result): self
    {
        $self         = new self();
        $self->result = $result;

        return $self;
    }

    /**
     * @param Error           $error
     *
     * @return Response
     */
    public static function failure(Error $error): self
    {
        $self        = new self();
        $self->error = $error;

        return $self;
    }
}
