<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OptionRepository;
use App\Entity\Option;
use App\Form\OptionType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class AdminOptionController extends AbstractController
{
    /**
     * @Route("/admin/option", name="admin_option")
     */
    public function index(OptionRepository $repo)
    {

        $option = $repo->findAll();

        return $this->render('admin/option/index.html.twig', [
            'options' => $option
        ]);
    }

    /**
     * @Route("/admin/option/create", name="admin_option_create")
     */
    public function new(Request $request, ObjectManager $em)
    {
        $option = new Option();
        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($option);
            $em->flush();
            $this->addFlash('notice', 'bien create avec succee');
            return $this->redirectToRoute('admin_option');
        }
        return $this->render('admin/option/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/option/edit/{id}", name="admin_option_edit")
     */
    public function edit(Option $option, Request $request, ObjectManager $em)
    {

        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('notice', 'bien modifee avec succee');
            return $this->redirectToRoute('admin_option');
        }
        return $this->render('admin/option/edit.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/option/delete/{id}", name="admin_option_delete")
     */
    public function delete(Option $option, ObjectManager $em)
    {

        $em->remove($option);
        $em->flush();

        $response = new Response();
        $response->send();
        $this->addFlash('notice', 'bien suppreme avec succee');
        return $this->redirectToRoute('admin_option');
    }

}
