<?php

namespace App\Controllers;

use Core\BaseController;

class HomeController extends BaseController
{

    public function index()
    {
        $this->setPageTitle('Welcome');
        $this->view->nome = "Jonnathan rEIS";

        $this->render('home/index', 'layout');
        //require_once __DIR__ . "/../Views/home/index.php";
    }
}