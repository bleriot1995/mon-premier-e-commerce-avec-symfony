<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Stripe\Stripe;

class OrderSuccessController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/commande/merci/{stripeSessionId}", name="order_validate")
     */
    public function index($stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);
        $this->entityManager->flush();
         if (!$order || $order->getUser() != $this->getUser()) {
             return $this->redirectToRoute('home');
         }

         if (!$order->isIsPaid()) {
             // Modifier le statut isPaid de notre commande en mettant 1
             $order->setIsPaid(1);
             $this->entityManager->persist($order);
             $this->entityManager->flush();
             // Envoyer un email à notre client pour lui confirmer sa commande
         }

        return $this->render('order_validate/index.html.twig', [
            'order' => $order
        ]);
    }
}
