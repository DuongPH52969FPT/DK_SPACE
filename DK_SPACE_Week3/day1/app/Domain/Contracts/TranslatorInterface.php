<?php

namespace App\Domain\Contracts;

interface TranslatorInterface
{
    public function translate(string $key): string;
}
