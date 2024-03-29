<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Utilisateur;
use App\Entity\Abonnements;
use App\Entity\Entreprise;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Mot;
use App\Entity\Categorie;
use App\Entity\Theme;
use App\Entity\Liste;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    private $manager;
    private $repoUser;
    private $faker;
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        //public function __construct(){
        $this->faker = Factory::create("fr_FR");
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $repoUser = $this->manager->getRepository(Utilisateur::class);

        $this->loadTheme();
        $this->loadAbonnements();
        $this->loadEntreprise();
        $this->loadRole();
        $this->loadCat();
        $this->loadMot();
        $this->loadListe();
        $this->loadUtilisateurs();
        $this->loadUsers();

        $manager->flush();
    }

    public function loadUtilisateurs()
    {
        for ($i = 0; $i < 10; $i++) {
            $utilisateur = new Utilisateur();

            $utilisateur->setNom($this->faker->lastName())
                ->setPrenom($this->faker->firstName());


            $utilisateur->setAbonnement($this->getReference('abo' . mt_rand(0, 9)))
                ->setEntreprise($this->getReference('ent' . mt_rand(0, 9)));


            $this->addReference('utilisateur' . $i, $utilisateur);
            $this->manager->persist($utilisateur);
        }
        $utilisateur = new Utilisateur();
        $utilisateur->setNom('TELLIEZ')
            ->setPrenom('theo')
            ->setAbonnement($this->getReference('abo' . mt_rand(0, 9)))
            ->setEntreprise($this->getReference('ent1'));
        //->setUsers($this->getReference('user10'));

        //->setDateInscription(new \DateTime());
        $this->addReference('theo', $utilisateur);

        $this->manager->flush();

    }

    public function loadUsers()
    {

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $utilisateur = $this->getReference('utilisateur' . $i);

            $emailSans = strtolower($utilisateur->getPrenom() . "." . $utilisateur->getNom() . "@" . $this->faker->freeEmailDomain());

            $emailSans = htmlentities($emailSans, ENT_NOQUOTES, 'utf-8');
            $emailSans = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $emailSans);
            $emailSans = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $emailSans); // pour les ligatures e.g. 'œ'
            $emailSans = preg_replace('#&[^;]+;#', '', $emailSans); // supprime les autres caractères


            $user->setEmail(strtolower($emailSans))
                ->setPassword($this->encoder->encodePassword($user, 'test'))
                ->setRoles(array('ROLE_USER'));

            $user->setUtilisateur($utilisateur);
            $utilisateur->setUser($user);

            $this->manager->persist($utilisateur);

            $this->addReference('user' . $i, $user);
            $this->manager->persist($user);
        }


    }


    public function loadAbonnements()
    {

        for ($i = 0; $i < 10; $i++) {
            $abo = new Abonnements();

            $abo->setLibelle("Abonnement" . $i)
                ->setPaiementenunefois(mt_rand(0, 1));

            $this->addReference('abo' . $i, $abo);
            $this->manager->persist($abo);
        }

    }

    public function loadEntreprise()
    {
        for ($i = 0; $i < 10; $i++) {
            $ent = new Entreprise();

            $ent->setLibelle("Entreprise" . $i);

            $this->addReference('ent' . $i, $ent);
            $this->manager->persist($ent);
        }

    }

    public function loadRole()
    {

        $role = new Role();

        $role->setLibelle("ROLE_USER");

        $this->manager->persist($role);

        //--------

        $role = new Role();

        $role->setLibelle("ROLE_ADMIN");

        $this->manager->persist($role);


    }

    public function loadMot()
    {
        $mot = new Mot();

        $mot->setLibelle("Pomme")
            ->setLibelleen("Apple")
            ->setCategorie($this->getReference('cat' . mt_rand(0, 9)));

        $this->addReference('mot1', $mot);
        $this->manager->persist($mot);

        //-----

        $mot = new Mot();

        $mot->setLibelle("Peche")
            ->setLibelleen("Peach")
            ->setCategorie($this->getReference('cat' . mt_rand(0, 9)));

        $this->addReference('mot2', $mot);
        $this->manager->persist($mot);

        //-----

        $mot = new Mot();

        $mot->setLibelle("Ordinateur")
            ->setLibelleen("Computer")
            ->setCategorie($this->getReference('cat' . mt_rand(0, 9)));

        $this->addReference('mot3', $mot);
        $this->manager->persist($mot);


    }

    public function loadCat()
    {
        for ($i = 0; $i < 10; $i++) {
            $cat = new Categorie();

            $cat->setLibelle("Categorie" . $i);

            $this->addReference('cat' . $i, $cat);
            $this->manager->persist($cat);
        }

    }

    public function loadTheme()
    {
        for ($i = 0; $i < 2; $i++) {
            $tem = new Theme();

            $tem->setLibelle("Theme" . $i);

            $this->addReference('tem' . $i, $tem);
            $this->manager->persist($tem);
        }

    }

    public function loadListe()
    {

        $liste = new Liste();

        $liste->setLibelle("Liste1")
            ->setEntreprise($this->getReference('ent' . mt_rand(0, 9)))
            ->setTheme($this->getReference('tem' . mt_rand(0, 1)))
            ->addMot(($this->getReference('mot1')))
            ->addMot(($this->getReference('mot2')));

        $this->addReference('liste1', $liste);
        $this->manager->persist($liste);

        //-------


        $liste = new Liste();

        $liste->setLibelle("Liste2")
            ->setEntreprise($this->getReference('ent' . mt_rand(0, 9)))
            ->setTheme($this->getReference('tem' . mt_rand(0, 1)))
            ->addMot(($this->getReference('mot3')));

        $this->addReference('liste2', $liste);
        $this->manager->persist($liste);


    }


}