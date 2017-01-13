<?php

namespace NLK\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function indexAction()
    {
    	$user = $this->getUser();

    	if (null === $user){
    		return $this->redirectToRoute('fos_user_security_login');
    	}
    	else{
    		//return $this->render('NLKCoreBundle:Core:index.html.twig');
            return $this->redirectToRoute('nlk_my_money_home'); 
    	}
    }
}
