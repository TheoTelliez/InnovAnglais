<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Utilisateur;
use App\Entity\Abonnements;
use App\Entity\Entreprise;
use App\Entity\Role;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class AppFixtures extends Fixture
{
    private $manager;
    private $repoUser;
    private $faker;
    private $encoder;

    //public function __construct(UserPasswordEncoderInterface $encoder){
    public function __construct(){
        $this->faker=Factory::create("fr_FR");
        //$this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $repoUser = $this->manager->getRepository(Utilisateur::class);

        $this->loadAbonnements();
        $this->loadEntreprise();
        $this->loadRole();
        $this->loadUsers();

        $manager->flush();
    }

    public function loadUsers(){
        for($i=0;$i<10;$i++){
            $user = new Utilisateur();





            $user->setNom($this->faker->lastName())
                ->setPrenom($this->faker->firstName()) ;

            $emailSans = strtolower($user->getPrenom() . "." . $user->getNom(). "@" . $this->faker->freeEmailDomain());
            $emailClear = str_replace('ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ','AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy', $emailSans);

            $emailSans = htmlentities($emailSans, ENT_NOQUOTES, 'utf-8');
            $emailSans = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $emailSans);
            $emailSans = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $emailSans); // pour les ligatures e.g. 'œ'
            $emailSans = preg_replace('#&[^;]+;#', '', $emailSans); // supprime les autres caractères


            $user->setEmail($emailSans)

                //->setPassword($this->encoder->encodePassword($mdpCode))
                ->setPassword(strtolower($user->getNom()))
                ->setAbonnements($this->getReference('abo'.mt_rand(1,2)))
                ->setEntreprise($this->getReference('ent1'))
                ->setRole($this->getReference('role1'));


            //->setDateInscription($this->faker->dateTimeThisYear);
            $this->addReference('user'.$i, $user);
            $this->manager->persist($user);
        }
        $user = new Utilisateur();
        $user->setNom('TELLIEZ')
            ->setPrenom('theo')
            ->setEmail('theo.telliez@epsi.fr')
            ->setPassword('theo')
            ->setAbonnements($this->getReference('abo'.mt_rand(1,2)))
            ->setEntreprise($this->getReference('ent1'))
            ->setRole($this->getReference('role1'));

            //->setDateInscription(new \DateTime());
        $this->addReference('theo', $user);

        $this->manager->flush();

    }

    public function loadAbonnements(){
        /////
        $abo = new Abonnements();
        $abo->setLibelle('Abo1')
            ->setPaiementenunefois('1');

        $this->addReference('abo1', $abo);
        $this->manager->persist($abo);

        /////
        $abo = new Abonnements();
        $abo->setLibelle('Abo2')
            ->setPaiementenunefois('0');

        $this->addReference('abo2', $abo);
        $this->manager->persist($abo);
        /////

        $this->manager->flush();

    }

    public function loadEntreprise(){
        $ent = new Entreprise();
        $ent->setLibelle('Ent1');

        $this->addReference('ent1', $ent);
        $this->manager->persist($ent);
        $this->manager->flush();

    }

    public function loadRole(){
        $role = new Role();
        $role->setLibelle('Role1');

        $this->addReference('role1', $role);
        $this->manager->persist($role);
        $this->manager->flush();

    }

}
