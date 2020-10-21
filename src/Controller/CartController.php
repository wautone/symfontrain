<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $entityManager;


    /**
     * @Route("/mon-panier", name="cart")
     */
    public function index(Cart $cart)
    {
        $cartComplete = [];

        foreach ($cart->get() as $id => $quantity){
            $cartComplete[] = [
                'product' => $this->getDoctrine()->getRepository(Product::class)->findOneById($id),
                'quantity' => $quantity

            ];
        }


        return $this->render('cart/index.html.twig',[
            'cart'=> $cartComplete
        ]);
    }
    /**
     * @Route ("/cart/add/{id}", name="add_to_cart")
     */
    public function add(Cart $cart, $id)
    {
        $cart->add($id);

        return $this->redirectToRoute('cart');

    }
    /**
     * @Route ("/cart/remove", name="remove_my_cart")
     */
    public function remove(Cart $cart)
    {
        $cart->remove();

        return $this->redirectToRoute('products');

    }
}