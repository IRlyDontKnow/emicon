<?php declare(strict_types=1);

namespace AppBundle\Repository;

use AppBundle\Model\FriendlyUrl;
use Doctrine\ORM\EntityManagerInterface;

class FriendlyUrlRepository
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function save(FriendlyUrl $friendlyUrl): void
    {
        $this->em->persist($friendlyUrl);
    }

    public function findByRequestUri(string $requestUri): ?FriendlyUrl
    {
        return $this->em->createQueryBuilder()
            ->from(FriendlyUrl::class, 'friendlyUrl')
            ->select('friendlyUrl')
            ->where('friendlyUrl.requestUri = :requestUri')
            ->setParameter('requestUri', $requestUri)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return FriendlyUrl[]
     */
    public function findAll(): array
    {
        return $this->em->createQueryBuilder()
            ->from(FriendlyUrl::class, 'friendlyUrl')
            ->select('friendlyUrl')
            ->getQuery()
            ->getResult();
    }
}
