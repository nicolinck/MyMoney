<?php

namespace NLK\MyMoneyBundle\Controller;

use NLK\MyMoneyBundle\Entity\Exercice;
use NLK\MyMoneyBundle\Entity\BilanMensuel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConsultationController extends Controller
{

    public function indexAction(Exercice $exercice)
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $bm = new BilanMensuel($em,$exercice,$user);

        $exercicePrecedent = $this->getDoctrine()
            ->getManager()
            ->getRepository('NLKMyMoneyBundle:Exercice')
            ->find($exercice->getId()-1)
        ;

        $exerciceSuivant = $this->getDoctrine()
            ->getManager()
            ->getRepository('NLKMyMoneyBundle:Exercice')
            ->find($exercice->getId()+1)
        ;

        $listeExercices = $this->getDoctrine()
            ->getManager()
            ->getRepository('NLKMyMoneyBundle:Exercice')
            ->findAll()
        ;

        $regularisation = $bm->getRegul();

    	return $this->render('NLKMyMoneyBundle:Consultation:index.html.twig', array(
    		'listeRenQuot' => $bm->getUserRenQ(),
            'listeRenMens' => $bm->getUserRenM(),
            'listeDepQuot'      => $bm->getUserDepQ(),
            'listeDepMens'      => $bm->getUserDepM(),
            'exercice'          => $exercice,
            'exercicePrecedent' => $exercicePrecedent,
            'exerciceSuivant'   => $exerciceSuivant,
            'listeExercices'    => $listeExercices,
            'totalRentreesQuotidiennes' => $bm->getTotalRenQ(),
            'totalRentreesMensuelles' => $bm->getTotalRenM(),
            'totalRentreesAmmorties' => $bm->getTotalRenA(),
            'totalDepensesQuotidiennes' => $bm->getTotalDepQ(),
            'totalDepensesMensuelles' => $bm->getTotalDepM(),
            'totalDepensesAmmorties' => $bm->getTotalDepA(),
            'regularisation'        => $regularisation,
    	));
    }

    public function viewAmmortissementsAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $listeRentreesAmmorties = $this->getDoctrine()
            ->getManager()
            ->getRepository('NLKMyMoneyBundle:RentreeAmmortie')
            ->findByUser($user)
        ;

        $listeDepensesAmmorties = $this->getDoctrine()
            ->getManager()
            ->getRepository('NLKMyMoneyBundle:DepenseAmmortie')
            ->findByUser($user)
        ;

        return $this->render('NLKMyMoneyBundle:Consultation:viewAmmortissements.html.twig', array(
            'listeRentreesAmmorties' => $listeRentreesAmmorties,
            'listeDepensesAmmorties' => $listeDepensesAmmorties,
        ));

    }

    public function viewDepensesCommunesAction(Exercice $exercice)
    {

        $listeDepensesMensuellesCommunes = $this->getDoctrine()
            ->getManager()
            ->getRepository('NLKMyMoneyBundle:DepenseMensuelle')
            ->findDepensesCommunes($exercice)
        ;

        $listeDepensesQuotidiennesCommunes = $this->getDoctrine()
            ->getManager()
            ->getRepository('NLKMyMoneyBundle:DepenseQuotidienne')
            ->findDepensesCommunes($exercice)
        ;

        $exercicePrecedent = $this->getDoctrine()
            ->getManager()
            ->getRepository('NLKMyMoneyBundle:Exercice')
            ->find($exercice->getId()-1)
        ;

        $exerciceSuivant = $this->getDoctrine()
            ->getManager()
            ->getRepository('NLKMyMoneyBundle:Exercice')
            ->find($exercice->getId()+1)
        ;

        $listeExercices = $this->getDoctrine()
            ->getManager()
            ->getRepository('NLKMyMoneyBundle:Exercice')
            ->findAll()
        ;
        
        return $this->render('NLKMyMoneyBundle:Consultation:viewDepensesCommunes.html.twig', array(
            'listeDepensesMensuellesCommunes'   => $listeDepensesMensuellesCommunes,
            'listeDepensesQuotidiennesCommunes' => $listeDepensesQuotidiennesCommunes,
            'exercice'                          => $exercice,
            'exercicePrecedent' => $exercicePrecedent,
            'exerciceSuivant'   => $exerciceSuivant,
            'listeExercices'    => $listeExercices,
        ));
    }

}
