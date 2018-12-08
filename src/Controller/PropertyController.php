<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Form\ContactType;
use App\Entity\Contact;
use App\Services\ContactNotification;

class PropertyController extends AbstractController
{
    /**
     * @Route("/biens", name="property")
     */
    public function index(PropertyRepository $repo, Request $request, PaginatorInterface $paginate)
    {

        $propsearch = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $propsearch);
        $form->handleRequest($request);


        $query = $repo->getAllVisible($propsearch);
        $pagination = $paginate->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );    
        return $this->render('property/index.html.twig', [
            'props' => $pagination,
            'form'  => $form->createView()
        ]);
    }

    /**
     * @Route("/biens/{id}/{slug}", name="property_show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(Property $property, $slug, Request $request, ContactNotification $sendContact)
    {

        if ($property->getSlug() !== $slug)
        {
           return $this->redirectToRoute('property_show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ]);
        }

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $sendContact->contactSend($contact);
            $this->addFlash('notice', 'bien email ete envoyee');
        }

        return $this->render('property/show.html.twig', [
            'prop' => $property,
            'contactForm' => $form->createView()
        ]);
    }    

}
