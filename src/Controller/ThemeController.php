<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Theme;
use App\Form\AjoutThemeType;
use App\Form\ModifThemeType;

class ThemeController extends AbstractController
{
    /**
     * @Route("/theme", name="theme")
     */
    public function index(): Response
    {
        return $this->render('theme/index.html.twig', [
            'controller_name' => 'ThemeController',
        ]);
    }

    /**
     * @Route("/ajout-theme", name="ajout-theme")
     */
    public function ajoutTheme(Request $request)
    {
        $theme = new Theme(); // Instanciation d’un objet Theme
        $form = $this->createForm(AjoutThemeType::class, $theme); // Création du formulaire pour ajouter un thème, en lui donnant l’instance .
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager(); // On récupère le gestionnaire des entités
                $em->persist($theme); // Nous enregistrons notre nouveau thème
                $em->flush(); // Nous validons notre ajout
                $this->addFlash('notice', 'Thème inséré'); // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
            }
            return $this->redirectToRoute('ajout-theme'); // Nous redirigeons l’utilisateur sur l’ajout d’un thème après l’insertion.
        }
        return $this->render('theme/ajout-theme.html.twig', [
            'form' => $form->createView() // Nous passons le formulaire à la vue
        ]);
    }

    /**
     * @Route("/liste-themes", name="liste-themes")
     */
    public function listeThemes(Request $request)
    {
        $em = $this->getDoctrine();
        $repoTheme = $em->getRepository(Theme::class);
        if ($request->get('supp')!=null){
            $theme = $repoTheme->find($request->get('supp'));
            if($theme!=null){
                $em->getManager()->remove($theme);
                $em->getManager()->flush();
                $this->addFlash('notice', 'Thème supprimé');
            }
            return $this->redirectToRoute('liste-themes');
        }
        $themes = $repoTheme->findBy(array(), array('libelle' => 'ASC'));
        return $this->render('theme/liste-themes.html.twig', [
            'themes' => $themes // Nous passons la liste des thèmes à la vue
        ]);
    }

    /**
     * @Route("/modif-theme/{id}", name="modif-theme", requirements={"id"="\d+"})
     */
    public function modifTheme(int $id, Request $request)
    {
        $em = $this->getDoctrine();
        $repoTheme = $em->getRepository(Theme::class);
        $theme = $repoTheme->find($id);
        if ($theme == null) {
            $this->addFlash('notice', "Ce thème n'existe pas");
            return $this->redirectToRoute('liste-themes');
        }
        $form = $this->createForm(ModifThemeType::class, $theme);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($theme);
                $em->flush();
                $this->addFlash('notice', 'Thème modifié');
            }
            return $this->redirectToRoute('liste-themes');
        }
        return $this->render('theme/modif-theme.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
