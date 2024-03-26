<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Entity\Warehouse;
use App\Form\StockFormType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StockController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/stock/create', name: 'create_stock')]
    public function create(Request $request): Response
    {
        $stock = new Stock;
        $form = $this->createForm(StockFormType::class, $stock);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newStock = $form->getData();
            
            $warehouseAddedCount = 0;
            $remainingCapacity = $form->get('warehouse')->getData()->getRemainingCapacity();
            $remainingQuantity = $form->get('quantity')->getData();            
            
            // Add stock to the selected warehouse if there is still capacity left
            if (0 < $remainingCapacity)
            {
                // Adjust the quantity if it's greater then the remaining capacity of the selected warehouse
                if ($remainingCapacity < $remainingQuantity)
                {
                    $newStock->setQuantity($remainingCapacity);
                    $remainingQuantity -= $remainingCapacity;
                }
                else
                {
                    $remainingQuantity = 0;
                }

                $newStock->setDateRegister(new DateTime());
                
                $this->em->persist($newStock);
                $this->em->flush();

                $warehouseAddedCount++;
            }

            if (0 < $remainingQuantity)
            {
                $warehouses = $this->em->getRepository(Warehouse::class)->findAll();
                $this->em->getRepository(Warehouse::class)->getRemainingCapacity($warehouses); // This is so ugly...

                $i=0;

                while (0 < $remainingQuantity && $i < count($warehouses))
                {
                    if (0 < $warehouses[$i]->getRemainingCapacity() && $form->get('warehouse')->getData()->getId() !== $warehouses[$i]->getId())
                    {
                        echo $warehouses[$i]->getId().' '.$warehouses[$i]->getRemainingCapacity().' '.$remainingQuantity.'<br>';
                        $newStock2 = new Stock();

                        $newStock2->setWarehouse($warehouses[$i]);
                        $newStock2->setProduct($form->get('product')->getData());

                        if ($warehouses[$i]->getRemainingCapacity() < $remainingQuantity)
                        {
                            $newStock2->setQuantity($warehouses[$i]->getRemainingCapacity());
                            $remainingQuantity -= $warehouses[$i]->getRemainingCapacity();
                        }
                        else
                        {
                            $newStock2->setQuantity($remainingQuantity);
                            $remainingQuantity = 0;
                        }

                        $newStock2->setDateRegister(new DateTime());
                
                        $this->em->persist($newStock2);
                        $this->em->flush();

                        $warehouseAddedCount++;
                    }
                    
                    $i++;
                }
            }
            
            $this->addFlash(
                'notice',
                'Stocks were added to '.$warehouseAddedCount.' warehouses!'
            );

            if (0 < $remainingQuantity)
            {
                $this->addFlash(
                    'warning',
                    'There was no space for '.$remainingQuantity.' products!'
                );
            }

            return $this->redirectToRoute('app_index');
        }

        return $this->render('stock/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/stock/remove', name: 'remove_stock')]
    public function remove(Request $request): Response
    {
        $stock = new Stock;
        $form = $this->createForm(StockFormType::class, $stock);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $removedStockCount = 0;
            $updatedStockCount = 0;
            $removeQuantity = $form->get('quantity')->getData();
            
            foreach ($form->get('warehouse')->getData()->getStocks() as $stock)
            {
                if (0 < $removeQuantity && $form->get('product')->getData() === $stock->getProduct())
                {
                    if ($removeQuantity >= $stock->getQuantity())
                    {
                        $removeQuantity -= $stock->getQuantity();

                        $this->em->remove($stock);
                        $this->em->flush();
                        $removedStockCount++;
                    }
                    else
                    {
                        $stock->setQuantity($stock->getQuantity() - $removeQuantity);
                        $removeQuantity = 0;

                        $this->em->persist($stock);
                        $this->em->flush();
                        $updatedStockCount++;
                    }
                }
            }

            echo $removeQuantity.'<br>';

            if (0 < $removeQuantity)
            {
                $stocks = $this->em->getRepository(Stock::class)->findBy(array('product' => $form->get('product')->getData()), array('warehouse' => 'ASC'));

                $i=0;

                while (0 < $removeQuantity && $i < count($stocks))
                {
                    echo $stocks[$i]->getId().' '.$stocks[$i]->getQuantity().' '.$removeQuantity.'<br>';

                    if ($removeQuantity >= $stocks[$i]->getQuantity())
                    {
                        echo 'REMOVE ';
                        $removeQuantity -= $stocks[$i]->getQuantity();

                        $this->em->remove($stocks[$i]);
                        $this->em->flush();
                        $removedStockCount++;
                    }
                    else
                    {
                        $stocks[$i]->setQuantity($stocks[$i]->getQuantity() - $removeQuantity);
                        $removeQuantity = 0;

                        $this->em->persist($stocks[$i]);
                        $this->em->flush();
                        $updatedStockCount++;
                    }

                    $i++;
                }
            }
            
            $this->addFlash(
                'notice',
                $updatedStockCount.' stocks were updated and '.$removedStockCount.' stocks were removed!'
            );

            if (0 < $removeQuantity)
            {
                $this->addFlash(
                    'warning',
                    $removeQuantity.' products cound\'t been deleted!'
                );
            }

            return $this->redirectToRoute('app_index');
        }

        return $this->render('stock/remove.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
