<?php declare(strict_types=1);

namespace App\Controller;

use App\Common\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AuthorizationController extends AbstractController
{
    private Cache $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    public function authorize(): Response
    {
        if (array_key_exists('code', $_GET)) {
            $this->cache->save('code', $_GET['code']);
            return $this->render('authorized.html.twig', [
                'redirectUrl' => $_ENV['SPOTIFY_REDIRECT_URL'],
            ]);
        }
        return $this->render('authorize.html.twig', [
            'clientId' => $_ENV['SPOTIFY_CLIENT_ID'],
            'redirectUrl' => $_ENV['SPOTIFY_REDIRECT_URL'],
        ]);
    }
}