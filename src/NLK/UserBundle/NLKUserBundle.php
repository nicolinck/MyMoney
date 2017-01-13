<?php

namespace NLK\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NLKUserBundle extends Bundle
{
	public function getParent()
  	{
    	return 'FOSUserBundle';
  	}
}
