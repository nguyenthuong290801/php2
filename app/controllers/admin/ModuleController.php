<?php

namespace App\controllers\admin;

use Illuminate\framework\Controller;
use Illuminate\framework\Response;
use Illuminate\framework\Request;
use Illuminate\framework\factory\Model;

class ModuleController extends Controller
{
    public function index()
    {
        $this->setLayout('admin');
        
        echo $this->view('pages/admin/module-new');
    }
}
