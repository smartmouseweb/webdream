<?php

namespace App\Controller;

use App\Entity\Warehouse;
use App\Form\WarehouseFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WarehouseController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/warehouse/create', name: 'create_warehouse')]
    public function create(Request $request): Response
    {
        $warehouse = new Warehouse;
        $form = $this->createForm(WarehouseFormType::class, $warehouse);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $warehouse = $form->getData();
            $this->em->persist($warehouse);
            $this->em->flush();

            return $this->redirectToRoute('app_index');
        }

        return $this->render('warehouse/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
