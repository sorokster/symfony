<?php declare(strict_types=1);

namespace App\Factory;

use App\Entity\UrlCode;
use App\Entity\User;
use App\Service\UserService;
use App\Shortener\ValueObject\UrlCodeValueObject;
use Symfony\Bundle\SecurityBundle\Security;

class UrlCodeEntityFactory
{
    /**
     * @param Security $security
     * @param UserService $userService
     */
    public function __construct(
        protected Security    $security,
        protected UserService $userService
    )
    {
    }

    /**
     * @param UrlCodeValueObject $object
     * @return UrlCode
     */
    public function createFromUrlCodeValueObject(UrlCodeValueObject $object): UrlCode
    {
        /** @var User $user */
        $user = $this->security->getUser();
        return new UrlCode($object->getUrl(), $object->getCode(), $user);
    }

    /**
     * @param array $data
     * @return UrlCode
     */
    public function createFromArray(array $data): UrlCode
    {
        try {
            return new UrlCode($data['url'], $data['code'], $data['user']);
        } catch (\Throwable $e) {
            throw new \InvalidArgumentException(previous: $e);
        }
    }
}
