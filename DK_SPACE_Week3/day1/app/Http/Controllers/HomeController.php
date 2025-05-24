<?php

namespace App\Http\Controllers;

use App\Domain\Contracts\TranslatorInterface;

// phải đúng namespace interface

class HomeController extends Controller
{
    protected TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function index()
    {
        // Call the translator's method to return the greeting
        return response($this->translator->translate('admin_greeting'));
    }
}