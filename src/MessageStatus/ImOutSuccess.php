<?php

namespace igorbunov\Edna\MessageStatus;

class ImOutSuccess
{
    public $id;
    public $code;

    public function __construct(array $response)
    {
        $this->id = $response['id'];
        $this->code = $response['code'];
    }
}