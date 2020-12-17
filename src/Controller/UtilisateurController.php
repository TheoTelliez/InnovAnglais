<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Utilisateur;

use App\Entity\Abonnements;
use App\Entity\Entreprise;
use App\Form\AjoutUtilisateurType;
use App\Form\ModifUtilisateurType;
use App\Form\ImageProfilType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\User;

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
     * @Route("/ajout-utilisateur/{id}", name="ajout-utilisateur", requirements = {"id"="\d+"})
     */
    public function ajoutUtilisateur(Request $request, $id)
    {
        $utilisateur = new Utilisateur(); // Instanciation d’un objet Utilisateur
        if ($id != null){
            $em = $this->getDoctrine()->getRepository(User::class);
            $user = $em->find($id);
            $utilisateur->setUser($user);

        }

        $form = $this->createForm(AjoutUtilisateurType::class, $utilisateur); // Création du formulaire pour ajouter un utilisateur, en lui donnant l’instance .


        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager(); // On récupère le gestionnaire des entités
                $em->persist($utilisateur); // Nous enregistrons notre nouvel utilisateur
                $em->flush(); // Nous validons notre ajout
                $this->addFlash('notice', 'Utilisateur inséré'); // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
            }
            return $this->redirectToRoute('app_login'); // Nous redirigeons l’utilisateur sur l’ajout d’un utilisateur après l’insertion.
        }
        return $this->render('utilisateur/ajout-utilisateur.html.twig', [
            'form' => $form->createView() // Nous passons le formulaire à la vue
        ]);
    }



    /**
     * @Route("/user-profile/{id}", name="user-profile", requirements={"id"="\d+"})
     */
    public function userprofile(int $id, Request $request)
    {

        $em = $this->getDoctrine();
        $repoUtilisateur = $em->getRepository(Utilisateur::class);
        $utilisateur = $repoUtilisateur->find($id);
        if ($utilisateur==null){
            $this->addFlash('notice','Utilisateur introuvable');
            return $this->redirectToRoute('accueil');
        }
        $form = $this->createForm(ImageProfilType::class);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $file = $form->get('photo')->getData();
                try{
                    $fileName = $utilisateur->getId().'.'.$file->guessExtension();
                    $file->move($this->getParameter('profile_directory'),$fileName); // Nous déplaçons lefichier dans le répertoire configuré dans services.yaml
                    $em = $em->getManager();
                    $utilisateur->setPhoto($fileName);
                    $em->persist($utilisateur);
                    $em->flush();
                    $this->addFlash('notice', 'Fichier inséré');

                } catch (FileException $e) {                // erreur durant l’upload            }
                    $this->addFlash('notice', 'Problème fichier inséré');
                }
            }
        }

        if($utilisateur->getPhoto()==null){
            $path = $this->getParameter('profile_directory').'/defaut.png';
        }
        else{
            $path = $this->getParameter('profile_directory').'/'.$utilisateur->getPhoto();
        }
        $data = file_get_contents($path);
        $base64 = 'data:image/png;base64,' . base64_encode($data);

        return $this->render('utilisateur/user-profile.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
            'base64' => $base64
        ]);
    }

    /**
     * @Route("/liste-utilisateurs", name="liste-utilisateurs")
     */
    public function listeUtilisateurs(Request $request)
    {
        $em = $this->getDoctrine();
        $repoUtilisateur = $em->getRepository(Utilisateur::class);
        $utilisateurs = $repoUtilisateur->findBy(array(),array('id'=>'ASC'));
        if ($request->get('supp')!=null){
            $utilisateur = $repoUtilisateur->find($request->get('supp'));
            if($utilisateur!=null){
                $em->getManager()->remove($utilisateur);
                $em->getManager()->flush();
                $this->addFlash('notice', 'Utilisateur supprimé');
            }
            return $this->redirectToRoute('liste-utilisateurs');
        }
        return $this->render('utilisateur/liste-utilisateurs.html.twig', [
            'utilisateurs'=>$utilisateurs // Nous passons la liste des utilisateurs à la vue
        ]);
    }

    /**
     * @Route("/modif-utilisateur/{id}", name="modif-utilisateur", requirements={"id"="\d+"})
     */
    public function modifUtilisateur(int $id, Request $request)
    {
        $em = $this->getDoctrine();
        $repoUtilisateur = $em->getRepository(Utilisateur::class);
        $utilisateur = $repoUtilisateur->find($id);
        if ($utilisateur == null) {
            $this->addFlash('notice', "Cet utilisateur n'existe pas");
            return $this->redirectToRoute('liste-utlisateurs');
        }
        $form = $this->createForm(ModifUtilisateurType::class, $utilisateur);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($utilisateur);
                $em->flush();
                $this->addFlash('notice', 'Utilisateur modifié');
            }
            return $this->redirectToRoute('liste-utilisateurs');
        }
        return $this->render('utilisateur/modif-utilisateur.html.twig', [
            'form' => $form->createView()
        ]);
    }




}
