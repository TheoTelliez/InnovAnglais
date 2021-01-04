<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Test;
use App\Form\PasserUnTestType;


class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function passerTest(Request $request)
    {
        $test = new Test();
        $form = $this->createForm(PasserUnTestType::class, $test); // Création du formulaire pour ajouter un thème, en lui donnant l’instance .
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
        }
        return $this->render('test/passeruntest.html.twig', [
            'form' => $form->createView() // Nous passons le formulaire à la vue
        ]);
    }
}
