<?php
namespace App\Controller;
use App\Entity\User;
use App\Entity\Demande;
use App\Entity\ReponseD;
use App\Entity\ExamenBio;
use App\Form\DemandeType;
use App\Entity\ExamenATCD;
use App\Form\ExamenBiType;
use App\Entity\Commentaire;
use App\Entity\DemandeRens;
use App\Entity\ExamenRadio;
use App\Entity\Generaliste;
use App\Form\ExamenBioType;
use App\Form\ExamenATCDType;
use App\Form\ExamenRadioType;
use App\Form\GeneralisteType;
use App\Form\ReponseRensType;
use App\Entity\ExamenClinique;
use App\Entity\PropertySearch;
use App\Form\ExamenCliniqueType;
use App\Form\PropertySearchType;
use App\Repository\DemandeRepository;
use App\Repository\ReponseDRepository;
use App\Repository\ExamenBioRepository;
use App\Repository\ExamenATCDRepository;
use App\Repository\CommentaireRepository;
use App\Repository\DemandeRensRepository;
use App\Repository\ExamenRadioRepository;
use App\Repository\GeneralisteRepository;
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
     * @Route("/generaliste")
     * @IsGranted("ROLE_GENERALISTE")
     */
class GeneralisteController extends AbstractController
{        /**
         * @Route("/listdemande", name="listdemande")
        */ 
        public function listdemande(?UserInterface $user, DemandeRepository $demRep){
        //récuparetion de toutes les objets examen de la bdd
         return $this->render('demande/listedemande.html.twig',array('demande'=>$demRep->findDemandByUser($user->getId())));
        }
    
        /**
         *@Route("/newdemande" ,name="newdemande")
         */
        //initialisation d'objet demande
        public function newdemande(Request $request, ?UserInterface $user): Response
    {   
            $demande= new Demande(); 
            $date=new \DateTime('@'.strtotime('now'));
            $demande->setDate($date);
            $demande->setEtat("En Attente d'acceptation");
            $demande->setMedecinEmitteur($user);
            //cration du formulaire pour lobjet demande
            $form = $this->createForm(DemandeType::class,$demande);
                $form->handleRequest($request);
            if($form->isSubmitted()) {
                //recuperertion des info de la formulaire
                $demande = $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($demande);
                //exécution de l'ajout
                $entityManager->flush();
                //affichage aprés l'ajout
                return $this->redirectToRoute("newExamenATCD",array("id"=>$demande->getId()));}
            return $this->render('demande/newdemande.html.twig', [
                'form' => $form->createView(),
            ]);
        }
       
        

         /**
         *@Route("/editdemande/{id}", name="editdemande")
         */
        public function editdemande(Request $request, $id, DemandeRepository $demRep): Response
        {   //initialisation d'objet demande
            $demande = $demRep->findDemande($id);
            $form = $this->createForm(DemandeType::class,$demande);
                //il prend les données POST de la request précédente
                $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
                $demande = $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($demande);
                $entityManager->flush();
                return $this->redirectToRoute("showdemande",array("id"=>$demande->getId()));}
            return $this->render('demande/editdemande.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        
       /**
        * @Route("/showdemande/{id}", name="showdemande")
        */
        public function showdemande($id,DemandeRepository $demRep) {
           
            return $this->render('demande/showdemande.html.twig',array('demande'=> $demRep->findDemande($id),"id"=>$id));
        }
        

        /** 
         * @Route("/showreponseD/{idD}", name="showreponseD")
         */
        public function showreponseD(ReponseDRepository $Rep , $idD){
            return $this->render("showreponseD.html.twig",["reponses"=>$Rep->findReponseD($idD),"id"=>$idD]);
         }
         
         /**
         * @Route("/deletedemande/{id}", name="deletedemande")
         *  method=({"DELETE"})
         */
        public function deleteDemande(Request $request, $id, DemandeRepository $demRep)
        {
        $demande =$demRep->findDemande($id);
        
           
            if($demande->getSpecialisteAtt()){
            foreach($demande->getSpecialisteAtt() as $spec){
                $demande->removeSpecialisteAtt($spec);
               }}  
               
               if($demande->getDemandeRens()){
                foreach($demande->getDemandeRens() as $dem){
                    $demande->removeDemandeRen($dem);
                }
            }
            if ($demande->getReponseDs()){
            foreach($demande->getReponseDs() as $rep){
                $demande->removeReponseD($rep);
            }}
         
            if($demande->getCommentaires()){
                foreach($demande->getCommentaires() as $com)
                {  
                     $demande->removeCommentaire($com);

                }
            }
            

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($demande);
        $entityManager->flush(); 
        if($demande->getEtat()=="Refusé"){
            return $this->redirectToRoute('demandeRefus');}
            else{
        return $this->redirectToRoute('listdemande');
        }}

    
         
         /**
         * @Route("/profil", name="profil")
         */
    public function newProfil(Request $request, ?UserInterface $user, GeneralisteRepository $genRep): Response
       { 
        $id=$user->getId();
        if($generaliste=$genRep->findprofil($id)){
        return $this->render('profil.html.twig',array(
        'generaliste' => $generaliste));
        } 
        else {
        $generaliste=new Generaliste();
        $generaliste->setUser($user);
        $generaliste->setEtat("En attente d'acceptation");
        $form = $this->createForm(GeneralisteType::class,$generaliste);
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
            $generaliste= $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($generaliste);
            //exécution de l'ajout
            $entityManager->flush();
            return $this->render('profil.html.twig',array(
                'generaliste' => $generaliste));}
        return $this->render('demande/newprofil.html.twig', [
                'form' => $form->createView()
        ]);
        }}

         /**
        * @Route("/listcommentaires/{id}" , name="listcommentaires")
        */
        public function listecomentaire($id,Request $request, CommentaireRepository $commentaireRep) {
            $commentaire=$commentaireRep->findCommentaires($id);
            $form = $this->createForm(PropertySearchType::class);
            $form->handleRequest($request);
            if($form->isSubmitted()) {
            $sujet = $form['nom']->getData();
                if($sujet!=""){
                $comm=$commentaireRep->findCommentairesBySujet($sujet,$id);
            return $this->render('Commentairecherche.html.twig',['comm' => $comm,'form'=>$form->createView(),"id"=>$id]);
                }
            }
        return $this->render('Commentaireliste.html.twig',array('form'=>$form->createView(),'commentaire' => $commentaire,"id"=>$id));
           }


     /**
    * @Route("/editprofil/{id}", name="editprofil")
    */
    public function editProfil(Request $request,$id): Response
    { 
    $generaliste=$this->getDoctrine()->getRepository(Generaliste::class)->find($id);
     $form = $this->createForm(GeneralisteType::class,$generaliste);
        if($generaliste->getEtat()=="Refusé"){
            $generaliste->setEtat("en attente");
        }
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
         $generaliste= $form->getData();
         $entityManager = $this->getDoctrine()->getManager();
         $entityManager->persist($generaliste);
         //exécution de l'ajout
         $entityManager->flush();
         return $this->render('profil.html.twig',array(
             'generaliste' => $generaliste));}
     return $this->render('demande/editprofil.html.twig', [
             'form' => $form->createView(),"generaliste"=>$generaliste
     ]);
    }


    /**
    * @Route("/deletephoto/{id}", name="deletephoto")
    * 
    */
    public function deletephoto($id,request $request) {
        $generaliste = $this->getDoctrine()->getRepository(Generaliste::class)->find($id);
        $generaliste->setPhoto("");
        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->persist($generaliste);
        //exécution de l'ajout
        $entityManager->flush();
        return $this->redirectToRoute("editprofil",["id"=>$id]);
    }


    /**
    * @Route("/deleteprofil/{id}", name="deleteprofil")
    *  method=({"DELETE"})
    */
    public function deleteprofil(Request $request, $id,?UserInterface $user,demandeRepository $demRep)
    {   $generaliste = $this->getDoctrine()->getRepository(Generaliste::class)->find($id);
    $demande=$demRep->findDemandByUser($user->getId());
    if($demande){
        foreach($demande as $dem){
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($dem);
        $entityManager->flush(); }}

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($generaliste);
        $entityManager->flush(); 
        return $this->redirectToRoute('accueil');
    } 



    /**
    * @Route("/listedemandeRensG/{id}", name="listedemandeRensG")
    */
    public function listedemandeRensG( $id,DemandeRensRepository $demandeRep)
    {  
        return $this->render('listedemandeRens.html.twig',
        ["demandeRens"=>$demandeRep->demandeRens($id),
        "id"=>$id]);
    } 



    /**
    * @Route("/showdemandeRensG/{id}", name="showdemandeRensG")
    */
    public function showdemandeRensG(Request $request, $id)
    { $demandeRens = $this->getDoctrine()->getRepository(DemandeRens::class)->find($id);
      $reponses=$demandeRens->getReponserens();
      $reponseRens=new ReponseRens();
      $reponseRens->setDemandeRens($demandeRens);
      $date=new \DateTime('@'.strtotime('now'));
      $reponseRens->setDate($date);
      $form = $this->createForm(ReponseRensType::class,$reponseRens);
     $form->handleRequest($request);
     if($form->isSubmitted()) {
        $images = $form->get('fichiers')->getData();
       // On boucle sur les images
        foreach($images as $image){
            // On génère un nouveau nom de fichier
            $fichier = md5(uniqid()) . '.' . $image->guessExtension();
             // On copie le fichier dans le dossier uploads
            $image->move(
                $this->getParameter('images_directory'),
                $fichier
            );
            $Tabfich[]=$fichier;
            // On stocke l'image dans la base de données (son nom)
            $reponseRens->setFichiers($Tabfich);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reponseRens);
        //exécution de l'ajout
        $entityManager->flush();
        return $this->redirectToRoute("accueil");
    }
    return $this->render("showdemandeRens.html.twig",["demandeRens"=>$demandeRens,"form"=>$form->createView()
    ,"reponses"=>$reponses]);
    }



      /**
       * @Route("/newExamenATCD/{id}" , name="newExamenATCD")
       */
        public function newExamenATCD($id, request $request, ExamenATCDRepository $examenRep)
       {
        $Message="Examen ATCD";
        if($examen=$examenRep->findExamenATCD($id)){
        return $this->redirectToRoute("showExamenATCD",["id"=>$examen->getId(),"Message"=>$Message]);
        }
        else{
            $Message="Examen ATCD ";
        $examen= new ExamenATCD();
        $demande = $this->getDoctrine()->getRepository(Demande::class)->find($id);
        $examen->setDemande($demande);
        $form=$this->createForm(ExamenATCDType::class,$examen);
        $form->handleRequest($request);
         if($form->isSubmitted()) {
            $images = $form->get('Images')->getData();
           // On boucle sur les images
            foreach($images as $image){
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                // On stocke l'image dans la base de données (son nom)
                $Tabfich[]=$fichier;
                $examen->setImages($Tabfich);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($examen);
            //exécution de l'ajout
            $entityManager->flush();
            return $this->redirectToRoute("showExamenATCD",["id"=>$examen->getId()]);
       }
        return $this->render("examen/newExamen.html.twig",["form"=>$form->createView(),"id"=>$id,"Message"=>$Message]);
       }}




       /**
        * @Route("/showExamenATCD/{id}", name="showExamenATCD")
        */
        function showExamenATCD($id)
        {
            $Message="Examen ATCD";
        $examen=$this->getDoctrine()->getRepository(ExamenATCD::class)->find($id);
        return $this->render("examen/showExamenATCD.html.twig",["examen"=>$examen,"id"=>$examen->getdemande()->getId()]);
        }


        /**
       * @Route("/newExamenBio/{id}" , name="newExamenBio")
       */
        public function newExamenBio($id, request $request, ExamenBioRepository $examenRep){
            $Message="Examen biologique";
            if($examen=$examenRep->findExamenBio($id)){
            return $this->redirectToRoute("showExamenBio",["id"=>$examen->getId()]);
            }
            else{
                $Message="Examen Biologique";
        $examen= new ExamenBio();
        $demande = $this->getDoctrine()->getRepository(Demande::class)->find($id);
        $examen->setDemande($demande);
        $form=$this->createForm(ExamenBioType::class,$examen);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
           $images = $form->get('Images')->getData();
          // On boucle sur les images
           foreach($images as $image){
               // On génère un nouveau nom de fichier
               $fichier = md5(uniqid()) . '.' . $image->guessExtension();
               // On copie le fichier dans le dossier uploads
               $image->move(
                   $this->getParameter('images_directory'),
                   $fichier
               );
               // On stocke l'image dans la base de données (son nom)
               $Tabfich[]=$fichier;
               $examen->setImages($Tabfich);
           }
           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($examen);
           //exécution de l'ajout
           $entityManager->flush();
           return $this->redirectToRoute("showExamenBio",["id"=>$examen->getId()]);
      }
       return $this->render("examen/newExamen.html.twig",["form"=>$form->createView(),"id"=>$id,"Message"=>$Message]);
       }}
      /**
       * @Route("/showExamenBio/{id}", name="showExamenBio")
       */
       function showExamenBio($id)
       {
        $Message="Examen Biologique";
       $examen=$this->getDoctrine()->getRepository(ExamenBio::class)->find($id);
       return $this->render("examen/showExamenBio.html.twig",["examen"=>$examen,"id"=>$examen->getdemande()->getId()]);
       }
       

        /**
       * @Route("/newExamenRadio/{id}" , name="newExamenRadio")
       */

      public function newExamenRadio($id, request $request,ExamenRadioRepository $examenRep){
      $Message="Examen Radiologique";
        if($examen=$examenRep->findExamenRadio($id)){
        return $this->redirectToRoute("showExamenRadio",["id"=>$examen->getId()]);
        }
        else{
        
        $examen= new ExamenRadio();
        $demande = $this->getDoctrine()->getRepository(Demande::class)->find($id);
        $examen->setDemande($demande);
        $form=$this->createForm(ExamenRadioType::class,$examen);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
           $images = $form->get('images')->getData();
          // On boucle sur les images
           foreach($images as $image){
               // On génère un nouveau nom de fichier
               $fichier = md5(uniqid()) . '.' . $image->guessExtension();
               // On copie le fichier dans le dossier uploads
               $image->move(
                   $this->getParameter('images_directory'),
                   $fichier
               );
               // On stocke l'image dans la base de données (son nom)
               $Tabfich[]=$fichier;
               $examen->setImages($Tabfich);
           }
           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($examen);
           //exécution de l'ajout
           $entityManager->flush();
           return $this->redirectToRoute("showExamenRadio",["id"=>$examen->getId()]);
      }
       return $this->render("examen/newExamen.html.twig",["form"=>$form->createView(),"id"=>$id,"Message"=>$Message]);
       }}

      /**
       * @Route("/showExamenRadio/{id}", name="showExamenRadio")
       */
       function showExamenRadio($id)
       {
           $Message="Examen Radiologique";
        $examen=$this->getDoctrine()->getRepository(ExamenRadio::class)->find($id);
       return $this->render("examen/showExamenRadio.html.twig",["examen"=>$examen,"id"=>$examen->getDemande()->getId()]);
       }
      


        /**
       * @Route("/newExamenClinique/{id}" , name="newExamenClinique")
       */

      public function newExamenClinique($id, request $request, ExamenCliniqueRepository $examenRep){
        $Message="Examen Clinique";
        if($examen=$examenRep->findExamenClinique($id))
        {
        return $this->redirectToRoute("showExamenClinique",["id"=>$examen->getId()]);
        }
        else{
        
        $examen= new ExamenClinique();
        $demande = $this->getDoctrine()->getRepository(Demande::class)->find($id);
        $examen->setDemande($demande);
        $form=$this->createForm(ExamenCliniqueType::class,$examen);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
           $images = $form->get('images')->getData();
          // On boucle sur les images
           foreach($images as $image){
               // On génère un nouveau nom de fichier
               $fichier = md5(uniqid()) . '.' . $image->guessExtension();
               // On copie le fichier dans le dossier uploads
               $image->move(
                   $this->getParameter('images_directory'),
                   $fichier
               );
               // On stocke l'image dans la base de données (son nom)
               $Tabfich[]=$fichier;
               $examen->setImages($Tabfich);
           }
           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($examen);
           //exécution de l'ajout
           $entityManager->flush();
           return $this->redirectToRoute("showExamenClinique",["id"=>$examen->getId()]);
      }
       return $this->render("examen/newExamen.html.twig",["form"=>$form->createView(),"id"=>$id,"Message"=>$Message]);
       }}

      /**
       * @Route("/showExamenClinique/{id}", name="showExamenClinique")
       */
       function showExamenClinique($id)
       {
        $Message="Examen Clinique";
       $examen=$this->getDoctrine()->getRepository(ExamenClinique::class)->find($id);
       return $this->render("examen/showExamenClinique.html.twig",["examen"=>$examen,"id"=>$examen->getDemande()->getId()]);
       }

    

       /**
         * @Route("/deletexamenClinique/{id}", name="deletexamenClinique")
         *  method=({"DELETE"})
         */
        public function deleteExamenClinique(Request $request, $id)
        {   
            $examen = $this->getDoctrine()->getRepository(ExamenClinique::class)->find($id);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($examen);
            $entityManager->flush(); 
            return $this->redirectToRoute("listexamenClinique",["id"=>$examen->getIdDemande()->getId()]);
        }
         /**
         * @Route("/deletexamenBio/{id}", name="deletexamenBio")
         *  method=({"DELETE"})
         */
        public function deleteExamenBio(Request $request, $id)
        {   
            $examen = $this->getDoctrine()->getRepository(ExamenBio::class)->find($id);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($examen);
            $entityManager->flush(); 
            return $this->redirectToRoute("listexamenBio",["id"=>$examen->getDemande()->getId()]);
        }
        /**
         * @Route("/deletexamenRadio/{id}", name="deletexamenRadio")
         *  method=({"DELETE"})
         */
        public function deleteExamenRadio(Request $request, $id)
        { 
            $examen = $this->getDoctrine()->getRepository(ExamenRadio::class)->find($id);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($examen);
            $entityManager->flush(); 
            return $this->redirectToRoute("listeexamenRadio",["id"=>$examen->getDemande()->getId()]);
        }
        /**
         * @Route("/deletexamenATCD/{id}", name="deletexamenATCD")
         *  method=({"DELETE"})
         */
        public function deleteExamenATCD(Request $request, $id)
        { 
            $examen = $this->getDoctrine()->getRepository(ExamenATCD::class)->find($id);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($examen);
            $entityManager->flush(); 
            return $this->redirectToRoute("listeexamenATCD",["id"=>$examen->getDemande()->getId()]);
        }
        
         /**
    * @Route("/demandeRefus", name="demandeRefus")
    */
    public function demandeRefus(DemandeRepository $demandeRep)
    {  
        return $this->render('demande/listeDemandeRefus.html.twig',
        ["demande"=>$demandeRep->demandeRefus()]);
    } 
    }

  



 














