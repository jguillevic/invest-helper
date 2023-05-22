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
		$result = [ "success" => false ];

		try
		{
			if ($_SERVER['REQUEST_METHOD'] === 'POST')
			{
				$lastname = $queryParameters['lastname']->GetValue();
				$firstname = $queryParameters['firstname']->GetValue();
				$email = $queryParameters['email']->GetValue();
				$message = $queryParameters['message']->GetValue();
				$sendCopy = $queryParameters['send-copy']->GetValue();

				$result["success"] = true;
			}
		}
		catch (\Exception $e)
		{
        	$result['error'] = $e->getMessage();
		}

		return json_encode($result);
    }
}