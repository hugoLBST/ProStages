<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Repository\FormationRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\StageRepository;
class ProstageController extends AbstractController
{
    /**
     * @Route("/", name="prostage_accueil")
     */
    public function index()
    {
        return $this->render('prostage/index.html.twig');
    }

    /**
     * @Route("/formations", name="prostage_formations")
     */
    public function formations(FormationRepository $repertoireFormations)
    {
        
        $formations = $repertoireFormations->findAll();
        return $this->render('prostage/formations.html.twig',['formations' => $formations]);
    }

     /**
     * @Route("/formation{formation}/stages", name="prostage_stages_pour_formation")
     */
    public function stagesParFormation(StageRepository $repertoireStages, $formation)
    {

        $stages = $repertoireStages->findByFormation($formation);
        return $this->render('prostage/listeStages.html.twig',['stages' => $stages]);
    }

    /**
     * @Route("/entreprises", name="prostage_entreprises")
     */
    public function entreprises(EntrepriseRepository $repertoireEntreprises)
    {
        $entreprises = $repertoireEntreprises->findAll();
        return $this->render('prostage/entreprises.html.twig',['entreprises' => $entreprises]);
    }

    /**
     * @Route("/entreprise{entrep}/stages", name="prostage_stages_pour_entreprise")
     */
    public function stagesParEntreprise(StageRepository $repertoireStages,$entrep)
    {
        $stages = $repertoireStages->findByEntreprise($entrep);
        return $this->render('prostage/listeStages.html.twig',['stages' => $stages]);
    }

    /**
     * @Route("/stages/{idstage}", name="prostage_detailsstage")
     */
    public function detailsStage(StageRepository $repertoireStages,$idstage)

    {
        $stage = $repertoireStages->find($idstage);
        return $this->render('prostage/stage.html.twig',['stage'=>$stage]);
    }

/**
     * @Route("/stages", name="prostage_listeStages")
     */
    public function listeStages(StageRepository $repertoireStages)
    {

        $stages = $repertoireStages->findAll();
        return $this->render('prostage/listeStages.html.twig',['stages' => $stages]);
    }


}

