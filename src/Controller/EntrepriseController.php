<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;;
use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\EntrepriseType;
use App\Form\AjoutEntrepriseType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;

class EntrepriseController extends AbstractController
{
    /**
     * @Route("/entreprise", name="entreprise")
     */
    public function index(): Response
    {
        return $this->render('entreprise/index.html.twig', [
            'controller_name' => 'EntrepriseController',
        ]);
    }


    /**
     * @Route("/liste-entreprises", name="liste-entreprises")
     */
    public function listeentreprises(Request $request)
    {
        // LA BASE

        $em = $this->getDoctrine();
        $repoEntreprise = $em->getRepository(Entreprise::class);

        // ON ETABLI LA CONNEXION

        $conn = $this->getDoctrine()->getManager()->getConnection();

        // POUR SUPPRIMER

        if ($request->get('supp')!=null){
            $ent = $repoEntreprise->find($request->get('supp'));
            if($ent!=null){
                $em->getManager()->remove($ent);
                $em->getManager()->flush();
                $this->addFlash('notice', 'Entreprise supprimée');
            }
            return $this->redirectToRoute('liste-entreprises');
        }

        // POUR LA LISTE AVEC ID, LIBELLE, etc

        $sqlListe = '
            SELECT * FROM entreprise WHERE 1
            ';
        $liste = $conn->prepare($sqlListe);
        $liste->execute(array());


        // POUR LE COUNT

        $sqlCount = '
            SELECT COUNT(*) as NbEnt FROM entreprise  WHERE 1
            ';
        $count = $conn->prepare($sqlCount);
        $count->execute(array());

        // POUR LE RENDER
        // Nous passons la liste des entreprises + le count à la vue

        return $this->render('entreprise/liste-entreprises.html.twig', [
            'entreprises' => $liste, //ICI C'EST AVEC L'ID ET LE LIBELLE
            'count' => $count // ICI C'EST AVEC LE COUNT
        ]);
    }


    /**
     * @Route("/ajout-entreprise", name="ajout-entreprise")
     */
    public function ajoutentreprise(Request $request)
    {
        $entreprise = new Entreprise(); // Instanciation d’un objet Entreprise
        $form = $this->createForm(AjoutEntrepriseType::class, $entreprise); // Création du formulaire pour ajouter une entreprise, en lui donnant l’instance .
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager(); // On récupère le gestionnaire des entités
                $em->persist($entreprise); // Nous enregistrons notre nouvelle entreprise
                $em->flush(); // Nous validons notre ajout
                $this->addFlash('notice', 'Entreprise insérée'); // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
            }
            return $this->redirectToRoute('liste-entreprises'); // Nous redirigeons l’utilisateur
        }
        return $this->render('entreprise/ajout-entreprise.html.twig', [
            'form' => $form->createView() // Nous passons le formulaire à la vue
        ]);
    }

}
