<?php

namespace NLK\MyMoneyBundle\Controller;

use NLK\MyMoneyBundle\Entity\CategorieCredit;
use NLK\MyMoneyBundle\Form\Type\CategorieCreditType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategCreditController extends Controller
{
    public function indexAction(Request $request)
    {
    	$categorie = new CategorieCredit();

    	$formCateg   = $this->get('form.factory')->create(CategorieCreditType::class, $categorie);

    	if ($request->isMethod('POST') && $formCateg->handleRequest($request)->isValid()) {
        $em = $this->getDoctrine()->getManager();
	   		$em->persist($categorie);
		    $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Categorie bien enregistrée.');

    	}

    	$repository = $this->getDoctrine()
      	->getManager()
      	->getRepository('NLKMyMoneyBundle:CategorieCredit')
    	;

    	$listeCategCredit = $repository->orderedFindAll();

    	$typeCateg = 'Rentrées';

    	return $this->render('NLKMyMoneyBundle:Categories:index.html.twig', array(
      	'listCategs' 	=> $listeCategCredit,
      	'typeCateg'  	=> $typeCateg,
      	'formCateg'		=> $formCateg->createView(),
    ));

    }
}
