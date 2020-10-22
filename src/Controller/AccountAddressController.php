<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    private $entityManager ;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/compte/address", name="account_adrress")
     */
    public function index()
    {

        return $this->render('account/address.html.twig');
    }
    /**
     * @Route("/compte/ajouter-une-adresse", name="account_adrress_add")
     */
    public function add(Request $request)
    {
        $address = new Address();

        $form = $this->createForm(AddressType::class, $address);

        $form -> handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()){
            $address->setUser($this->getUser());
            $this->entityManager->persist($address);
            $this->entityManager->flush();
            return $this->redirectToRoute('account_adrress');

        }

        return $this->render('account/address_form.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/compte/modifier-une-adresse/{id}", name="account_adrress_edit")
     */
    public function edit(Request $request, $id)
    {
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);

        if (!$address || $address->getUser() != $this->getUser()){
            return $this->redirectToRoute('account_adrress');
        }

        $form = $this->createForm(AddressType::class, $address);

        $form -> handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()){
            $this->entityManager->flush();
            return $this->redirectToRoute('account_adrress');

        }

        return $this->render('account/address_form.html.twig',[
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/compte/supprimer-une-adresse/{id}", name="account_adrress_delete")
     */
    public function delete($id)
    {
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);

        if ($address && $address->getUser() == $this->getUser()){
            $this->entityManager->remove($address);
            $this->entityManager->flush();
        }




            return $this->redirectToRoute('account_adrress');


    }

}
