<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PropertyRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PropertyRepository $repository)
    {
        $repo = $repository->latestProp();
        return $this->render('home/index.html.twig', [
            'props' => $repo
        ]);
    }
}
