<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Mot;
use App\Form\AjoutMotType;
use App\Form\ModifMotType;

class MotController extends AbstractController
{
    /**
     * @Route("/mot", name="mot")
     */
    public function index(): Response
    {
        return $this->render('mot/index.html.twig', [
            'controller_name' => 'ThemeController',
        ]);
    }

    /**
     * @Route("/ajout-mot", name="ajout-mot")
     */
    public function ajoutMot(Request $request)
    {
        $mot = new Mot(); // Instanciation d’un objet Theme
        $form = $this->createForm(AjoutMotType::class, $mot); // Création du formulaire pour ajouter un thème, en lui donnant l’instance .
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager(); // On récupère le gestionnaire des entités
                $em->persist($mot); // Nous enregistrons notre nouveau thème
                $em->flush(); // Nous validons notre ajout
                $this->addFlash('notice', 'Mot inséré'); // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
            }
            return $this->redirectToRoute('ajout-mot'); // Nous redirigeons l’utilisateur sur l’ajout d’un thème après l’insertion.
        }
        return $this->render('mot/ajout-mot.html.twig', [
            'form' => $form->createView() // Nous passons le formulaire à la vue
        ]);
    }

    /**
     * @Route("/liste-mots", name="liste-mots")
     */
    public function listeMots(Request $request)
    {
        $em = $this->getDoctrine();
        $repoMot = $em->getRepository(Mot::class);
        if ($request->get('supp')!=null){
            $mot = $repoMot->find($request->get('supp'));
            if($mot!=null){
                $em->getManager()->remove($mot);
                $em->getManager()->flush();
                $this->addFlash('notice', 'Mot supprimé');
            }
            return $this->redirectToRoute('liste-mots');
        }
        $mots = $repoMot->findBy(array(), array('libelle' => 'ASC'));
        return $this->render('mot/liste-mots.html.twig', [
            'mots' => $mots // Nous passons la liste des thèmes à la vue
        ]);
    }

    /**
     * @Route("/modif-mot/{id}", name="modif-mot", requirements={"id"="\d+"})
     */
    public function modifMot(int $id, Request $request)
    {
        $em = $this->getDoctrine();
        $repoMot = $em->getRepository(Mot::class);
        $mot = $repoMot->find($id);
        if ($mot == null) {
            $this->addFlash('notice', "Ce mot n'existe pas");
            return $this->redirectToRoute('liste-mot');
        }
        $form = $this->createForm(ModifMotType::class, $mot);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($mot);
                $em->flush();
                $this->addFlash('notice', 'Mot modifié');
            }
            return $this->redirectToRoute('liste-mots');
        }
        return $this->render('mot/modif-mot.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
