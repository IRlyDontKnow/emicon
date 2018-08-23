<?php declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Repository\FriendlyUrlRepository;
use AppBundle\Resolver\FriendlyUrlControllerResolver;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FriendlyUrlController extends Controller
{
    /** @var FriendlyUrlRepository */
    private $friendlyUrlRepository;

    /** @var FriendlyUrlControllerResolver */
    private $controllerResolver;

    public function __construct(
        FriendlyUrlRepository $friendlyUrlRepository,
        FriendlyUrlControllerResolver $controllerResolver
    ) {
        $this->friendlyUrlRepository = $friendlyUrlRepository;
        $this->controllerResolver = $controllerResolver;
    }

    public function indexAction(string $uri, ?string $parameters = null)
    {
        $friendlyUrl = $this->friendlyUrlRepository->findByRequestUri($uri);

        if ($friendlyUrl === null) {
            throw new NotFoundHttpException('Page not found.');
        }

        $controller = $this->controllerResolver->resolve($friendlyUrl->itemType());
        $additionalParameters = [];

        if ($parameters !== null) {
            $additionalParameters = $this->extractAdditionalParameters($parameters);
        }

        $attributes = array_merge($additionalParameters, [
            'id' => $friendlyUrl->itemId(),
            'parameters' => $additionalParameters,
        ]);

        return $this->forward($controller, $attributes);
    }

    private function extractAdditionalParameters(string $parametersString): array
    {
        $items = explode('/', $parametersString);
        $parameters = [];

        for ($i = 0; $i < count($items); $i += 2) {
            $parameters[$items[$i]] = $items[$i + 1] ?? null;
        }

        return $parameters;
    }
}
