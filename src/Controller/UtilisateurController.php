<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Utilisateur;
use App\Form\AjoutUtilisateurType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/utilisateur", name="utilisateur")
     */
    public function index(): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

    /**
     * @Route("/ajout-utilisateur", name="ajout-utilisateur")
     */
    public function ajoutUtilisateur(Request $request)
    {
        $utilisateur = new Utilisateur(); // Instanciation d’un objet Utilisateur
        $form = $this->createForm(AjoutUtilisateurType::class, $utilisateur); // Création du formulaire pour ajouter un utilisateur, en lui donnant l’instance .
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager(); // On récupère le gestionnaire des entités
                $em->persist($utilisateur); // Nous enregistrons notre nouvel utilisateur
                $em->flush(); // Nous validons notre ajout
                $this->addFlash('notice', 'Utilisateur inséré'); // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
            }
            return $this->redirectToRoute('ajout-utilisateur'); // Nous redirigeons l’utilisateur sur l’ajout d’un utilisateur après l’insertion.
        }
        return $this->render('utilisateur/ajout-utilisateur.html.twig', [
            'form' => $form->createView() // Nous passons le formulaire à la vue
        ]);
    }


}
