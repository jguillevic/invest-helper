<?php

namespace Controller\Sponsorship;

use \Framework\View\View;
use \Framework\Tools\Helper\PathHelper;

class SponsorshipController
{
    public function Display($queryParameters)
	{
		$path = PathHelper::GetPath([ "Sponsorship", "Display" ]);
		$view = new View($path);
		return $view->Render();
	}
}