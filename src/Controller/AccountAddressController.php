<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    /**
     * @Route("/compte/address", name="account_adrress")
     */
    public function index()
    {
        return $this->render('account/address.html.twig');
    }
}
