<?php

namespace igorbunov\Edna\Config;

interface ConfigContract
{
    public function url(string $url): string;

    public function keyHeader(): array;
}
