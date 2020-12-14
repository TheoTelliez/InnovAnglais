<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\CategorieType;
use App\Form\ModifCategorieType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;



class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function categorie(Request $request)
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($categorie);
                $em->flush();
                $this->addFlash('notice', 'Categorie insérée');
            }
            return $this->redirectToRoute('categorie');
        }
        return $this->render('categorie/categorie.html.twig', [
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/liste-categories", name="liste-categories")
     */
    public function listecategories(Request $request)
    {
        $em = $this->getDoctrine();
        $repoCategorie = $em->getRepository(Categorie::class);

        if ($request->get('supp')!=null){
            $cat = $repoCategorie->find($request->get('supp'));
            if($cat!=null){
                $em->getManager()->remove($cat);
                $em->getManager()->flush();
                $this->addFlash('notice', "La catégorie a été supprimé !");
            }
            return $this->redirectToRoute('liste-categories');
        }


        $categories = $repoCategorie->findBy(array(), array('libelle' => 'ASC'));
        return $this->render('categorie/liste-categories.html.twig', [
            'categories' => $categories // Nous passons la liste des categories à la vue
        ]);
    }



    /**
     * @Route("/modif-categorie/{id}", name="modif-categorie", requirements={"id"="\d+"})
     */
    public function modifCategorie(int $id, Request $request)
    {
        $em = $this->getDoctrine();
        $repoCategorie = $em->getRepository(Categorie::class);
        $categorie = $repoCategorie->find($id);
        if ($categorie == null) {
            $this->addFlash('notice', "Cette catégorie n'existe pas");
            return $this->redirectToRoute('liste-categories');
        }
        $form = $this->createForm(ModifCategorieType::class, $categorie);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($categorie);
                $em->flush();
                $this->addFlash('notice', 'Catégorie modifiée');
            }
            return $this->redirectToRoute('liste-categories');
        }
        return $this->render('categorie/modif-categorie.html.twig', [
            'form' => $form->createView()
        ]);
    }




}
