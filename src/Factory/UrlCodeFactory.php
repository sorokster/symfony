<?php declare(strict_types=1);

namespace App\Factory;

use App\Entity\UrlCode;
use App\Shortener\ValueObject\UrlCodeValueObject;

class UrlCodeFactory
{
    /**
     * @param UrlCodeValueObject $object
     * @return UrlCode
     */
    public function createFromUrlCodeValueObject(UrlCodeValueObject $object): UrlCode
    {
        return new UrlCode($object->getUrl(), $object->getCode());
    }
}
