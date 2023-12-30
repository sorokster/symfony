<?php declare(strict_types=1);

namespace App\Entity;

use App\Interface\IIncrementalCounter;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'url_codes')]
class UrlCode implements IIncrementalCounter
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER, length: 11)]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'integer', length: 6)]
    protected int $counter = 0;

    public function __construct(
        #[ORM\Column(length: 255)]
        protected string $url,
        #[ORM\Column(length: 10)]
        protected string $code,
        #[ORM\ManyToOne(targetEntity: User::class, fetch: 'EAGER', inversedBy: 'urls')]
        #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
        protected User   $user,
    )
    {

    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function getCounter(): int
    {
        return $this->counter;
    }

    /**
     * @return void
     */
    public function incrementCounter(): void
    {
        $this->counter++;
    }
}
