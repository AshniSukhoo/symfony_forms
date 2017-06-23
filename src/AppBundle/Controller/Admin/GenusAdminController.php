<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Genus;
use AppBundle\Form\GenusFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class GenusAdminController extends Controller
{
    /**
     * @Route("/genus", name="admin_genus_list")
     */
    public function indexAction()
    {
        $genuses = $this->getDoctrine()
            ->getRepository('AppBundle:Genus')
            ->findAll();

        return $this->render('admin/genus/list.html.twig', array(
            'genuses' => $genuses
        ));
    }

    /**
     * @Route("/genus/new", name="admin_genus_new")
     */
    public function newAction(Request $request)
    {
        //create the form object
       $form = $this->createForm(GenusFormType::class);


        // only handles data on POST
        $form->handleRequest($request);

        //if this is a POST request and if the form passed all validation
        if ($form->isSubmitted() && $form->isValid()) {
            $genus = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $em->persist($genus);
            $em->flush();

            //add msg
            $this->addFlash('success', 'Genus created!');

            //redirect
            return $this->redirectToRoute('admin_genus_list');

        }

       //rendering twig
        return $this->render('admin/genus/new.html.twig', [
            'genusForm' =>$form->createView()
        ]);
    }

    /**
     * @Route("/genus/{id}/edit", name="admin_genus_edit")
     */
    public function editAction(Request $request,Genus $genus)
    {
        //create the form object
        $form = $this->createForm(GenusFormType::class, $genus);


        // only handles data on POST
        $form->handleRequest($request);

        //if this is a POST request and if the form passed all validation
        if ($form->isSubmitted() && $form->isValid()) {
            $genus = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $em->persist($genus);
            $em->flush();

            //add msg
            $this->addFlash('success', 'Genus updated!');

            //redirect
            return $this->redirectToRoute('admin_genus_list');

        }

        //rendering twig
        return $this->render('admin/genus/edit.html.twig', [
            'genusForm' => $form->createView()
        ]);
    }
}