<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class ShoppingController
{
    public function index(): Response
    {
        return Inertia::render('Shopping/Pages/ShoppingHome');
    }
}
