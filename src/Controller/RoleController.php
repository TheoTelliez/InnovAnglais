<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Role;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\RoleType;
use App\Form\ModifRoleType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Categorie;

class RoleController extends AbstractController
{
    /**
     * @Route("/ajout-role", name="ajout-role")
     */
    public function role(Request $request)
    {
        $role = new Role();
        $form = $this->createForm(RoleType::class, $role);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($role);
                $em->flush();
                $this->addFlash('notice', 'Role inséré');
            }
            return $this->redirectToRoute('role');
        }
        return $this->render('role/role.html.twig', [
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/liste-roles", name="liste-roles")
     */
    public function listeRoles(Request $request)
    {
        $em = $this->getDoctrine();
        $repoRole = $em->getRepository(Role::class);

        if ($request->get('supp')!=null){
            $theme = $repoRole->find($request->get('supp'));
            if($theme!=null){
                $em->getManager()->remove($theme);
                $em->getManager()->flush();
                $this->addFlash('notice', "Le rôle a été supprimé !");
            }
            return $this->redirectToRoute('liste-roles');
        }


        $roles = $repoRole->findBy(array(), array('libelle' => 'ASC'));
        return $this->render('role/liste-roles.html.twig', [
            'roles' => $roles // Nous passons la liste des roles à la vue
        ]);
    }



    /**
     * @Route("/modif-role/{id}", name="modif-role", requirements={"id"="\d+"})
     */
    public function modifRole(int $id, Request $request)
    {
        $em = $this->getDoctrine();
        $repoRole = $em->getRepository(Role::class);
        $role = $repoRole->find($id);
        if ($role == null) {
            $this->addFlash('notice', "Ce rôle n'existe pas");
            return $this->redirectToRoute('liste-roles');
        }
        $form = $this->createForm(ModifRoleType::class, $role);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($role);
                $em->flush();
                $this->addFlash('notice', 'Rôle modifié');
            }
            return $this->redirectToRoute('liste-roles');
        }
        return $this->render('role/modif-role.html.twig', [
            'form' => $form->createView()
        ]);
    }












}
