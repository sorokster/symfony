<?php declare(strict_types=1);

namespace App\Shortener\Interface;

use App\Shortener\ValueObject\UrlCodeValueObject;

interface IUrlCodeService
{
    /**
     * @param UrlCodeValueObject $urlCode
     * @return void
     */
    public function addRecord(UrlCodeValueObject $urlCode): void;

    /**
     * @param string $code
     * @return UrlCodeValueObject|null
     */
    public function getRecord(string $code): ?UrlCodeValueObject;
}
