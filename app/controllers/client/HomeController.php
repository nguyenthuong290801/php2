<?php

namespace App\controllers\client;

use Illuminate\framework\Response;
use Illuminate\framework\Controller;
use Illuminate\framework\Request;
use Illuminate\framework\factory\Model;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        echo $this->view('pages/client/home');
    }
}
