<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AuthorizationController extends AbstractController
{
    public function authorize(): Response
    {
        if (array_key_exists('code', $_GET)) {
            return $this->render('authorized.html.twig', ['code' => $_GET['code']]);
        }
        return $this->render('authorize.html.twig', [
            'clientId' => $_ENV['CLIENT_ID'],
            'redirectUrl' => $_ENV['REDIRECT_URL'],
        ]);
    }
}