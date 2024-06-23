<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class GardeningController
{
    public function index(): Response
    {
        return Inertia::render('Gardening/Pages/GardeningHome');
    }
}
