<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\Table(name: 'url_codes')]
class UrlCode
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER, length: 11)]
    #[ORM\GeneratedValue]
    private int $id;

    public function __construct(
        #[ORM\Column(length: 255)]
        protected string $url,
        #[ORM\Column(length: 10)]
        protected string $code
    ) {

    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }
}
