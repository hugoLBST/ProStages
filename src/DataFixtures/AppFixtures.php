<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Stage;
use App\Entity\Formation;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $hugo = new User();
        $hugo->setUsername("hugol");
        $hugo->setNom("labastie");
        $hugo->setPrenom("hugo");
        $hugo->setPassword('$2y$10$elIsoC3fFcq2LwtttlqfxeUSebcQks8yejCtokJAaSD57uLvgNwtq');
        $hugo->setRoles(["ROLE_ADMIN","ROLE_USER"]);
        $manager->persist($hugo);

        $dupond = new User();
        $dupond->setUsername("dupondj");
        $dupond->setNom("dupond");
        $dupond->setPrenom("jean");
        $dupond->setPassword('$2y$10$DsCo4q1h2s2W0R5jvySxku4bKtnQ6EREvXhonZCtB.YhHD.5ihW0C');
        $dupond->setRoles(["ROLE_USER"]);
        $manager->persist($dupond);

		//Générateur faker
		$faker=\Faker\Factory::create('fr_FR');
        
        
        //Génération de formations
        $formation1 = new Formation();
        $formation1 -> setNom("DUT Informatique");
        $manager->persist($formation1);

        $formation2 = new Formation();
        $formation2 -> setNom("LP Prog avancée");
        $manager->persist($formation2);

        $formation3 = new Formation();
        $formation3 -> setNom("DUT TIC");
        $manager->persist($formation3);

        $tableauFormations=array($formation1,$formation2,$formation3);

        //Génération d'entreprises
        
        $nbEnt=10;
        $nbStages=2;

        for ($i=0; $i <= $nbEnt ; $i++) { 

         $entreprise = new Entreprise();
         $nomEnt=$faker->company();
         $entreprise->setNom($nomEnt);
         $entreprise->setActivite($faker->text($maxNbChars = 100));		 
		 $entreprise->setAdresse($faker->address());
		 $entreprise->setSite($faker->regexify('www\.'.$nomEnt.'\.com'));
         
            for ($j=0; $j <= $nbStages ; $j++) { 
                
                $stage = new Stage();
                $stage->setTitre($faker->realText($maxNbChars = 100, $indexSize = 1));
                $stage->setDescription($faker->text($maxNbChars = 100));		 
                $stage->setMail($faker->companyEmail());


                $stage->setEntreprise($entreprise);
                
                $nbF=$faker->randomElement($array=array(1,2,3));
                $choixFormation=$faker->randomElements($tableauFormations,$nbF);

                foreach ($choixFormation as $forma) {
                    $stage->addFormation($forma);
                    $forma->addStage($stage);
                }

                
                $entreprise->addStage($stage);
                
                $manager->persist($stage);

            }

         $manager->persist($entreprise);
            
        }
         
        $manager->flush();
    }
}
?>