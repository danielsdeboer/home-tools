<?php

namespace App\Http\Controllers;

use Admin\Common\Settings\FrostDateSettings;
use Inertia\Inertia;
use Inertia\Response;

class GardeningController
{
	public function index(FrostDateSettings $settings): Response
	{
		return Inertia::render('Gardening/Pages/GardeningHome', [
			'frostDates' => [
				'spring' => $settings->getSpring(),
				'autumn' => $settings->getAutumn(),
			],
		]);
	}
}
