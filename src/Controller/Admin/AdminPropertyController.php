<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PropertyRepository;
use App\Entity\Property;
use App\Form\PropertyType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class AdminPropertyController extends AbstractController
{

    /**
     * @Route("/admin", name="admin_home")
     */
    public function index(PropertyRepository $repo)
    {

        $props = $repo->findAll();

        return $this->render('admin/property/index.html.twig', [
            "props" => $props
        ]);
    }

    /**
     * @Route("/admin/biens/create", name="admin_property_create")
     */
    public function new(Request $request, ObjectManager $em)
    {
        $props = new Property();
        $form = $this->createForm(PropertyType::class, $props);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($props);
            $em->flush();
            $this->addFlash('notice', 'bien create avec succee');
            return $this->redirectToRoute('admin_home');
        }
        return $this->render('admin/property/create.html.twig', [
            'form' => $form->createView()
        ]);         
    }

    /**
     * @Route("/admin/biens/edit/{id}", name="admin_property_edit")
     */
    public function edit(Property $property, Request $request, ObjectManager $em)
    {

        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $em->flush();
            $this->addFlash('notice','bien modifee avec succee');
            return $this->redirectToRoute('admin_home');
        }
        return $this->render('admin/property/edit.html.twig', [
            'form' => $form->createView()
        ]);     

    }

    /**
     * @Route("/admin/biens/delete/{id}", name="admin_property_delete")
     */
    public function delete(Property $property, ObjectManager $em)
    {

        $em->remove($property);
        $em->flush();

        $response = new Response();
        $response->send();
        $this->addFlash('notice', 'bien suppreme avec succee');
        return $this->redirectToRoute('admin_home');
    }
 
}