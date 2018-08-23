<?php declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /** @var int */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function show(int $id, ?array $parameters = []): Response
    {
        $product = $this->productRepository->getById($id);

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'parameters' => $parameters,
        ]);
    }
}
