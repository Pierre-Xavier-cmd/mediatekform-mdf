<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FormationRepository;
use App\Repository\NiveauxRepository;
/**
 * Description of FormationsController
 *
 * @author emds
 */
class FormationsController extends AbstractController {
    
    private const PAGEFORMATIONS = "pages/formations.html.twig";

    /**
     *
     * @var FormationRepository
     */
    private $repository;

    /**
     * 
     * @param NiveauxRepository $repositoryNiveaux
     */
    private $repositoryNiveaux;
    
    
    
    
    /**
     * 
     * @param FormationRepository $repository
     * @param NiveauxRepository $repositoryNiveaux
     */
    function __construct(FormationRepository $repository, NiveauxRepository $repositoryNiveaux) {
        $this->repository = $repository;
        $this->repositoryNiveaux = $repositoryNiveaux;
    }

    /**
     * @Route("/formations", name="formations")
     * @return Response
     */
    public function index(): Response{
        $niveaux = $this->repositoryNiveaux->findAll();
        $formations = $this->repository->findAll();
        return $this->render(self::PAGEFORMATIONS, [
            'formations' => $formations,
            'niveaux' => $niveaux,
        ]);
    }
    
    /**
     * @Route("/formations/tri/{champ}/{ordre}", name="formations.sort")
     * @param type $champ
     * @param type $ordre
     * @return Response
     */
    public function sort($champ, $ordre): Response{
        $niveaux = $this->repositoryNiveaux->findAll();
        $formations = $this->repository->findAllOrderBy($champ, $ordre);
        return $this->render(self::PAGEFORMATIONS, [
           'formations' => $formations,
           'niveaux' => $niveaux
        ]);
    }
        
    /**
    /**
     * @Route("/formations/recherche/{champ}", name="formations.findallcontain")
     * @param type $champ
     * @param Request $request
     * @return Response
     */
    public function findAllContain($champ, Request $request): Response{
        if($this->isCsrfTokenValid('filtre_'.$champ, $request->get('_token'))){
            $niveaux = $this->repositoryNiveau->findAll();
            $valeur = $request->get("recherche");
            if ($champ == "niveau") {
                $formations = $this->repository->findByLevel("libelle", $valeur);
            }
            else {
                $formations = $this->repository->findByContainValue($champ, $valeur);
            }
            return $this->render(self::PAGEFORMATIONS, [
                'formations' => $formations,
                'niveaux' => $niveaux,
                'niveauchoisi' => $valeur
            ]);
        }
        return $this->redirectToRoute("formations");
    }
    
    
    /**
     * @Route("/formations/recherche/{champ}", name="formations.findallniveau")
     * @param type $champ
     * @param Request $request
     * @return Response
     */
    public function findAllNiveau($champ, Request $request): Response{
        if($this->isCsrfTokenValid('filtre_'.$champ, $request->get('_token'))){
            $valeur = $request->get("recherche");
            $formations = $this->repository->findByNiveau($champ, $valeur);
            return $this->render(self::PAGEFORMATIONS, [
                'formations' => $formations
            ]);
        }
        return $this->redirectToRoute("formations");
    }     


    
    
    /**
     * @Route("/formations/formation/{id}", name="formations.showone")
     * @param type $id
     * @return Response
     */
    public function showOne($id): Response{
        $niveaux = $this->repositoryNiveaux->findAll();
        $formation = $this->repository->find($id);
        return $this->render("pages/formation.html.twig", [
            'formation' => $formation,
            'niveaux' => $niveaux
        ]);        
    }      
}
