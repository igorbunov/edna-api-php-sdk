<?php

namespace igorbunov\Edna\Validator;

interface ValicatorContract
{
    public function validate(?array $response = []): void;
}