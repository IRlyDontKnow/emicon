<?php declare(strict_types=1);

namespace AppBundle\Resolver;

class FriendlyUrlControllerResolver
{
    /** @var array */
    private $mapping = [];

    public function __construct(array $mapping = [])
    {
        $this->mapping = $mapping;
    }

    public function resolve(string $itemType): string
    {
        if (!array_key_exists($itemType, $this->mapping)) {
            throw new \RuntimeException(
                sprintf('Failed to resolve controller for item type %s.', $itemType)
            );
        }

        return $this->mapping[$itemType];
    }

    public function addMapping(string $itemType, string $controller): void
    {
        if ($controller == '') {
            throw new \InvalidArgumentException('Controller cannot be empty.');
        }

        if (array_key_exists($itemType, $this->mapping)) {
            throw new \RuntimeException(
                sprintf('Controller for item type "%s" is already registered.', $itemType)
            );
        }

        $this->mapping[$itemType] = $controller;
    }
}
