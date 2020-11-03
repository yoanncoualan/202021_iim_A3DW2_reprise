<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager(); // accès à la bdd

        $categorie = new Categorie(); // objet vide
        $form = $this->createForm(CategorieType::class, $categorie); // Nouveau formulaire
        $form->handleRequest($request); // Analyse la requete HTTP
        if($form->isSubmitted()){ // Si le formulaire a été soumis
            $em->persist($categorie); // prépare la sauvegarde en base
            $em->flush(); // execute la sauvegarde
        }

        $categories = $em->getRepository(Categorie::class)->findAll();

        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
            'ajout' => $form->createView()
        ]);
    }
}
