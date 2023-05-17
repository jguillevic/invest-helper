<?php

namespace Controller\Calculator\PremiumTax;

use \Framework\View\View;
use \Framework\Tools\Helper\PathHelper;

class PremiumTaxCalculatorController
{
	public function DisplayForm($queryParameters)
	{
		$path = PathHelper::GetPath([ "Calculator", "PremiumTax", "DisplayForm" ]);
		$view = new View($path);
		return $view->Render();
	}

	public function DisplayCalcResult($queryParameters)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			// Récupération des infos.
			$grossAmount = (float)$queryParameters['gross-amount']->GetValue();
			$marginalTaxBracket = (float)$queryParameters['marginal-tax-bracket']->GetValue();

			// Taux de csg.
			$csgRate = 0.092;
			// Taux de csg déductible.
			$deductibleCsgRate = 0.068;
			// Taux de crds.
			$crdsRate = 0.005;
			// Taux d'abattemment des frais professionnels.
			$professionalFeesDeduction = 0.1;

			// Montant de la csg + crds.
			$csgAndCrdsAmount = $grossAmount * ($csgRate + $crdsRate);
			$netAmount = $grossAmount - $csgAndCrdsAmount;
			$netTaxableAmount = $grossAmount * (1 - $deductibleCsgRate);
			$incomeTax = $netTaxableAmount * (1 - $professionalFeesDeduction) * $marginalTaxBracket;

			$path = PathHelper::GetPath([ "Calculator", "PremiumTax", "DisplayCalcResult" ]);
			$view = new View($path);
			return $view->Render([
				'grossAmount' => $grossAmount
				, 'marginalTaxBracket' => $marginalTaxBracket
				, 'csgRate' => $csgRate
				, 'deductibleCsgRate' => $deductibleCsgRate
				, 'crdsRate' => $crdsRate
				, 'professionalFeesDeduction' => $professionalFeesDeduction
				, 'csgAndCrdsAmount' => $csgAndCrdsAmount
				, 'netAmount' => $netAmount
				, 'netTaxableAmount' => $netTaxableAmount
				, 'incomeTax' => $incomeTax
			]);
		}

		return RoutesHelper::Redirect("DisplayHome");
	}
}