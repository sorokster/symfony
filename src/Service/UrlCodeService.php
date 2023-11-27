<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\UrlCode;
use App\Factory\UrlCodeFactory;
use App\Repository\UrlCodeRepository;
use App\Shortener\Interface\IUrlCodeService;
use App\Shortener\ValueObject\UrlCodeValueObject;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class UrlCodeService implements IUrlCodeService
{
    /**
     * @var UrlCodeRepository
     */
    protected ObjectRepository $repository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param UrlCodeFactory $factory
     */
    public function __construct(protected EntityManagerInterface $entityManager, protected UrlCodeFactory $factory)
    {
        $this->repository = $this->entityManager->getRepository(UrlCode::class);
    }

    /**
     * @param UrlCodeValueObject $urlCode
     * @return void
     */
    public function addRecord(UrlCodeValueObject $urlCode): void
    {
        $entity = $this->factory->createFromUrlCodeValueObject($urlCode);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * @param string $code
     * @return UrlCodeValueObject|null
     */
    public function getRecord(string $code): ?UrlCodeValueObject
    {
        if (is_null($url = $this->repository->findOneBy(['code' => $code])->getUrl())) {
            return null;
        }

        return new UrlCodeValueObject($url, $code);
    }
}
