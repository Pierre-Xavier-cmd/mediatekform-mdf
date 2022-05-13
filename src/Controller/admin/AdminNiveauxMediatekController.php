<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller\admin;



use App\Entity\Niveaux;
use App\Repository\NiveauxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AdminNiveauxMediatekController
 *
 * @author pierr
 */
class AdminNiveauxMediatekController {
    private const ADMINNIVEAUX = "admin/admin.niveaux.html.twig";
    private const ADMINNIVEAUXROUTE = "admin.niveaux";
    
    
    /**
     *
     * @var NiveauxRepository
     */
    private $repository;
    
    
    /**
     * 
     * @var EntityManagerInterface
     */
    private $om;
    
    
    /**
     * 
     * @param NiveauxRepository $repository
     */
    public function __construct(NiveauxRepository $repository, EntityManagerInterface $om) {
        $this->repository = $repository;
        $this->om = $om;
    }    
    
    
    /**
     * @Route("/admin/niveaux", name="admin.niveaux")
     * @return Response
     */
    public function index(): Response{
        $niveaux = $this->repository->findAll();
        return $this->render(self::ADMINNIVEAUX, [
            'niveaux' => $niveaux,
            'erreur' => null
        ]);
    }
    
    
    /**
     * @Route("admin/niveaux/suppr/{id}", name="admin.niveaux.suppr")
     * @param Niveaux $niveaux
     * @return Response
     */
    public function suppr(Niveaux $niveau, Request $request): Response{
        if($niveau->getFormations()->count() === 0 && $this->isCsrfTokenValid('suppr_niveaux', $request->get('_token'))){
            $this->om->remove($niveaux);
            $this->om->flush();
        }
        return $this->redirectToRoute(self::ADMINNIVEAUXROUTE);
    }
    
    
    /**
     * @Route("/admin/niveaux/ajout", name="admin.niveau.ajout")
     * @param Request $request
     * @return Response
     */
    public function ajout(Request $request): Response {
        if($this->isCsrfTokenValid('ajout_niveaux', $request->get('_token'))){
            $niveau = new Niveau();
            $nom = $request->get('nouveau_niveaux');
            
            if (strlen($nom) === 0 || strlen($nom) > 15) {
                $niveaux = $this->repository->findAll();
                return $this->render(self::ADMINNIVEAUX, [
                    'niveaux' => $niveaux,
                    'erreur' => "Nom de niveau invalide"
                ]);
            }
            else {
                $niveau->setLibelle($nom);
                $this->om->persist($niveaux);
                $this->om->flush();
            }
        }
        return $this->redirectToRoute(self::ADMINNIVEAUXROUTE);
    }
}

