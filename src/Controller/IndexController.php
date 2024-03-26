<?php

namespace App\Controller;

use App\Entity\Warehouse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', methods:['GET'], name: 'app_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $warehouses = $em->getRepository(Warehouse::class)->findAll();

        $em->getRepository(Warehouse::class)->getRemainingCapacity($warehouses);

        return $this->render('index/index.html.twig', [
            'warehouses' => $warehouses,
        ]);
    }
}
