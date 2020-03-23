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
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\EntrepriseType;
use App\Form\StageType;

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
     * @Route("/formation{nomFormation}/stages", name="prostage_stages_pour_formation")
     */
    public function stagesParFormation(StageRepository $repertoireStages, $nomFormation)
    {
        $stages = $repertoireStages->findByNomFormation($nomFormation);
        return $this->render('prostage/listeStagesPar.html.twig',['stages' => $stages]);
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
     * @Route("/entreprise{nomEntreprise}/stages", name="prostage_stages_pour_entreprise")
     */
    public function stagesParEntreprise(StageRepository $repertoireStages,$nomEntreprise)
    {
        $stages = $repertoireStages->findByNomEntreprise($nomEntreprise);
        return $this->render('prostage/listeStagesPar.html.twig',['stages' => $stages]);
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
        $stagesEntreprises = $repertoireStages->findAll();
        return $this->render('prostage/listeStages.html.twig',['stagesEntreprises' => $stagesEntreprises]);
    }


/**
     * @Route("/creer-entreprise", name="prostage_nvelleEntrep")
     */
    public function newEntrep(Request $request, ObjectManager $entityManager)
    {
        $entreprise = new Entreprise();

        $form = $this -> createForm(EntrepriseType::class,$entreprise);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($entreprise);
            $entityManager->flush();

            return $this->redirectToRoute('prostage_entreprises');
       }

        return $this->render('prostage/creerEntreprise.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/modifier-entreprise{id}", name="prostage_modifierEntrep")
     */
    public function editEntrep(Request $request, Entreprise $entreprise, ObjectManager $entityManager)
    {
        $form = $this -> createForm(EntrepriseType::class,$entreprise);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($entreprise);
            $entityManager->flush();

            return $this->redirectToRoute('prostage_entreprises');
       }

        return $this->render('prostage/modifierEntreprise.html.twig', [
            'form' => $form->createView(),
        ]);
    }



/**
     * @Route("/ajouter-stage", name="prostage_nvStage")
     */
    public function newStage(Request $request, ObjectManager $entityManager)
    {
        $stage = new Stage();

        $form = $this -> createForm(StageType::class,$stage);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($stage);
            $entityManager->flush();

            return $this->redirectToRoute('prostage_listeStages');
       }

        return $this->render('prostage/ajouterStage.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}