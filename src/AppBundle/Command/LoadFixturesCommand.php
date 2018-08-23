<?php declare(strict_types=1);

namespace AppBundle\Command;

use AppBundle\Model\Page;
use AppBundle\Model\Product;
use AppBundle\Repository\PageRepository;
use AppBundle\Repository\ProductRepository;
use AppBundle\Services\FriendlyUrlCreator;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LoadFixturesCommand extends Command
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var PageRepository */
    private $pageRepository;

    /** @var ProductRepository */
    private $productRepository;

    /** @var FriendlyUrlCreator */
    private $friendlyUrlService;

    /** @var ORMPurger */
    private $purger;

    public function __construct(
        EntityManagerInterface $entityManager,
        PageRepository $pageRepository,
        ProductRepository $productRepository,
        FriendlyUrlCreator $friendlyUrlService
    ) {
        parent::__construct('app:fixtures:load');
        $this->entityManager = $entityManager;
        $this->pageRepository = $pageRepository;
        $this->productRepository = $productRepository;
        $this->friendlyUrlService = $friendlyUrlService;
        $this->purger = (new ORMPurger($entityManager));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $this->purger->purge();
        $this->entityManager->beginTransaction();

        try {
            $this->loadPages();
            $this->loadProducts();

            $this->entityManager->flush();
            $this->entityManager->commit();

            $io->success('Fixtures successfully loaded.');
        } catch (\Exception $ex) {
            $this->entityManager->rollback();

            $io->error($ex->getMessage());
        }
    }

    private function loadPages(): void
    {
        $pages = [
            [
                'title' => 'Page one',
                'content' => 'Page one [content]',
                'friendlyUrl' => 'page-one',
            ],
            [
                'title' => 'Page two',
                'content' => 'Page two [content]',
                'friendlyUrl' => 'page-two-2018',
            ],
        ];

        foreach ($pages as $data) {
            $page = Page::create($data['title'], $data['content']);
            $this->pageRepository->save($page);
            $this->entityManager->flush();

            if (array_key_exists('friendlyUrl', $data)) {
                $this->friendlyUrlService->create($data['friendlyUrl'], 'page', $page->id());
            }
        }
    }

    private function loadProducts()
    {
        $products = [
            [
                'title' => 'Jack & Jones',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'friendlyUrl' => 'jack-and-jones',
            ],
            [
                'title' => 'ERIKA - Sunglasses',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'friendlyUrl' => 'ray-ban-erika-sunglasses',
            ],
        ];

        foreach ($products as $data) {
            $product = Product::create($data['title'], $data['content']);
            $this->productRepository->save($product);
            $this->entityManager->flush();

            if (array_key_exists('friendlyUrl', $data)) {
                $this->friendlyUrlService->create($data['friendlyUrl'], 'product', $product->id());
            }
        }
    }
}
