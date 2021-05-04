<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Niveau;
use App\Entity\Specialite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
     }
    public function load(ObjectManager $manager)
    {
         $user = new User();
         $niveau1 = new Niveau();
         $niveau2 = new Niveau();
         $niveau3 = new Niveau();
         $specialite1 = new Specialite();
         $specialite2 = new Specialite();
         $specialite3 = new Specialite();
         $niveau1->setNom("Licence 1");
         $niveau2->setNom("Licence 2");
         $niveau3->setNom("Licence 3");
         $specialite1->setNom("GLSI");
         $specialite2->setNom("ASR");
         $specialite3->setNom("MTWI");
         $user->setEmail("admino@yopmail.com");
         $user->setRoles(["ROLE_ADMIN"]);
         $user->setPassword($this->passwordEncoder->encodePassword(
                         $user,
                         'admin'
                     ));
         $manager->persist($user);
         $manager->persist($niveau1);
         $manager->persist($niveau2);
         $manager->persist($niveau3);
         $manager->persist($specialite1);
         $manager->persist($specialite2);
         $manager->persist($specialite3);

        $manager->flush();
    }
}
