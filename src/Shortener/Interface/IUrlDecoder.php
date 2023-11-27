<?php declare(strict_types=1);

namespace App\Shortener\Interface;

use InvalidArgumentException;

interface IUrlDecoder
{
    /**
     * @param string $code
     * @return string
     * @throws InvalidArgumentException
     */
    public function decode(string $code): string;
}
