<?php declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Repository\FriendlyUrlRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /** @var FriendlyUrlRepository */
    private $friendlyUrlRepository;

    public function __construct(FriendlyUrlRepository $friendlyUrlRepository)
    {
        $this->friendlyUrlRepository = $friendlyUrlRepository;
    }

    public function indexAction()
    {
        $friendlyUrls = $this->friendlyUrlRepository->findAll();

        return $this->render('home.html.twig', [
            'friendlyUrls' => $friendlyUrls,
        ]);
    }
}
