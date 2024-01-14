<?php declare(strict_types=1);

namespace App\Controller;

use App\Common\Authorization;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AuthorizationController extends AbstractController
{
    private Authorization $authorization;

    public function __construct(Authorization $authorization)
    {
        $this->authorization = $authorization;
    }

    public function authorize(): Response
    {
        if (array_key_exists('code', $_GET)) {
            $authorizationCode = $_GET['code'];
            $this->authorization->cacheAccessToken($authorizationCode);
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