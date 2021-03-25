<?php

    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\HttpFoundation\Request;
    use App\Entity\Test;
    use App\Entity\Realise;
    use App\Entity\Utilisateur;
    use App\Form\PasserUnTestType;


    class TestController extends AbstractController
    {
        /**
         * @Route("/test", name="test")
         */
        public function passerTest(Request $request)
        {
            $em = $this->getDoctrine()->getManager();
            $repoTest = $em->getRepository(Test::class);
            $repoUtilisateur = $em->getRepository(Utilisateur::class);
            $lesTests = $repoTest->findBy(array(), array('niveau' => 'ASC'));

            $realise = new Realise();

            if ($request->isMethod('POST')) {

                $testId = $_POST['BDidtest'];
                $leTest = $repoTest->findOneBy(array('id' => $testId));
                $realise->setTest($leTest);

                $utilisateurId = $_POST['BDutilisateur'];
                $utilisateur = $repoUtilisateur->findOneBy(array('id' => $utilisateurId));
                $realise->setUtilisateur($utilisateur);

                $score = $_POST['BDscore'];
                $realise->setScore($score);

                $date = new \DateTime();
                $realise->setDatedujour($date);

                $em->persist($realise); // Nous enregistrons notre nouvelle entrée
                $em->flush(); // Nous validons notre ajout

            }

            return $this->render('test/passeruntest.html.twig', [
                'tests' => $lesTests // Nous passons le formulaire à la vue
            ]);
        }
    }
