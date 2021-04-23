<?php
namespace App\Controller;
use App\Entity\User;
use App\Entity\Images;
use App\Entity\Demande;
use App\Entity\ReponseD;
use App\Entity\ExamenBio;
use App\Entity\ExamenATCD;
use App\Entity\Commentaire;
use App\Entity\ExamenRadio;
use App\Entity\Generaliste;
use App\Entity\Specialiste;
use App\Form\ExamenRadioType;
use App\Entity\ExamenClinique;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\DemandeRepository;
use App\Repository\ReponseDRepository;
use App\Repository\ExamenBioRepository;
use App\Repository\ExamenATCDRepository;
use App\Repository\CommentaireRepository;
use App\Repository\DemandeRensRepository;
use App\Repository\ExamenRadioRepository;
use App\Repository\GeneralisteRepository;
use App\Repository\SpecialisteRepository;
use App\Repository\ExamenCliniqueRepository;
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
     * @Route("/admin")
     * @IsGranted("ROLE_ADMIN")
     */
    class AdminController extends AbstractController
    { 
    /**
    * @Route("/listdemandeA", name="listdemandeA")
    */ 
    public function list( DemandeRepository $demRep){
    //récuparetion de toutes les objets  demande de la bdd
    
    return $this->render('demande/listedemandeAdmin.html.twig',array('demande' => $demRep-> findDemandeEnAttent()));
    }
    /**
    * @Route("/showdemandeA/{id}", name="showdemandeA")
    */
    public function showdemande($id) {
        $demande = $this->getDoctrine()->getRepository(Demande::class)->find($id);
        return $this->render('demande/showDemandeAdmin.html.twig',array('demande'=> $demande)
        );
        
    }
     
    /** 
         * @Route("/showreponseDA/{idD}", name="showreponseDA")
         */
        public function showreponseD(ReponseDRepository $Rep , $idD){
            return $this->render("showreponseD.html.twig",["reponses"=>$Rep->findReponseD($idD),"id"=>$idD]);
        }
    
          /**
         * @Route("/newcommentaireA/{id}", name="newcommentaireA")
         */
        public function newCommentaireA(Request $request, ?UserInterface $user , $id): Response
        { 
            $commentaire=new Commentaire();
            $date=new \DateTime('@'.strtotime('now'));
            $commentaire->setDate($date);
            $commentaire->setEmetteur($user);
            $demande = $this->getDoctrine()->getRepository(Demande::class)->find($id);
            $commentaire->setDemande($demande);
            $form = $this->createFormBuilder(Commentairetype::class,$commentaire);
               // création d'une liste déroulante
                $form->handleRequest($request);
            if($form->isSubmitted()) {
                $commentaire= $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($commentaire);
                //exécution de l'ajout
                $entityManager->flush();
                return $this->redirectToRoute("listcommentairesA",["id"=>$id]);}
            return $this->render('demande/newCommentaireA.html.twig', [
                    'form' => $form->createView(),'demande' => $demande,
                ]);
            
         }
    
     /**
    * @Route("/specialisteAttrib/{id_demande}", name="specialisteAttrib")
    */
    public function SpecialisteAttrib(Request $request,$id_demande, SpecialisteRepository $specialisteRep){
        //recuperation des examens associé a un demande donné 'id'
        $specialiste = $specialisteRep->SpecialisteAcceptee();
        $form = $this->createForm(PropertySearchType::class);
        $form->handleRequest($request);
       if($form->isSubmitted()) {
        $specialite = $form['nom']->getData();
            if($specialite!=""){
            $spec=$specialisteRep->SpecialisteByspec($specialite);
        return $this->render('specialisterecherche.html.twig',['spec' => $spec,'form'=>$form->createView(),'id_demande'=>$id_demande]);
            }
        }
        return $this->render('specialisteliste.html.twig',array('form'=>$form->createView(),'specialiste' => $specialiste,
        'id_demande'=>$id_demande));
        }
   /**
    * @Route("/attribuerS/{id_demande}/{id_specialiste}", name="attribuerS")
    */
    public function AttriburS(Request $request , $id_specialiste,$id_demande , SpecialisteRepository $specialisteRep,DemandeRepository $demandeRep){
        //recuperation des examens associé a un demande donné 'id'
        $specialiste = $specialisteRep->SpecialisteById($id_specialiste);
        $demande=$demandeRep->findDemande($id_demande);
        $specialiste->addDemandeAtt($demande);
        $demande->setEtat("En cour de traitements");
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($specialiste);
        //exécution de l'ajout
         $entityManager->flush();
         return $this->redirectToRoute("specialisteAttrib",["id_demande"=>$id_demande]);
    }
  /**
    * @Route("/listtraiteA", name="listtraiteA")
    */ 
    public function listTraite(?UserInterface $user){
        //récuparetion de toutes les objets  demande de la bdd
        $demande = $this->getDoctrine()->getRepository(Demande::class)->findBy(["Etat"=>"En cour de traitements"]);
        return $this->render('demande/listeattribAdmin.html.twig',array('demande' => $demande));
        }
         /**
          * @Route("/listcommentairesA/{id}" , name="listcommentairesA")
        */
        public function listecomentaireA($id,request $request) {
            $commentaire=$this->getDoctrine()->getRepository(Commentaire::class)->findBy(["demande"=>$id]);
            $propertySearch = new PropertySearch();
            $form = $this->createForm(PropertySearchType::class,$propertySearch);
            $form->handleRequest($request);
            $comm=[];
           if($form->isSubmitted()) {
            //on récupère le nom d'article tapé dans le formulaire 
            $sujet= $propertySearch->getNom();
            if ($Enoyerpar!=""){
           //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
                $comm= $this->getDoctrine()->getRepository(Commentaire::class)->findBy(['sujet' => $sujet] );
            return $this->render('Commentairecherche.html.twig',['comm' => $comm,'form'=>$form->createView(),"id"=>$id]);
                }
            }
            return $this->render('Commentaireliste.html.twig',array('form'=>$form->createView(),'commentaire' => $commentaire,"id"=>$id));
            }

          /**
    * @Route("/specialisteNonAccpt", name="specialisteNonAccpt")
    */
    public function SpecialisteNonAccpt(Request $request,SpecialisteRepository $specialisteRep){
        //recuperation des examens associé a un demande donné 'id'
        $specialiste = $specialisteRep->SpecialistNonAccept();
        $propertySearch = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class,$propertySearch);
        $form->handleRequest($request);
        $spec=[];
       if($form->isSubmitted()) {
        //on récupère le nom d'article tapé dans le formulaire 
        $nom= $propertySearch->getNom();
        if ($nom!=""){
       //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
            $spec= $this->getDoctrine()->getRepository(Specialiste::class)->findBy(['specialite' => $nom] );
        return $this->render('specialisteNonAccptRechercher.html.twig',['spec' => $spec,'form'=>$form->createView()]);
            }
        }
        return $this->render('specialisteNonAccpt.html.twig',array('form'=>$form->createView(),'specialiste' => $specialiste,
       ));
        }
        /**
    * @Route("/showprofil/{id}", name="showprofil")
    * 
    */
    public function showprofil($id) {
        $specialiste = $this->getDoctrine()->getRepository(Specialiste::class)->find($id);
        if($specialiste->getEtat()=="En attente d'acceptation"){
        return $this->render('profilSpecialisteNonAccpt.html.twig',array('specialiste' => $specialiste));
        }
        if($specialiste->getEtat()=="Accepté"){
        return $this->render('profilSpecialiste.html.twig',array('specialiste' => $specialiste));
        }
        }
        /**
    * @Route("/AccepterSpecialiste/{id}", name="AccepterSpecialiste")
    * 
    */
    public function AccepterSpecialiste($id,Request $request ) {
        $specialiste = $this->getDoctrine()->getRepository(Specialiste::class)->find($id);
        $specialiste->setEtat("Accepté");
        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->persist($specialiste);
        //exécution de l'ajout
         $entityManager->flush();
        return $this->redirectToRoute("specialisteNonAccpt");
        }
        /**
    * @Route("/RefuserSpecialiste/{id}", name="RefuserSpecialiste")
    * 
    */
    public function RefuserSpecialiste($id,Request $request ) {
        $specialiste = $this->getDoctrine()->getRepository(Specialiste::class)->find($id);
        $specialiste->setEtat("Réfusé");
        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->persist($specialiste);
        //exécution de l'ajout
         $entityManager->flush();
        return $this->redirectToRoute("specialisteNonAccpt");
        }

       
    /**
    * @Route("/specialisteAccpt", name="specialisteAccpt")
    */
    public function SpecialisteAccpt(Request $request){
        //recuperation des examens associé a un demande donné 'id'
        $specialiste = $this->getDoctrine()->getRepository(Specialiste::class)->findBy(["Etat"=>"Accepté"]);
        $propertySearch = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class,$propertySearch);
        $form->handleRequest($request);
        $spec=[];
       if($form->isSubmitted()) {
        //on récupère le nom d'article tapé dans le formulaire 
        $nom= $propertySearch->getNom();
        if ($nom!=""){
       //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
            $spec= $this->getDoctrine()->getRepository(Specialiste::class)->findBy(['specialite' => $nom] );
        return $this->render('specialisteAccptRechercher.html.twig',['spec' => $spec,'form'=>$form->createView()]);
            }
        }
        return $this->render('specialistAccpt.html.twig',array('form'=>$form->createView(),'specialiste' => $specialiste,
       ));
        }
         /**
         * @Route("/deleteprofil/{id}", name="deleteprofil")
         *  method=({"DELETE"})
         */
    public function deleteprofil(Request $request, $id,SpecialisteRepository $specialisteRep)
    {  $specialiste = $SpecialisteRep->SpecialisteById($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($specialiste);
        $entityManager->flush(); 
        return $this->redirectToRoute('specialisteAccpt');
    }
        /**
         * @Route("/deleteCommentaire/{id}", name="deleteCommentaire")
         *  method=({"DELETE"})
         */
        public function deleteCommentaire(Request $request, $id, CommentaireRepository $commentaireRep)
        {  $commentaire =$commentaireRep->findCommentairesById($id);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commentaire);
            $entityManager->flush(); 
            return $this->redirectToRoute('listcommentairesA',["id"=>$commentaire->getDemande()->getId()]);
        }

/**
    * @Route("/desattribuer/{id_demande}/{id_specialiste}", name="desattribuer")
    */
    public function desAttribuerS(Request $request , $id_specialiste,$id_demande){
        //recuperation des examens associé a un demande donné 'id'
        $specialiste = $this->getDoctrine()->getRepository(Specialiste::class)->find($id_specialiste);
        $demande=$this->getDoctrine()->getRepository(Demande::class)->find($id_demande);
        $specialiste->removeDemandeAtt($demande);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($specialiste);
        //exécution de l'ajout
         $entityManager->flush();
         return $this->redirectToRoute("specialisteAttrib",["id_demande"=>$id_demande]);
    }
    
       /**
        * @Route("/showExamenATCDA/{id}", name="showExamenATCDA")
        */
        function showExamenATCD($id)
        {
        $examen=$this->getDoctrine()->getRepository(ExamenATCD::class)->findOneBy(["demande"=>$id]);
        return $this->render("examen/showExamenATCD.html.twig",["examen"=>$examen,"id"=>$id]);
        }
  
         /**
       * @Route("/showExamenBioA/{id}", name="showExamenBioA")
       */
       function showExamenBioA($id)
       {
        $examen=$this->getDoctrine()->getRepository(ExamenBio::class)->findOneBy(['demande'=>$id]);
        return $this->render("examen/showExamenBio.html.twig",["examen"=>$examen,"id"=>$id]);
       }
   
       /**
       * @Route("/showExamenRadioA/{id}", name="showExamenRadioA")
       */
      function showExamenRadio($id)
      {
        $examen=$this->getDoctrine()->getRepository(ExamenRadio::class)->findOneBy(["demande"=>$id]);
        return $this->render("examen/showExamenRadio.html.twig",["examen"=>$examen,"id"=>$id]);
      }
 
      /**
       * @Route("/showExamenCliniqueA/{id}", name="showExamenCliniqueA")
       */
      function showExamenCliniqueA($id)
      {
        $examen=$this->getDoctrine()->getRepository(ExamenClinique::class)->findOneBy(["demande"=>$id]);
        return $this->render("examen/showExamenClinique.html.twig",["examen"=>$examen,"id"=>$id]);
      }
      /**
       * @Route("/AccepterDemande/{id}", name="AccepterDemande")
       */
       function AccepterDemande($id,DemandeRepository $demandeRep){
           $demande=$demandeRep->findDemande($id);
           $demande->setEtat("Acceptée");
           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($demande);
           $entityManager->flush(); 
           return $this->redirectToRoute('showdemandeA',["id"=>$id]);
       } 
       /**
       * @Route("/RefuserDemande/{id}", name="RefuserDemande")
       */
       function RefuserDemande($id,DemandeRepository $demandeRep){
           $demande=$demandeRep->findDemande($id);
           $demande->setEtat("Refusé");
           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($demande);
           $entityManager->flush();
           return $this->redirectToRoute('newcommentaireA',["id"=>$id]);

       }
        /**
    * @Route("/generalisteNonAccpt", name="generalisteNonAccpt")
    */
    public function GeneralisteNonAccpt(Request $request,GeneralisteRepository $generalisteRep){
        //recuperation des examens associé a un demande donné 'id'
        $generaliste = $generalisteRep->generalisteNonAccept();
        return $this->render('generalisteNonAccpt.html.twig',array('generaliste' => $generaliste
       ));
        }
        /**
    * @Route("/showprofilgeneraliste/{id}", name="showprofilgeneraliste")
    */
    public function showprofilgeneraliste($id) {
        $generaliste = $this->getDoctrine()->getRepository(Generaliste::class)->find($id);
        if($generaliste->getEtat()=="En attente d'acceptation"){
        return $this->render('profilgeneralisteNon.html.twig',array('generaliste' => $generaliste));
        }
        if($generaliste->getEtat()=="Accepté"){
        return $this->render('profilgeneraliste.html.twig',array('generaliste' => $generaliste));
        }}

    /**
    * @Route("/Acceptergeneraliste/{id}", name="Acceptergeneraliste")
    */
    public function AccepterGeneraliste($id,Request $request ) {
        $generaliste = $this->getDoctrine()->getRepository(Generaliste::class)->find($id);
        $generaliste->setEtat("Accepté");
        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->persist($generaliste);
        //exécution de l'ajout
         $entityManager->flush();
        return $this->redirectToRoute("generalisteNonAccpt");
        }
        /**
    * @Route("/Refusergeneraliste/{id}", name="Refusergeneraliste")
    * 
    */
    public function Refusergeneraliste($id,Request $request ) {
        $generaliste = $this->getDoctrine()->getRepository(Generaliste::class)->find($id);
        $generaliste>setEtat("Réfusé");
        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->persist($generaliste);
        //exécution de l'ajout
         $entityManager->flush();
        return $this->redirectToRoute("generalisteNonAccpt");
        }

       
    /**
    * @Route("/generalisteAccpt", name="generalisteAccpt")
    */
    public function GeneralisteAccpt(Request $request){
        //recuperation des examens associé a un demande donné 'id'
        $generaliste = $this->getDoctrine()->getRepository(Generaliste::class)->findBy(["etat"=>"Accepté"]);
        return $this->render('generalisteAccpt.html.twig',array('generaliste' => $generaliste));
        }

         /**
         * @Route("/deleteprofilGeneraliste/{id}", name="deleteprofilGeneraliste")
         *  method=({"DELETE"})
         */
    public function deleteprofilGeneraliste(Request $request, $id,GeneralisteRepository $generalisteRep)
    {  $generaliste = $generalisteRep->GeneralisteById($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($generaliste);
        $entityManager->flush(); 
        return $this->redirectToRoute('gneralisteAccept');
    }
   }



