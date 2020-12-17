<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Abonnements;
use App\Form\AjoutAbonnementType;
use App\Form\ModifAbonnementType;

class AbonnementController extends AbstractController
{
    /**
     * @Route("/abonnement", name="abonnement")
     */
    public function index(): Response
    {
        return $this->render('abonnement/index.html.twig', [
            'controller_name' => 'AbonnementController',
        ]);
    }

    /**
     * @Route("/ajout-abonnement", name="ajout-abonnement")
     */
    public function ajoutAbonnement(Request $request)
    {
        $abonnement = new Abonnements(); // Instanciation d’un objet Abonnement
        $form = $this->createForm(AjoutAbonnementType::class, $abonnement); // Création du formulaire pour ajouter un thème, en lui donnant l’instance .
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager(); // On récupère le gestionnaire des entités
                $em->persist($abonnement); // Nous enregistrons notre nouveau abonnement
                $em->flush(); // Nous validons notre ajout
                $this->addFlash('notice', 'Abonnement inséré'); // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
            }
            return $this->redirectToRoute('ajout-abonnement'); // Nous redirigeons l’utilisateur sur l’ajout d’un abonnement après l’insertion.
        }
        return $this->render('abonnement/ajout-abonnement.html.twig', [
            'form' => $form->createView() // Nous passons le formulaire à la vue
        ]);
    }

    /**
     * @Route("/liste-abonnements", name="liste-abonnements")
     */
    public function listeAbonnements(Request $request)
    {
        $em = $this->getDoctrine();
        $repoAbo = $em->getRepository(Abonnements::class);
        if ($request->get('supp')!=null){
            $abonnement = $repoAbo->find($request->get('supp'));
            if($abonnement!=null){
                $em->getManager()->remove($abonnement);
                $em->getManager()->flush();
                $this->addFlash('notice', 'Abonnement supprimé');
            }
            return $this->redirectToRoute('liste-abonnements');
        }
        $abonnements = $repoAbo->findBy(array(), array('libelle' => 'ASC'));
        return $this->render('abonnement/liste-abonnements.html.twig', [
            'abonnements' => $abonnements // Nous passons la liste des thèmes à la vue
        ]);
    }

    /**
     * @Route("/modif-abonnement/{id}", name="modif-abonnement", requirements={"id"="\d+"})
     */
    public function modifAbonnement(int $id, Request $request)
    {
        $em = $this->getDoctrine();
        $repoAbo = $em->getRepository(Abonnements::class);
        $abonnement = $repoAbo->find($id);
        if ($abonnement == null) {
            $this->addFlash('notice', "Ce Abonnement n'existe pas");
            return $this->redirectToRoute('liste-abonnements');
        }
        $form = $this->createForm(ModifAbonnementType::class, $abonnement);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($abonnement);
                $em->flush();
                $this->addFlash('notice', 'Abonnement modifié');
            }
            return $this->redirectToRoute('liste-abonnements');
        }
        return $this->render('abonnement/modif-abonnement.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/stats-abonnements", name="stats-abonnements")
     */
    public function statsabonnements(Request $request)
    {
        // LA BASE

        $em = $this->getDoctrine();
        $repoAbo = $em->getRepository(Abonnements::class);

        // ON ETABLI LA CONNEXION

        $conn = $this->getDoctrine()->getManager()->getConnection();

        // POUR LA LISTE AVEC ID, LIBELLE, etc

        $sqlListeAbo = '
            SELECT a.libelle, COUNT(*) as NbParAbo FROM utilisateur u, abonnements a WHERE a.id=u.abonnement_id GROUP BY u.abonnement_id
            ';
        $liste = $conn->prepare($sqlListeAbo);
        $liste->execute(array());



        // POUR LE RENDER
        // Nous passons la liste des entreprises + le count à la vue

        return $this->render('abonnement/stats-abonnements.html.twig', [
            'abonnements' => $liste, //ICI C'EST AVEC L'ID ET LE LIBELLE
        ]);
    }



}
