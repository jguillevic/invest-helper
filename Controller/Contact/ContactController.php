<?php

namespace Controller\Contact;

use \Framework\View\View;
use \Framework\Tools\Helper\PathHelper;

class ContactController
{
	public function Display($queryParameters)
	{
		$path = PathHelper::GetPath([ "Contact", "Display" ]);
		$view = new View($path);
		return $view->Render();
	}

    public function Send($queryParameters)
    {
        return true;
    }
}