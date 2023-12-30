<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\UrlCode;
use App\Entity\User;
use App\Service\IncrementalCounterService;
use App\Service\UrlCodeService;
use App\Shortener\Interface\IUrlDecoder;
use App\Shortener\Interface\IUrlEncoder;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/shortener')]
class ShortenerController extends AbstractController
{
    /**
     * @return Response
     * @throws Exception
     */
    #[Route('/', name: 'shortener')]
    public function shortener(): Response
    {
        return $this->render('shortener/index.html.twig');
    }

    /**
     * @param Request $request
     * @param IUrlEncoder $encoder
     * @return Response
     * @throws Exception
     */
    #[Route('/encode', name: 'shortener_encode', requirements: ['url' => '.*'], methods: ['POST'])]
    public function encode(Request $request, IUrlEncoder $encoder): Response
    {
        $url = $request->get('url');
        $code = $encoder->encode($url);

        return $this->redirectToRoute('shortener_statistic_url', ['code' => $code]);
    }

    /**
     * @param UrlCodeService $service
     * @return Response
     */
    #[Route('/statistics', name: 'shortener_statistics')]
    public function allStatistics(UrlCodeService $service): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        return $this->render('shortener/statistics.html.twig', [
            'url_codes' => $service->getAllObjects($user)
        ]);
    }

    /**
     * @param string $code
     * @param IUrlDecoder $decoder
     * @param UrlCode $urlCode
     * @return Response
     * @throws Exception
     */
    #[Route('/statistics/{code}', name: 'shortener_statistic_url', requirements: ['code' => '\w{10}'])]
    public function decode(string $code, IUrlDecoder $decoder, UrlCode $urlCode): Response
    {
        if ($this->getUser() !== $urlCode->getUser()) {
            throw new Exception('You don\'t have access');
        }

        return $this->render('shortener/decode.html.twig', [
            'url' => $decoder->decode($code),
        ]);
    }

    /**
     * @param UrlCode $urlCode
     * @param IncrementalCounterService $service
     * @return Response
     */
    #[Route('/{code}', name: 'shortener_redirect_to_url', requirements: ['code' => '\w{10}'])]
    public function redirectUrl(UrlCode $urlCode, IncrementalCounterService $service): Response
    {
        $service->incrementCounter($urlCode);
        return $this->redirect($urlCode->getUrl());
    }
}
