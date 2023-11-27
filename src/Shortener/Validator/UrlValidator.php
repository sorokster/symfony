<?php declare(strict_types=1);

namespace App\Shortener\Validator;

use App\Shortener\Interface\IUrlValidator;
use InvalidArgumentException;

class UrlValidator implements IUrlValidator
{
    /**
     * @param string $url
     * @return bool
     */
    public function validate(string $url): bool
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException('String is not a url.');
        }

        return true;
    }
}
