<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Stage;
use App\Entity\Formation;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

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

                $choixFormation=$faker->randomElement($tableauFormations);
                $stage->addFormation($choixFormation);
                $choixFormation->addStage($stage);
                $entreprise->addStage($stage);
                
                $manager->persist($stage);

            }

         $manager->persist($entreprise);
            
        }
         
        $manager->flush();
    }
}
?>