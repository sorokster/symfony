<?php declare(strict_types=1);

namespace App\Controller;

use App\Shortener\Interface\IUrlDecoder;
use App\Shortener\Interface\IUrlEncoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Shortener extends AbstractController
{
    #[Route('/shortener/encode/{url}', name: 'Encode', requirements: ['url' => '.*'])]
    public function encode(string $url, IUrlEncoder $encoder): Response
    {
        return $this->render('shortener/encode.html.twig', [
            'code' => $encoder->encode($url),
        ]);
    }

    #[Route('/shortener/decode/{code}', name: 'Decode', requirements: ['code' => '\w{10}'])]
    public function decode(string $code, IUrlDecoder $decoder): Response
    {
        return $this->render('shortener/decode.html.twig', [
            'url' => $decoder->decode($code),
        ]);
    }
}
