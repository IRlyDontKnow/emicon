<?php declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    /** @var PageRepository */
    private $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function show(int $id, ?array $parameters = []): Response
    {
        $page = $this->pageRepository->getById($id);

        return $this->render('page/show.html.twig', [
            'page' => $page,
            'parameters' => $parameters,
        ]);
    }
}
