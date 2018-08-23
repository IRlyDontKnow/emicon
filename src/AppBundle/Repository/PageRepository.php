<?php declare(strict_types=1);

namespace AppBundle\Repository;

use AppBundle\Exception\PageNotFoundException;
use AppBundle\Model\Page;
use Doctrine\ORM\EntityManagerInterface;

class PageRepository
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function save(Page $page): void
    {
        $this->em->persist($page);
    }

    public function getById(int $id): Page
    {
        $page = $this->em->find(Page::class, $id);

        if ($page === null) {
            throw new PageNotFoundException(
                sprintf('Could not find page with id %s.', $id)
            );
        }

        return $page;
    }
}
