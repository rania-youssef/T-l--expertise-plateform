<?php
namespace App\Controller;
use App\Entity\User;
use App\Entity\Images;
use App\Entity\Demande;
use App\Entity\ReponseD;
use App\Entity\ExamenBio;
use App\Entity\ExamenATCD;
use App\Form\ReponseDType;
use App\Entity\Commentaire;
use App\Entity\DemandeRens;
use App\Entity\ExamenRadio;
use App\Entity\Specialiste;
use App\Form\ExamenRadioType;
use App\Entity\ExamenClinique;
use App\Entity\PropertySearch;;
use App\Form\PropertySearchType;
use App\Repository\DemandeRepository;
use App\Repository\SpecialisteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    /**
     * @Route("/specialiste")
     * @IsGranted("ROLE_SPECIALISTE")
     */
class SpecialisteController extends AbstractController
{      /**
    * @Route("/profilS", name="profilS")
    */
public function ProfilS(?UserInterface $user , SpecialisteRepository $SpecialisteRep): Response
  { return $this->render('profilSpecialisteS.html.twig',array(
   'specialiste' => $SpecialisteRep->SpecialisteFindByUser($user->getId())));
   } 
         /**
         * @Route("/listdemandeS", name="listdemandeS")
        */ 
        public function listdemandeS(?UserInterface $user,DemandeRepository $demandeRep){
          $demande=$demandeRep->demandeAttrib($user->getId());
         return $this->render('demande/listedemandeSpecialiste.html.twig',["demande"=>$demande]);
        }
        /**
         * @Route("/showdemandeS/{id}" , name="showdemandeS")
        */
        public function showdemandeS($id) {
          $demande = $this->getDoctrine()->getRepository(Demande::class)->find($id);
          return $this->render('demande/showDemandeSpecialiste.html.twig',array('demande'=> $demande));
        }
          
       /**
         * @Route("/repondre/{id}", name="repondre")
         * 
         */
        public function repondre($id,SpecialisteRepository $specialisteRep,?UserInterface $user, request $request) {
          $demande = $this->getDoctrine()->getRepository(Demande::class)->find($id);
          $reponse= new ReponseD();
          $date=new \DateTime('@'.strtotime('now'));
          $reponse->setDate($date);
          $reponse->setDemande($demande);
          $reponse->setSpecialiste($specialisteRep->SpecialisteFindByUser($user->getId()));
          $form=$this->createForm(ReponseDType::class,$reponse);
          if($form->isSubmitted()) {
            $commentaire= $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reponse);
            //exécution de l'ajout
            $entityManager->flush();
            return $this->redirectToRoute("listReponseS",["id"=>$id]);}
      return $this->render('demande/repondre.html.twig',array('demande' => $demande,'form'=>$form->createView()));
      }
    
        
           /**
         * @Route("/listReponseS/{id}", name="listReponseS")
        */ 
        public function listReponseS(?UserInterface $user,$id,ReponseDRepository $reponseRep){
         $iduser=$user->getId();
          return $this->render("listeReponseS.html.twig",["reponses"=>$reponseRep->findReponseDbyspecialiste($iduser,$id), "id"=>$id]);
        }
      
          
          /**
         * @Route("/deleteReponse/{id}/{idD}", name="deleteReponse")
         *  method=({"DELETE"})
         */
    public function deleteReponse(Request $request, $id,$idD)
    {
        $reponse=$this->getDoctrine()->getRepository(ReponseD::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($reponse);
        $entityManager->flush(); 
        return $this->redirectToRoute('listReponseS',["id"=>$idD]);
        }
         /**
         * @Route("/deleteprofilS/{id}", name="deleteprofilS")
         *  method=({"DELETE"})
         */
    public function deleteprofilS(Request $request, $id)
    {  $specialiste = $this->getDoctrine()->getRepository(Specialiste::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($specialiste);
        $entityManager->flush(); 
        return $this->redirectToRoute('accueil');
    }
    /**
    * @Route("/editprofilS/{id}", name="editprofilS")
    * 
    */
    public function editprofil($id,request $request) {
      $specialiste = $this->getDoctrine()->getRepository(Specialiste::class)->find($id);
      if($specialiste->getEtat()=="Réfusé"){
      $specialiste->setEtat("En attente d'acceptation");}
      $form = $this->createFormBuilder(SpecialisteType::class,$specialiste);
         // création d'une liste déroulante
       $form->handleRequest($request);
       if($form->isSubmitted()) {
        $image = $form->get('photo')->getData();
        $img = $form->get('dossier')->getData();

        if($image){
            
        $fichier = md5(uniqid()) . '.' . $image->guessExtension();
    // On copie le fichier dans le dossier uploads
        $image->move(
            $this->getParameter('images_directory'),
            $fichier
        );
        $generaliste->setPhoto($fichier);}
            foreach($img as $img){
            $fichier= md5(uniqid()) . '.' . $img->guessExtension();
        // On copie le fichier dans le dossier uploads
            $img->move(
                $this->getParameter('images_directory'),
                $fichier
            );
         $tabfichier[]=$fichier;
        $generaliste->setDossier($tabfichier);}
           $specialiste= $form->getData();
           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($specialiste);
          //exécution de l'ajout
           $entityManager->flush();
             return $this->redirectToRoute("profilS",["id"=>$id]);}
             return $this->render('demande/editprofilS.html.twig', [
              'form' => $form->createView(),"specialiste"=>$specialiste
      ]);}
      /**
    * @Route("/deletephotoS/{id}", name="deletephotoS")
    * 
    */
    public function deletephotoS($id,request $request) {
      $specialiste = $this->getDoctrine()->getRepository(Specialiste::class)->find($id);
      $specialiste->setPhoto("");
      $entityManager=$this->getDoctrine()->getManager();
      $entityManager->persist($specialiste);
      //exécution de l'ajout
       $entityManager->flush();
       return $this->redirectToRoute("editprofilS",["id"=>$id]);
    }
        
          /**
         * @Route("/demanderenseignements/{id}", name="demanderenseignements")
         */
        public function demanderenseignements (Request $request, $id,)
        {
            $demande=$this->getDoctrine()->getRepository(Demande::class)->find($id);
            $demandeRens=new DemandeRens();
            $demandeRens->setDemande($demande);
            $date=new \DateTime('@'.strtotime('now'));
            $demandeRens->setDate($date);
            $form = $this->createForm(DemandeRensType::class,$demandeRens);
            // création d'une liste déroulante
          $form->handleRequest($request);
          if($form->isSubmitted()) {
            $demandeRens= $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($demandeRens);
            $entityManager->flush(); 
            return $this->redirectToRoute('showdemandeRens',["id"=>$demandeRens->getId()]);
        }
      return $this->render("demandeRens.html.twig",["form"=>$form->createView()]);}
    
      
          /**
         * @Route("/showdemandeRens/{id}", name="showdemandeRens")
         */
        public function showdemandeRens (Request $request, $id,)
        {  
            $demandeRens=$this->getDoctrine()->getRepository(DemandeRens::class)->find($id);
             $reponses=$demandeRens->getReponserens();
            return $this->render('showdemandeRens.html.twig',["demandeRens"=>$demandeRens,"reponses"=>$reponses]);
        }
         
          /**
         * @Route("/editdemandeRens/{id}", name="editdemandeRens")
         */
        public function editdemandeRens (Request $request, $id,)
        { 
            $demandeRens=$this->getDoctrine()->getRepository(DemandeRens::class)->find($id);
            $form = $this->createForm(DemandeRensType::class,$demandeRens);
            // création d'une liste déroulante
          $form->handleRequest($request);
          if($form->isSubmitted()) {
            $demandeRens= $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($demandeRens);
            $entityManager->flush(); 
            return $this->redirectToRoute('showdemandeRens',["id"=>$demandeRens->getId()]);
        }
            return $this->render('demandeRens.html.twig',["form"=>$form->createView()]);
        }
        /**
         * @Route("/deletedemandeRens/{id}", name="deletedemandeRens")
         *  method=({"DELETE"})
         */
        public function deletedemandeRens(Request $request, $id,)
        {
            $demandeRens=$this->getDoctrine()->getRepository(DemandeRens::class)->find($id);
            $demande=$demandeRens->getDemande();
            $idD=$demande->getId();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($demandeRens);
            $entityManager->flush(); 
            return $this->redirectToRoute('showdemandeS',["id"=>$idD]);
        }
          /**
    * @Route("/listedemandeRens/{id}", name="listedemandeRens")
    */
    public function listedemandeRens(Request $request, $id)
    {   $demandeRens = $this->getDoctrine()->getRepository(DemandeRens::class)->findBy(["demande"=>$id]);
        return $this->render('listedemandeRens.html.twig',["demandeRens"=>$demandeRens,"id"=>$id]);
    } 
       
        /**
        * @Route("/showExamenATCDS/{id}", name="showExamenATCDS")
        */
        function showExamenATCDS($id)
        {
        $examen=$this->getDoctrine()->getRepository(ExamenATCD::class)->findOneBy(["demande"=>$id]);
        return $this->render("examen/showExamenATCD.html.twig",["examen"=>$examen,"id"=>$id]);
        }
    
         /**
       * @Route("/showExamenBioS/{id}", name="showExamenBioS")
       */
       function showExamenBioS($id)
       {
       $examen=$this->getDoctrine()->getRepository(ExamenBio::class)->findOneBy(['demande'=>$id]);
       return $this->render("examen/showExamenBio.html.twig",["examen"=>$examen,"id"=>$id]);
       }
  

        /**
       * @Route("/showExamenRadioS/{id}", name="showExamenRadioS")
       */
       function showExamenRadio($id)
       {
       $examen=$this->getDoctrine()->getRepository(ExamenRadio::class)->findOneBy(["demande"=>$id]);
       return $this->render("examen/showExamenRadio.html.twig",["examen"=>$examen,"id"=>$id]);
       }
      
       /**
       * @Route("/showExamenCliniqueS/{id}", name="showExamenCliniqueS")
       */
      function showExamenClinique($id)
      {
      $examen=$this->getDoctrine()->getRepository(ExamenClinique::class)->findOneBy(["demande"=>$id]);
      return $this->render("examen/showExamenClinique.html.twig",["examen"=>$examen,"id"=>$id]);
      }
    
   }
        
        
        