<?php declare(strict_types=1);

namespace AppBundle\Repository;

use AppBundle\Exception\ProductNotFoundException;
use AppBundle\Model\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductRepository
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function save(Product $product): void
    {
        $this->em->persist($product);
    }

    public function getById(int $id): Product
    {
        $product = $this->em->find(Product::class, $id);

        if ($product === null) {
            throw new ProductNotFoundException(
                sprintf('Could not find product with id %s.', $id)
            );
        }

        return $product;
    }
}
