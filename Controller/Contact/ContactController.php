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

				if (array_key_exists('send-copy', $queryParameters))
				{
					$sendCopy = $queryParameters['send-copy']->GetValue();
				}
				else
				{
					$sendCopy = false;
				}

				$gRecaptchaResponse = $queryParameters['g-recaptcha-response']->GetValue();

				if ($this->IsRecaptchaValid($gRecaptchaResponse))
				{
					$result['success'] = true;
				}
				else
				{
					$result['error'] = 'Le recaptacha n\'a pas été validé.';
				}
			}
			else
			{
				$result['error'] = 'La méthode ' . $_SERVER['REQUEST_METHOD'] . ' n\'est pas acceptée.';
			}
		}
		catch (\Exception $e)
		{
        	$result['error'] = $e->getMessage();
		}

		return json_encode($result);
    }

	
	/** 
	 * Vérifie la validité du code recaptacha.
	 * 
	 * @param string $recaptchaCode Code du recaptcha
	 * 
	 * @return bool true si le code a été validé, false sinon.
	*/
	private function IsRecaptchaValid($recaptchaCode)
	{
		$params = [ 'secret' => getenv('G_RECAPTCHA_SECRET_KEY'), 'response' => $recaptchaCode ];

		$url = 'https://www.google.com/recaptcha/api/siteverify?' . http_build_query($params);

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($curl);

		if (empty($response) || is_null($response)) 
		{
			return false;
		}
	
		$json = json_decode($response);
		return ($json->success && $json->score >= 0.5);
	}
}