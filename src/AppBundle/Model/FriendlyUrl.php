<?php declare(strict_types=1);

namespace AppBundle\Model;

class FriendlyUrl
{
    /** @var int */
    private $id;

    /** @var int */
    private $itemId;

    /** @var string */
    private $itemType;

    /** @var string */
    private $requestUri;

    public function id()
    {
        return $this->id;
    }

    public function itemId(): int
    {
        return $this->itemId;
    }

    public function itemType(): string
    {
        return $this->itemType;
    }

    public function requestUri(): string
    {
        return $this->requestUri;
    }

    public static function create(string $requestUri, string $itemType, int $itemId): self
    {
        $friendlyUrl = new self;
        $friendlyUrl->requestUri = $requestUri;
        $friendlyUrl->itemType = $itemType;
        $friendlyUrl->itemId = $itemId;

        return $friendlyUrl;
    }
}
