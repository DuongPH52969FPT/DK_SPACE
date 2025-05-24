<?php

namespace App\Domain\Services\Translator;

use App\Domain\Contracts\TranslatorInterface;

class EnglishTranslator implements TranslatorInterface{
    protected $translations = [
         'admin_greeting' => 'Hello, admin',
    ];

    public function translate(string $key): string
    {
        return $this->translations[$key] ?? $key;
    }
}