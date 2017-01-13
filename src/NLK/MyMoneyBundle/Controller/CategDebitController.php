<?php

namespace NLK\MyMoneyBundle\Controller;

use NLK\MyMoneyBundle\Entity\CategorieDebit;
use NLK\MyMoneyBundle\Form\Type\CategorieDebitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategDebitController extends Controller
{
    public function indexAction(Request $request)
    {
    	$categorie = new CategorieDebit();

    	$formCateg   = $this->get('form.factory')->create(CategorieDebitType::class, $categorie);

    	if ($request->isMethod('POST') && $formCateg->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
	   		$em->persist($categorie);
		    $em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Categorie bien enregistrée.');
    	}

    	$repository = $this->getDoctrine()
      	->getManager()
      	->getRepository('NLKMyMoneyBundle:CategorieDebit')
    	;

    	$listeCategDebit = $repository->orderedFindAll();

    	$typeCateg = 'Dépenses';

    	return $this->render('NLKMyMoneyBundle:Categories:index.html.twig', array(
      	'listCategs' 	=> $listeCategDebit,
      	'typeCateg'  	=> $typeCateg,
      	'formCateg'		=> $formCateg->createView(),
    ));

    }
}
