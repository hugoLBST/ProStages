<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProstageController extends AbstractController
{
    /**
     * @Route("/", name="prostage_accueil")
     */
    public function index()
    {
        return $this->render('prostage/index.html.twig', [
            'controller_name' => 'ProstageController',
        ]);
    }

    /**
     * @Route("/formations", name="prostage_formations")
     */
    public function formations()
    {
        return $this->render('prostage/formations.html.twig', [
            'controller_name' => 'ProstageController',
        ]);
    }

    /**
     * @Route("/entreprises", name="prostage_entreprises")
     */
    public function entreprises()
    {
        return $this->render('prostage/entreprises.html.twig', [
            'controller_name' => 'ProstageController',
        ]);
    }

    /**
     * @Route("/stages/{idstage}", name="prostage_stages")
     */
    public function stages($idstage)
    {
        return $this->render('prostage/stages.html.twig', [
            'controller_name' => 'ProstageController','idstage' => $idstage
        ]);
    }

/**
     * @Route("/stages", name="prostage_listeStages")
     */
    public function listeStages()
    {
        return $this->render('prostage/listeStages.html.twig', [
            'controller_name' => 'ProstageController',
        ]);
    }


}

