<?php declare(strict_types=1);

namespace AppBundle\Services;

use AppBundle\Model\FriendlyUrl;
use AppBundle\Repository\FriendlyUrlRepository;

class FriendlyUrlCreator
{
    /** @var FriendlyUrlRepository */
    private $friendlyUrlRepository;

    public function __construct(FriendlyUrlRepository $friendlyUrlRepository)
    {
        $this->friendlyUrlRepository = $friendlyUrlRepository;
    }

    public function create(string $requestUri, string $itemType, int $itemId): FriendlyUrl
    {
        if ($this->friendlyUrlRepository->findByRequestUri($requestUri) !== null) {
            throw new \DomainException(
                sprintf('Friendly uri "%s" is already in use.', $requestUri)
            );
        }

        $friendlyUrl = FriendlyUrl::create($requestUri, $itemType, $itemId);

        $this->friendlyUrlRepository->save($friendlyUrl);

        return $friendlyUrl;
    }
}
