<?php

namespace App\Domain\Services\Translator;


use App\Domain\Contracts\TranslatorInterface;

class VietnameseTranslator implements TranslatorInterface
{
    protected $translations = [
        'admin_greeting' => 'Xin chào, quản trị viên',
    ];

    public function translate(string $key): string
    {
        return $this->translations[$key] ?? $key;
    }
}
