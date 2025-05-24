<?php

namespace App\Providers;

use App\Domain\Contracts\TranslatorInterface;
use App\Domain\Services\Translator\EnglishTranslator;
use App\Domain\Services\Translator\VietnameseTranslator;
use Illuminate\Support\ServiceProvider;

class TranslatorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TranslatorInterface::class, function ($app) {
            $locale = config('app.locale');

            return match ($locale) {
                'en' => new EnglishTranslator(),
                'vi' => new VietnameseTranslator(),
                default => new EnglishTranslator(),
            };
        });
    }

    public function boot(): void
    {
        //
    }
}
