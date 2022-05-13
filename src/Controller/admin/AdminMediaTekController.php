<?php



namespace App\Controller\admin;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use App\Repository\NiveauxRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AdminMediaTekController
 *
 * @author pierr
 */
class AdminMediaTekController extends AbstractController {
    
    /**
     * 
     * @var EntityManagerInterface
     */
    private $om;






    private const PAGEADMIN = "admin/_admin.html.twig";
    private const ROUTEADMIN = "mediatek.formations";



    /**
     *
     * @var FormationRepository
     */
    private $repository;
    
    /**
     * @var NiveauxRepository $repositoryNiveaux
     */
    private $repositoryNiveaux;
    
    


    /**
     * 
     * @param FormationRepository $repository
     * @param EntityManagerInterface $om
     */
    function __construct(FormationRepository $repository, EntityManagerInterface $om, NiveauxRepository $repositoryNiveaux) {
        $this->repository = $repository;
        $this->repositoryNiveaux = $repositoryNiveaux;
        $this->om = $om;
    }

    /**
     * @Route("/admin", name="admin.mediatek")
     * @return Response
     */
    public function index(): Response{
        $niveaux = $this->repositoryNiveaux->findAll();
        $formations = $this->repository->findAll();
        return $this->render(self::PAGEADMIN, [
            'formations' => $formations,
            'niveaux' => $niveaux
        ]);
    }
    
    /**
     * @Route("/admin/tri/{champ}/{ordre}", name="admin.sort")
     * @param type $champ
     * @param type $ordre
     * @return Response
     */
    public function sort($champ, $ordre): Response{
        $niveaux = $this->repositoryNiveaux->findAllOrderBy($champ, $ordre);
        $formations = $this->repository->findAllOrderBy($champ, $ordre);
        return $this->render(self::PAGEADMIN, [
           'formations' => $formations,
           'niveaux' => $niveaux
        ]);
    }   
        
    /**
     * @Route("/admin/recherche/{champ}", name="admin.findallcontain")
     * @param type $champ
     * @param Request $request
     * @return Response
     */
    public function findAllContain($champ, Request $request): Response{
        if($this->isCsrfTokenValid('filtre_'.$champ, $request->get('_token'))){
            $niveaux = $this->repositoryNiveaux->findAll();
            $valeur = $request->get("recherche");
            if($champ == "niveaux"){
                $formations = $this->repository->findByNiveau("nom", $valeur);
            }
            else{
                $formations = $this->repository->findByContainValue($champ, $valeur);                
            }

            return $this->render(self::PAGEADMIN, [
                'formations' => $formations,
                'niveaux' => $niveaux,
                'niveauchoisi' => $valeur
            ]);
        }
        return $this->redirectToRoute(self::ROUTEADMIN);
    }  
    
    
    /**
     * @Route("/admin/recherche/{champ}", name="admin.findallniveau")
     * @param type $champ
     * @param Request $request
     * @return Response
     */
//   public function findAllNiveau($champ, Request $request): Response{
//       if($this->isCsrfTokenValid('filtre_'.$champ, $request->get('_token'))){
//          $valeur = $request->get("recherche");
//          $formations = $this->repository->findByNiveau($champ, $valeur);
//          return $this->render(self::PAGEADMIN, [
//              'formations' => $formations
//          ]);
//      }
//        return $this->redirectToRoute(self::PAGEADMIN);
//    }     


    
    
    
    /**
     * @Route("/admin/formation/{id}", name="admin.showone")
     * @param type $id
     * @return Response
     */
//    public function showOne($id): Response{
//        $formation = $this->repository->find($id);
//        return $this->render("admin/admin.formation.html.twig", [
//            'formation' => $formation
//        ]);        
//    }


    /**
     * @Route("/admin/suppr/{id}", name="admin.mediatek.suppr")
     * @param Formation $formation
     * @return Response
     */
    public function suppr(Formation $formation, Request $request): Response{
        if($this->isCsrfTokenValid('supp_formation', $request->get('_token'))){
            $this->om->remove($formation);
            $this->om->flush();            
        }

        return $this->redirectToRoute(self::ROUTEADMIN);
    }
    

    
    /**
     * @Route("/admin/edit/{id}", name="admin.mediatek.edit")
     * @param Formation $formation
     * @param Request $request
     * @return Response
     */ 
    public function edit(Formation $formation, Request $request): Response{
        $formFormation = $this->createForm(FormationType::class, $formation);
        
        $formFormation->handleRequest($request);
        if($formFormation->isSubmitted() && $formFormation->isValid()){
            $this->om->flush();
            return $this->redirectToRoute('admin.mediatek');
        }
        if($this->isCsrfTokenValid('edit_formation', $request->get('_token'))){
            return $this->render("admin/admin.formation.edit.html.twig", [
                'requete' => 'edit',
                'formation' => $formation,
                'formformation' => $formFormation->createView()
            ]);
        }
        return $this->redirectToRoute(self::ROUTEADMIN);
    
    }
    
    
    
    
    /**
     * @Route("/admin/ajout", name="admin.mediatek.ajout")
     * @param Request $request
     * @return Response
     */
    public function ajout(Request $request): Response{
        $formation = new Formation();
        $formation->setPublishedAt(new DateTimeImmutable());
        $formFormation = $this->createForm(FormationType::class, $formation);
        
        $formFormation->handleRequest($request);
        if($formFormation->isSubmitted() && $formFormation->isValid()){
            $this->om->persist($formation);
            $this->om->flush();
            return $this->redirectToRoute(self::ROUTEADMIN);
        }
        
//        return $this->render("admin/admin.formation.ajout.html.twig", [
//            'formation' => $formation,
//            'formformation' => $formFormation->createView()
//        ]);
 //   }
        
        if($this->isCsrfTokenValid('ajout_formation', $request->get('_token'))){
            return $this->render("admin/admin.formation.ajout.html.twig", [
                'requete' => 'ajout',
                'formformation' => $formFormation->createView()
            ]);
        }
        return $this->redirectToRoute(self::ROUTEADMIN);
    }
} 
