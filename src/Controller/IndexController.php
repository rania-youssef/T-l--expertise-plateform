<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Demande;
use App\Entity\Generaliste;
use App\Entity\Specialiste;
use App\Form\GeneralisteType;
use App\Repository\RPPSRepository;
use App\Repository\DemandeRepository;
use App\Repository\GeneralisteRepository;
use App\Repository\SpecialisteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Security as SecurityCore;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class IndexController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function pageAvecPeutEtreUnUtilisateur(Request $request,?UserInterface $user, DemandeRepository $demandeRep,
    SpecialisteRepository $specialisteRep,GeneralisteRepository $generalisteRep,RPPSRepository $rppsRep)
    {   
       if ($user) {
        $demande=$demandeRep->findDemandeGeneralise ($user->getId());
        $generaliste=$generalisteRep->findProfil($user->getId());
        foreach (($user->getRoles()) as $role)
        {
        if ($role=="ROLE_GENERALISTE"){
            if($generaliste==null){
                $urgenceA=0;
                $urgenceB=0;
                $urgenceC=0;
            $generaliste=new Generaliste();
            $generaliste->setUser($user);
            $generaliste->setEtat("En attente d'acceptation");
            $form = $this->createForm(GeneralisteType::class,$generaliste); 
           $form->handleRequest($request);
        if($form->isSubmitted()) {
            $rpps=$form->get('rpps')->getData();
           if($rppsRep->FindRPPS($rpps)==null)
           { 
        return $this->render("RppsNotxiste.html.twig");
           }
        else{
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
        return $this->redirectToRoute("accueil");}}
         return $this->render('demande/newprofil.html.twig', [
           'form' => $form->createView()
   ]);
   }      else{
        $urgenceA=0;
        $urgenceB=0;
        $urgenceC=0;
       foreach( $demande as $dem){
        $niveau=$dem->getNiveauUrganece();
        if($niveau==24){
            $urgenceA=$urgenceA+1;
        }
        elseif($niveau==72){
            $urgenceB=$urgenceB+1;
        }else{
            $urgenceC=$urgenceC+1;
        }}
        return $this->render("AccueilGeneraliste.html.twig",["generaliste"=>$generaliste,
            "urgenceA"=>$urgenceA,
            "urgenceB"=>$urgenceB,
            "urgenceC"=>$urgenceC]);
    }}
        elseif($role=="ROLE_ADMIN"){
            $demande = $this->getDoctrine()->getRepository(Demande::class)->findBy(["Etat"=>"En Attente d'acceptation"]);
            $urgenceAa=0;
            $urgenceBb=0;
            $urgenceCc=0;
            foreach( $demande as $dem){
            $niveau=$dem->getNiveauUrganece();
            if($niveau==24){
                $urgenceAa=$urgenceAa+1;
            }
            elseif($niveau==72){
                $urgenceBb=$urgenceBb+1;
            }else{
                $urgenceCc=$urgenceCc+1;
            }}
            return $this->render("AccueilAdmin.html.twig",[
            "urgenceAa"=>$urgenceAa,
            "urgenceBb"=>$urgenceBb,
            "urgenceCc"=>$urgenceCc]);
        } else{
            $specialiste=$specialisteRep->SpecialisteFindByUser($user->getId());
             if($specialiste==null){
                $urgenceAaa=0;
                $urgenceBbb=0;
                $urgenceCcc=0;
            $specialiste=new Specialiste();
            $specialiste->setUser($user);
            $specialiste->setEtat("En attente d'acceptation");
            $form = $this->createFormBuilder(SpecialisteType::class,$specialiste); 
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
            $specialiste->setPhoto($fichier);}
                foreach($img as $img){
                $fichier= md5(uniqid()) . '.' . $img->guessExtension();
            // On copie le fichier dans le dossier uploads
                $img->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
             $tabfichier[]=$fichier;
            $specialiste->setDossier($tabfichier);}
            $rpps=$form->get('rpps')->getData();
            if($rppsRep->FindRPPS($rpps)){ $this->addFlash(
                'notice',
                "Code RPPS n'existe pas!"
            );}
        $specialiste= $form->getData();
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($specialiste);
       //exécution de l'ajout
        $entityManager->flush(); 
        
        return $this->redirectToRoute("accueil");}
    
         return $this->render('demande/newprofil.html.twig', [
           'form' => $form->createView()
   ]);
   }      if($specialiste!=null){
            $urgenceAaa=0;
            $urgenceBbb=0;
            $urgenceCcc=0;
            $demande=$demandeRep->demandeAttrib($user->getId());
            foreach( $demande as $dem){
            $niveau=$dem->getNiveauUrganece();
            if($niveau==24){
                $urgenceAaa=$urgenceAaa+1;
            }
            elseif($niveau==72){
                $urgenceBbb=$urgenceBbb+1;
            }else{
                $urgenceCcc=$urgenceCcc+1;
            }}
           return $this->render ("AccueilSpecialiste.html.twig",[
                "specialiste"=>$specialiste,
                'urgenceAaa'=>$urgenceAaa,'urgenceBbb'=>$urgenceBbb,'urgenceCcc'=>$urgenceCcc,
        
                ]);
         }}}}
           
              else {
            return $this->render('welcome.html.twig');}
        
            
            
            
            
            
        
    


    }
}