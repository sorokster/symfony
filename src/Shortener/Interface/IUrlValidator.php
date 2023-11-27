<?php declare(strict_types=1);

namespace App\Shortener\Interface;

interface IUrlValidator
{
    public function validate(string $url): bool;
}
